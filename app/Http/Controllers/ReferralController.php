<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\ReferralFormRequest;
    use App\Models\Referral;
    use App\Services\ReferralService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class ReferralController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', Referral::class );
            $data[ 'title' ]     = 'All Referrals';
            $data[ 'referrals' ] = ( new ReferralService() ) -> all ();
            return view ( 'referrals.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Referral::class );
            $data[ 'title' ] = 'Add Referral';
            return view ( 'referrals.create', $data );
        }
        
        public function store ( ReferralFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Referral::class );
            try {
                DB ::beginTransaction ();
                $referral = ( new ReferralService() ) -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $referral ) and $referral -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'Referral has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Referral $referral ): View {
            $this -> authorize ( 'edit', $referral );
            $data[ 'title' ]    = 'Edit Referral';
            $data[ 'referral' ] = $referral;
            return view ( 'referrals.update', $data );
        }
        
        public function update ( ReferralFormRequest $request, Referral $referral ): RedirectResponse {
            $this -> authorize ( 'update', $referral );
            try {
                DB ::beginTransaction ();
                ( new ReferralService() ) -> edit ( $request, $referral );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Referral has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Referral $referral ): RedirectResponse {
            $this -> authorize ( 'delete', $referral );
            try {
                DB ::beginTransaction ();
                ( new ReferralService() ) -> delete ( $referral );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Referral has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
