<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\GeneralLedger;
    use App\Services\AccountService;
    use App\Services\ReportingService;
    use App\Services\UserService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\Request;
    
    class AccountReporting extends Controller {
        
        public function trial_balance_sheet (): View {
            $this -> authorize ( 'trial_balance_sheet', GeneralLedger::class );
            $data[ 'title' ]         = 'Trial Balance Sheet';
            $data[ 'account_heads' ] = ( new AccountService() ) -> trialBalance ();
            return view ( 'accounts-reporting.trial-balance-sheet', $data );
        }
        
        public function profit_and_loss_report (): View {
            $this -> authorize ( 'profit_and_loss', GeneralLedger::class );
            $data[ 'title' ]                  = 'Profit & Loss Report';
            $data[ 'sales' ]                  = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.cash_sale.sales' ) );
            $data[ 'sales_refund' ]           = ( new ReportingService() ) -> calculate_sales_ledger ( config ( 'constants.cash_sale.sales' ), 'debit' );
            $data[ 'sale_discounts' ]         = ( new ReportingService() ) -> calculate_sales_ledger ( config ( 'constants.discount_on_invoices' ) );
            $data[ 'direct_costs' ]           = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.direct_cost' ) );
            $data[ 'general_admin_expenses' ] = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.expenses' ) );
            $data[ 'income' ]                 = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.income' ) );
            $data[ 'taxes' ]                  = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.tax' ) );
            return view ( 'accounts-reporting.profit-and-loss-report', $data );
        }
        
        public function balance_sheet (): View {
            $this -> authorize ( 'balance_sheet', GeneralLedger::class );
            $data[ 'title' ]              = 'Balance Sheet';
            $data[ 'current_assets' ]     = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.current_assets' ) );
            $data[ 'non_current_assets' ] = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.non_current_assets' ) );
            $data[ 'liabilities' ]        = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.liabilities' ) );
            $data[ 'capital' ]            = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.capital' ) );
            $data[ 'profit' ]             = ( new ReportingService() ) -> profit ();
            return view ( 'accounts-reporting.balance-sheet', $data );
        }
        
        public function customer_receivable_report (): View {
            $this -> authorize ( 'customer_receivable', GeneralLedger::class );
            $data[ 'title' ]         = 'Customers Receivable Report';
            $data[ 'account_heads' ] = ( new AccountService() ) -> customersTrialBalance ();
            $data[ 'users' ]         = ( new UserService() ) -> users ();
            return view ( 'accounts-reporting.customer-receivable-report', $data );
        }
        
        public function vendor_payable_report () {
            $this -> authorize ( 'vendor_payable', GeneralLedger::class );
            $data[ 'title' ]         = 'Vendors Payable Report';
            $data[ 'account_heads' ] = ( new AccountService() ) -> vendorsTrialBalance ();
            return view ( 'accounts-reporting.vendor-payable-report', $data );
        }
        
    }
