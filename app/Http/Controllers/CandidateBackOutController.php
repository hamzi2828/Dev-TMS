<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Candidate;
    use App\Models\CandidateBackOut;
    use App\Services\CandidateBackoutService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Validation\Rules\Can;
    
    class CandidateBackOutController extends Controller {
        
        public function index () {
            //
        }
        
        public function create ( Candidate $candidate ): View {
            $this -> authorize ( 'create', CandidateBackOut::class );
            $data[ 'title' ]     = 'Candidate Back Out';
            $data[ 'candidate' ] = $candidate;
            return view ( 'candidates.update', $data );
        }
        
        public function store ( Request $request, Candidate $candidate ): RedirectResponse {
            $this -> authorize ( 'create', CandidateBackOut::class );
            try {
                DB ::beginTransaction ();
                $backOut = ( new CandidateBackoutService() ) -> save ( $request, $candidate );
                DB ::commit ();
                
                return redirect () -> route ( 'candidates.back-out.edit', [ 'candidate' => $candidate -> id, 'back_out' => $backOut -> id ] ) -> with ( 'success', 'Candidate back out saved.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Candidate $candidate, CandidateBackOut $backOut ): View {
            $this -> authorize ( 'create', CandidateBackOut::class );
            $data[ 'title' ]     = 'Candidate Back Out';
            $data[ 'candidate' ] = $candidate;
            $data[ 'back_out' ]  = $backOut;
            return view ( 'candidates.update', $data );
        }
        
        public function update ( Request $request, Candidate $candidate, CandidateBackOut $backOut ) {
            $this -> authorize ( 'create', CandidateBackOut::class );
            try {
                DB ::beginTransaction ();
                ( new CandidateBackoutService() ) -> edit ( $request, $backOut );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate back out updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function unback ( Request $request, Candidate $candidate, CandidateBackOut $backOut ) {
            $this -> authorize ( 'unback', CandidateBackOut::class );
            try {
                DB ::beginTransaction ();
                ( new CandidateBackoutService() ) -> delete ( $backOut );
                DB ::commit ();
                
                return redirect () -> route (route ( 'candidates.edit', [ 'candidate' => $candidate -> id ] )) -> with ( 'success', 'Candidate back out updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( CandidateBackOut $backOut ) {
            //
        }
    }
