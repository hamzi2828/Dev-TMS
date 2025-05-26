<?php

    namespace App\Http\Controllers;

    use App\Models\Candidate;
    use App\Models\MyBooking;
    use App\Models\DocumentReady;
    use App\Models\CandidateMedical;
    use App\Models\CompanyRequisition;
    use App\Models\Fee;
    use App\Models\GeneralLedger;
    use App\Services\AccountService;
    use App\Services\AccountTypeService;
    use App\Services\GeneralLedgerService;
    use App\Services\ReportingService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\Request;
    use Mpdf\Mpdf;
    use Mpdf\MpdfException;

    class InvoiceController extends Controller {

        protected object $accountService;
        protected object $accountTypeService;
        protected object $generalLedgerService;

        public function __construct ( AccountService $accountService, AccountTypeService $accountTypeService, GeneralLedgerService $generalLedgerService ) {
            $this -> accountService       = $accountService;
            $this -> accountTypeService   = $accountTypeService;
            $this -> generalLedgerService = $generalLedgerService;
        }

        public function pdf_settings (): Mpdf {
            return new Mpdf( [
                                 'mode'             => 'utf-8',
                                 'autoScriptToLang' => true,
                                 'autoLangToFont'   => true,
                                 'margin_left'      => 5,
                                 'margin_right'     => 5,
                                 'margin_top'       => 35,
                                 'margin_bottom'    => 20,
                                 'margin_header'    => 5,
                                 'margin_footer'    => 5,
                             ] );
        }

        public function trial_balance_sheet (): void {
            $this -> authorize ( 'trial_balance_sheet', GeneralLedger::class );
            try {
                $title         = 'Trial Balance';
                $account_heads = ( new AccountService() ) -> trialBalance ();
                $html_content  = view ( 'invoices.trial-balance', compact ( 'account_heads', 'title' ) ) -> render ();
                $mpdf          = $this -> pdf_settings ();
                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function profit_and_loss_report (): void {
            $this -> authorize ( 'profit_and_loss', GeneralLedger::class );
            try {
                $data[ 'title' ]                  = $title = 'Profit & Loss Report';
                $data[ 'sales' ]                  = ( new ReportingService() ) -> calculate_sales_ledger ( config ( 'constants.cash_sale.sales' ), 'credit' );
                $data[ 'sales_refund' ]           = ( new ReportingService() ) -> calculate_sales_ledger ( config ( 'constants.cash_sale.sales' ), 'debit' );
                $data[ 'sale_discounts' ]         = ( new ReportingService() ) -> calculate_sales_ledger ( config ( 'constants.discount_on_invoices' ) );
                $data[ 'direct_costs' ]           = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.direct_cost' ) );
                $data[ 'general_admin_expenses' ] = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.expenses' ) );
                $data[ 'income' ]                 = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.income' ) );
                $data[ 'taxes' ]                  = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.tax' ) );
                $html_content                     = view ( 'invoices.profit-and-loss-report', $data ) -> render ();
                $mpdf                             = $this -> pdf_settings ();

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function balance_sheet (): void {
            $this -> authorize ( 'balance_sheet', GeneralLedger::class );
            try {
                $data[ 'title' ]              = $title = 'Balance Sheet';
                $data[ 'current_assets' ]     = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.current_assets' ) );
                $data[ 'non_current_assets' ] = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.non_current_assets' ) );
                $data[ 'liabilities' ]        = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.liabilities' ) );
                $data[ 'capital' ]            = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.capital' ) );
                $data[ 'profit' ]             = ( new ReportingService() ) -> profit ();
                $html_content                 = view ( 'invoices.balance-sheet', $data ) -> render ();
                $mpdf                         = $this -> pdf_settings ();

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function customer_receivable_report (): void {
            $this -> authorize ( 'customer_receivable', GeneralLedger::class );
            try {
                $data[ 'title' ]         = $title = 'Customers Receivable Report';
                $data[ 'account_heads' ] = ( new AccountService() ) -> customersTrialBalance ();
                $html_content            = view ( 'invoices.customer-receivable-report', $data ) -> render ();
                $mpdf                    = $this -> pdf_settings ();

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function vendor_payable_report (): void {
            $this -> authorize ( 'vendor_payable', GeneralLedger::class );
            try {
                $data[ 'title' ]         = $title = 'Vendors Payable Report';
                $data[ 'account_heads' ] = ( new AccountService() ) -> vendorsTrialBalance ();
                $html_content            = view ( 'invoices.customer-receivable-report', $data ) -> render ();
                $mpdf                    = $this -> pdf_settings ();

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function general_ledger (): void {
            $this -> authorize ( 'all', GeneralLedger::class );
            try {
                $data[ 'title' ]     = $title = 'General Ledger';
                $account_heads       = $this -> accountService -> getRecursiveAccountHeads ( request ( 'account-head-id' ) );
                $parent_account_head = $this -> accountService -> get_account_head_by_id ( request ( 'account-head-id' ) );
                $account_head[]      = $parent_account_head;
                $account_heads_list  = array_merge ( $account_head, $account_heads );
                $data[ 'ledgers' ]   = $this -> generalLedgerService -> build_ledgers_table ( $account_heads_list );
                $html_content        = view ( 'invoices.general-ledger', $data ) -> render ();
                $mpdf                = $this -> pdf_settings ();

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function transaction (): void {
            $this -> authorize ( 'search', GeneralLedger::class );
            try {
                $data[ 'title' ]        = $title = 'Transaction';
                $data[ 'transactions' ] = ( new ReportingService() ) -> search_transactions ();
                $html_content           = view ( 'invoices.transactions', $data ) -> render ();
                $mpdf                   = $this -> pdf_settings ();

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function candidate_ticket ( Candidate $candidate ): void {
            $this -> authorize ( 'print_candidates_ticket', $candidate );
            try {
                $data[ 'title' ]     = $title = 'Ticket';
                $data[ 'candidate' ] = $candidate;
                $html_content        = view ( 'invoices.candidate-ticket', $data ) -> render ();
                $mpdf                = new Mpdf( [
                                                     'format'        => [ 71, 30 ],
                                                     'margin_left'   => 5,
                                                     'margin_right'  => 5,
                                                     'margin_top'    => 3,
                                                     'margin_bottom' => 0,
                                                     'margin_header' => 0,
                                                     'margin_footer' => 0,
                                                 ] );

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function candidate_bio_data ( Candidate $candidate ): void {
            $this -> authorize ( 'print_bio_data_form', $candidate );
            try {
                $data[ 'title' ]     = $title = 'Bio-Data';
                $data[ 'candidate' ] = $candidate;
                $html_content        = view ( 'invoices.candidate-bio-data', $data ) -> render ();
                $mpdf                = new Mpdf( [
                                                     'mode'             => 'utf-8',
                                                     'autoScriptToLang' => true,
                                                     'autoLangToFont'   => true,
                                                     'margin_left'      => 8,
                                                     'margin_right'     => 8,
                                                     'margin_top'       => 35,
                                                     'margin_bottom'    => 20,
                                                     'margin_header'    => 5,
                                                     'margin_footer'    => 5,
                                                 ] );

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkImage ( asset ( '/assets/watermark.jpeg' ), 0.1 );
                $mpdf -> showWatermarkImage = true;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function candidate_fee ( Candidate $candidate, Fee $fee ): void {
            $this -> authorize ( 'print_test_slip', $candidate );
            try {
                $data[ 'title' ]     = $title = 'Test Fee';
                $data[ 'candidate' ] = $candidate;
                $data[ 'fee' ]       = $fee;
                $html_content        = view ( 'invoices.candidate-fee', $data ) -> render ();
                $mpdf                = new Mpdf( [
                                                     'format'           => [ 120, 130 ],
                                                     'mode'             => 'utf-8',
                                                     'autoScriptToLang' => true,
                                                     'autoLangToFont'   => true,
                                                     'margin_left'      => 5,
                                                     'margin_right'     => 5,
                                                     'margin_top'       => 42,
                                                     'margin_bottom'    => 5,
                                                     'margin_header'    => 5,
                                                     'margin_footer'    => 5,
                                                 ] );

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkImage ( asset ( '/assets/watermark.jpeg' ), 0.1 );
                $mpdf -> showWatermarkImage = true;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function candidate_test_fee_slip ( Candidate $candidate ): void {
            $this -> authorize ( 'print_test_slip', $candidate );
            try {
                $data[ 'title' ]     = $title = 'Test Fee Invoice';
                $data[ 'candidate' ] = $candidate;
                $html_content        = view ( 'invoices.candidate-test-fee-slip', $data ) -> render ();
                $mpdf                = new Mpdf( [
                                                     'format'           => [ 210, 148.5 ],
                                                     'mode'             => 'utf-8',
                                                     'autoScriptToLang' => true,
                                                     'autoLangToFont'   => true,
                                                     'margin_left'      => 5,
                                                     'margin_right'     => 5,
                                                     'margin_top'       => 42,
                                                     'margin_bottom'    => 5,
                                                     'margin_header'    => 5,
                                                     'margin_footer'    => 5,
                                                 ] );

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkImage ( asset ( '/assets/watermark.jpeg' ), 0.1, [ 80, 80 ] );
                $mpdf -> showWatermarkImage = true;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function medical_receipt ( Candidate $candidate, CandidateMedical $medical ): View {
            $this -> authorize ( 'print_medical_slip', $medical );
            try {
                $data[ 'title' ]     = $title = 'Medical Fee Invoice';
                $data[ 'candidate' ] = $candidate;
                $data[ 'medical' ]   = $medical;
                return view ( 'invoices.candidate-medical-fee-slip', $data );
//                $html_content        = view ( 'invoices.candidate-medical-fee-slip', $data ) -> render ();
//                $mpdf                = new Mpdf( [
//                                                     'format'           => [ 120, 180 ],
//                                                     'mode'             => 'utf-8',
//                                                     'autoScriptToLang' => true,
//                                                     'autoLangToFont'   => true,
//                                                     'margin_left'      => 5,
//                                                     'margin_right'     => 5,
//                                                     'margin_top'       => 38,
//                                                     'margin_bottom'    => 0,
//                                                     'margin_header'    => 5,
//                                                     'margin_footer'    => 0,
//                                                 ] );

//                $mpdf -> SetTitle ( $title );
//                $mpdf -> SetAuthor ( config ( 'app.name' ) );
//                $mpdf -> SetWatermarkImage ( asset ( '/assets/watermark.jpeg' ), 0.1, [ 50, 50 ] );
//                $mpdf -> showWatermarkImage = true;
//                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
//                $mpdf -> watermarkTextAlpha = 0.1;
//                $mpdf -> SetDisplayMode ( 'real' );
//                $mpdf -> WriteHTML ( $html_content );
//                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function company_requisitions ( CompanyRequisition $requisition ): void {
            $requisition -> load ( [ 'principal', 'jobs.job' ] );
            try {
                $data[ 'title' ]       = $title = 'MRF';
                $data[ 'requisition' ] = $requisition;
                $html_content          = view ( 'invoices.company-requisitions', $data ) -> render ();
                $mpdf                  = $this -> pdf_settings ();

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function agreement ( Candidate $candidate, CandidateDocumentReady $document_ready ): void {
            $document_ready -> load ( [ 'agreement.principal', 'agreement.job' ] );
            try {
                $data[ 'title' ]          = $title = 'Agreement';
                $data[ 'document_ready' ] = $document_ready;
                $data[ 'candidate' ]      = $candidate;
                $html_content             = view ( 'invoices.agreement', $data ) -> render ();
                $mpdf                     = new Mpdf( [
                                                          'mode'             => 'utf-8',
                                                          'autoScriptToLang' => true,
                                                          'autoLangToFont'   => true,
                                                          'margin_left'      => 5,
                                                          'margin_right'     => 5,
                                                          'margin_top'       => 42,
                                                          'margin_bottom'    => 5,
                                                          'margin_header'    => 2,
                                                          'margin_footer'    => 0,
                                                      ] );

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function specialized_deposit_slip ( Candidate $candidate ): void {
            try {
                $data[ 'title' ]     = $title = 'Specialized Deposit Slip';
                $data[ 'candidate' ] = $candidate;
                $html_content        = view ( 'invoices.specialized-deposit-slip', $data ) -> render ();
                $mpdf                = new Mpdf( [
                                                     'mode'             => 'utf-8',
                                                     'autoScriptToLang' => true,
                                                     'autoLangToFont'   => true,
                                                     'margin_left'      => 5,
                                                     'margin_right'     => 5,
                                                     'margin_top'       => 5,
                                                     'margin_bottom'    => 5,
                                                     'margin_header'    => 5,
                                                     'margin_footer'    => 5,
                                                 ] );

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function foreign_services_contract ( Candidate $candidate ): void {
            try {
                $data[ 'title' ]     = $title = 'Foreign Services Contract';
                $data[ 'candidate' ] = $candidate;
                $html_content        = view ( 'invoices.foreign-services-contract', $data ) -> render ();
                $mpdf                = new Mpdf( [
                                                     'mode'             => 'utf-8',
                                                     'autoScriptToLang' => true,
                                                     'autoLangToFont'   => true,
                                                     'margin_left'      => 0,
                                                     'margin_right'     => 0,
                                                     'margin_top'       => 35,
                                                     'margin_bottom'    => 0,
                                                     'margin_header'    => 0,
                                                     'margin_footer'    => 0,
                                                 ] );

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function form_7 ( Candidate $candidate ): void {
            try {
                $data[ 'title' ]     = $title = 'Form-7';
                $data[ 'candidate' ] = $candidate;
                $html_content        = view ( 'invoices.form-7', $data ) -> render ();
                $mpdf                = new Mpdf( [
                                                     'mode'             => 'utf-8',
                                                     'autoScriptToLang' => true,
                                                     'autoLangToFont'   => true,
                                                     'margin_left'      => 2,
                                                     'margin_right'     => 2,
                                                     'margin_top'       => 2,
                                                     'margin_bottom'    => 2,
                                                     'margin_header'    => 2,
                                                     'margin_footer'    => 2,
                                                 ] );

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function form_32a ( Candidate $candidate ): void {
            try {
                $data[ 'title' ]     = $title = 'Form-32A';
                $data[ 'candidate' ] = $candidate;
                $html_content        = view ( 'invoices.form-32a', $data ) -> render ();
                $mpdf                = new Mpdf( [
                                                     'mode'             => 'utf-8',
                                                     'autoScriptToLang' => true,
                                                     'autoLangToFont'   => true,
                                                     'margin_left'      => 5,
                                                     'margin_right'     => 5,
                                                     'margin_top'       => 5,
                                                     'margin_bottom'    => 5,
                                                     'margin_header'    => 5,
                                                     'margin_footer'    => 5,
                                                 ] );

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

        public function undertaking ( Candidate $candidate ): void {
            try {
                $data[ 'title' ]     = $title = 'Undertaking';
                $data[ 'candidate' ] = $candidate;
                $html_content        = view ( 'invoices.undertaking', $data ) -> render ();
                $mpdf                = new Mpdf( [
                                                     'mode'             => 'utf-8',
                                                     'autoScriptToLang' => true,
                                                     'autoLangToFont'   => true,
                                                     'margin_left'      => 15,
                                                     'margin_right'     => 15,
                                                     'margin_top'       => 45,
                                                     'margin_bottom'    => 5,
                                                     'margin_header'    => 5,
                                                     'margin_footer'    => 5,
                                                 ] );

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }


        public function myBookingsPrint(MyBooking $myBooking) {
            try {
                $title = 'My Booking';

                $booking = MyBooking::with(['airline', 'airlineGroup.segments', 'passengers'])
                ->latest()
                    ->where('id', $myBooking->id)->first();
                $html_content = view('invoices.my-bookings', $booking)->render();
                $mpdf                = new Mpdf( [
                                                     'mode'             => 'utf-8',
                                                     'autoScriptToLang' => true,
                                                     'autoLangToFont'   => true,
                                                     'margin_left'      => 5,
                                                     'margin_right'     => 5,
                                                     'margin_top'       => 5,
                                                     'margin_bottom'    => 5,
                                                     'margin_header'    => 5,
                                                     'margin_footer'    => 5,
                                                 ] );

                $mpdf -> SetTitle ( $title );
                $mpdf -> SetAuthor ( config ( 'app.name' ) );
                $mpdf -> SetWatermarkText ( config ( 'app.name' ) );
                $mpdf -> showWatermarkText  = false;
                $mpdf -> watermark_font     = 'DejaVuSansCondensed';
                $mpdf -> watermarkTextAlpha = 0.1;
                $mpdf -> SetDisplayMode ( 'real' );
                $mpdf -> WriteHTML ( $html_content );
                $mpdf -> Output ( $title . '.pdf', 'I' );
            }
            catch ( MpdfException $exception ) {
                dd ( $exception );
            }
        }

    }
