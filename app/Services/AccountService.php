<?php
    
    namespace App\Services;
    
    use App\Models\Account;
    use App\Models\FinancialYear;
    use App\Models\GeneralLedger;
    use App\Models\GeneralLedgerTransactionDetails;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Gate;
    
    class AccountService {
        
        protected int $counter;
        
        public function __construct () {
            $this -> counter = 0;
        }
        
        public function all (): Collection {
            return Account ::with ( [ 'account_head', 'account_type' ] ) -> get ();
        }
        
        public function save ( $request ): mixed {
            $account = Account ::create ( [
                                              'user_id'         => auth () -> user () -> id,
                                              'account_head_id' => $request -> input ( 'account-head-id' ),
                                              'account_type_id' => $request -> input ( 'account-type-id' ),
                                              'name'            => $request -> input ( 'name' ),
                                              'phone'           => $request -> input ( 'phone' ),
                                              'description'     => $request -> input ( 'description' ),
                                          ] );
            ( new LogService() ) -> log ( 'account-created', $account );
            return $account;
        }
        
        public function edit ( $request, $account ): void {
            $account -> user_id         = auth () -> user () -> id;
            $account -> account_head_id = $request -> input ( 'account-head-id' );
            $account -> account_type_id = $request -> input ( 'account-type-id' );
            $account -> name            = $request -> input ( 'name' );
            $account -> phone           = $request -> input ( 'phone' );
            $account -> description     = $request -> input ( 'description' );
            $account -> update ();
            ( new LogService() ) -> log ( 'account-updated', $account );
        }
        
        function buildTree ( array $elements, $parentId = 0 ): array {
            $branch = array ();
            
            foreach ( $elements as $element ) {
                if ( $element[ 'parent_id' ] == $parentId ) {
                    $children = $this -> buildTree ( $elements, $element[ 'id' ] );
                    if ( $children ) {
                        $element[ 'children' ] = $children;
                    }
                    $branch[] = $element;
                }
            }
            
            return $branch;
        }
        
        function buildList ( $nodes, &$options, $depth = 0, $disable_parent = false, $account_head_obj = null ) {
            $id = request () -> input ( 'account-head-id' );
            if ( !empty( $account_head_obj ) && $account_head_obj -> account_head_id > 0 )
                $id = $account_head_obj -> account_head_id;
            
            foreach ( $nodes as $item ) {
                $indentation = str_repeat ( '&nbsp;', $depth * 5 );
                $selected    = $id == $item[ 'id' ] ? 'selected="selected"' : '';
                $disabled    = $disable_parent ? 'disabled="disabled"' : '';
                if ( !empty( $item[ 'children' ] ) ) {
                    $options .= '<option value="' . $item[ 'id' ] . '" class="fw-bold" ' . $selected . $disabled . '><strong>' . $indentation . $item[ 'name' ] . '</strong></option>';
                    $this -> buildList ( $item[ 'children' ], $options, $depth + 1, $disable_parent, $account_head_obj );
                }
                else {
                    $options .= '<option value="' . $item[ 'id' ] . '" ' . $selected . '>' . $indentation . $item[ 'name' ] . '</option>';
                }
            }
            return $options;
        }
        
        public function parseAccountHeads ( $active = false ): array {
            if ( $active )
                $account_heads = Account ::with ( [ 'account_head', 'account_type' ] ) -> where ( [ 'active' => '1' ] ) -> get ();
            else
                $account_heads = $this -> all ();
            
            $array = array ();
            if ( count ( $account_heads ) > 0 ) {
                foreach ( $account_heads as $account_head ) {
                    $info = array (
                        'id'              => $account_head -> id,
                        'parent_id'       => $account_head -> account_head_id,
                        'account_type_id' => $account_head -> account_type_id,
                        'name'            => $account_head -> name,
                        'phone'           => $account_head -> phone,
                        'active'          => $account_head -> active,
                    );
                    array_push ( $array, $info );
                }
            }
            return $array;
        }
        
        public function convertToList ( $account_heads = array () ): string {
            
            if ( count ( $account_heads ) < 1 )
                $account_heads = $this -> buildTree ( $this -> parseAccountHeads () );
            
            $item   = '';
            $edit   = '';
            $delete = '';
            $status = '';
            
            if ( count ( $account_heads ) > 0 ) {
                $item .= '<ol>';
                foreach ( $account_heads as $account_head ) {
                    if ( Gate ::allows ( 'delete', Account ::find ( $account_head[ 'id' ] ) ) )
                        $delete = '<a href="' . route ( 'accounts.destroy', [ 'account' => $account_head[ 'id' ] ] ) . '" class="float-start fs-tiny ms-1 position-relative"><i class="ti ti-trash ti-sm text-dark fs-5 me-1"></i></a>';
                    
                    if ( Gate ::allows ( 'edit', Account ::find ( $account_head[ 'id' ] ) ) )
                        $edit = '<a href="' . route ( 'accounts.edit', [ 'account' => $account_head[ 'id' ] ] ) . '" class="float-start fs-tiny ms-1 position-relative"><i class="ti ti-edit ti-sm text-dark fs-5 me-1"></i></a>';
                    
                    if ( Gate ::allows ( 'status', Account ::find ( $account_head[ 'id' ] ) ) )
                        $status = '<a href="' . route ( 'accounts.status', [ 'account' => $account_head[ 'id' ] ] ) . '" class="float-start fs-tiny ms-1 position-relative"><i class="ti ti-status-change ti-sm text-dark fs-5 me-1"></i></a>';
                    
                    $link  = $edit . $status . $delete;
                    $class = $account_head[ 'active' ] == '0' ? ' text-strike-through' : '';
                    
                    if ( array_key_exists ( 'children', $account_head ) ) {
                        $item .= '<li class="position-relative mb-1' . $class . '">' . $link . $account_head[ 'name' ] . '</li>';
                        if ( count ( $account_head[ 'children' ] ) > 0 ) {
                            $item .= $this -> convertToList ( $account_head[ 'children' ] );
                        }
                    }
                    else {
                        $item .= '<li class="position-relative mb-1' . $class . '">' . $link . $account_head[ 'name' ] . '</li>';
                    }
                }
                $item .= '</ol>';
            }
            
            return $item;
        }
        
        public function convertToOptions ( $account_heads = array (), $class = 'parent', $recursive = false, $depth = 0, $disabled = true ): string {
            
            if ( $recursive )
                $this -> counter++;
            else
                $this -> counter = 0;
            
            if ( count ( $account_heads ) < 1 )
                $account_heads = $this -> buildTree ( $this -> parseAccountHeads () );
            
            $item     = '';
            $selected = '';
            
            if ( count ( $account_heads ) > 0 ) {
                foreach ( $account_heads as $key => $account_head ) {
                    $indentation = str_repeat ( '&nbsp;', $depth * 5 );
                    if ( array_key_exists ( 'children', $account_head ) ) {
                        
                        if ( request () -> input ( 'account-head-id' ) == $account_head[ 'id' ] )
                            $selected = 'selected="selected"';
                        else
                            $selected = '';
                        
                        if ( count ( $account_head[ 'children' ] ) > 0 && $disabled )
                            $disabled = 'disabled="disabled"';
                        else
                            $disabled = '';
                        
                        $item .= '<option class="' . $class . '" style="font-weight: 900" value="' . $account_head[ 'id' ] . '" ' . $selected . $disabled . '>' . $indentation . $account_head[ 'name' ] . '</option>';
                        if ( count ( $account_head[ 'children' ] ) > 0 ) {
                            $item .= $this -> convertToOptions ( $account_head[ 'children' ], 'child-' . $this -> counter, true, $depth + 1, $disabled );
                        }
                    }
                    else {
                        
                        if ( request () -> input ( 'account-head-id' ) == $account_head[ 'id' ] )
                            $selected = 'selected="selected"';
                        else
                            $selected = '';
                        
                        $this -> counter = 0;
                        $item            .= '<option class="' . $class . '" value="' . $account_head[ 'id' ] . '" ' . $selected . '>' . $indentation . $account_head[ 'name' ] . '</option>';
                    }
                }
            }
            
            return $item;
        }
        
        public function add_transactions ( $request ): string {
            $accountHead = Account ::findorFail ( $request -> input ( 'account-head-id' ) );
            $voucher_no  = $this -> generate_voucher_no ();
            
            ( new LogService() ) -> log ( 'transactions-added', $request );
            
            $accountHead
                -> general_ledger ()
                -> create ( [
                                'user_id'          => auth () -> user () -> id,
                                'account_head_id'  => $accountHead -> id,
                                'credit'           => $request -> input ( 'transaction-type' ) === 'credit' ? $request -> input ( 'amount' ) : 0,
                                'debit'            => $request -> input ( 'transaction-type' ) === 'debit' ? $request -> input ( 'amount' ) : 0,
                                'transaction_date' => date ( 'Y-m-d', strtotime ( $request -> input ( 'transaction-date' ) ) ),
                                'payment_mode'     => $request -> input ( 'payment-mode' ),
                                'transaction_no'   => $request -> input ( 'transaction-no' ),
                                'voucher_no'       => $voucher_no,
                                'description'      => $request -> input ( 'description' )
                            ] );
            
            $accountHead = Account ::findorFail ( $request -> input ( 'account-head-id-2' ) );
            return $accountHead
                -> general_ledger ()
                -> create ( [
                                'user_id'          => auth () -> user () -> id,
                                'account_head_id'  => $accountHead -> id,
                                'credit'           => $request -> input ( 'transaction-type-2' ) === 'credit' ? $request -> input ( 'amount' ) : 0,
                                'debit'            => $request -> input ( 'transaction-type-2' ) === 'debit' ? $request -> input ( 'amount' ) : 0,
                                'transaction_date' => date ( 'Y-m-d', strtotime ( $request -> input ( 'transaction-date' ) ) ),
                                'payment_mode'     => $request -> input ( 'payment-mode' ),
                                'transaction_no'   => $request -> input ( 'transaction-no' ),
                                'voucher_no'       => $voucher_no,
                                'description'      => $request -> input ( 'description' )
                            ] );
        }
        
        public function generate_voucher_no () {
            if ( request () -> has ( 'voucher-no' ) && request () -> filled ( 'voucher-no' ) ) {
                $voucher_no = request () -> input ( 'voucher-no' );
                $row        = DB ::table ( 'general_ledgers' )
                    -> select ( 'voucher_no' )
                    -> where ( 'voucher_no', 'like', $voucher_no . '%' )
                    -> orderBy ( 'id', 'DESC' )
                    -> first ();
                
                if ( !empty( $row ) ) {
                    $v_no = explode ( '-', $row -> voucher_no );
                    $rows = ( $v_no[ 1 ] ) + 1;
                    return $voucher_no . '-' . $rows;
                }
                else
                    return $voucher_no . '-1';
                
            }
        }
        
        public function add_opening_balance ( $request ): void {
            $accountHead = Account ::findorFail ( $request -> input ( 'account-head-id' ) );
            
            $accountHead -> general_ledger () -> create ( [
                                                              'user_id'          => auth () -> user () -> id,
                                                              'account_head_id'  => $accountHead -> id,
                                                              'credit'           => $request -> input ( 'transaction-type' ) === 'credit' ? $request -> input ( 'amount' ) : 0,
                                                              'debit'            => $request -> input ( 'transaction-type' ) === 'debit' ? $request -> input ( 'amount' ) : 0,
                                                              'transaction_date' => date ( 'Y-m-d', strtotime ( $request -> input ( 'transaction-date' ) ) ),
                                                              'payment_mode'     => 'opening-balance',
                                                              'description'      => $request -> input ( 'description' ),
                                                          ] );
            
            ( new LogService() ) -> log ( 'opening-balance-added', $request );
        }
        
        public function add_multiple_transactions ( $request ): ?string {
            $date           = $request -> input ( 'transaction-date' );
            $account_heads  = $request -> input ( 'account-heads' );
            $amount         = $request -> input ( 'amount' );
            $description    = $request -> input ( 'description' );
            $payment_mode   = $request -> input ( 'payment-mode' );
            $transaction_no = $request -> input ( 'transaction-no' );
            $voucher_no     = $this -> generate_voucher_no ();
            
            ( new LogService() ) -> log ( 'multiple-transactions-added', $request );
            
            if ( count ( $account_heads ) > 0 ) {
                foreach ( $account_heads as $key => $account_head_id ) {
                    if ( !empty( trim ( $account_head_id ) ) && $account_head_id > 0 ) {
                        $account_head = Account ::findorFail ( $account_head_id );
                        
                        $account_head -> general_ledger () -> create ( [
                                                                           'user_id'          => auth () -> user () -> id,
                                                                           'account_head_id'  => $account_head -> id,
                                                                           'credit'           => $request -> input ( 'transaction-type-' . $key ) === 'credit' ? $amount[ $key ] : 0,
                                                                           'debit'            => $request -> input ( 'transaction-type-' . $key ) === 'debit' ? $amount[ $key ] : 0,
                                                                           'transaction_date' => date ( 'Y-m-d', strtotime ( $date ) ),
                                                                           'voucher_no'       => $voucher_no,
                                                                           'payment_mode'     => $payment_mode,
                                                                           'transaction_no'   => $transaction_no,
                                                                           'description'      => $description
                                                                       ] );
                    }
                }
            }
            
            return $voucher_no;
            
        }
        
        public function update_transactions ( $request ): void {
            $ledgers          = $request -> input ( 'ledger-id' );
            $amount           = $request -> input ( 'amount' );
            $transaction_date = $request -> input ( 'transaction-date' );
            $description      = $request -> input ( 'description' );
            $payment_mode     = $request -> input ( 'payment-mode' );
            $transaction_no   = $request -> input ( 'transaction-no' );
            
            if ( count ( $ledgers ) > 0 ) {
                foreach ( $ledgers as $key => $ledger_id ) {
                    $generalLedger = GeneralLedger ::findorFail ( $ledger_id );
                    
                    $generalLedger -> credit           = $request -> input ( 'transaction-type-' . $ledger_id ) === 'credit' ? $amount[ $key ] : 0;
                    $generalLedger -> debit            = $request -> input ( 'transaction-type-' . $ledger_id ) === 'debit' ? $amount[ $key ] : 0;
                    $generalLedger -> transaction_date = date ( 'Y-m-d', strtotime ( $transaction_date ) );
                    $generalLedger -> description      = $description;
                    $generalLedger -> payment_mode     = $payment_mode;
                    $generalLedger -> transaction_no   = $transaction_no;
                    
                    $generalLedger -> update ();
                }
            }
            
            ( new LogService() ) -> log ( 'transactions-updated', $request );
        }
        
        public function trialBalance () {
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                return Account ::withSum ( 'trial_balance as totalCredit', 'credit' )
                    -> withSum ( 'trial_balance as totalDebit', 'debit' )
                    -> has ( 'trial_balance' )
                    -> get ();
            }
            return [];
        }
        
        public function customersTrialBalance () {
            $account_head_id = config ( 'constants.account_receivable' );
            $record          = Account ::where ( [ 'account_head_id' => $account_head_id ] )
                -> with ( [ 'running_balance', 'candidate' ] )
                -> withSum ( 'trial_balance as totalCredit', 'credit' )
                -> withSum ( 'trial_balance as totalDebit', 'debit' );
            
            if ( request () -> has ( 'user-id' ) && request () -> filled ( 'user-id' ) ) {
                $user_id = request ( 'user-id' );
                $user    = User ::find ( $user_id );
                
                if ( $user ) {
                    $user -> load ( 'customers' );
                    $customers = $user -> customers -> pluck ( 'account_head_id' ) -> toArray ();
                    $record -> whereIn ( 'id', $customers );
                }
            }
            
            if ( request () -> has ( 'sr-no' ) && request () -> filled ( 'sr-no' ) ) {
                $record -> whereIn ( 'id', function ( $query ) {
                    $query -> select ( 'account_head_id' ) -> from ( 'candidates' ) -> where ( [ 'sr_no' => request ( 'sr-no' ) ] );
                } );
            }
            
            return $record -> orderBy ( 'name', 'ASC' ) -> get ();
        }
        
        public function vendorsTrialBalance () {
            $account_head_id = config ( 'constants.account_payable' );
            return Account ::where ( [ 'account_head_id' => $account_head_id ] )
                -> with ( 'running_balance' )
                -> withSum ( 'trial_balance as totalCredit', 'credit' )
                -> withSum ( 'trial_balance as totalDebit', 'debit' )
                -> orderBy ( 'name', 'ASC' )
                -> get ();
        }
        
        public function get_account_head_running_balance ( $account_head_id, $sale = null, $currentMonth = false, $month = 0 ) {
            
            $account = GeneralLedger ::query ();
            $account -> select ( 'account_head_id', 'credit', 'debit' );
            
            $account -> whereIn ( 'account_head_id', function ( $query ) use ( $account_head_id ) {
                $query -> select ( 'id' ) -> from ( 'account_heads' ) -> where ( [ 'id' => $account_head_id ] );
            } );
            
            if ( ( request () -> has ( 'start-date' ) && request () -> filled ( 'start-date' ) && request () -> has ( 'end-date' ) && request () -> filled ( 'end-date' ) ) && !request ( 'current-month' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $account -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [ $start_date, $end_date ] );
            }
            
            else if ( !empty( $sale ) ) {
                $ledger = GeneralLedger ::where ( [ 'invoice_no' => $sale -> id, 'account_head_id' => $account_head_id ] ) -> first ();
                
                if ( !empty( $ledger ) ) {
                    $account -> where ( DB ::raw ( 'DATE(transaction_date)' ), '<=', date ( 'Y-m-d', strtotime ( $sale -> created_at ) ) );
                    $account -> where ( function ( $query ) use ( $ledger ) {
                        $query -> where ( 'id', '<', $ledger -> id );
                    } );
                }
            }
            
            else if ( $currentMonth || request ( 'current-month' ) == 'true' ) {
                $month = date ( 'm' );
                $account -> where ( DB ::raw ( 'MONTH(transaction_date)' ), '=', $month );
            }
            
            else if ( $month > 0 ) {
                $account -> where ( DB ::raw ( 'MONTH(transaction_date)' ), '=', $month );
            }
            
            $records      = $account -> get ();
            $account_head = Account ::find ( $account_head_id );
            
            $running_balance = 0;
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    if ( in_array ( $account_head -> account_type_id, config ( 'constants.account_type_in' ) ) )
                        $running_balance = $running_balance + $record -> debit - $record -> credit;
                    else
                        $running_balance = $running_balance - $record -> debit + $record -> credit;
                }
            }
            
            return $running_balance;
        }
        
        function update_account_head ( $model ): void {
            $model -> account_head () -> update ( [ 'name' => $model -> name ] );
            ( new LogService() ) -> log ( 'account-updated', $model );
        }
        
        public function account_heads_not_linked_with_user ( $user_id = 0 ) {
            $account_head_id = config ( 'constants.customers' );
            $account_heads   = Account ::where ( [ 'account_head_id' => $account_head_id ] )
                -> whereNotIn ( 'id', function ( $query ) {
                    $query -> select ( 'account_head_id' ) -> from ( 'user_account_heads' );
                } );
            
            if ( $user_id > 0 ) {
                $account_heads -> orWhereIn ( 'id', function ( $query ) use ( $user_id ) {
                    $query -> select ( 'account_head_id' )
                        -> from ( 'user_account_heads' )
                        -> where ( 'user_id', $user_id );
                } );
            }
            
            return $account_heads -> get ();
        }
        
        public function delete_transactions (): void {
            $ledgers = request ( 'ledgers' );
            if ( count ( $ledgers ) > 0 ) {
                foreach ( $ledgers as $ledger ) {
                    ( new LogService() ) -> log ( 'transactions-deleted', $ledger );
                    GeneralLedger ::where ( [ 'id' => $ledger ] ) -> delete ();
                }
            }
        }
        
        public function getRecursiveAccountHeads ( $parentID = 0 ): array {
            if ( $parentID > 0 ) {
                $result  = Account ::where ( [ 'account_head_id' => $parentID ] ) -> get () -> toArray ();
                $records = array ();
                
                foreach ( $result as $row ) {
                    $id                 = $row[ 'id' ];
                    $row[ 'children' ]  = $this -> getRecursiveAccountHeads ( $id );
                    $row[ 'parent_id' ] = $parentID;
                    $records[]          = $row;
                }
                
                return $records;
            }
            return array ();
        }
        
        public function add_transaction_detail ( $request, $account_head ) {
            $sales      = $request -> input ( 'sales', [] );
            $stocks     = $request -> input ( 'stocks', [] );
            $voucher_no = request () -> input ( 'voucher-no' );
            
            if ( count ( $sales ) > 0 ) {
                foreach ( $sales as $sale_id ) {
                    ( new LogService() ) -> log ( 'transactions-details-added', $request );
                    GeneralLedgerTransactionDetails ::create ( [
                                                                   'general_ledger_id' => $account_head -> id,
                                                                   'customer_id'       => $request -> input ( 'account-head-id-2' ),
                                                                   'sale_id'           => $sale_id,
                                                                   'voucher'           => $voucher_no,
                                                                   'voucher_no'        => $account_head -> voucher_no,
                                                               ] );
                }
            }
            
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock_id ) {
                    GeneralLedgerTransactionDetails ::create ( [
                                                                   'general_ledger_id' => $account_head -> id,
                                                                   'vendor_id'         => $request -> input ( 'account-head-id-2' ),
                                                                   'stock_id'          => $stock_id,
                                                                   'voucher'           => $voucher_no,
                                                                   'voucher_no'        => $account_head -> voucher_no,
                                                               ] );
                }
            }
            
        }
        
        public function get_transaction_details_by_search ( $voucher_no ) {
            return !empty( trim ( $voucher_no ) ) ? GeneralLedgerTransactionDetails ::where ( [ 'voucher_no' => $voucher_no ] ) -> get () : [];
        }
        
        public function delete_transaction_details ( $general_ledger ) {
            GeneralLedgerTransactionDetails ::where ( [ 'general_ledger_id' => $general_ledger -> id ] ) -> delete ();
        }
        
        public function update_transaction_detail ( $request, $account_head, $general_ledger ) {
            $sales      = $request -> input ( 'sales', [] );
            $stocks     = $request -> input ( 'stocks', [] );
            $voucher_no = $general_ledger -> voucher_no;
            $voucher    = explode ( '-', $voucher_no );
            $voucher    = $voucher[ 0 ];
            
            if ( count ( $sales ) > 0 ) {
                foreach ( $sales as $sale_id ) {
                    GeneralLedgerTransactionDetails ::create ( [
                                                                   'general_ledger_id' => $general_ledger -> id,
                                                                   'customer_id'       => $general_ledger -> account_head_id,
                                                                   'sale_id'           => $sale_id,
                                                                   'voucher'           => $voucher,
                                                                   'voucher_no'        => $voucher_no,
                                                               ] );
                }
            }
            
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock_id ) {
                    GeneralLedgerTransactionDetails ::create ( [
                                                                   'general_ledger_id' => $general_ledger -> id,
                                                                   'vendor_id'         => $general_ledger -> account_head_id,
                                                                   'stock_id'          => $stock_id,
                                                                   'voucher'           => $voucher,
                                                                   'voucher_no'        => $voucher_no,
                                                               ] );
                }
            }
            
        }
        
        public function get_account_head_by_id ( $account_head ) {
            return Account ::find ( $account_head );
        }
        
        public function get_sales_running_balance ( $account_head_id, $column = '' ) {
            $account = GeneralLedger ::query ();
            $account -> select ( 'account_head_id', 'credit', 'debit' );
            
            $account -> whereIn ( 'account_head_id', function ( $query ) use ( $account_head_id ) {
                $query -> select ( 'id' ) -> from ( 'account_heads' ) -> where ( [ 'id' => $account_head_id ] );
            } );
            
            if ( request () -> has ( 'start-date' ) && request () -> filled ( 'start-date' ) && request () -> has ( 'end-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $account -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [ $start_date, $end_date ] );
            }
            else if ( request () -> routeIs ( 'balance-sheet' ) && request () -> filled ( 'start-date' ) ) {
                $financial_year = FinancialYear ::first ();
                $start_date     = $financial_year -> start_date;
                $end_date       = request () -> input ( 'start-date' );
                $account -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [ $start_date, $end_date ] );
            }
            else if ( request ( 'current-month' ) == 'true' ) {
                $month = date ( 'm' );
                $account -> where ( DB ::raw ( 'MONTH(transaction_date)' ), '=', $month );
            }
            
            $records      = $account -> get ();
            $account_head = Account ::find ( $account_head_id );
            
            $running_balance = 0;
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    if ( $column === 'credit' )
                        $running_balance = $running_balance + $record -> credit;
                    else if ( $column === 'debit' )
                        $running_balance = $running_balance + $record -> debit;
                    else {
                        if ( in_array ( $account_head -> account_type_id, config ( 'constants.account_type_in' ) ) )
                            $running_balance = $running_balance + $record -> debit - $record -> credit;
                        else
                            $running_balance = $running_balance - $record -> debit + $record -> credit;
                    }
                }
            }
            
            return $running_balance;
        }
        
        public function get_recursive_account_head_running_balance ( $account_head_id, $running_balance = 0 ) {
            
            $account = GeneralLedger ::query ();
            $account -> select ( 'account_head_id', 'credit', 'debit' );
            
            $account -> whereIn ( 'account_head_id', function ( $query ) use ( $account_head_id ) {
                $query -> select ( 'id' ) -> from ( 'account_heads' ) -> where ( [ 'id' => $account_head_id ] );
            } );
            
            if ( request () -> filled ( 'start-date' ) ) {
                
                $financial_year = FinancialYear ::first ();
                if ( $financial_year )
                    $start_date = $financial_year -> start_date;
                else {
                    $month = date ( 'm' );
                    if ( $month < 7 )
                        $year = date ( 'Y' ) - 1;
                    else
                        $year = date ( 'Y' );
                    $start_date = $year . '-07-01';
                }
                
                $trans_date = date ( 'Y-m-d', strtotime ( request () -> input ( 'start-date' ) ) );
                $account -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [ $start_date, $trans_date ] );
            }
            
            $records      = $account -> get ();
            $account_head = Account ::find ( $account_head_id );
            
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    if ( in_array ( $account_head -> account_type_id, config ( 'constants.account_type_in' ) ) )
                        $running_balance = $running_balance + $record -> debit - $record -> credit;
                    else
                        $running_balance = $running_balance - $record -> debit + $record -> credit;
                }
            }
            
            $accountHeads = Account ::where ( [ 'account_head_id' => $account_head_id ] ) -> get ();
            if ( count ( $accountHeads ) > 0 )
                $running_balance = $this -> calculate_recursive_account_heads_running_balance ( $accountHeads, $running_balance );
            
            return $running_balance;
        }
        
        public function calculate_recursive_account_heads_running_balance ( $account_heads, $running_balance ) {
            if ( count ( $account_heads ) > 0 ) {
                foreach ( $account_heads as $account_headInfo ) {
                    $account_head_id = $account_headInfo -> id;
                    $account         = GeneralLedger ::query ();
                    $account -> select ( 'account_head_id', 'credit', 'debit' );
                    
                    $account -> whereIn ( 'account_head_id', function ( $query ) use ( $account_head_id ) {
                        $query -> select ( 'id' ) -> from ( 'account_heads' ) -> where ( [ 'id' => $account_head_id ] );
                    } );
                    
                    if ( request () -> filled ( 'start-date' ) ) {
                        
                        $financial_year = FinancialYear ::first ();
                        if ( $financial_year )
                            $start_date = $financial_year -> start_date;
                        else {
                            $month = date ( 'm' );
                            if ( $month < 7 )
                                $year = date ( 'Y' ) - 1;
                            else
                                $year = date ( 'Y' );
                            $start_date = $year . '-07-01';
                        }
                        
                        $trans_date = date ( 'Y-m-d', strtotime ( request () -> input ( 'start-date' ) ) );
                        $account -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [ $start_date, $trans_date ] );
                    }
                    
                    $records = $account -> get ();
                    
                    if ( count ( $records ) > 0 ) {
                        foreach ( $records as $record ) {
                            if ( in_array ( $account_headInfo -> account_type_id, config ( 'constants.account_type_in' ) ) )
                                $running_balance = $running_balance + $record -> debit - $record -> credit;
                            else
                                $running_balance = $running_balance - $record -> debit + $record -> credit;
                        }
                    }
                    
                    $accountHeads = Account ::where ( [ 'account_head_id' => $account_head_id ] ) -> get ();
                    if ( count ( $accountHeads ) > 0 )
                        $running_balance = $this -> calculate_recursive_account_heads_running_balance ( $accountHeads, $running_balance );
                }
            }
            
            return $running_balance;
        }
        
        public function add_candidate ( $request, $candidate ): mixed {
            $accountHead = Account ::find ( config ( 'constants.customers' ) );
            ( new LogService() ) -> log ( 'candidate-account-head-added', $candidate );
            return Account ::create ( [
                                          'user_id'         => auth () -> user () -> id,
                                          'account_head_id' => $accountHead -> id,
                                          'account_type_id' => $accountHead -> account_type_id,
                                          'name'            => $candidate -> fullName () . ' (' . $candidate -> srNo () . ')',
                                          'phone'           => $candidate -> mobile,
                                      ] );
        }
        
        public function edit_candidate ( $candidate ): void {
            $accountHead = Account ::find ( $candidate -> account_head_id );
            
            if ( $accountHead ) {
                $accountHead -> name  = $candidate -> fullName () . ' (' . $candidate -> srNo () . ')';
                $accountHead -> phone = $candidate -> mobile;
                $accountHead -> update ();
                ( new LogService() ) -> log ( 'candidate-account-head-updated', $accountHead );
            }
            else
                $this -> add_candidate ( request (), $candidate );
        }
        
        public function add_vendor ( $vendor ): mixed {
            $accountHead = Account ::find ( config ( 'constants.vendors' ) );
            ( new LogService() ) -> log ( 'vendor-account-head-added', $vendor );
            return Account ::create ( [
                                          'user_id'         => auth () -> user () -> id,
                                          'account_head_id' => $accountHead -> id,
                                          'account_type_id' => $accountHead -> account_type_id,
                                          'name'            => $vendor -> title,
                                          'phone'           => $vendor -> contact,
                                      ] );
        }
        
        public function edit_vendor ( $vendor ): void {
            $accountHead = Account ::find ( $vendor -> account_head_id );
            
            if ( $accountHead ) {
                $accountHead -> name  = $vendor -> title;
                $accountHead -> phone = $vendor -> contact;
                $accountHead -> update ();
                ( new LogService() ) -> log ( 'vendor-account-head-updated', $vendor );
            }
            else
                $this -> add_candidate ( request (), $vendor );
        }
        
        public function add_payment_method ( $method ): mixed {
            $accountHead = Account ::find ( config ( 'constants.banks' ) );
            ( new LogService() ) -> log ( 'payment-method-added', $method );
            return Account ::create ( [
                                          'user_id'         => auth () -> user () -> id,
                                          'account_head_id' => $accountHead -> id,
                                          'account_type_id' => $accountHead -> account_type_id,
                                          'name'            => $method -> title,
                                      ] );
        }
        
        public function edit_payment_method ( $method ): void {
            $accountHead = Account ::find ( $method -> account_head_id );
            
            if ( $accountHead ) {
                $accountHead -> name = $method -> title;
                $accountHead -> update ();
                ( new LogService() ) -> log ( 'payment-method-updated', $method );
            }
            else
                $this -> add_payment_method ( request (), $method );
        }
        
        public function get_daily_account_head_running_balance ( $account_head_id ) {
            
            $account = GeneralLedger ::query ();
            $account -> select ( 'account_head_id', 'credit', 'debit' );
            
            $account -> whereIn ( 'account_head_id', function ( $query ) use ( $account_head_id ) {
                $query -> select ( 'id' ) -> from ( 'account_heads' ) -> where ( [ 'id' => $account_head_id ] );
            } );
            
            $date = date ( 'Y-m-d' );
            $account -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [ $date, $date ] );
            
            $records      = $account -> get ();
            $account_head = Account ::find ( $account_head_id );
            
            $running_balance = 0;
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    $running_balance = ( new GeneralLedgerService() ) -> calculate_running_balance ( $running_balance, $record -> credit, $record -> debit, $account_head );
                }
            }
            
            return $running_balance;
        }
        
        public function status ( $account ): void {
            $account -> active = !$account -> active;
            $account -> update ();
        }
    }
