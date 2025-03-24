<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CandidateVisaFormRequest;
    use App\Models\Candidate;
    use App\Models\CandidateVisa;
    use App\Services\CandidateMedicalService;
    use App\Services\CandidateVisaService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CandidateVisaController extends Controller {
        
        public function index () {
            //
        }
        
        public function create ( Candidate $candidate ): View {
            $this -> authorize ( 'create', CandidateVisa::class );
            $data[ 'title' ]     = 'Add Candidate Visa';
            $data[ 'candidate' ] = $candidate;
            return view ( 'candidates.update', $data );
        }
        
        public function store ( CandidateVisaFormRequest $request, Candidate $candidate ) {
            $this -> authorize ( 'create', CandidateVisa::class );
            try {
                DB ::beginTransaction ();
                $visa = ( new CandidateVisaService() ) -> save ( $request, $candidate );
                DB ::commit ();
                
                if ( !empty( $visa ) )
                    return redirect () -> route ( 'candidates.visas.edit', [ 'candidate' => $candidate -> id, 'visa' => $visa -> id ] ) -> with ( 'success', 'Candidate visa has been saved.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Candidate $candidate, CandidateVisa $visa ): View {
            $this -> authorize ( 'edit', $visa );
            $data[ 'title' ]     = 'Edit Candidate Visa';
            $data[ 'candidate' ] = $candidate;
            $data[ 'visa' ]      = $visa;
            return view ( 'candidates.update', $data );
        }
        
        public function update ( CandidateVisaFormRequest $request, Candidate $candidate, CandidateVisa $visa ) {
            $this -> authorize ( 'edit', $visa );
            try {
                DB ::beginTransaction ();
                ( new CandidateVisaService() ) -> edit ( $request, $candidate, $visa );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate visa has been updated.' );
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
                ( new CandidateVisaService() ) -> bulk_status_update ( $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidates statuses have been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Candidate $candidate, CandidateVisa $visa ) {
            //
        }
        
        public function bulk_visa_details_popup ( Request $request ): string {
            $candidates           = str_replace ( 'on, ', '', $request -> input ( 'candidates' ) );
            $data[ 'candidates' ] = Candidate ::whereIn ( 'id', explode ( ',', $candidates ) ) -> get ();
            return view ( 'candidates.popups.visa', $data ) -> render ();
        }
    }
