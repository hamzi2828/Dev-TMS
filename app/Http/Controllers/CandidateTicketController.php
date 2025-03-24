<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CandidateTicketFormRequest;
    use App\Models\Candidate;
    use App\Models\CandidateTicket;
    use App\Services\AgentService;
    use App\Services\AirlineService;
    use App\Services\CandidateService;
    use App\Services\CandidateTicketService;
    use App\Services\CountryService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CandidateTicketController extends Controller {
        
        public function index () {
            //
        }
        
        public function create ( Candidate $candidate ): View {
            $this -> authorize ( 'create', CandidateTicket::class );
            $data[ 'title' ]     = 'Add Candidate Ticket';
            $data[ 'candidate' ] = $candidate;
            $data[ 'countries' ] = ( new CountryService() ) -> all ();
            $data[ 'airlines' ]  = ( new AirlineService() ) -> all ();
            $data[ 'agents' ]    = ( new AgentService() ) -> all ();
            return view ( 'candidates.update', $data );
        }
        
        public function store ( CandidateTicketFormRequest $request, Candidate $candidate ) {
            $this -> authorize ( 'create', CandidateTicket::class );
            try {
                DB ::beginTransaction ();
                $ticket = ( new CandidateTicketService() ) -> save ( $request, $candidate );
                DB ::commit ();
                
                if ( $ticket -> status == 'travelled' ) {
                    DB ::beginTransaction ();
                    ( new CandidateService() ) -> close_case ( $candidate );
                    DB ::commit ();
                }
                
                if ( !empty( $ticket ) )
                    return redirect () -> route ( 'candidates.tickets.edit', [ 'candidate' => $candidate -> id, 'ticket' => $ticket -> id ] ) -> with ( 'success', 'Candidate ticket has been saved.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Candidate $candidate, CandidateTicket $ticket ): View {
            $this -> authorize ( 'edit', $ticket );
            $data[ 'title' ]     = 'Edit Candidate Ticket';
            $data[ 'candidate' ] = $candidate;
            $data[ 'ticket' ]    = $ticket;
            $data[ 'countries' ] = ( new CountryService() ) -> all ();
            $data[ 'airlines' ]  = ( new AirlineService() ) -> all ();
            $data[ 'agents' ]    = ( new AgentService() ) -> all ();
            return view ( 'candidates.update', $data );
        }
        
        public function update ( CandidateTicketFormRequest $request, Candidate $candidate, CandidateTicket $ticket ) {
            $this -> authorize ( 'edit', $ticket );
            try {
                DB ::beginTransaction ();
                ( new CandidateTicketService() ) -> edit ( $request, $candidate, $ticket );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate ticket has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function bulk_status_update ( Request $request ) {
            try {
                DB ::beginTransaction ();
                ( new CandidateTicketService() ) -> bulk_status_update ( $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidates statuses have been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function bulk_flight_details_popup ( Request $request ): string {
            $data[ 'countries' ]  = ( new CountryService() ) -> all ();
            $data[ 'airlines' ]   = ( new AirlineService() ) -> all ();
            $candidates           = str_replace ( 'on, ', '', $request -> input ( 'candidates' ) );
            $data[ 'candidates' ] = Candidate ::whereIn ( 'id', explode ( ',', $candidates ) ) -> get ();
            $data[ 'agents' ]     = ( new AgentService() ) -> all ();
            return view ( 'candidates.popups.flight-details', $data ) -> render ();
        }
        
        public function upsert_bulk_flight_details ( Request $request ) {
            $this -> authorize ( 'create', CandidateTicket::class );
            try {
                DB ::beginTransaction ();
                ( new CandidateTicketService() ) -> upsert ( $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate(s) ticket have been saved.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Candidate $candidate, CandidateTicket $ticket ) {
            //
        }
    }
