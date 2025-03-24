<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\AccountTypeRequest;
    use App\Models\AccountType;
    use App\Services\AccountService;
    use App\Services\AccountTypeService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class AccountTypeController extends Controller {
        
        protected object $accountTypeService;
        
        public function __construct ( AccountTypeService $accountTypeService ) {
            $this -> accountTypeService = $accountTypeService;
        }
        
        public function index (): View {
            $this -> authorize ( 'all', AccountType::class );
            $data[ 'title' ] = 'All Account Types';
            $data[ 'types' ] = $this -> accountTypeService -> all ();
            return view ( 'account-settings.account-types.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', AccountType::class );
            $data[ 'title' ] = 'Add Account Types';
            return view ( 'account-settings.account-types.create', $data );
        }
        
        public function store ( AccountTypeRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', AccountType::class );
            try {
                DB ::beginTransaction ();
                $type = $this -> accountTypeService -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $type ) and $type -> id > 0 )
                    return redirect ( route ( 'account-types.edit', [ 'account_type' => $type -> id ] ) ) -> with ( 'message', 'Account type has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( AccountType $accountType ): View {
            $this -> authorize ( 'edit', $accountType );
            $data[ 'title' ] = 'Edit Account Types';
            $data[ 'type' ]  = $accountType;
            return view ( 'account-settings.account-types.update', $data );
        }
        
        public function update ( AccountTypeRequest $request, AccountType $accountType ): RedirectResponse {
            $this -> authorize ( 'edit', $accountType );
            try {
                DB ::beginTransaction ();
                $this -> accountTypeService -> edit ( $request, $accountType );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Account type has been updated.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( AccountType $accountType ): RedirectResponse {
            $this -> authorize ( 'delete', $accountType );
            $accountType -> delete ();
            return redirect () -> back () -> with ( 'message', 'Account type has been deleted.' );
        }
    }
