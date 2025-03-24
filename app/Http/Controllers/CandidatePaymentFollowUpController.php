<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Candidate;
    use App\Models\CandidatePaymentFollowUp;
    use App\Services\CandidatePaymentFollowUpService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CandidatePaymentFollowUpController extends Controller {
        
        public function index () {
            //
        }
        
        public function create ( Candidate $candidate ): View {
            $this -> authorize ( 'mainMenu', CandidatePaymentFollowUp::class );
            $data[ 'title' ]     = 'Add Payment Follow Up';
            $data[ 'candidate' ] = $candidate;
            return view ( 'candidates.update', $data );
        }
        
        public function store ( Request $request, Candidate $candidate ) {
            $this -> authorize ( 'mainMenu', CandidatePaymentFollowUp::class );
            try {
                DB ::beginTransaction ();
                $followUp = ( new CandidatePaymentFollowUpService() ) -> save ( $request, $candidate );
                DB ::commit ();
                
                if ( $followUp )
                    return redirect () -> route ( 'candidates.payment-follow-up.edit', [ 'candidate' => $candidate -> id, 'payment_follow_up' => $followUp -> id ] ) -> with ( 'success', 'Candidate payment follow up has been saved.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Candidate $candidate, CandidatePaymentFollowUp $payment_follow_up ): View {
            $this -> authorize ( 'mainMenu', CandidatePaymentFollowUp::class );
            $data[ 'title' ]             = 'Edit Payment Follow Up';
            $data[ 'candidate' ]         = $candidate;
            $data[ 'payment_follow_up' ] = $payment_follow_up;
            return view ( 'candidates.update', $data );
        }
        
        public function update ( Request $request, Candidate $candidate, CandidatePaymentFollowUp $payment_follow_up ) {
            $this -> authorize ( 'mainMenu', CandidatePaymentFollowUp::class );
            try {
                DB ::beginTransaction ();
                ( new CandidatePaymentFollowUpService() ) -> edit ( $request, $payment_follow_up );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate payment follow up has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( string $id ) {
            //
        }
    }
