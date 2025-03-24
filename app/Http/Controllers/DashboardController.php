<?php

    namespace App\Http\Controllers;

    use App\Models\Candidate;
    use App\Models\CandidateDocumentReady;
    use App\Models\CandidateInterview;
    use App\Models\CandidateMedical;
    use App\Models\CandidateProtector;
    use App\Models\CandidateTicket;
    use App\Models\CandidateVisa;
    use App\Models\User;
    use App\Services\AnalyticsService;
    use App\Services\ReportingService;
    use Illuminate\Contracts\View\View;

    class DashboardController extends Controller {

        public function index (): View {
            $this -> authorize ( 'dashboard', User::class );
            $data[ 'title' ]                         = 'Dashboard';
            $data[ 'banks_balances' ]                = ( new AnalyticsService() ) -> banks_balances ();
            $data[ 'daily_cash_balances' ]           = ( new AnalyticsService() ) -> daily_cash_balances ();
            $data[ 'general_admin_expenses' ]        = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.expenses' ) );
            $data[ 'total_medicals' ]           = CandidateMedical ::count ();
            $data[ 'total_documents_ready' ]    = CandidateDocumentReady ::count ();
            $data[ 'total_documents_uploaded' ] = CandidateVisa ::whereNotNull ( 'tgid' ) -> count ();
            $data[ 'total_tickets' ]            = CandidateTicket ::count ();
            $data[ 'total_protectors' ]         = CandidateProtector ::count ();
            $data[ 'total_visas' ]              = CandidateVisa ::count ();
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
            $data[ 'profit' ]                 = ( new ReportingService() ) -> profit ();
            return view ( 'dashboard.index', $data );
        }

        public function home (): View {
            $data[ 'title' ] = 'Home';
            return view ( 'dashboard.home', $data );
        }

    }
