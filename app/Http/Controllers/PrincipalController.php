<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\PrincipalFormRequest;
    use App\Models\Principal;
    use App\Services\CountryService;
    use App\Services\JobService;
    use App\Services\PrincipalJobService;
    use App\Services\PrincipalService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class PrincipalController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', Principal::class );
            $data[ 'title' ]      = 'All Principals';
            $data[ 'principals' ] = ( new PrincipalService() ) -> all ();
            return view ( 'principals.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Principal::class );
            $data[ 'title' ]     = 'Add Principal';
            $data[ 'countries' ] = ( new CountryService() ) -> all ();
            $data[ 'jobs' ]      = ( new JobService() ) -> all ();
            return view ( 'principals.create', $data );
        }
        
        public function store ( PrincipalFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Principal::class );
            try {
                DB ::beginTransaction ();
                $principal = ( new PrincipalService() ) -> save ( $request );
                ( new PrincipalJobService() ) -> save ( $request, $principal );
                DB ::commit ();
                
                if ( !empty( $principal ) and $principal -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'Principal has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Principal $principal ): View {
            $this -> authorize ( 'edit', $principal );
            $data[ 'title' ]     = 'Edit Principal';
            $data[ 'principal' ] = $principal;
            $data[ 'countries' ] = ( new CountryService() ) -> all ();
            $data[ 'jobs' ]      = ( new JobService() ) -> all ();
            return view ( 'principals.update', $data );
        }
        
        public function update ( PrincipalFormRequest $request, Principal $principal ): RedirectResponse {
            $this -> authorize ( 'update', $principal );
            try {
                DB ::beginTransaction ();
                ( new PrincipalService() ) -> edit ( $request, $principal );
                ( new PrincipalJobService() ) -> delete ( $principal );
                ( new PrincipalJobService() ) -> save ( $request, $principal );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Principal has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Principal $principal ): RedirectResponse {
            $this -> authorize ( 'delete', $principal );
            try {
                DB ::beginTransaction ();
                ( new PrincipalService() ) -> delete ( $principal );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Principal has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
