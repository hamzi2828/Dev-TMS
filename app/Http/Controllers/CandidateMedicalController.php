<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CandidateMedicalFormRequest;
    use App\Models\Candidate;
    use App\Models\CandidateMedical;
    use App\Services\AccountService;
    use App\Services\CandidateMedicalAttachmentService;
    use App\Services\CandidateMedicalService;
    use App\Services\CandidateService;
    use App\Services\GeneralLedgerService;
    use App\Services\PaymentMethodService;
    use App\Services\VendorService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CandidateMedicalController extends Controller {
        
        public function index () {
            //
        }
        
        public function create ( Candidate $candidate ): View {
            $this -> authorize ( 'create', CandidateMedical::class );
            $data[ 'title' ]           = 'Add Medical';
            $data[ 'candidate' ]       = $candidate;
            $data[ 'payment_methods' ] = ( new PaymentMethodService() ) -> all ();
            $data[ 'vendors' ]         = ( new VendorService() ) -> all ();
            return view ( 'candidates.update', $data );
        }
        
        public function store ( CandidateMedicalFormRequest $request, Candidate $candidate ) {
            $this -> authorize ( 'create', CandidateMedical::class );
            try {
                DB ::beginTransaction ();
                $medical = ( new CandidateMedicalService() ) -> save ( $request, $candidate );
                
                if ( $medical -> status == 'fit' ) {
                    $account_head = ( new AccountService() ) -> add_candidate ( $request, $candidate );
                    ( new CandidateService() ) -> add_candidate_account_head_id ( $candidate, $account_head -> id );
                    ( new GeneralLedgerService() ) -> candidate_agreed_amount ( $candidate );
                    $candidate -> current_status = 'medical';
                    $candidate -> update ();
                }
                
                ( new GeneralLedgerService() ) -> charge_candidate_medical_fee ( $medical, $candidate );
                
                DB ::commit ();
                
                if ( !empty( $medical ) )
                    return redirect () -> route ( 'candidates.medicals.edit', [ 'candidate' => $candidate -> id, 'medical' => $medical -> id ] ) -> with ( 'success', 'Candidate medical has been saved.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Candidate $candidate, CandidateMedical $medical ): View {
            $this -> authorize ( 'edit', $medical );
            $data[ 'title' ]           = 'Edit Medical';
            $data[ 'candidate' ]       = $candidate;
            $data[ 'medical' ]         = $medical;
            $data[ 'payment_methods' ] = ( new PaymentMethodService() ) -> all ();
            $data[ 'vendors' ]         = ( new VendorService() ) -> all ();
            return view ( 'candidates.update', $data );
        }
        
        public function update ( CandidateMedicalFormRequest $request, Candidate $candidate, CandidateMedical $medical ) {
            $this -> authorize ( 'edit', $medical );
            try {
                DB ::beginTransaction ();
                ( new CandidateMedicalService() ) -> edit ( $request, $medical );
                ( new CandidateMedicalAttachmentService() ) -> save ( $request, $candidate, $medical );
                
                if ( $medical -> status == 'fit' && empty( trim ( $candidate -> account_head_id ) ) ) {
                    $account_head = ( new AccountService() ) -> add_candidate ( $request, $candidate );
                    ( new CandidateService() ) -> add_candidate_account_head_id ( $candidate, $account_head -> id );
                    ( new GeneralLedgerService() ) -> candidate_agreed_amount ( $candidate );
                }
                
                if ( !empty( trim ( $candidate -> account_head_id ) ) )
                    ( new AccountService() ) -> edit_candidate ( $candidate );
                
//                if ( empty( trim ( $candidate -> payment_method_id ) ) && $candidate -> free_candidate == '1' )
//                    ( new GeneralLedgerService() ) -> charge_candidate_medical_fee ( $medical, $candidate );
                
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidate medical has been updated.' );
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
                ( new CandidateMedicalService() ) -> bulk_status_update ( $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Candidates statuses have been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( CandidateMedical $medical ) {
            //
        }
    }
