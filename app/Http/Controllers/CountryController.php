<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CountryRequest;
    use App\Models\Country;
    use App\Services\CountryService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CountryController extends Controller {
        
        protected object $countryService;
        
        public function __construct ( CountryService $countryService ) {
            $this -> countryService = $countryService;
        }
        
        public function index (): View {
            $this -> authorize ( 'all', Country::class );
            $data[ 'title' ]     = 'All Countries';
            $data[ 'countries' ] = $this -> countryService -> all ();
            return view ( 'countries.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Country::class );
            $data[ 'title' ] = 'Add Countries';
            return view ( 'countries.create', $data );
        }
        
        public function store ( CountryRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Country::class );
            try {
                DB ::beginTransaction ();
                $country = $this -> countryService -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $country ) and $country -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'Country has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Country $country ): View {
            $this -> authorize ( 'edit', $country );
            $data[ 'title' ]   = 'Edit Country';
            $data[ 'country' ] = $country;
            return view ( 'countries.update', $data );
        }
        
        public function update ( CountryRequest $request, Country $country ): RedirectResponse {
            $this -> authorize ( 'edit', $country );
            try {
                DB ::beginTransaction ();
                $this -> countryService -> edit ( $request, $country );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Country has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Country $country ) {
            $this -> authorize ( 'delete', $country );
            try {
                DB ::beginTransaction ();
                $country -> delete ();
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Country has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function cities ( Request $request ): string {
            $country = Country ::with ( [ 'cities' ] ) -> find ( $request -> input ( 'country_id' ) );
            return view ( 'countries.cities', compact ( 'country' ) ) -> render ();
        }
    }
