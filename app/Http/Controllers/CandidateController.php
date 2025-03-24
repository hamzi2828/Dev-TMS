<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CandidateFormRequest;
    use App\Models\Candidate;
    use App\Models\CandidateDocumentReady;
    use App\Models\CandidateInterview;
    use App\Models\CandidateMedical;
    use App\Models\CandidatePaymentReceipt;
    use App\Models\CandidateProtector;
    use App\Models\CandidateTicket;
    use App\Models\CandidateVisa;
    use App\Models\Fee;
    use App\Models\GeneralLedger;
    use App\Models\User;
    use App\Policies\CandidateDocumentReadyPolicy;
    use App\Services\AccountService;
    use App\Services\BankService;
    use App\Services\CandidateDocumentService;
    use App\Services\CandidateInterviewService;
    use App\Services\CandidateMedicalService;
    use App\Services\CandidatePaymentReceiptService;
    use App\Services\CandidateProtectorService;
    use App\Services\CandidateService;
    use App\Services\CandidateTicketService;
    use App\Services\CandidateVisaService;
    use App\Services\CityService;
    use App\Services\CountryService;
    use App\Services\DistrictService;
    use App\Services\GeneralLedgerService;
    use App\Services\JobService;
    use App\Services\LeadSourceService;
    use App\Services\PaymentMethodService;
    use App\Services\PrincipalService;
    use App\Services\ProvinceService;
    use App\Services\QualificationService;
    use App\Services\ReferralService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CandidateController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', Candidate::class );
            $data[ 'title' ]       = 'All Candidates';
            $data[ 'candidates' ]  = ( new CandidateService() ) -> all ();
            $data[ 'fee' ]         = Fee ::where ( [ 'slug' => 'test-fee' ] ) -> first ();
            $data[ 'searchRoute' ] = route ( 'candidates.index' );
            $data[ 'jobs' ]        = ( new JobService() ) -> all ();
            $data[ 'referrals' ]   = ( new ReferralService() ) -> all ();
            return view ( 'candidates.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Candidate::class );
            $data[ 'title' ]           = 'Add Candidate';
            $data[ 'jobs' ]            = ( new JobService() ) -> all ();
            $data[ 'qualifications' ]  = ( new QualificationService() ) -> all ();
            $data[ 'banks' ]           = ( new BankService() ) -> all ();
            $data[ 'payment_methods' ] = ( new PaymentMethodService() ) -> all ();
            $data[ 'countries' ]       = ( new CountryService() ) -> all ();
            $data[ 'cities' ]          = ( new CityService() ) -> get_cities_by_country_id ( 1 );
            $data[ 'sources' ]         = ( new LeadSourceService() ) -> sources ();
            $data[ 'referrals' ]       = ( new ReferralService() ) -> all ();
            $data[ 'provinces' ]       = ( new ProvinceService() ) -> all ();
            $data[ 'districts' ]       = ( new DistrictService() ) -> all ();
            $data[ 'principals' ]      = ( new PrincipalService() ) -> all ();
            return view ( 'candidates.create', $data );
        }
        
        public function store ( CandidateFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Candidate::class );
            try {
                DB ::beginTransaction ();
                $candidate = ( new CandidateService() ) -> save ( $request );
                ( new CandidateDocumentService() ) -> save ( $request, $candidate );
                $interview = ( new CandidateService() ) -> save_interview ( $candidate );
                ( new CandidateService() ) -> save_payment_follow_up ( $candidate );
                ( new CandidateService() ) -> save_visa_follow_up ( $candidate );
                ( new CandidateService() ) -> save_ticket_follow_up ( $candidate );
                
                if ( $request -> input ( 'free-candidate', 0 ) == '0' )
                    ( new GeneralLedgerService() ) -> charge_candidate_test_fee ( $candidate );
                DB ::commit ();
                
                if ( !empty( $candidate ) and $candidate -> id > 0 )
                    return redirect () -> route ( 'candidates.interviews.edit', [ 'candidate' => $candidate -> id, 'interview' => $interview -> id ] ) -> with ( 'success', 'Candidate profile has been saved.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function update_discount ( Request $request, Candidate $candidate ): RedirectResponse {
            $this -> authorize ( 'billing', Candidate::class );
            try {
                DB ::beginTransaction ();
                $candidate = ( new CandidateService() ) -> update_discount ( $request, $candidate );
                ( new GeneralLedgerService() ) -> candidate_payment_discount ( $candidate );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Discount has been saved.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function show ( Candidate $candidate ): View {
            $this -> authorize ( 'view', $candidate );
            $candidate -> load ( [ 'document' ] );
            $data[ 'title' ]           = 'View Candidate';
            $data[ 'jobs' ]            = ( new JobService() ) -> all ();
            $data[ 'qualifications' ]  = ( new QualificationService() ) -> all ();
            $data[ 'banks' ]           = ( new BankService() ) -> all ();
            $data[ 'payment_methods' ] = ( new PaymentMethodService() ) -> all ();
            $data[ 'countries' ]       = ( new CountryService() ) -> all ();
            $data[ 'cities' ]          = ( new CityService() ) -> get_cities_by_country_id ( $candidate -> country_id );
            $data[ 'sources' ]         = ( new LeadSourceService() ) -> sources ();
            $data[ 'referrals' ]       = ( new ReferralService() ) -> all ();
            $data[ 'provinces' ]       = ( new ProvinceService() ) -> all ();
            $data[ 'districts' ]       = ( new DistrictService() ) -> all ();
            $data[ 'principals' ]      = ( new PrincipalService() ) -> all ();
            $data[ 'candidate' ]       = $candidate;
            return view ( 'candidates.update', $data );
        }
        
        public function edit ( Candidate $candidate ): View {
            $this -> authorize ( 'edit', $candidate );
            $candidate -> load ( [ 'document' ] );
            $data[ 'title' ]           = 'Edit Candidate';
            $data[ 'jobs' ]            = ( new JobService() ) -> all ();
            $data[ 'qualifications' ]  = ( new QualificationService() ) -> all ();
            $data[ 'banks' ]           = ( new BankService() ) -> all ();
            $data[ 'payment_methods' ] = ( new PaymentMethodService() ) -> all ();
            $data[ 'countries' ]       = ( new CountryService() ) -> all ();
            $data[ 'cities' ]          = ( new CityService() ) -> get_cities_by_country_id ( $candidate -> country_id );
            $data[ 'sources' ]         = ( new LeadSourceService() ) -> sources ();
            $data[ 'referrals' ]       = ( new ReferralService() ) -> all ();
            $data[ 'provinces' ]       = ( new ProvinceService() ) -> all ();
            $data[ 'districts' ]       = ( new DistrictService() ) -> all ();
            $data[ 'principals' ]      = ( new PrincipalService() ) -> all ();
            $data[ 'candidate' ]       = $candidate;
            return view ( 'candidates.update', $data );
        }
        
        public function update ( CandidateFormRequest $request, Candidate $candidate ): RedirectResponse {
            $this -> authorize ( 'update', $candidate );
            try {
                DB ::beginTransaction ();
                ( new CandidateService() ) -> edit ( $request, $candidate );
                ( new CandidateDocumentService() ) -> edit ( $request, $candidate );
                
                if ( !empty( trim ( $candidate -> account_head_id ) ) )
                    ( new AccountService() ) -> edit_candidate ( $candidate );
                
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate profile has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Candidate $candidate ) {
            $this -> authorize ( 'delete', $candidate );
            try {
                DB ::beginTransaction ();
                ( new CandidateService() ) -> delete ( $candidate );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate profile has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function close_case ( Candidate $candidate ): RedirectResponse {
            $this -> authorize ( 'case_closed', Candidate::class );
            try {
                DB ::beginTransaction ();
                ( new CandidateService() ) -> close_case ( $candidate );
                DB ::commit ();
                
                return redirect () -> route ( 'candidates.index' ) -> with ( 'success', 'Candidate case has been closed.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function billing ( Candidate $candidate ): View {
            $this -> authorize ( 'billing', Candidate::class );
            $candidate -> load ( [ 'fee', 'medical.fee', 'transactions' => fn ( $q ) => $q -> whereNull ( 'voucher_no' ) ] );
            $title        = 'Candidate Billing';
            $transactions = GeneralLedger ::where ( [ 'account_head_id' => $candidate -> account_head_id ] ) -> whereNotNull ( 'voucher_no' ) -> get ();
            return view ( 'candidates.update', compact ( 'title', 'candidate', 'transactions' ) );
        }
        
        public function trade_change ( Candidate $candidate ): View {
            $this -> authorize ( 'trade_change', Candidate::class );
            $title = 'Trade Change';
            $jobs  = ( new JobService() ) -> all ();
            return view ( 'candidates.update', compact ( 'title', 'candidate', 'jobs' ) );
        }
        
        public function save_trade_change ( Request $request, Candidate $candidate ): RedirectResponse {
            $this -> authorize ( 'trade_change', $candidate );
            try {
                DB ::beginTransaction ();
                ( new CandidateService() ) -> save_trade_change ( $request, $candidate );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Trade change has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function interview_candidates (): View {
            $this -> authorize ( 'all', CandidateInterview::class );
            $data[ 'title' ]       = 'Interview Candidates';
            $data[ 'candidates' ]  = ( new CandidateService() ) -> interview_candidates ();
            $data[ 'fee' ]         = Fee ::where ( [ 'slug' => 'test-fee' ] ) -> first ();
            $data[ 'jobs' ]        = ( new JobService() ) -> all ();
            $data[ 'searchRoute' ] = route ( 'candidates.interview-candidates' );
            $data[ 'referrals' ]   = ( new ReferralService() ) -> all ();
            return view ( 'candidates.interview', $data );
        }
        
        public function medical_candidates (): View {
            $this -> authorize ( 'all', CandidateMedical::class );
            $data[ 'title' ]       = 'Medical Candidates';
            $data[ 'candidates' ]  = ( new CandidateService() ) -> medical_candidates ();
            $data[ 'fee' ]         = Fee ::where ( [ 'slug' => 'test-fee' ] ) -> first ();
            $data[ 'jobs' ]        = ( new JobService() ) -> all ();
            $data[ 'searchRoute' ] = route ( 'candidates.medical-candidates' );
            $data[ 'referrals' ]   = ( new ReferralService() ) -> all ();
            return view ( 'candidates.medical', $data );
        }
        
        public function document_ready_candidates (): View {
            $this -> authorize ( 'mainMenu', CandidateDocumentReady::class );
            $data[ 'title' ]       = 'Documents Ready Candidates';
            $data[ 'candidates' ]  = ( new CandidateService() ) -> documents_ready_candidates ();
            $data[ 'fee' ]         = Fee ::where ( [ 'slug' => 'test-fee' ] ) -> first ();
            $data[ 'jobs' ]        = ( new JobService() ) -> all ();
            $data[ 'searchRoute' ] = route ( 'candidates.document-ready-candidates' );
            $data[ 'referrals' ]   = ( new ReferralService() ) -> all ();
            return view ( 'candidates.document-ready', $data );
        }
        
        public function visa_candidates (): View {
            $this -> authorize ( 'all', CandidateVisa::class );
            $data[ 'title' ]           = 'Visa Candidates';
            $data[ 'candidates' ]      = ( new CandidateService() ) -> visa_candidates ();
            $data[ 'fee' ]             = Fee ::where ( [ 'slug' => 'test-fee' ] ) -> first ();
            $data[ 'jobs' ]            = ( new JobService() ) -> all ();
            $data[ 'tgid_candidates' ] = ( new CandidateVisaService() ) -> get_tgid_candidates ();
            $data[ 'searchRoute' ]     = route ( 'candidates.visa-candidates' );
            $data[ 'referrals' ]       = ( new ReferralService() ) -> all ();
            return view ( 'candidates.visa', $data );
        }
        
        public function protector_candidates (): View {
            $this -> authorize ( 'all', CandidateProtector::class );
            $data[ 'title' ]       = 'Protector Candidates';
            $data[ 'candidates' ]  = ( new CandidateService() ) -> protector_candidates ();
            $data[ 'fee' ]         = Fee ::where ( [ 'slug' => 'test-fee' ] ) -> first ();
            $data[ 'jobs' ]        = ( new JobService() ) -> all ();
            $data[ 'searchRoute' ] = route ( 'candidates.protector-candidates' );
            $data[ 'referrals' ]   = ( new ReferralService() ) -> all ();
            return view ( 'candidates.protector', $data );
        }
        
        public function ticket_candidates (): View {
            $this -> authorize ( 'all', CandidateTicket::class );
            $data[ 'title' ]       = 'Ticket Candidates';
            $data[ 'candidates' ]  = ( new CandidateService() ) -> ticket_candidates ();
            $data[ 'fee' ]         = Fee ::where ( [ 'slug' => 'test-fee' ] ) -> first ();
            $data[ 'jobs' ]        = ( new JobService() ) -> all ();
            $data[ 'searchRoute' ] = route ( 'candidates.ticket-candidates' );
            $data[ 'referrals' ]   = ( new ReferralService() ) -> all ();
            return view ( 'candidates.ticket', $data );
        }
        
        public function case_closed_candidates (): View {
            $this -> authorize ( 'case_closed', Candidate::class );
            $data[ 'title' ]       = 'Case Closed Candidates';
            $data[ 'candidates' ]  = ( new CandidateService() ) -> case_closed_candidates ();
            $data[ 'fee' ]         = Fee ::where ( [ 'slug' => 'test-fee' ] ) -> first ();
            $data[ 'jobs' ]        = ( new JobService() ) -> all ();
            $data[ 'referrals' ]   = ( new ReferralService() ) -> all ();
            $data[ 'searchRoute' ] = route ( 'candidates.index' );
            return view ( 'candidates.index', $data );
        }
        
        public function attachments ( Candidate $candidate ): View {
            $this -> authorize ( 'attachments', $candidate );
            $data[ 'title' ]     = 'Candidate Attachments';
            $data[ 'candidate' ] = $candidate;
            return view ( 'candidates.update', $data );
        }
        
        public function clear_accounts ( Request $request, Candidate $candidate ): RedirectResponse {
            $this -> authorize ( 'candidate_clear_accounts', $candidate );
            try {
                DB ::beginTransaction ();
                ( new CandidateService() ) -> clear_accounts ( $candidate );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Accounts has been cleared.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function proceed_to_visa ( Request $request, Candidate $candidate ): RedirectResponse {
            $this -> authorize ( 'candidate_proceed_to_visa', $candidate );
            try {
                DB ::beginTransaction ();
                ( new CandidateService() ) -> proceed_to_visa ( $candidate );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate is now ready for visa.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function save_payment_remarks ( Request $request, Candidate $candidate ): RedirectResponse {
            try {
                DB ::beginTransaction ();
                ( new CandidateService() ) -> save_payment_remarks ( $candidate, $request );
                ( new CandidatePaymentReceiptService() ) -> save ( $request, $candidate );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate payment remarks saved.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function status_change ( Request $request, Candidate $candidate ): RedirectResponse {
            try {
                DB ::beginTransaction ();
                ( new CandidateService() ) -> status_change ( $candidate, $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate status has been changed.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function arrived ( Request $request, Candidate $candidate ): RedirectResponse {
            $this -> authorize ( 'qj_medical_report', User::class );
            try {
                DB ::beginTransaction ();
                ( new CandidateService() ) -> arrived ( $candidate, $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate arrived has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
