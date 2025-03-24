<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\User;
    use App\Services\AccountService;
    use App\Services\CandidateService;
    use App\Services\CandidateVisaService;
    use App\Services\JobService;
    use App\Services\PrincipalService;
    use App\Services\ReferralService;
    use App\Services\ReportingService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\Request;
    
    class ReportingController extends Controller {
        
        public function status_check ( Request $request ): View {
            $this -> authorize ( 'status_check', User::class );
            $data[ 'title' ]           = 'Status Check Report';
            $data[ 'candidates' ]      = ( new CandidateService() ) -> status_check ();
            $data[ 'searchRoute' ]     = route ( 'reporting.status-check' );
            $data[ 'jobs' ]            = ( new JobService() ) -> all ();
            $data[ 'referrals' ]       = ( new ReferralService() ) -> all ();
            $data[ 'tgid_candidates' ] = ( new CandidateVisaService() ) -> get_tgid_candidates ();
            return view ( 'reporting.status-check', $data );
        }
        
        public function summary_report ( Request $request ): View {
            $this -> authorize ( 'summary_report', User::class );
            $data[ 'title' ]                  = 'Status Check Report';
            $data[ 'selected_interviews' ]    = ( new ReportingService() ) -> count_interviews ( 'selected' );
            $data[ 'rejected_interviews' ]    = ( new ReportingService() ) -> count_interviews ( 'rejected' );
            $data[ 'fit_medicals' ]           = ( new ReportingService() ) -> count_medicals ( 'fit' );
            $data[ 'unfit_medicals' ]         = ( new ReportingService() ) -> count_medicals ( 'unfit' );
            $data[ 'documents_ready' ]        = ( new ReportingService() ) -> count_documents_ready ( 'yes' );
            $data[ 'not_documents_ready' ]    = ( new ReportingService() ) -> count_documents_ready ( 'no' );
            $data[ 'documents_uploaded' ]     = ( new ReportingService() ) -> count_documents_uploaded ( 'yes' );
            $data[ 'not_documents_uploaded' ] = ( new ReportingService() ) -> count_documents_uploaded ( 'no' );
            $data[ 'issued_visas' ]           = ( new ReportingService() ) -> count_visas ( 'issued' );
            $data[ 'rejected_visas' ]         = ( new ReportingService() ) -> count_visas ( 'rejected' );
            $data[ 'sent_protectors' ]        = ( new ReportingService() ) -> count_protector ( 'sent' );
            $data[ 'done_protectors' ]        = ( new ReportingService() ) -> count_protector ( 'done' );
            $data[ 'confirmed_tickets' ]      = ( new ReportingService() ) -> count_tickets ( 'confirmed' );
            $data[ 'travelled_tickets' ]      = ( new ReportingService() ) -> count_tickets ( 'travelled' );
            $data[ 'back_out' ]               = ( new ReportingService() ) -> count_back_out ();
            return view ( 'reporting.summary-report', $data );
        }
        
        public function follow_up_report ( Request $request ): View {
            $this -> authorize ( 'follow_up_report', User::class );
            $data[ 'title' ]      = 'Follow Up Report';
            $data[ 'candidates' ] = ( new ReportingService() ) -> follow_up_report ();
            return view ( 'reporting.follow-up-report', $data );
        }
        
        public function missing_docs_report ( Request $request ): View {
            $this -> authorize ( 'missing_docs_report', User::class );
            $data[ 'title' ]      = 'Missing Docs Report';
            $data[ 'candidates' ] = ( new ReportingService() ) -> missing_docs_report ();
            return view ( 'reporting.missing-docs-report', $data );
        }
        
        public function cheque_details_report ( Request $request ): View {
            $this -> authorize ( 'cheque_details_report', User::class );
            $object            = ( new AccountService() );
            $data[ 'title' ]   = 'Cheque Details Report';
            $account_heads     = $object -> getRecursiveAccountHeads ( config ( 'constants.banks' ) );
            $data[ 'banks' ]   = $object -> convertToOptions ( $account_heads );
            $data[ 'ledgers' ] = ( new ReportingService() ) -> cheque_details_report ( $request );
            return view ( 'reporting.cheque-details-report', $data );
        }
        
        public function gross_profit_report ( Request $request ): View {
            $this -> authorize ( 'gross_profit_report', User::class );
            $object               = ( new AccountService() );
            $data[ 'title' ]      = 'Gross Profit Report';
            $data[ 'jobs' ]       = ( new JobService() ) -> all ();
            $data[ 'principals' ] = ( new PrincipalService() ) -> all ();
            $data[ 'referrals' ]  = ( new ReferralService() ) -> all ();
            $data[ 'candidates' ] = ( new ReportingService() ) -> gross_profit_report ( $request );
            return view ( 'reporting.gross-profit-report', $data );
        }
        
        public function qj_medical_report ( Request $request ): View {
            $this -> authorize ( 'qj_medical_report', User::class );
            $data[ 'title' ]       = 'QJ Medical Report';
            $data[ 'candidates' ]  = ( new ReportingService() ) -> get_qj_vendor_candidates ();
            return view ( 'reporting.qj-medical-report', $data );
        }
    }
