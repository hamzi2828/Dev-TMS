<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CandidateInterviewFormRequest;
    use App\Models\Candidate;
    use App\Models\CandidateInterview;
    use App\Services\CandidateInterviewDocumentService;
    use App\Services\CandidateInterviewService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CandidateInterviewController extends Controller {
        
        public function index (): View {
        
        }
        
        public function create ( Candidate $candidate ): View {
            $this -> authorize ( 'create', CandidateInterview::class );
            $data[ 'title' ]     = 'Add Interview';
            $data[ 'candidate' ] = $candidate;
            return view ( 'candidates.update', $data );
        }
        
        public function store ( CandidateInterviewFormRequest $request, Candidate $candidate ) {
            $this -> authorize ( 'create', CandidateInterview::class );
            try {
                DB ::beginTransaction ();
                $interview = ( new CandidateInterviewService() ) -> save ( $request, $candidate );
                ( new CandidateInterviewDocumentService() ) -> save ( $request, $candidate, $interview );
                
                if ( $interview -> status == 'selected' )
                    ( new CandidateInterviewService() ) -> save_medical ( $candidate );
                
                DB ::commit ();
                
                if ( !empty( $interview ) )
                    return redirect () -> route ( 'candidates.interviews.edit', [ 'candidate' => $candidate -> id, 'interview' => $interview -> id ] ) -> with ( 'success', 'Candidate interview has been saved.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Candidate $candidate, CandidateInterview $interview ): View {
            $this -> authorize ( 'edit', $interview );
            $data[ 'title' ]     = 'Add Interview';
            $data[ 'candidate' ] = $candidate;
            return view ( 'candidates.update', $data );
        }
        
        public function update ( CandidateInterviewFormRequest $request, Candidate $candidate, CandidateInterview $interview ) {
            $this -> authorize ( 'edit', $interview );
            try {
                DB ::beginTransaction ();
                ( new CandidateInterviewService() ) -> edit ( $request, $interview );
                ( new CandidateInterviewDocumentService() ) -> edit ( $request, $candidate, $interview );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate interview has been updated.' );
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
                ( new CandidateInterviewService() ) -> bulk_status_update ( $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidates statuses have been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( CandidateInterview $candidate_interview ) {
            //
        }
    }
