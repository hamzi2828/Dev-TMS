<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CandidateProtectorFormRequest;
    use App\Models\Candidate;
    use App\Models\CandidateProtector;
    use App\Services\CandidateProtectorService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CandidateProtectorController extends Controller {
        
        public function index () {
            //
        }
        
        public function create ( Candidate $candidate ): View {
            $this -> authorize ( 'create', CandidateProtector::class );
            $data[ 'title' ]     = 'Add Candidate Protector';
            $data[ 'candidate' ] = $candidate;
            return view ( 'candidates.update', $data );
        }
        
        public function store ( CandidateProtectorFormRequest $request, Candidate $candidate ) {
            $this -> authorize ( 'create', CandidateProtector::class );
            try {
                DB ::beginTransaction ();
                $protector = ( new CandidateProtectorService() ) -> save ( $request, $candidate );
//                ( new CandidateProtectorService() ) -> save_ticket ( $request, $candidate );
                DB ::commit ();
                
                if ( !empty( $protector ) )
                    return redirect () -> route ( 'candidates.protectors.edit', [ 'candidate' => $candidate -> id, 'protector' => $protector -> id ] ) -> with ( 'success', 'Candidate protector has been saved.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Candidate $candidate, CandidateProtector $protector ): View {
            $this -> authorize ( 'edit', $protector );
            $data[ 'title' ]     = 'Edit Candidate Protector';
            $data[ 'candidate' ] = $candidate;
            $data[ 'protector' ] = $protector;
            return view ( 'candidates.update', $data );
        }
        
        public function update ( CandidateProtectorFormRequest $request, Candidate $candidate, CandidateProtector $protector ) {
            $this -> authorize ( 'edit', $protector );
            try {
                DB ::beginTransaction ();
                ( new CandidateProtectorService() ) -> edit ( $request, $candidate, $protector );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate protector has been updated.' );
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
                ( new CandidateProtectorService() ) -> bulk_status_update ( $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidates statuses have been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Candidate $candidate, CandidateProtector $protector ) {
            //
        }
    }
