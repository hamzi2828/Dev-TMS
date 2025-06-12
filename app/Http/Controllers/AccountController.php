<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\AccountRequest;
    use App\Http\Requests\AddOpeningBalanceRequest;
    use App\Http\Requests\TransactionRequest;
    use App\Models\GeneralLedger;
    use App\Services\AccountService;
    use App\Services\AccountTypeService;
    use App\Services\GeneralLedgerService;
    use App\Models\Account;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class AccountController extends Controller {

        protected object $accountService;
        protected object $accountTypeService;
        protected object $generalLedgerService;

        public function __construct ( AccountService $accountService, AccountTypeService $accountTypeService, GeneralLedgerService $generalLedgerService ) {
            $this -> accountService       = $accountService;
            $this -> accountTypeService   = $accountTypeService;
            $this -> generalLedgerService = $generalLedgerService;
        }

        public function index (): View {
            $this -> authorize ( 'all', Account::class );
            $data[ 'title' ]    = 'All Account Heads';
            $data[ 'accounts' ] = $this -> accountService -> all ();
            return view ( 'accounts.index', $data );
        }

        public function chart_of_accounts (): View {
            $this -> authorize ( 'all', Account::class );
            $data[ 'title' ]          = 'Chart of Accounts';
            $data[ 'accounts_heads' ] = $this -> accountService -> convertToList ();
            return view ( 'accounts.chart-of-accounts', $data );
        }

        public function general_ledger (): View {
            $this -> authorize ( 'all', GeneralLedger::class );
            $data[ 'title' ]           = 'General Ledger';
            $account_heads             = $this -> accountService -> parseAccountHeads (true);
            $tree                      = $this -> accountService -> buildTree ( $account_heads );
            $options                   = '';
            $list                      = $this -> accountService -> buildList ( $tree, $options );
            $data[ 'list' ]            = $list;
            $data[ 'ledgers' ]         = $this -> generalLedgerService -> filter_general_ledgers ();
            $data[ 'running_balance' ] = $this -> generalLedgerService -> get_running_balance ();
            return view ( 'accounts.general-ledger', $data );
        }

        public function create (): View {
            $this -> authorize ( 'create', Account::class );
            $data[ 'title' ] = 'Add Account Heads';
            $account_heads   = $this -> accountService -> parseAccountHeads (true);
            $tree            = $this -> accountService -> buildTree ( $account_heads );
            $options         = '';
            $list            = $this -> accountService -> buildList ( $tree, $options );
            $data[ 'list' ]  = $list;
            $data[ 'types' ] = $this -> accountTypeService -> all ();
            return view ( 'accounts.create', $data );
        }

        public function store ( AccountRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Account::class );
            try {
                DB ::beginTransaction ();
                dd ( $request -> all() );
                $account_head = $this -> accountService -> save ( $request );
                DB ::commit ();

                if ( !empty( $account_head ) and $account_head -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'Account head has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function edit ( Account $account ): View {
            $this -> authorize ( 'edit', $account );
            $data[ 'title' ]   = 'Edit Account Heads';
            $data[ 'account' ] = $account;
            $account_heads     = $this -> accountService -> parseAccountHeads (true);
            $tree              = $this -> accountService -> buildTree ( $account_heads );
            $options           = '';
            $list              = $this -> accountService -> buildList ( $tree, $options, 0, false, $account );
            $data[ 'list' ]    = $list;
            $data[ 'types' ]   = $this -> accountTypeService -> all ();
            return view ( 'accounts.update', $data );
        }

        public function update ( Request $request, Account $account ): RedirectResponse {
            $this -> authorize ( 'edit', $account );
            try {
                DB ::beginTransaction ();
                $this -> accountService -> edit ( $request, $account );
                DB ::commit ();

                return redirect () -> back () -> with ( 'success', 'Account head has been updated.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function destroy ( Account $account ): RedirectResponse {
            // $this -> authorize ( 'delete', $account );
            dd($account);
            $account -> delete ();
            return redirect () -> back () -> with ( 'success', 'Account head has been deleted.' );
        }

        public function add_transactions (): View {
            $this -> authorize ( 'create', GeneralLedger::class );
            $data[ 'title' ] = 'Add Transactions';
            $account_heads   = $this -> accountService -> parseAccountHeads (true);
            $tree            = $this -> accountService -> buildTree ( $account_heads );
            $options         = '';
            $list            = $this -> accountService -> buildList ( $tree, $options, 0, true );
            $data[ 'list' ]  = $list;
            return view ( 'accounts.add-transactions', $data );
        }

        public function get_account_head_type ( Request $request ) {
            $account_head = Account ::find ( $request -> input ( 'account_head_id' ) );
            $account_head -> load ( 'account_type' );
            return $account_head -> account_type -> type;
        }

        public function process_add_transactions ( TransactionRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', GeneralLedger::class );
            try {
                DB ::beginTransaction ();
                $account_head = $this -> accountService -> add_transactions ( $request );
                DB ::commit ();

                $print = '<a href="' . route ( 'invoices.transaction', [ 'voucher-no' => json_decode ( $account_head ) -> voucher_no ] ) . '" class="ms-1 text-primary text-decoration-underline" target="_blank">Print Voucher</a>';

                return redirect () -> back () -> with ( 'success', 'Transactions have been added.' . $print );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception ) -> withInput ();
            }
        }

        public function add_opening_balance (): View {
            $this -> authorize ( 'add_opening_balance', GeneralLedger::class );
            $data[ 'title' ] = 'Add Opening Balance';
            $account_heads   = $this -> accountService -> parseAccountHeads (true);
            $tree            = $this -> accountService -> buildTree ( $account_heads );
            $options         = '';
            $list            = $this -> accountService -> buildList ( $tree, $options, 0, true );
            $data[ 'list' ]  = $list;
            return view ( 'accounts.add-opening-balance', $data );
        }

        public function process_add_opening_balance ( AddOpeningBalanceRequest $request ): RedirectResponse {
            $this -> authorize ( 'add_opening_balance', GeneralLedger::class );
            try {
                DB ::beginTransaction ();
                $this -> accountService -> add_opening_balance ( $request );
                DB ::commit ();

                return redirect () -> back () -> with ( 'success', 'Opening balance has been added.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function add_multiple_transactions (): View {
            $this -> authorize ( 'add_multiple', GeneralLedger::class );
            $data[ 'title' ] = 'Add Multiple Transactions';
            $account_heads   = $this -> accountService -> parseAccountHeads (true);
            $tree            = $this -> accountService -> buildTree ( $account_heads );
            $options         = '';
            $list            = $this -> accountService -> buildList ( $tree, $options, 0, true );
            $data[ 'list' ]  = $list;
            return view ( 'accounts.add-multiple-transactions', $data );
        }

        public function add_more_transactions ( Request $request ): View {
            $data[ 'row' ]  = $request -> input ( 'nextRow' );
            $account_heads  = $this -> accountService -> parseAccountHeads (true);
            $tree           = $this -> accountService -> buildTree ( $account_heads );
            $options        = '';
            $list           = $this -> accountService -> buildList ( $tree, $options, 0, true );
            $data[ 'list' ] = $list;
            return view ( 'accounts.add-more-transactions', $data );
        }

        public function process_add_multiple_transactions ( Request $request ): RedirectResponse {
            $this -> authorize ( 'add_multiple', GeneralLedger::class );
            try {
                DB ::beginTransaction ();
                $voucher_no = $this -> accountService -> add_multiple_transactions ( $request );
                DB ::commit ();

                $print = '<a href="' . route ( 'invoices.transaction', [ 'voucher-no' => $voucher_no ] ) . '" class="ms-1 text-primary text-decoration-underline" target="_blank">Print Voucher</a>';
                return redirect () -> back () -> with ( 'success', 'Transactions have been added.' . $print );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function search_transactions ( Request $request ): View {
            $this -> authorize ( 'search', GeneralLedger::class );
            $data[ 'title' ]   = 'Search Transactions';
            $data[ 'ledgers' ] = $this -> generalLedgerService -> search_transactions_by_voucher ( $request );
            return view ( 'accounts.search-transactions', $data );
        }

        public function update_transactions ( Request $request ): RedirectResponse {
            $this -> authorize ( 'search', GeneralLedger::class );
            try {
                DB ::beginTransaction ();
                $this -> accountService -> update_transactions ( $request );
                DB ::commit ();

                return redirect () -> back () -> with ( 'success', 'Transactions have been updated.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function delete_transactions (): RedirectResponse {
            $this -> authorize ( 'delete', GeneralLedger::class );
            try {
                DB ::beginTransaction ();
                $this -> accountService -> delete_transactions ();
                DB ::commit ();

                return redirect () -> route ( 'accounts.search-transactions' ) -> with ( 'success', 'Transactions have been deleted.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function account_heads_dropdown ( Request $request ): void {

            $account_heads = array ();
            if ( $request -> input ( 'type' ) == 'cash' )
                $account_heads = ( new AccountService() ) -> getRecursiveAccountHeads ( config ( 'constants.cash_balances' ) );

            else if ( $request -> input ( 'type' ) == 'bank' )
                $account_heads = ( new AccountService() ) -> getRecursiveAccountHeads ( config ( 'constants.banks' ) );

            echo $this -> accountService -> convertToOptions ( $account_heads );
        }

        public function transaction_detail_dropdown ( Request $request ): string {
            $account_head_id = $request -> get ( 'account_head_id' );
            $account         = Account ::findorFail ( $account_head_id );
            $sales           = ( new SaleService() ) -> get_credit_sales ( $account_head_id, $account );
            $stocks          = ( new VendorService() ) -> get_vendor_stocks ( $account_head_id, $account );
            return view ( 'accounts.transaction-dropdown', compact ( 'sales', 'stocks', 'account' ) ) -> render ();
        }

        public function transaction_detail ( GeneralLedger $general_ledger ): View {
            $general_ledger -> load ( [ 'account_head', 'transaction_details' ] );
            $title        = 'Transaction Details';
            $account_head = Account ::where ( [ 'id' => $general_ledger -> account_head_id ] ) -> first ();
            $sales        = ( new SaleService() ) -> get_credit_sales ( $general_ledger -> account_head_id, $account_head );
            $stocks       = ( new VendorService() ) -> get_vendor_stocks ( $general_ledger -> account_head_id, $account_head );
            $vouchers     = $general_ledger -> transaction_details -> pluck ( 'voucher' ) -> toArray ();
            return view ( 'accounts.transaction-details', compact ( 'general_ledger', 'title', 'sales', 'stocks', 'vouchers' ) );
        }

        public function update_transaction_detail ( Request $request, GeneralLedger $general_ledger ): RedirectResponse {
            $this -> authorize ( 'edit', $general_ledger );
            try {
                DB ::beginTransaction ();
                $account_head = Account ::find ( $general_ledger -> account_head_id );
                $this -> accountService -> delete_transaction_details ( $general_ledger );
                $this -> accountService -> update_transaction_detail ( $request, $account_head, $general_ledger );
                DB ::commit ();

                return redirect () -> back () -> with ( 'message', 'Transactions have been updated.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function general_ledgers (): View {
            $this -> authorize ( 'all', GeneralLedger::class );
            $data[ 'title' ]         = 'General Ledger';
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ( disabled: false );
            $account_heads           = $this -> accountService -> getRecursiveAccountHeads ( request ( 'account-head-id' ) );
            $parent_account_head     = $this -> accountService -> get_account_head_by_id ( request ( 'account-head-id' ) );
            $account_head[]          = $parent_account_head;
            $account_heads_list      = array_merge ( $account_head, $account_heads );
            $data[ 'ledgers' ]       = $this -> generalLedgerService -> build_ledgers_table ( $account_heads_list );
            return view ( 'accounts.general-ledgers', $data );
        }

        public function status ( Account $account ): RedirectResponse {
            $this -> authorize ( 'status', $account );
            try {
                DB ::beginTransaction ();
                ( new AccountService() ) -> status ( $account );
                DB ::commit ();

                return redirect () -> back () -> with ( 'success', 'Account head status has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
