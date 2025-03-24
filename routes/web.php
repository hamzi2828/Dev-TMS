<?php

    use App\Http\Controllers\AccountController;
    use App\Http\Controllers\AccountReporting;
    use App\Http\Controllers\AccountTypeController;
    use App\Http\Controllers\AgentController;
    use App\Http\Controllers\AgreementController;
    use App\Http\Controllers\AirlineController;
    use App\Http\Controllers\AnalyticsController;
    use App\Http\Controllers\BankController;
    use App\Http\Controllers\CityController;
    use App\Http\Controllers\CompanyController;
    use App\Http\Controllers\CompanyRequisitionController;
    use App\Http\Controllers\CountryController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\DistrictController;
    use App\Http\Controllers\FeeController;
    use App\Http\Controllers\InvoiceController;
    use App\Http\Controllers\JobController;
    use App\Http\Controllers\LeadSourceController;
    use App\Http\Controllers\LoginController;
    use App\Http\Controllers\PaymentMethodController;
    use App\Http\Controllers\PrincipalController;
    use App\Http\Controllers\ProvinceController;
    use App\Http\Controllers\QualificationController;
    use App\Http\Controllers\ReferralController;
    use App\Http\Controllers\ReportingController;
    use App\Http\Controllers\RoleController;
    use App\Http\Controllers\SiteSettingController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\VendorController;
    use Illuminate\Support\Facades\Route;

    Route ::middleware ( [ 'guest', 'throttle:10', 'web' ] ) -> group ( function () {

        Route ::get ( '/', [ LoginController::class, 'index' ] ) -> name ( 'login' );
        Route ::post ( '/', [ LoginController::class, 'authenticate' ] ) -> name ( 'authenticate' );

    } );

    Route ::middleware ( [ 'auth', 'web' ] ) -> group ( function () {

        Route ::get ( 'home', [ DashboardController::class, 'home' ] ) -> name ( 'home' );
        Route ::get ( 'dashboard', [ DashboardController::class, 'index' ] ) -> name ( 'dashboard' );

        Route ::get ( 'payable-count', [ AnalyticsController::class, 'payable_count' ] ) -> name ( 'analytics.payable' );
        Route ::get ( 'receivable-count', [ AnalyticsController::class, 'receivable_count' ] ) -> name ( 'analytics.receivable' );
        Route ::get ( 'income-from-test', [ AnalyticsController::class, 'income_from_test' ] ) -> name ( 'analytics.income-from-test' );
        Route ::get ( 'income-from-medical', [ AnalyticsController::class, 'income_from_medical' ] ) -> name ( 'analytics.income-from-medical' );
        Route ::get ( 'income-from-candidate', [ AnalyticsController::class, 'income_from_candidate' ] ) -> name ( 'analytics.income-from-candidate' );

        Route ::get ( 'logout', [ LoginController::class, 'logout' ] ) -> name ( 'logout' ) -> withoutMiddleware ( 'guest' );
        Route ::get ( 'users/trashed', [ UserController::class, 'trashed' ] ) -> name ( 'users.trashed' );
        Route ::get ( 'users/{user_id}/restore', [ UserController::class, 'restore' ] ) -> name ( 'users.restore' );
        Route ::delete ( 'users/{user_id}/force-delete', [ UserController::class, 'force_delete' ] ) -> name ( 'users.force-delete' );
        Route ::get ( 'users/{user}/status', [ UserController::class, 'status' ] ) -> name ( 'users.status' );
        Route ::get ( 'users/profile', [ UserController::class, 'profile' ] ) -> name ( 'users.profile' );
        Route ::put ( 'users/profile', [ UserController::class, 'update_profile' ] ) -> name ( 'users.update-profile' );
        Route ::resource ( 'users', UserController::class ) -> except ( [ 'show' ] );

        Route ::prefix ( 'settings' ) -> group ( function () {
            Route ::get ( 'countries/load-cities-by-country', [ CountryController::class, 'cities' ] ) -> name ( 'countries.cities' );
            Route ::resource ( 'countries', CountryController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'cities', CityController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'jobs', JobController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'qualifications', QualificationController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'banks', BankController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'payment-methods', PaymentMethodController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'fees', FeeController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'airlines', AirlineController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'roles', RoleController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'vendors', VendorController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'agents', AgentController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'principals', PrincipalController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'referrals', ReferralController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'companies', CompanyController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'provinces', ProvinceController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'districts', DistrictController::class ) -> except ( [ 'show' ] );
        } );

        Route ::prefix ( 'accounts' ) -> group ( function () {
            Route ::get ( 'chart-of-accounts', [ AccountController::class, 'chart_of_accounts' ] ) -> name ( 'accounts.chart-of-accounts' );
            Route ::get ( 'status/{account}', [ AccountController::class, 'status' ] ) -> name ( 'accounts.status' );
            Route ::get ( 'general-ledger', [ AccountController::class, 'general_ledger' ] ) -> name ( 'accounts.general-ledger' );
            Route ::get ( 'add-transactions', [ AccountController::class, 'add_transactions' ] ) -> name ( 'accounts.add-transactions' );
            Route ::post ( 'add-transactions', [ AccountController::class, 'process_add_transactions' ] ) -> name ( 'accounts.process-add-transactions' );
            Route ::get ( 'get-account-head-type', [ AccountController::class, 'get_account_head_type' ] ) -> name ( 'accounts.get-account-head-type' );
            Route ::get ( 'add-opening-balance', [ AccountController::class, 'add_opening_balance' ] ) -> name ( 'accounts.add-opening-balance' );
            Route ::post ( 'add-opening-balance', [ AccountController::class, 'process_add_opening_balance' ] ) -> name ( 'accounts.process-add-opening-balance' );
            Route ::get ( 'add-multiple-transactions', [ AccountController::class, 'add_multiple_transactions' ] ) -> name ( 'accounts.add-multiple-transactions' );
            Route ::post ( 'process-add-multiple-transactions', [ AccountController::class, 'process_add_multiple_transactions' ] ) -> name ( 'accounts.process-add-multiple-transactions' );
            Route ::get ( 'search-transactions', [ AccountController::class, 'search_transactions' ] ) -> name ( 'accounts.search-transactions' );
            Route ::post ( 'search-transactions', [ AccountController::class, 'update_transactions' ] ) -> name ( 'accounts.update-transactions' );
            Route ::get ( 'delete-transactions', [ AccountController::class, 'delete_transactions' ] ) -> name ( 'accounts.delete-transactions' );
            Route ::get ( 'account-heads-dropdown', [ AccountController::class, 'account_heads_dropdown' ] ) -> name ( 'accounts.account-heads-dropdown' );
            Route ::get ( '/general-ledgers', [ AccountController::class, 'general_ledgers' ] ) -> name ( 'accounts.general-ledgers' );
        } );

        Route ::get ( 'add-more-transactions', [ AccountController::class, 'add_more_transactions' ] ) -> name ( 'accounts.add-more-transactions' );
        Route ::get ( '/accounts/transaction-detail-dropdown', [ AccountController::class, 'transaction_detail_dropdown' ] ) -> name ( 'accounts.transaction-detail-dropdown' );
        Route ::get ( '/accounts/transaction-detail/{general_ledger}', [ AccountController::class, 'transaction_detail' ] ) -> name ( 'accounts.transaction-detail' );
        Route ::post ( '/accounts/transaction-detail/{general_ledger}', [ AccountController::class, 'update_transaction_detail' ] ) -> name ( 'accounts.update-transaction-details' );

        Route ::resource ( 'accounts', AccountController::class ) -> except ( [ 'show' ] );

        Route ::prefix ( 'account-settings' ) -> group ( function () {
            Route ::resource ( 'account-types', AccountTypeController::class ) -> except ( [ 'show' ] );
        } );

        Route ::prefix ( 'templates' ) -> group ( function () {
            Route ::resource ( 'agreements', AgreementController::class ) -> except ( [ 'show' ] );
        } );

        Route ::resource ( 'site-settings', SiteSettingController::class ) -> except ( [ 'show' ] );

        Route ::prefix ( 'accounts-reporting' ) -> name ( 'accounts-reporting.' ) -> group ( function () {
            Route ::get ( '/trial-balance-sheet', [ AccountReporting::class, 'trial_balance_sheet' ] ) -> name ( 'trial-balance-sheet' );
            Route ::get ( '/profit-and-loss-report', [ AccountReporting::class, 'profit_and_loss_report' ] ) -> name ( 'profit-and-loss-report' );
            Route ::get ( '/balance-sheet', [ AccountReporting::class, 'balance_sheet' ] ) -> name ( 'balance-sheet' );
            Route ::get ( '/customer-receivable-report', [ AccountReporting::class, 'customer_receivable_report' ] ) -> name ( 'customer-receivable-report' );
            Route ::get ( '/vendor-payable-report', [ AccountReporting::class, 'vendor_payable_report' ] ) -> name ( 'vendor-payable-report' );
            Route ::get ( '/cheque-details-report', [ ReportingController::class, 'cheque_details_report' ] ) -> name ( 'cheque-details-report' );
        } );

        Route ::prefix ( 'reporting' ) -> name ( 'reporting.' ) -> group ( function () {
            Route ::get ( '/status-check', [ ReportingController::class, 'status_check' ] ) -> name ( 'status-check' );
            Route ::get ( '/summary-report', [ ReportingController::class, 'summary_report' ] ) -> name ( 'summary-report' );
            Route ::get ( '/follow-up-report', [ ReportingController::class, 'follow_up_report' ] ) -> name ( 'follow-up-report' );
            Route ::get ( '/missing-docs-report', [ ReportingController::class, 'missing_docs_report' ] ) -> name ( 'missing-docs-report' );
            Route ::get ( '/gross-profit-report', [ ReportingController::class, 'gross_profit_report' ] ) -> name ( 'gross-profit-report' );
            Route ::get ( '/qj-medical-report', [ ReportingController::class, 'qj_medical_report' ] ) -> name ( 'qj-medical-report' );
        } );

        Route ::prefix ( 'invoices' ) -> name ( 'invoices.' ) -> group ( function () {
            Route ::get ( '/trial-balance-sheet', [ InvoiceController::class, 'trial_balance_sheet' ] ) -> name ( 'trial-balance-sheet' );
            Route ::get ( '/profit-and-loss-report', [ InvoiceController::class, 'profit_and_loss_report' ] ) -> name ( 'profit-and-loss-report' );
            Route ::get ( '/balance-sheet', [ InvoiceController::class, 'balance_sheet' ] ) -> name ( 'balance-sheet' );
            Route ::get ( '/customer-receivable-report', [ InvoiceController::class, 'customer_receivable_report' ] ) -> name ( 'customer-receivable-report' );
            Route ::get ( '/vendor-payable-report', [ InvoiceController::class, 'vendor_payable_report' ] ) -> name ( 'vendor-payable-report' );
            Route ::get ( '/general-ledger', [ InvoiceController::class, 'general_ledger' ] ) -> name ( 'general-ledger' );
            Route ::get ( '/transaction', [ InvoiceController::class, 'transaction' ] ) -> name ( 'transaction' );
            Route ::get ( '/company-requisitions/{requisition}', [ InvoiceController::class, 'company_requisitions' ] ) -> name ( 'company-requisitions' );
        } );
    } );
