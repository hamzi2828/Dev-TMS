<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CandidateDocumentReadyFormRequest;
    use App\Models\Candidate;
    use App\Models\CandidateDocumentReady;
    use App\Services\AgreementService;
    use App\Services\CandidateDocumentReadyService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CandidateDocumentReadyController extends Controller {
        
        public function index () {
            //
        }
        
        public function create ( Candidate $candidate ): View {
            $this -> authorize ( 'mainMenu', CandidateDocumentReady::class );
            $data[ 'title' ]      = 'Add Document Ready';
            $data[ 'candidate' ]  = $candidate;
            $data[ 'agreements' ] = ( new AgreementService() ) -> get_agreements_by_job ( $candidate -> job_id );
            return view ( 'candidates.update', $data );
        }
        
        public function store ( CandidateDocumentReadyFormRequest $request, Candidate $candidate ) {
            $this -> authorize ( 'mainMenu', CandidateDocumentReady::class );
            try {
                DB ::beginTransaction ();
                $ready = ( new CandidateDocumentReadyService() ) -> save ( $request, $candidate );
//                ( new CandidateDocumentReadyService() ) -> save_visa ( $candidate );
                DB ::commit ();
                
                if ( !empty( $ready ) )
                    return redirect () -> route ( 'candidates.document-ready.edit', [ 'candidate' => $candidate -> id, 'document_ready' => $ready -> id ] ) -> with ( 'success', 'Candidate documents ready has been saved.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Candidate $candidate, CandidateDocumentReady $document_ready ) {
            $this -> authorize ( 'mainMenu', CandidateDocumentReady::class );
            $data[ 'title' ]      = 'Edit Document Ready';
            $data[ 'candidate' ]  = $candidate;
            $data[ 'agreements' ] = ( new AgreementService() ) -> get_agreements_by_job ( $candidate -> job_id );
            return view ( 'candidates.update', $data );
        }
        
        public function update ( CandidateDocumentReadyFormRequest $request, Candidate $candidate, CandidateDocumentReady $document_ready ) {
            $this -> authorize ( 'mainMenu', CandidateDocumentReady::class );
            try {
                DB ::beginTransaction ();
                ( new CandidateDocumentReadyService() ) -> edit ( $request, $candidate, $document_ready );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate documents ready has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Candidate $candidate, CandidateDocumentReady $document_ready ) {
            //
        }
        
        public function bulk_status_update ( Request $request ) {
            try {
                DB ::beginTransaction ();
                ( new CandidateDocumentReadyService() ) -> bulk_status_update ( $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidates statuses have been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
