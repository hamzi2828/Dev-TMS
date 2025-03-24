<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\DistrictFormRequest;
    use App\Models\District;
    use App\Services\DistrictService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class DistrictController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', District::class );
            $data[ 'title' ]     = 'All Districts';
            $data[ 'districts' ] = ( new DistrictService() ) -> all ();
            return view ( 'districts.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', District::class );
            $data[ 'title' ] = 'Add District';
            return view ( 'districts.create', $data );
        }
        
        public function store ( DistrictFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', District::class );
            try {
                DB ::beginTransaction ();
                $district = ( new DistrictService() ) -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $district ) and $district -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'District has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( District $district ): View {
            $this -> authorize ( 'edit', $district );
            $data[ 'title' ]    = 'Edit District';
            $data[ 'district' ] = $district;
            return view ( 'districts.update', $data );
        }
        
        public function update ( DistrictFormRequest $request, District $district ): RedirectResponse {
            $this -> authorize ( 'edit', $district );
            try {
                DB ::beginTransaction ();
                ( new DistrictService() ) -> edit ( $request, $district );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'District has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( District $district ) {
            $this -> authorize ( 'delete', $district );
            try {
                DB ::beginTransaction ();
                ( new DistrictService() ) -> delete ( $district );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'District has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
