<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\AirlineFormRequest;
    use App\Models\Airline;
    use App\Services\AirlineService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log; 
    
    class AirlineController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', Airline::class );
            $data[ 'title' ]    = 'All Airlines';
            $data[ 'airlines' ] = ( new AirlineService() ) -> all ();
            return view ( 'airlines.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Airline::class );
            $data[ 'title' ] = 'Add Airline';
            return view ( 'airlines.create', $data );
        }
        
        public function store ( AirlineFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Airline::class );
            try {
                DB ::beginTransaction ();
                $airline = ( new AirlineService() ) -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $airline ) and $airline -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'Airline has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Airline $airline ): View {
            $this -> authorize ( 'edit', $airline );
            $data[ 'title' ]   = 'Edit Airline';
            $data[ 'airline' ] = $airline;
            return view ( 'airlines.update', $data );
        }
        
        public function update ( AirlineFormRequest $request, Airline $airline ): RedirectResponse {
            $this -> authorize ( 'edit', $airline );
            try {
                DB ::beginTransaction ();
                ( new AirlineService() ) -> edit ( $request, $airline );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Airline has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Airline $airline ): RedirectResponse {
            $this -> authorize ( 'delete', $airline );
            try {
                DB ::beginTransaction ();
                ( new AirlineService() ) -> delete ( $airline );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Airline has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
