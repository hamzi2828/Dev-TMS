<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\AgreementFormRequest;
    use App\Models\Agreement;
    use App\Services\AgreementService;
    use App\Services\JobService;
    use App\Services\PrincipalService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class AgreementController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', Agreement::class );
            $data[ 'title' ]      = 'All Agreements';
            $data[ 'agreements' ] = ( new AgreementService() ) -> all ();
            return view ( 'templates.agreements.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Agreement::class );
            $data[ 'title' ]      = 'Add Agreement';
            $data[ 'jobs' ]       = ( new JobService() ) -> all ();
            $data[ 'principals' ] = ( new PrincipalService() ) -> all ();
            return view ( 'templates.agreements.create', $data );
        }
        
        public function store ( AgreementFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Agreement::class );
            try {
                DB ::beginTransaction ();
                $job = ( new AgreementService() ) -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $job ) and $job -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'Agreement has been saved.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Agreement $agreement ): View {
            $this -> authorize ( 'edit', $agreement );
            $data[ 'title' ]      = 'Edit Agreement';
            $data[ 'agreement' ]  = $agreement;
            $data[ 'jobs' ]       = ( new JobService() ) -> all ();
            $data[ 'principals' ] = ( new PrincipalService() ) -> all ();
            return view ( 'templates.agreements.update', $data );
        }
        
        public function update ( AgreementFormRequest $request, Agreement $agreement ) {
            $this -> authorize ( 'update', $agreement );
            try {
                DB ::beginTransaction ();
                ( new AgreementService() ) -> edit ( $request, $agreement );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Agreement has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Agreement $agreement ) {
            $this -> authorize ( 'delete', $agreement );
            try {
                DB ::beginTransaction ();
                ( new AgreementService() ) -> delete ( $agreement );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Agreement has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
