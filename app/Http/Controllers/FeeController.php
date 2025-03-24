<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\FeeFormRequest;
    use App\Models\Fee;
    use App\Services\FeeService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class FeeController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', Fee::class );
            $data[ 'title' ] = 'All Fees';
            $data[ 'fees' ]  = ( new FeeService() ) -> all ();
            return view ( 'fees.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Fee::class );
            $data[ 'title' ] = 'Add Fee';
            return view ( 'fees.create', $data );
        }
        
        public function store ( FeeFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Fee::class );
            try {
                DB ::beginTransaction ();
                $method = ( new FeeService() ) -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $method ) and $method -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'Fee has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Fee $fee ): View {
            $this -> authorize ( 'edit', $fee );
            $data[ 'title' ] = 'Edit Fee';
            $data[ 'fee' ]   = $fee;
            return view ( 'fees.update', $data );
        }
        
        public function update ( FeeFormRequest $request, Fee $fee ): RedirectResponse {
            $this -> authorize ( 'edit', $fee );
            try {
                DB ::beginTransaction ();
                ( new FeeService() ) -> edit ( $request, $fee );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Fee has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Fee $fee ): RedirectResponse {
            $this -> authorize ( 'delete', $fee );
            try {
                DB ::beginTransaction ();
                ( new FeeService() ) -> delete ( $fee );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Fee has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
