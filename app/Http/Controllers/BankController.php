<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\BankFormRequest;
    use App\Models\Bank;
    use App\Services\BankService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class BankController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', Bank::class );
            $data[ 'title' ] = 'All Banks';
            $data[ 'banks' ] = ( new BankService() ) -> all ();
            return view ( 'banks.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Bank::class );
            $data[ 'title' ] = 'Add Banks';
            return view ( 'banks.create', $data );
        }
        
        public function store ( BankFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Bank::class );
            try {
                DB ::beginTransaction ();
                $bank = ( new BankService() ) -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $bank ) and $bank -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'Bank has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Bank $bank ): View {
            $this -> authorize ( 'edit', $bank );
            $data[ 'title' ] = 'Edit Bank';
            $data[ 'bank' ]  = $bank;
            return view ( 'banks.update', $data );
        }
        
        public function update ( BankFormRequest $request, Bank $bank ): RedirectResponse {
            $this -> authorize ( 'edit', $bank );
            try {
                DB ::beginTransaction ();
                ( new BankService() ) -> edit ( $request, $bank );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Bank has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Bank $bank ) {
            $this -> authorize ( 'delete', $bank );
            try {
                DB ::beginTransaction ();
                ( new BankService() ) -> delete ( $bank );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Bank has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
