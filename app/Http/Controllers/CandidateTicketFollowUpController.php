<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Candidate;
    use App\Models\CandidateTicketFollowUp;
    use App\Services\CandidateTicketFollowUpService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CandidateTicketFollowUpController extends Controller {
        
        public function index () {
            //
        }
        
        public function create ( Candidate $candidate ): View {
            $this -> authorize ( 'mainMenu', CandidateTicketFollowUp::class );
            $data[ 'title' ]     = 'Add Ticket Follow Up';
            $data[ 'candidate' ] = $candidate;
            return view ( 'candidates.update', $data );
        }
        
        public function store ( Request $request, Candidate $candidate ) {
            $this -> authorize ( 'mainMenu', CandidateTicketFollowUp::class );
            try {
                DB ::beginTransaction ();
                $followUp = ( new CandidateTicketFollowUpService() ) -> save ( $request, $candidate );
                DB ::commit ();
                
                if ( $followUp )
                    return redirect () -> route ( 'candidates.ticket-follow-up.edit', [ 'candidate' => $candidate -> id, 'ticket_follow_up' => $followUp -> id ] ) -> with ( 'success', 'Candidate payment follow up has been saved.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Candidate $candidate, CandidateTicketFollowUp $ticket_follow_up ): View {
            $this -> authorize ( 'mainMenu', CandidateTicketFollowUp::class );
            $data[ 'title' ]            = 'Edit Ticket Follow Up';
            $data[ 'candidate' ]        = $candidate;
            $data[ 'ticket_follow_up' ] = $ticket_follow_up;
            return view ( 'candidates.update', $data );
        }
        
        public function update ( Request $request, Candidate $candidate, CandidateTicketFollowUp $ticket_follow_up ) {
            $this -> authorize ( 'mainMenu', CandidateTicketFollowUp::class );
            try {
                DB ::beginTransaction ();
                ( new CandidateTicketFollowUpService() ) -> edit ( $request, $ticket_follow_up );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate ticket follow up has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Candidate $candidate, CandidateTicketFollowUp $ticket_follow_up ) {
            //
        }
    }
