<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Candidate;
    use App\Models\CandidateVisaFollowUp;
    use App\Services\CandidateVisaFollowUpService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CandidateVisaFollowUpController extends Controller {
        
        public function index () {
            //
        }
        
        public function create ( Candidate $candidate ): View {
            $this -> authorize ( 'mainMenu', CandidateVisaFollowUp::class );
            $data[ 'title' ]     = 'Add Visa Follow Up';
            $data[ 'candidate' ] = $candidate;
            return view ( 'candidates.update', $data );
        }
        
        public function store ( Request $request, Candidate $candidate ) {
            $this -> authorize ( 'mainMenu', CandidateVisaFollowUp::class );
            try {
                DB ::beginTransaction ();
                $followUp = ( new CandidateVisaFollowUpService() ) -> save ( $request, $candidate );
                DB ::commit ();
                
                if ( $followUp )
                    return redirect () -> route ( 'candidates.visa-follow-up.edit', [ 'candidate' => $candidate -> id, 'visa_follow_up' => $followUp -> id ] ) -> with ( 'success', 'Candidate visa follow up has been saved.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Candidate $candidate, CandidateVisaFollowUp $visa_follow_up ): View {
            $this -> authorize ( 'mainMenu', CandidateVisaFollowUp::class );
            $data[ 'title' ]     = 'Edit Visa Follow Up';
            $data[ 'candidate' ] = $candidate;
            return view ( 'candidates.update', $data );
        }
        
        public function update ( Request $request, Candidate $candidate, CandidateVisaFollowUp $visa_follow_up ) {
            $this -> authorize ( 'mainMenu', CandidateVisaFollowUp::class );
            try {
                DB ::beginTransaction ();
                ( new CandidateVisaFollowUpService() ) -> edit ( $request, $visa_follow_up );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate visa follow up has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Candidate $candidate, CandidateVisaFollowUp $visa_follow_up ) {
            //
        }
    }
