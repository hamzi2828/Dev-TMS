<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\UserFormRequest;
    use App\Models\User;
    use App\Services\CompanyService;
    use App\Services\AgentService;
    use App\Services\RoleService;
    use App\Services\UserRoleService;
    use App\Services\UserService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException; 
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class UserController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', User::class );
            $title = 'All Users';
            $users = ( new UserService() ) -> users ();
            return view ( 'users.index', compact ( 'title', 'users' ) );
        }
        

        public function create (): View {
            $this -> authorize ( 'create', User::class );
            $title = 'Add User';
            $roles = ( new RoleService() ) -> roles ();
            $companies = ( new CompanyService() ) -> companies ();
            $agents    = ( new AgentService() ) -> all ();
            
            return view ( 'users.create', compact ( 'title', 'roles', 'companies', 'agents' ) );
        }
        
        public function store ( UserFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', User::class );
            try {
                DB ::beginTransaction ();
                $user = ( new UserService() ) -> add ( $request );
                ( new UserRoleService() ) -> add ( $request, $user );
                DB ::commit ();
                
                if ( $user )
                    return redirect () -> route ( 'users.create' ) -> with ( 'success', 'User has been created.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Please try again.' ) -> withInput ();
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( User $user ): View {
            $this -> authorize ( 'edit', $user );
            $title = 'Edit User';
            $roles = ( new RoleService() ) -> roles ();
            $companies = ( new CompanyService() ) -> companies ();
            $agents    = ( new AgentService() ) -> all ();
            return view ( 'users.update', compact ( 'title', 'user', 'roles', 'companies', 'agents' ) );
        }
        
        public function update ( UserFormRequest $request, User $user ): RedirectResponse {
            $this -> authorize ( 'edit', $user );
            try {
                DB ::beginTransaction ();
                ( new UserService() ) -> update ( $request, $user );
                ( new UserRoleService() ) -> delete ( $user );
                ( new UserRoleService() ) -> add ( $request, $user );
                DB ::commit ();
                
                return redirect () -> route ( 'users.edit', [ 'user' => $user -> id ] ) -> with ( 'success', 'User has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function profile (): View {
            $title = 'User Profile';
            $roles = ( new RoleService() ) -> roles ();
            $user  = auth () -> user ();
            return view ( 'users.profile', compact ( 'title', 'user', 'roles' ) );
        }
        
        public function update_profile ( Request $request ): RedirectResponse {
            try {
                DB ::beginTransaction ();
                ( new UserService() ) -> update_profile ( $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Profile has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( User $user ) {
            $this -> authorize ( 'delete', $user );
            try {
                DB ::beginTransaction ();
                ( new UserService() ) -> delete ( $user );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'User account has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function status ( User $user ): RedirectResponse {
            $this -> authorize ( 'status', $user );
            try {
                DB ::beginTransaction ();
                ( new UserService() ) -> status ( $user );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'User account status has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
