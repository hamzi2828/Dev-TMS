<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\ProvinceFormRequest;
    use App\Models\Province;
    use App\Services\ProvinceService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class ProvinceController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', Province::class );
            $data[ 'title' ]     = 'All Provinces';
            $data[ 'provinces' ] = ( new ProvinceService() ) -> all ();
            return view ( 'provinces.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Province::class );
            $data[ 'title' ] = 'Add Provinces';
            return view ( 'provinces.create', $data );
        }
        
        public function store ( ProvinceFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Province::class );
            try {
                DB ::beginTransaction ();
                $country = ( new ProvinceService() ) -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $country ) and $country -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'Province has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Province $province ): View {
            $this -> authorize ( 'edit', $province );
            $data[ 'title' ]    = 'Edit Province';
            $data[ 'province' ] = $province;
            return view ( 'provinces.update', $data );
        }
        
        public function update ( ProvinceFormRequest $request, Province $province ): RedirectResponse {
            $this -> authorize ( 'edit', $province );
            try {
                DB ::beginTransaction ();
                ( new ProvinceService() ) -> edit ( $request, $province );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Province has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Province $province ) {
            $this -> authorize ( 'delete', $province );
            try {
                DB ::beginTransaction ();
                ( new ProvinceService() ) -> delete ( $province );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Province has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
