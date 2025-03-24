<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CityFormRequest;
    use App\Models\City;
    use App\Services\CityService;
    use App\Services\CountryService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CityController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', City::class );
            $data[ 'title' ]  = 'All Cities';
            $data[ 'cities' ] = ( new CityService() ) -> all ();
            return view ( 'cities.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', City::class );
            $data[ 'title' ]     = 'Add Cities';
            $data[ 'countries' ] = ( new CountryService() ) -> all ();
            return view ( 'cities.create', $data );
        }
        
        public function store ( CityFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', City::class );
            try {
                DB ::beginTransaction ();
                $city = ( new CityService() ) -> save ( $request );
                DB ::commit ();
                
                if ( $city )
                    return redirect () -> back () -> with ( 'success', 'City has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( City $city ): View {
            $this -> authorize ( 'edit', $city );
            $data[ 'title' ]     = 'Edit City';
            $data[ 'countries' ] = ( new CountryService() ) -> all ();
            $data[ 'city' ]      = $city;
            return view ( 'cities.update', $data );
        }
        
        public function update ( CityFormRequest $request, City $city ) {
            $this -> authorize ( 'edit', $city );
            try {
                DB ::beginTransaction ();
                ( new CityService() ) -> edit ( $request, $city );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'City has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( City $city ) {
            $this -> authorize ( 'delete', $city );
            try {
                DB ::beginTransaction ();
                $city -> delete ();
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'City has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
