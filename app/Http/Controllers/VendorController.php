<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\VendorFormRequest;
    use App\Models\Vendor;
    use App\Services\AccountService;
    use App\Services\VendorService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class VendorController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', Vendor::class );
            $data[ 'title' ]   = 'All Medical Vendor';
            $data[ 'vendors' ] = ( new VendorService() ) -> all ();
            return view ( 'vendors.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Vendor::class );
            $data[ 'title' ] = 'Add Medical Vendor';
            return view ( 'vendors.create', $data );
        }
        
        public function store ( VendorFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Vendor::class );
            try {
                DB ::beginTransaction ();
                $vendor                    = ( new VendorService() ) -> save ( $request );
                $account_head              = ( new AccountService() ) -> add_vendor ( $vendor );
                $vendor -> account_head_id = $account_head -> id;
                $vendor -> update ();
                DB ::commit ();
                
                if ( !empty( $vendor ) and $vendor -> id > 0 )
                    return redirect () -> back () -> with ( 'success', 'Vendor has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Vendor $vendor ): View {
            $this -> authorize ( 'edit', $vendor );
            $data[ 'title' ]  = 'Edit Medical Vendor';
            $data[ 'vendor' ] = $vendor;
            return view ( 'vendors.update', $data );
        }
        
        public function update ( VendorFormRequest $request, Vendor $vendor ): RedirectResponse {
            $this -> authorize ( 'update', $vendor );
            try {
                DB ::beginTransaction ();
                ( new VendorService() ) -> edit ( $request, $vendor );
                ( new AccountService() ) -> edit_vendor ( $vendor );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Vendor has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Vendor $vendor ) {
            $this -> authorize ( 'delete', $vendor );
            try {
                DB ::beginTransaction ();
                ( new VendorService() ) -> delete ( $vendor );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Vendor has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
