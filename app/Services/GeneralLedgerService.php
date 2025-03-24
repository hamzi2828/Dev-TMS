<?php
    
    namespace App\Services;
    
    use App\Http\Helpers\AdjustmentService;
    use App\Http\Helpers\GeneralHelper;
    use App\Models\Fee;
    use App\Models\PaymentMethod;
    use App\Models\Principal;
    use App\Models\PrincipalJob;
    use App\Services\AccountService;
    use App\Models\Account;
    use App\Models\Customer;
    use App\Models\GeneralLedger;
    use App\Models\Vendor;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\DB;
    
    class GeneralLedgerService {
        
        /**
         * --------------
         * @param $stock
         * @return void
         * save general ledger on following basis
         * gets vendor & its account role along with role models
         * then saves the initial values
         * --------------
         */
        
        public function save_stock_added_ledger ( $stock ): void {
            
            if ( request () -> has ( 'vendor-id' ) && request () -> filled ( 'vendor-id' ) )
                $vendor = Vendor ::find ( request () -> input ( 'vendor-id' ) );
            else if ( request () -> has ( 'customer-id' ) && request () -> filled ( 'customer-id' ) )
                $vendor = Customer ::find ( request () -> input ( 'customer-id' ) );
            
            $description = null;
            if ( $stock -> stock_type == 'customer-return' )
                $description = 'Stock return by customer. Reference No. ' . request ( 'invoice-no' );
            
            if ( !empty( $vendor ) && $vendor -> account_head_id > 0 ) {
                
                $accountHead = Account ::find ( $vendor -> account_head_id );
                $accountHead -> load ( 'account_type' );
                
                $stock -> general_ledger () -> create ( [
                                                            'user_id'          => auth () -> user () -> id,
                                                            'account_head_id'  => $accountHead -> id,
                                                            'invoice_no'       => request () -> input ( 'invoice-no' ),
                                                            'credit'           => 0,
                                                            'debit'            => 0,
                                                            'transaction_date' => date ( 'Y-m-d', strtotime ( $stock -> stock_date ) ),
                                                            'description'      => $description
                                                        ] );
                
                $stock -> general_ledger () -> create ( [
                                                            'user_id'          => auth () -> user () -> id,
                                                            'account_head_id'  => config ( 'constants.stock.inventory' ),
                                                            'invoice_no'       => request () -> input ( 'invoice-no' ),
                                                            'credit'           => 0,
                                                            'debit'            => 0,
                                                            'transaction_date' => date ( 'Y-m-d', strtotime ( $stock -> stock_date ) ),
                                                            'description'      => $description
                                                        ] );
                
            }
        }
        
        /**
         * --------------
         * @param $stock
         * @return void
         * updates general ledger on following basis
         * get account head of vendor, checks its account type, basis on that updates the values
         * gets vendor & its account role along with role models
         * then updates the values by role model type
         * --------------
         */
        
        public function update_stock_added_ledger ( $stock ): void {
            
            if ( request () -> has ( 'vendor-id' ) && request () -> filled ( 'vendor-id' ) ) {
                $vendor = Vendor ::find ( request () -> input ( 'vendor-id' ) );
                $vendor -> load ( [ 'account_role.role_models' ] );
            }
            else if ( request () -> has ( 'customer-id' ) && request () -> filled ( 'customer-id' ) )
                $vendor = Customer ::find ( request () -> input ( 'customer-id' ) );
            
            $total = ( new AdjustmentService() ) -> sum_net_price ();
            
            if ( !empty( $vendor ) && $vendor -> account_head_id > 0 ) {
                
                $accountHead = Account ::find ( $vendor -> account_head_id );
                $accountHead -> load ( 'account_type' );
                $credit = 0;
                $debit  = 0;
                
                if ( $accountHead -> account_type -> type == 'credit' ) {
                    $credit = $total;
                }
                
                if ( $accountHead -> account_type -> type == 'debit' ) {
                    $debit = $total;
                }
                
                if ( $stock -> stock_type == 'customer-return' ) {
                    $stock -> general_ledger () -> update ( [
                                                                'user_id'          => auth () -> user () -> id,
                                                                'credit'           => $total,
                                                                'debit'            => 0,
                                                                'transaction_date' => Carbon ::createFromFormat ( 'Y-m-d', request () -> input ( 'stock-date' ) ),
                                                            ] );
                }
                else {
                    $stock -> general_ledger () -> update ( [
                                                                'user_id'          => auth () -> user () -> id,
                                                                'credit'           => $credit,
                                                                'debit'            => $debit,
                                                                'transaction_date' => Carbon ::createFromFormat ( 'Y-m-d', request () -> input ( 'stock-date' ) ),
                                                            ] );
                }
                
                $ledgerable_type = get_class ( $stock );
                $info            = [
                    'user_id'          => auth () -> user () -> id,
                    'credit'           => 0,
                    'debit'            => $total,
                    'transaction_date' => date ( 'Y-m-d', strtotime ( $stock -> stock_date ) ),
                ];
                
                $ledger = GeneralLedger ::where ( [
                                                      'account_head_id' => config ( 'constants.stock.inventory' ),
                                                      'ledgerable_type' => $ledgerable_type,
                                                      'ledgerable_id'   => $stock -> id
                                                  ] ) -> first ();
                
                $ledger -> update ( $info );
            }
        }
        
        /**
         * --------------
         * @return array
         * search general ledger
         * --------------
         */
        
        public function filter_general_ledgers () {
            if ( request () -> filled ( 'account-head-id' ) || ( request () -> filled ( [
                                                                                            'start-date',
                                                                                            'end-date'
                                                                                        ] ) ) )
                return GeneralLedger ::Filter () -> with ( 'account_head.account_type' ) -> orderBy ( 'transaction_date', 'ASC' ) -> get ();
            else
                return array ();
        }
        
        /**
         * --------------
         * @return int
         * get running balance of any account head
         * --------------
         */
        
        public function get_running_balance () {
            $running_balance = 0;
            
            if ( request () -> filled ( 'account-head-id' ) && ( request () -> filled ( [
                                                                                            'start-date',
                                                                                            'end-date'
                                                                                        ] ) ) )
                $ledgers = GeneralLedger ::RunningBalance () -> with ( 'account_head.account_type' ) -> get ();
            else
                $ledgers = array ();
            
            if ( count ( $ledgers ) > 0 ) {
                foreach ( $ledgers as $ledger ) {
                    if ( in_array ( $ledger -> account_head -> account_type -> id, config ( 'constants.account_type_in' ) ) )
                        $running_balance = $running_balance + $ledger -> debit - $ledger -> credit;
                    else
                        $running_balance = $running_balance - $ledger -> debit + $ledger -> credit;
                }
            }
            return $running_balance;
        }
        
        /**
         * --------------
         * @param $sale
         * @return void
         * save sale ledger
         * --------------
         */
        
        public function save_sale_ledger ( $sale ): void {
            
            $sale -> load ( 'customer' );
            $sale_total = $sale -> net;
            $cost_sale  = ( new SaleService() ) -> get_cost_of_sale_tp_wise ( $sale );
            
            $user = auth () -> user () -> load ( 'branch' );
            
            $sale -> general_ledger () -> create ( [
                                                       'user_id'          => auth () -> user () -> id,
                                                       'account_head_id'  => config ( 'constants.cash_sale.sales' ),
                                                       'invoice_no'       => $sale -> id,
                                                       'credit'           => $sale_total,
                                                       'debit'            => 0,
                                                       'transaction_date' => date ( 'Y-m-d' ),
                                                       'description'      => $user -> branch -> name . ' / ' . $user -> name
                                                   ] );
            
            $sale -> general_ledger () -> create ( [
                                                       'user_id'          => auth () -> user () -> id,
                                                       'account_head_id'  => config ( 'constants.cash_sale.cost_of_products_sold' ),
                                                       'invoice_no'       => $sale -> id,
                                                       'credit'           => 0,
                                                       'debit'            => $cost_sale,
                                                       'transaction_date' => date ( 'Y-m-d' ),
                                                       'description'      => $user -> branch -> name . ' / ' . $user -> name
                                                   ] );
            
            $sale -> general_ledger () -> create ( [
                                                       'user_id'          => auth () -> user () -> id,
                                                       'account_head_id'  => config ( 'constants.cash_sale.inventory' ),
                                                       'invoice_no'       => $sale -> id,
                                                       'credit'           => $cost_sale,
                                                       'debit'            => 0,
                                                       'transaction_date' => date ( 'Y-m-d' ),
                                                       'description'      => $user -> branch -> name . ' / ' . $user -> name
                                                   ] );
            
            if ( $sale -> customer_type === 'cash' ) {
                $sale -> general_ledger () -> create ( [
                                                           'user_id'          => auth () -> user () -> id,
                                                           'account_head_id'  => config ( 'constants.cash_sale.cash_in_hand' ),
                                                           'invoice_no'       => $sale -> id,
                                                           'credit'           => 0,
                                                           'debit'            => $sale_total,
                                                           'transaction_date' => date ( 'Y-m-d' ),
                                                           'description'      => $user -> branch -> name . ' / ' . $user -> name
                                                       ] );
            }
            else {
                $sale -> general_ledger () -> create ( [
                                                           'user_id'          => auth () -> user () -> id,
                                                           'account_head_id'  => $sale -> customer -> account_head_id,
                                                           'invoice_no'       => $sale -> id,
                                                           'credit'           => 0,
                                                           'debit'            => $sale_total,
                                                           'transaction_date' => date ( 'Y-m-d' ),
                                                           'description'      => $user -> branch -> name . ' / ' . $user -> name
                                                       ] );
            }
        }
        
        /**
         * --------------
         * @param $sale
         * @return void
         * reverse sale ledger
         * --------------
         */
        
        public function reverse_sale_ledger ( $sale ): void {
            
            $sale -> load ( 'customer' );
            $sale_total = $sale -> net;
            $cost_sale  = ( new SaleService() ) -> get_cost_of_sale_tp_wise ( $sale );
            
            $user = auth () -> user () -> load ( 'branch' );
            
            $sale -> general_ledger () -> create ( [
                                                       'user_id'          => auth () -> user () -> id,
                                                       'account_head_id'  => config ( 'constants.cash_sale.sales' ),
                                                       'invoice_no'       => $sale -> id,
                                                       'credit'           => 0,
                                                       'debit'            => abs ( $sale_total ),
                                                       'transaction_date' => date ( 'Y-m-d' ),
                                                       'description'      => 'Sale Refunded By ' . $user -> branch -> name . ' / ' . $user -> name
                                                   ] );
            
            $sale -> general_ledger () -> create ( [
                                                       'user_id'          => auth () -> user () -> id,
                                                       'account_head_id'  => config ( 'constants.cash_sale.cost_of_products_sold' ),
                                                       'invoice_no'       => $sale -> id,
                                                       'credit'           => abs ( $cost_sale ),
                                                       'debit'            => 0,
                                                       'transaction_date' => date ( 'Y-m-d' ),
                                                       'description'      => 'Sale Refunded By ' . $user -> branch -> name . ' / ' . $user -> name
                                                   ] );
            
            $sale -> general_ledger () -> create ( [
                                                       'user_id'          => auth () -> user () -> id,
                                                       'account_head_id'  => config ( 'constants.cash_sale.inventory' ),
                                                       'invoice_no'       => $sale -> id,
                                                       'credit'           => 0,
                                                       'debit'            => abs ( $cost_sale ),
                                                       'transaction_date' => date ( 'Y-m-d' ),
                                                       'description'      => 'Sale Refunded By ' . $user -> branch -> name . ' / ' . $user -> name
                                                   ] );
            
            if ( $sale -> customer_type === 'cash' ) {
                $sale -> general_ledger () -> create ( [
                                                           'user_id'          => auth () -> user () -> id,
                                                           'account_head_id'  => config ( 'constants.cash_sale.cash_in_hand' ),
                                                           'invoice_no'       => $sale -> id,
                                                           'credit'           => abs ( $sale_total ),
                                                           'debit'            => 0,
                                                           'transaction_date' => date ( 'Y-m-d' ),
                                                           'description'      => 'Sale Refunded By ' . $user -> branch -> name . ' / ' . $user -> name
                                                       ] );
            }
            else {
                $sale -> general_ledger () -> create ( [
                                                           'user_id'          => auth () -> user () -> id,
                                                           'account_head_id'  => $sale -> customer -> account_head_id,
                                                           'invoice_no'       => $sale -> id,
                                                           'credit'           => abs ( $sale_total ),
                                                           'debit'            => 0,
                                                           'transaction_date' => date ( 'Y-m-d' ),
                                                           'description'      => 'Sale Refunded By ' . $user -> branch -> name . ' / ' . $user -> name
                                                       ] );
            }
        }
        
        /**
         * --------------
         * @param $request
         * @return void
         * search transactions by voucher no
         * --------------
         */
        
        public function search_transactions_by_voucher ( $request ) {
            if ( $request -> has ( 'voucher-no' ) && $request -> filled ( 'voucher-no' ) ) {
                $voucher_no = $request -> input ( 'voucher-no' );
                return GeneralLedger ::where ( [ 'voucher_no' => $voucher_no ] ) -> with ( [ 'account_head' ] ) -> get ();
            }
            else if ( $request -> has ( 'transaction-id' ) && $request -> filled ( 'transaction-id' ) ) {
                $transaction_id = $request -> input ( 'transaction-id' );
                return GeneralLedger ::where ( [ 'id' => $transaction_id ] ) -> with ( [ 'account_head' ] ) -> get ();
            }
            return array ();
        }
        
        /**
         * --------------
         * @param $stock
         * @return void
         * save general ledger on following basis
         * gets vendor & its account role along with role models
         * then saves the initial values
         * --------------
         */
        
        public function save_stock_return_ledger ( $stock ): void {
            
            $vendor = Vendor ::find ( $stock -> vendor_id );
            $vendor -> load ( [ 'account_role.role_models' ] );
            $total       = request () -> input ( 'return-total' );
            $description = 'Stock return by vendor. Reference No. ' . request ( 'reference-no' );
            
            if ( !empty( $vendor ) && $vendor -> account_head_id > 0 ) {
                
                $accountHead = Account ::find ( $vendor -> account_head_id );
                $accountHead -> load ( 'account_type' );
                $credit = 0;
                $debit  = 0;
                
                if ( $accountHead -> account_type -> type == 'credit' ) {
                    $credit = $total;
                }
                
                if ( $accountHead -> account_type -> type == 'debit' ) {
                    $debit = $total;
                }
                
                $stock -> general_ledger () -> create ( [
                                                            'user_id'          => auth () -> user () -> id,
                                                            'account_head_id'  => $accountHead -> id,
                                                            'invoice_no'       => request ( 'reference-no' ),
                                                            'credit'           => $debit,
                                                            'debit'            => $credit,
                                                            'transaction_date' => Carbon ::now (),
                                                            'description'      => $description
                                                        ] );
                
                $stock -> general_ledger () -> create ( [
                                                            'user_id'          => auth () -> user () -> id,
                                                            'account_head_id'  => config ( 'constants.stock.inventory' ),
                                                            'invoice_no'       => request ( 'reference-no' ),
                                                            'credit'           => $total,
                                                            'debit'            => 0,
                                                            'transaction_date' => Carbon ::now (),
                                                            'description'      => $description
                                                        ] );
            }
            
        }
        
        /**
         * --------------
         * @param $stock
         * @return void
         * save general ledger on following basis
         * gets vendor & its account role along with role models
         * then saves the initial values
         * --------------
         */
        
        public function update_stock_return_ledger ( $stockReturn ): void {
            
            $vendor = Vendor ::find ( $stockReturn -> vendor_id );
            $vendor -> load ( [ 'account_role.role_models' ] );
//            $total = request () -> input ( 'return-total' );
            $total = ( new StockReturnService() ) -> sum_total_stock_return_value ();
            
            if ( !empty( $vendor ) && $vendor -> account_head_id > 0 ) {
                
                $accountHead = Account ::find ( $vendor -> account_head_id );
                $accountHead -> load ( 'account_type' );
                $credit = 0;
                $debit  = 0;
                
                if ( $accountHead -> account_type -> type == 'credit' ) {
                    $credit = $total;
                }
                
                if ( $accountHead -> account_type -> type == 'debit' ) {
                    $debit = $total;
                }
                
                $ledgerable_type = get_class ( $stockReturn );
                $info            = [
                    'user_id' => auth () -> user () -> id,
                    'credit'  => $debit,
                    'debit'   => $credit,
                ];
                
                $ledger = GeneralLedger ::where ( [
                                                      'account_head_id' => $accountHead -> id,
                                                      'ledgerable_type' => $ledgerable_type,
                                                      'ledgerable_id'   => $stockReturn -> id
                                                  ] ) -> first ();
                
                $ledger -> update ( $info );
                
                $ledgerable_type = get_class ( $stockReturn );
                $info            = [
                    'user_id' => auth () -> user () -> id,
                    'credit'  => $total,
                    'debit'   => 0,
                ];
                $ledger          = GeneralLedger ::where ( [
                                                               'account_head_id' => config ( 'constants.stock.inventory' ),
                                                               'ledgerable_type' => $ledgerable_type,
                                                               'ledgerable_id'   => $stockReturn -> id
                                                           ] ) -> first ();
                $ledger -> update ( $info );
            }
            
        }
        
        public function delete_stock_added_ledger ( $stock ) {
            
            if ( !empty( trim ( $stock -> vendor_id ) ) && $stock -> vendor_id > 0 ) {
                $vendor = Vendor ::find ( $stock -> vendor_id );
                $vendor -> load ( [ 'account_role.role_models' ] );
            }
            else if ( !empty( trim ( $stock -> customer_id ) ) && $stock -> customer_id > 0 )
                $vendor = Customer ::find ( $stock -> customer_id );
            
            if ( !empty( $vendor ) && $vendor -> account_head_id > 0 ) {
                
                $accountHead = Account ::find ( $vendor -> account_head_id );
                $accountHead -> load ( 'account_type' );
                
                $stock -> general_ledger () -> delete ();
                
                $ledgerable_type = get_class ( $stock );
                
                $ledger = GeneralLedger ::where ( [
                                                      'account_head_id' => config ( 'constants.stock.inventory' ),
                                                      'ledgerable_type' => $ledgerable_type,
                                                      'ledgerable_id'   => $stock -> id
                                                  ] ) -> first ();
                
                $ledger -> delete ();
            }
        }
        
        public function save_stock_customer_return_ledger ( $stock ): void {
            
            if ( request () -> has ( 'vendor-id' ) && request () -> filled ( 'vendor-id' ) )
                $vendor = Vendor ::find ( request () -> input ( 'vendor-id' ) );
            else if ( request () -> has ( 'customer-id' ) && request () -> filled ( 'customer-id' ) )
                $vendor = Customer ::find ( request () -> input ( 'customer-id' ) );
            
            $description = null;
            if ( $stock -> stock_type == 'customer-return' )
                $description = 'Stock return by customer. Reference No. ' . request ( 'invoice-no' );
            
            if ( !empty( $vendor ) && $vendor -> account_head_id > 0 ) {
                
                $accountHead = Account ::find ( $vendor -> account_head_id );
                $accountHead -> load ( 'account_type' );
                
                $stock -> general_ledger () -> create ( [
                                                            'user_id'          => auth () -> user () -> id,
                                                            'account_head_id'  => $accountHead -> id,
                                                            'invoice_no'       => request () -> input ( 'invoice-no' ),
                                                            'credit'           => 0,
                                                            'debit'            => 0,
                                                            'transaction_date' => date ( 'Y-m-d', strtotime ( $stock -> stock_date ) ),
                                                            'description'      => $description
                                                        ] );
                
                $stock -> general_ledger () -> create ( [
                                                            'user_id'          => auth () -> user () -> id,
                                                            'account_head_id'  => config ( 'constants.stock.inventory' ),
                                                            'invoice_no'       => request () -> input ( 'invoice-no' ),
                                                            'credit'           => 0,
                                                            'debit'            => 0,
                                                            'transaction_date' => date ( 'Y-m-d', strtotime ( $stock -> stock_date ) ),
                                                            'description'      => $description
                                                        ] );
                
                $stock -> general_ledger () -> create ( [
                                                            'user_id'          => auth () -> user () -> id,
                                                            'account_head_id'  => config ( 'constants.cash_sale.sales' ),
                                                            'invoice_no'       => request () -> input ( 'invoice-no' ),
                                                            'credit'           => 0,
                                                            'debit'            => 0,
                                                            'transaction_date' => date ( 'Y-m-d', strtotime ( $stock -> stock_date ) ),
                                                            'description'      => $description
                                                        ] );
                
                $stock -> general_ledger () -> create ( [
                                                            'user_id'          => auth () -> user () -> id,
                                                            'account_head_id'  => config ( 'constants.cash_sale.cost_of_products_sold' ),
                                                            'invoice_no'       => request () -> input ( 'invoice-no' ),
                                                            'credit'           => 0,
                                                            'debit'            => 0,
                                                            'transaction_date' => date ( 'Y-m-d', strtotime ( $stock -> stock_date ) ),
                                                            'description'      => $description
                                                        ] );
                
            }
        }
        
        public function update_stock_customer_return_ledger ( $stock ): void {
            
            $vendor = Customer ::find ( request () -> input ( 'customer-id' ) );
            
            $total = ( new AdjustmentService() ) -> sum_net_price ();
            
            if ( !empty( $vendor ) && $vendor -> account_head_id > 0 ) {
                
                $accountHead = Account ::find ( $vendor -> account_head_id );
                $accountHead -> load ( 'account_type' );
                
                $return_total = ( new StockService() ) -> return_customer_stock_total ();
                $cost_sale    = $total;
                
                $stock -> general_ledger () -> update ( [
                                                            'user_id'          => auth () -> user () -> id,
                                                            'credit'           => $return_total,
                                                            'debit'            => 0,
                                                            'transaction_date' => Carbon ::createFromFormat ( 'Y-m-d', request () -> input ( 'stock-date' ) ),
                                                        ] );
                
                $ledgerable_type = get_class ( $stock );
                $info            = [
                    'user_id'          => auth () -> user () -> id,
                    'credit'           => 0,
                    'debit'            => $cost_sale,
                    'transaction_date' => date ( 'Y-m-d', strtotime ( $stock -> stock_date ) ),
                ];
                
                $ledger = GeneralLedger ::where ( [
                                                      'account_head_id' => config ( 'constants.stock.inventory' ),
                                                      'ledgerable_type' => $ledgerable_type,
                                                      'ledgerable_id'   => $stock -> id
                                                  ] ) -> first ();
                
                $ledger -> update ( $info );
                
                $ledger = GeneralLedger ::where ( [
                                                      'account_head_id' => config ( 'constants.cash_sale.sales' ),
                                                      'ledgerable_type' => $ledgerable_type,
                                                      'ledgerable_id'   => $stock -> id
                                                  ] ) -> first ();
                
                $info = [
                    'user_id'          => auth () -> user () -> id,
                    'credit'           => 0,
                    'debit'            => $return_total,
                    'transaction_date' => date ( 'Y-m-d', strtotime ( $stock -> stock_date ) ),
                ];
                $ledger -> update ( $info );
                
                $ledger = GeneralLedger ::where ( [
                                                      'account_head_id' => config ( 'constants.cash_sale.cost_of_products_sold' ),
                                                      'ledgerable_type' => $ledgerable_type,
                                                      'ledgerable_id'   => $stock -> id
                                                  ] ) -> first ();
                
                $info = [
                    'user_id'          => auth () -> user () -> id,
                    'credit'           => $cost_sale,
                    'debit'            => 0,
                    'transaction_date' => date ( 'Y-m-d', strtotime ( $stock -> stock_date ) ),
                ];
                $ledger -> update ( $info );
            }
        }
        
        /**
         * --------------
         * @param $stock
         * @return void
         * save general ledger on following basis
         * gets vendor & its account role along with role models
         * then saves the initial values
         * --------------
         */
        
        public function save_adjustment_added_ledger ( $stock ): void {
            
            $stock -> general_ledger () -> create ( [
                                                        'user_id'          => auth () -> user () -> id,
                                                        'account_head_id'  => config ( 'constants.stock.inventory' ),
                                                        'invoice_no'       => request () -> input ( 'invoice-no' ),
                                                        'credit'           => 0,
                                                        'debit'            => 0,
                                                        'transaction_date' => date ( 'Y-m-d', strtotime ( $stock -> stock_date ) ),
                                                        'description'      => request ( 'description' )
                                                    ] );
            
            $stock -> general_ledger () -> create ( [
                                                        'user_id'          => auth () -> user () -> id,
                                                        'account_head_id'  => config ( 'constants.adjustment_increase' ),
                                                        'invoice_no'       => request () -> input ( 'invoice-no' ),
                                                        'credit'           => 0,
                                                        'debit'            => 0,
                                                        'transaction_date' => date ( 'Y-m-d', strtotime ( $stock -> stock_date ) ),
                                                        'description'      => request ( 'description' )
                                                    ] );
            
        }
        
        /**
         * --------------
         * @param $stock
         * @return void
         * updates general ledger on following basis
         * get account head of vendor, checks its account type, basis on that updates the values
         * gets vendor & its account role along with role models
         * then updates the values by role model type
         * --------------
         */
        
        public function update_adjustment_added_ledger ( $stock ): void {
            
            $total = ( new AdjustmentService() ) -> sum_net_price ();
            
            $ledgerable_type = get_class ( $stock );
            $info            = [
                'user_id'          => auth () -> user () -> id,
                'credit'           => 0,
                'debit'            => $total,
                'transaction_date' => date ( 'Y-m-d', strtotime ( $stock -> stock_date ) ),
            ];
            
            $ledger = GeneralLedger ::where ( [
                                                  'account_head_id' => config ( 'constants.stock.inventory' ),
                                                  'ledgerable_type' => $ledgerable_type,
                                                  'ledgerable_id'   => $stock -> id
                                              ] ) -> first ();
            
            $ledger -> update ( $info );
            
            
            $info = [
                'user_id'          => auth () -> user () -> id,
                'credit'           => $total,
                'debit'            => 0,
                'transaction_date' => date ( 'Y-m-d', strtotime ( $stock -> stock_date ) ),
            ];
            
            $ledger = GeneralLedger ::where ( [
                                                  'account_head_id' => config ( 'constants.adjustment_increase' ),
                                                  'ledgerable_type' => $ledgerable_type,
                                                  'ledgerable_id'   => $stock -> id
                                              ] ) -> first ();
            
            $ledger -> update ( $info );
            
        }
        
        /**
         * --------------
         * @param $stock
         * @return void
         * save general ledger on following basis
         * gets vendor & its account role along with role models
         * then saves the initial values
         * --------------
         */
        
        public function save_adjustment_decrease_ledger ( $stock ): void {
            
            $stock -> general_ledger () -> create ( [
                                                        'user_id'          => auth () -> user () -> id,
                                                        'account_head_id'  => config ( 'constants.stock.inventory' ),
                                                        'invoice_no'       => request () -> input ( 'invoice-no' ),
                                                        'credit'           => $stock -> net_price,
                                                        'debit'            => 0,
                                                        'transaction_date' => date ( 'Y-m-d' ),
                                                        'description'      => request ( 'description' )
                                                    ] );
            
            $stock -> general_ledger () -> create ( [
                                                        'user_id'          => auth () -> user () -> id,
                                                        'account_head_id'  => config ( 'constants.adjustment_decrease' ),
                                                        'invoice_no'       => request () -> input ( 'invoice-no' ),
                                                        'credit'           => 0,
                                                        'debit'            => $stock -> net_price,
                                                        'transaction_date' => date ( 'Y-m-d' ),
                                                        'description'      => request ( 'description' )
                                                    ] );
            
        }
        
        /**
         * --------------
         * @param $stock
         * @return void
         * save general ledger on following basis
         * gets vendor & its account role along with role models
         * then saves the initial values
         * --------------
         */
        
        public function update_adjustment_decrease_ledger ( $stock ): void {
            
            $ledgerable_type = get_class ( $stock );
            $info            = [
                'user_id' => auth () -> user () -> id,
                'credit'  => $stock -> net_price,
                'debit'   => 0,
            ];
            
            $ledger = GeneralLedger ::where ( [
                                                  'account_head_id' => config ( 'constants.stock.inventory' ),
                                                  'ledgerable_type' => $ledgerable_type,
                                                  'ledgerable_id'   => $stock -> id
                                              ] ) -> first ();
            
            $ledger -> update ( $info );
            
            
            $info = [
                'user_id' => auth () -> user () -> id,
                'credit'  => 0,
                'debit'   => $stock -> net_price,
            ];
            
            $ledger = GeneralLedger ::where ( [
                                                  'account_head_id' => config ( 'constants.adjustment_decrease' ),
                                                  'ledgerable_type' => $ledgerable_type,
                                                  'ledgerable_id'   => $stock -> id
                                              ] ) -> first ();
            
            $ledger -> update ( $info );
        }
        
        /**
         * --------------
         * @param $stock
         * @return void
         * save general ledger on following basis
         * gets vendor & its account role along with role models
         * then saves the initial values
         * --------------
         */
        
        public function save_damage_stock_ledger ( $stock ): void {
            
            $stock -> general_ledger () -> create ( [
                                                        'user_id'          => auth () -> user () -> id,
                                                        'account_head_id'  => config ( 'constants.stock.inventory' ),
                                                        'invoice_no'       => request () -> input ( 'invoice-no' ),
                                                        'credit'           => $stock -> net_price,
                                                        'debit'            => 0,
                                                        'transaction_date' => date ( 'Y-m-d' ),
                                                        'description'      => request ( 'description' )
                                                    ] );
            
            $stock -> general_ledger () -> create ( [
                                                        'user_id'          => auth () -> user () -> id,
                                                        'account_head_id'  => config ( 'constants.damage_loss' ),
                                                        'invoice_no'       => request () -> input ( 'invoice-no' ),
                                                        'credit'           => 0,
                                                        'debit'            => $stock -> net_price,
                                                        'transaction_date' => date ( 'Y-m-d' ),
                                                        'description'      => request ( 'description' )
                                                    ] );
            
        }
        
        /**
         * --------------
         * @param $stock
         * @return void
         * save general ledger on following basis
         * gets vendor & its account role along with role models
         * then saves the initial values
         * --------------
         */
        
        public function update_damage_stock_ledger ( $stock ): void {
            
            $ledgerable_type = get_class ( $stock );
            $info            = [
                'user_id' => auth () -> user () -> id,
                'credit'  => $stock -> net_price,
                'debit'   => 0,
            ];
            
            $ledger = GeneralLedger ::where ( [
                                                  'account_head_id' => config ( 'constants.stock.inventory' ),
                                                  'ledgerable_type' => $ledgerable_type,
                                                  'ledgerable_id'   => $stock -> id
                                              ] ) -> first ();
            
            $ledger -> update ( $info );
            
            
            $info = [
                'user_id' => auth () -> user () -> id,
                'credit'  => 0,
                'debit'   => $stock -> net_price,
            ];
            
            $ledger = GeneralLedger ::where ( [
                                                  'account_head_id' => config ( 'constants.damage_loss' ),
                                                  'ledgerable_type' => $ledgerable_type,
                                                  'ledgerable_id'   => $stock -> id
                                              ] ) -> first ();
            
            $ledger -> update ( $info );
        }
        
        function build_ledgers_table ( $ledgers, $level = 0, $net_closing_balance = 0 ): array {
            $html       = '';
            $start_date = request ( 'start-date' );
            
            if ( $ledgers and count ( array_filter ( $ledgers ) ) > 0 ) {
                foreach ( $ledgers as $ledger ) {
                    $acc_head_id     = $ledger[ 'id' ];
                    $counter         = 1;
                    $total_credit    = 0;
                    $total_debit     = 0;
                    $running_balance = 0;
                    $transactions    = $this -> search_transactions ( $acc_head_id );
                    $acc_head        = ( new AccountService() ) -> get_account_head_by_id ( $acc_head_id );
                    
                    $html .= '<tr>';
                    $html .= '<td></td>';
                    $html .= '<td colspan="9">';
                    $html .= '<strong style="font-size: 12pt; color: #FF0000;">' . $acc_head -> name . '</strong>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    
                    if ( count ( $transactions ) > 0 ) {
                        
                        $current_opening_balance = $this -> get_opening_balance_previous_than_searched_start_date ( $start_date, $acc_head_id );
                        $opening_balance_date    = ( new GeneralHelper() ) -> format_date ( $start_date );
                        
                        if ( abs ( $current_opening_balance ) > 0 ) :
                            $running_balance = $current_opening_balance;
                            $html            .= '<tr>';
                            $html            .= '<td colspan="5"></td>';
                            $html            .= '<td colspan="4"><strong> Opening balance of ' . $opening_balance_date . '</strong></td>';
                            $html            .= '<td><strong> ' . number_format ( $current_opening_balance, 2 ) . '</strong></td>';
                            $html            .= '</tr>';
                        endif;
                        
                        foreach ( $transactions as $transaction ) {
                            
                            if ( $transaction -> transaction_type == 'opening_balance' )
                                $running_balance = $transaction[ 'debit' ] + $transaction[ 'credit' ];
                            
                            else
                                $running_balance = $this -> calculate_running_balance ( $running_balance, $transaction[ 'credit' ], $transaction[ 'debit' ], $acc_head );
                            
                            $second          = $this -> check_id_double_entry ( $transaction -> voucher_number, $transaction[ 'id' ] );
                            $opening_balance = $transaction -> payment_mode === 'opening-balance' ? 'opening' : '';
                            
                            $html .= '<tr class="odd gradeX ' . $opening_balance . '">';
                            $html .= '<td align="center">' . $counter++ . '</td>';
                            $html .= '<td>';
                            $html .= $transaction -> id;
                            if ( count ( $second ) > 0 ) {
                                foreach ( $second as $item ) {
                                    $html .= ' - ' . $item -> id . '<br/>';
                                }
                            }
                            $html         .= '</td>';
                            $html         .= '<td>';
                            $html         .= $transaction[ 'invoice_no' ];
                            $html         .= '</td>';
                            $html         .= '<td>' . $transaction[ 'transaction_no' ] . '</td>';
                            $html         .= '<td>';
                            $url          = route ( 'accounts.search-transactions', [ 'voucher-no' => $transaction[ 'voucher_no' ] ] );
                            $html         .= '<a href="' . $url . '" target="_blank" style="border-bottom: 1px solid #000"> ' . $transaction[ 'voucher_no' ] . '</a></td>';
                            $html         .= '<td>' . ( new GeneralHelper() ) -> format_date ( $transaction[ 'transaction_date' ] ) . '</td>';
                            $html         .= '<td>' . $transaction -> description . '</td>';
                            $html         .= '<td>' . number_format ( $transaction[ 'debit' ], 2 ) . '</td>';
                            $html         .= '<td>' . number_format ( $transaction[ 'credit' ], 2 ) . '</td>';
                            $html         .= '<td>' . number_format ( $running_balance, 2 ) . '</td>';
                            $html         .= '</tr>';
                            $total_credit += $transaction[ 'credit' ];
                            $total_debit  += $transaction[ 'debit' ];
                        }
                        
                        $html .= '<tr>';
                        $html .= '<td colspan="7"></td>';
                        $html .= '<td><strong>' . number_format ( $total_debit, 2 ) . '</strong></td>';
                        $html .= '<td><strong>' . number_format ( $total_credit, 2 ) . '</strong></td>';
                        $html .= '<td><strong>' . number_format ( $running_balance, 2 ) . '</strong></td>';
                        $html .= '</tr>';
                        
                    }
                    else {
                        $html .= '<tr>';
                        $html .= '<td></td>';
                        $html .= '<td></td>';
                        $html .= '<td>-</td>';
                        $html .= '<td>-</td>';
                        $html .= '<td>-</td>';
                        $html .= '<td>-</td>';
                        $html .= '<td>-</td>';
                        $html .= '<td>-</td>';
                        $html .= '<td>-</td>';
                        $html .= '<td>-</td>';
                        $html .= '</tr>';
                    }
                    
                    if ( isset( $ledger[ 'children' ] ) && is_array ( $ledger[ 'children' ] ) ) {
                        $childResult = $this -> build_ledgers_table ( $ledger[ 'children' ], $level + 1, $net_closing_balance );
                        $html        .= $childResult[ 'html' ];
                    }
                    
                    $net_closing_balance += $running_balance;
                }
            }
            return array (
                'html'        => $html,
                'net_closing' => $net_closing_balance
            );
        }
        
        public function search_transactions ( $acc_head_id ) {
            $start_date = request ( 'start-date' );
            $end_date   = request ( 'end-date' );
            
            $transactions = GeneralLedger ::where ( [ 'account_head_id' => $acc_head_id ] );
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date   = date ( 'Y-m-d', strtotime ( $start_date ) );
                $end_date     = date ( 'Y-m-d', strtotime ( $end_date ) );
                $transactions = $transactions -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [ $start_date, $end_date ] );
            }
            $transactions -> orderBy ( DB ::raw ( 'DATE(transaction_date)' ), 'ASC' );
            $transactions -> orderBy ( 'id', 'ASC' );
            return $transactions -> get ();
        }
        
        public function get_opening_balance_previous_than_searched_start_date ( $date, $acc_head_id ) {
            
            if ( !empty( trim ( $date ) ) ) {
                
                $financial_year = \App\Models\FinancialYear ::first ();
                $start_date     = $financial_year -> start_date;
                $trans_date = date ( 'Y-m-d', strtotime ( $date . ' -1 day' ) );
                
                $balances = GeneralLedger ::where ( [ 'account_head_id' => $acc_head_id ] )
                    -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [ $start_date, $trans_date ] )
                    -> get ();
                
                $last_running_balance = 0;
                
                if ( count ( $balances ) > 0 ) {
                    foreach ( $balances as $balance ) {
                        $account_head         = ( new AccountService() ) -> get_account_head_by_id ( $balance -> account_head_id );
                        $last_running_balance = $this -> calculate_running_balance ( $last_running_balance, $balance -> credit, $balance -> debit, $account_head );
                    }
                }
                return $last_running_balance;
            }
            else
                return 0;
        }
        
        public function calculate_running_balance ( $running_balance, $credit, $debit, $account_head ) {
            if ( in_array ( $account_head -> account_type_id, config ( 'constants.account_type_in' ) ) )
                $running_balance = $running_balance + $debit - $credit;
            else
                $running_balance = $running_balance - $debit + $credit;
            
            return $running_balance;
        }
        
        public function check_id_double_entry ( $voucher_number, $id ) {
            if ( !empty( trim ( $voucher_number ) ) ) {
                return GeneralLedger ::where ( [ 'voucher_no' => $voucher_number, 'id !=' => $id ] ) -> get ();
            }
            return array ();
        }
        
        public function add_candidate_test_fee ( $candidate ): void {
            $paymentMethod = PaymentMethod ::find ( $candidate -> payment_method_id );
            $testFee       = Fee ::where ( [ 'slug' => 'test-fee' ] ) -> first ();
            $invoiceNo     = ( new GeneralHelper() ) -> generateRandomString ( 4 );
            
            $paymentMethod -> general_ledger () -> create ( [
                                                                'user_id'          => auth () -> user () -> id,
                                                                'account_head_id'  => $paymentMethod -> account_head_id,
                                                                'invoice_no'       => $invoiceNo,
                                                                'transaction_no'   => $candidate -> transaction_no,
                                                                'credit'           => 0,
                                                                'debit'            => $testFee -> amount,
                                                                'transaction_date' => date ( 'Y-m-d', strtotime ( $candidate -> created_at ) ),
                                                                'description'      => 'Test fee charged. JMS-' . $candidate -> sr_no . ' - ' . $candidate -> fullName ()
                                                            ] );
            
            $candidate -> general_ledger () -> create ( [
                                                            'user_id'          => auth () -> user () -> id,
                                                            'account_head_id'  => $candidate -> account_head_id,
                                                            'invoice_no'       => $invoiceNo,
                                                            'transaction_no'   => $candidate -> transaction_no,
                                                            'credit'           => $testFee -> amount,
                                                            'debit'            => 0,
                                                            'transaction_date' => date ( 'Y-m-d', strtotime ( $candidate -> created_at ) ),
                                                            'description'      => 'Test fee charged. JMS-' . $candidate -> sr_no . ' - ' . $candidate -> fullName ()
                                                        ] );
            
        }
        
        public function charge_candidate_test_fee ( $candidate ): void {
            $paymentMethod = PaymentMethod ::find ( $candidate -> payment_method_id );
            $testFee       = Fee ::where ( [ 'slug' => 'test-fee' ] ) -> first ();
            $invoiceNo     = ( new GeneralHelper() ) -> generateRandomString ( 4 );
            
            $paymentMethod -> general_ledger () -> create ( [
                                                                'user_id'          => auth () -> user () -> id,
                                                                'account_head_id'  => $paymentMethod -> account_head_id,
                                                                'invoice_no'       => $invoiceNo,
                                                                'transaction_no'   => $candidate -> transaction_no,
                                                                'credit'           => 0,
                                                                'debit'            => $testFee -> amount,
                                                                'transaction_date' => date ( 'Y-m-d', strtotime ( $candidate -> created_at ) ),
                                                                'description'      => 'Test fee charged. JMS-' . $candidate -> sr_no . ' - ' . $candidate -> fullName ()
                                                            ] );
            
            $candidate -> general_ledger () -> create ( [
                                                            'user_id'          => auth () -> user () -> id,
                                                            'account_head_id'  => config ( 'constants.income_from_test' ),
                                                            'invoice_no'       => $invoiceNo,
                                                            'transaction_no'   => $candidate -> transaction_no,
                                                            'credit'           => $testFee -> amount,
                                                            'debit'            => 0,
                                                            'transaction_date' => date ( 'Y-m-d', strtotime ( $candidate -> created_at ) ),
                                                            'description'      => 'Test fee charged. JMS-' . $candidate -> sr_no . ' - ' . $candidate -> fullName ()
                                                        ] );
            
        }
        
        public function charge_candidate_medical_fee ( $medical, $candidate ): void {
            $paymentMethod = PaymentMethod ::find ( $medical -> payment_method_id );
            $vendor        = Vendor ::find ( $medical -> vendor_id );
            $account       = Account ::find ( config ( 'constants.credit_sale.cost_of_products_sold' ) );
            $invoiceNo     = ( new GeneralHelper() ) -> generateRandomString ( 4 );
            
            if ( $paymentMethod ) {
                $paymentMethod -> general_ledger () -> create ( [
                                                                    'user_id'          => auth () -> user () -> id,
                                                                    'account_head_id'  => $paymentMethod -> account_head_id,
                                                                    'invoice_no'       => $invoiceNo,
                                                                    'transaction_no'   => $medical -> transaction_no,
                                                                    'credit'           => 0,
                                                                    'debit'            => $medical -> amount,
                                                                    'transaction_date' => date ( 'Y-m-d' ),
                                                                    'description'      => 'Medical fee charged. JMS-' . $candidate -> sr_no . ' - ' . $candidate -> fullName ()
                                                                ] );
                
                $candidate -> general_ledger () -> create ( [
                                                                'user_id'          => auth () -> user () -> id,
                                                                'account_head_id'  => config ( 'constants.income_from_medical' ),
                                                                'invoice_no'       => $invoiceNo,
                                                                'transaction_no'   => $medical -> transaction_no,
                                                                'credit'           => $medical -> amount,
                                                                'debit'            => 0,
                                                                'transaction_date' => date ( 'Y-m-d'),
                                                                'description'      => 'Medical fee charged. JMS-' . $candidate -> sr_no . ' - ' . $candidate -> fullName ()
                                                            ] );
                
                $vendor -> general_ledger () -> create ( [
                                                             'user_id'          => auth () -> user () -> id,
                                                             'account_head_id'  => $vendor -> account_head_id,
                                                             'invoice_no'       => $invoiceNo,
                                                             'transaction_no'   => $medical -> transaction_no,
                                                             'credit'           => $vendor -> vendor_payable,
                                                             'debit'            => 0,
                                                             'transaction_date' => date ( 'Y-m-d' ),
                                                             'description'      => 'Medical fee charged. JMS-' . $candidate -> sr_no . ' - ' . $candidate -> fullName ()
                                                         ] );
                
                $account -> general_ledger () -> create ( [
                                                              'user_id'          => auth () -> user () -> id,
                                                              'account_head_id'  => $account -> id,
                                                              'invoice_no'       => $invoiceNo,
                                                              'transaction_no'   => $medical -> transaction_no,
                                                              'credit'           => 0,
                                                              'debit'            => $vendor -> vendor_payable,
                                                              'transaction_date' => date ( 'Y-m-d' ),
                                                              'description'      => 'Medical fee charged. JMS-' . $candidate -> sr_no . ' - ' . $candidate -> fullName ()
                                                          ] );
            }
        }
        
        public function candidate_agreed_amount ( $candidate ): void {
            $invoiceNo     = ( new GeneralHelper() ) -> generateRandomString ( 4 );
            $professionFee = PrincipalJob ::where ( [ 'principal_id' => $candidate -> principal_id, 'job_id' => $candidate -> job_id ] ) -> first ();
            $principal     = Principal ::find ( $candidate -> principal_id );
            
            $principal -> general_ledger () -> create ( [
                                                            'user_id'          => auth () -> user () -> id,
                                                            'account_head_id'  => config ( 'constants.Unearned_Revenue' ),
                                                            'invoice_no'       => $invoiceNo,
                                                            'credit'           => $professionFee -> fee,
                                                            'debit'            => 0,
                                                            'transaction_date' => date ( 'Y-m-d', strtotime ( $candidate -> created_at ) ),
                                                            'description'      => 'Total agreed payment. JMS-' . $candidate -> sr_no . ' - ' . $candidate -> fullName ()
                                                        ] );
            
            $candidate -> general_ledger () -> create ( [
                                                            'user_id'          => auth () -> user () -> id,
                                                            'account_head_id'  => $candidate -> account_head_id,
                                                            'invoice_no'       => $invoiceNo,
                                                            'credit'           => 0,
                                                            'debit'            => $professionFee -> fee,
                                                            'transaction_date' => date ( 'Y-m-d', strtotime ( $candidate -> created_at ) ),
                                                            'description'      => 'Total agreed payment. JMS-' . $candidate -> sr_no . ' - ' . $candidate -> fullName ()
                                                        ] );
            ( new LogService() ) -> log ( 'candidate-agreed-amount-added', $candidate );
        }
        
        public function get_candidate_test_fee ( $candidate ) {
            $account_head_id = config ( 'constants.income_from_test' );
            $fee             = GeneralLedger ::where ( [ 'account_head_id' => $account_head_id, 'transaction_no' => $candidate -> transaction_no ] ) -> first ();
            return $fee ? $fee -> debit : 0;
        }
        
        public function get_candidate_medical_fee ( $candidate ) {
            $account_head_id = config ( 'constants.income_from_medical' );
            $fee             = GeneralLedger ::where ( [ 'account_head_id' => $account_head_id, 'transaction_no' => $candidate -> transaction_no ] ) -> first ();
            return $fee ? $fee -> debit : 0;
        }
        
        public function get_candidate_agreed_fee ( $candidate ) {
            $fee = GeneralLedger ::where ( [ 'account_head_id' => $candidate -> account_head_id ] )
                -> whereNull ( 'voucher_no' )
                -> first ();
            return $fee ? $fee -> debit : 0;
        }
        
        public function candidate_payment_discount ( $candidate ): void {
            $candidate -> general_ledger () -> updateOrCreate ( [
                                                                    'account_head_id' => $candidate -> account_head_id,
                                                                    'invoice_no'      => $candidate -> discount_ledger_invoice_no
                                                                ],
                                                                [
                                                                    'user_id'          => auth () -> user () -> id,
                                                                    'account_head_id'  => $candidate -> account_head_id,
                                                                    'invoice_no'       => $candidate -> discount_ledger_invoice_no,
                                                                    'credit'           => $candidate -> discount,
                                                                    'debit'            => 0,
                                                                    'transaction_date' => date ( 'Y-m-d', strtotime ( $candidate -> created_at ) ),
                                                                    'description'      => 'Discount on payment. JMS-' . $candidate -> sr_no . ' - ' . $candidate -> fullName ()
                                                                ] );
            
            $candidate -> general_ledger () -> updateOrCreate ( [
                                                                    'account_head_id' => config ( 'constants.discount_on_invoices' ),
                                                                    'invoice_no'      => $candidate -> discount_ledger_invoice_no
                                                                ],
                                                                [
                                                                    'user_id'          => auth () -> user () -> id,
                                                                    'account_head_id'  => config ( 'constants.discount_on_invoices' ),
                                                                    'invoice_no'       => $candidate -> discount_ledger_invoice_no,
                                                                    'credit'           => 0,
                                                                    'debit'            => $candidate -> discount,
                                                                    'transaction_date' => date ( 'Y-m-d', strtotime ( $candidate -> created_at ) ),
                                                                    'description'      => 'Discount on payment. JMS-' . $candidate -> sr_no . ' - ' . $candidate -> fullName ()
                                                                ] );
            ( new LogService() ) -> log ( 'candidate-discount-amount-added', $candidate );
        }
    }