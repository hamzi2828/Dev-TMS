<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\RoleFormRequest;
    use App\Models\Role;
    use App\Services\RolePermissionService;
    use App\Services\RoleService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class RoleController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', Role::class );
            $title = 'Add Role';
            $roles = ( new RoleService() ) -> roles ();
            return view ( 'roles.index', compact ( 'title', 'roles' ) );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Role::class );
            $title = 'Add Role';
            return view ( 'roles.create', compact ( 'title' ) );
        }
        
        public function store ( RoleFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Role::class );
            try {
                DB ::beginTransaction ();
                $role = ( new RoleService() ) -> add ( $request );
                ( new RolePermissionService() ) -> add ( $request, $role );
                DB ::commit ();
                
                if ( $role )
                    return redirect () -> route ( 'roles.edit', [ 'role' => $role -> id ] ) -> with ( 'success', 'Role has been created.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Please try again.' ) -> withInput ();
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::error ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Role $role ): View {
            $this -> authorize ( 'edit', $role );
            $title = 'Edit Role';
            return view ( 'roles.update', compact ( 'title', 'role' ) );
        }
        
        public function update ( RoleFormRequest $request, Role $role ): RedirectResponse {
            $this -> authorize ( 'edit', $role );
            try {
                DB ::beginTransaction ();
                ( new RoleService() ) -> update ( $request, $role );
                ( new RolePermissionService() ) -> delete ( $role );
                ( new RolePermissionService() ) -> add ( $request, $role );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Role has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::error ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Role $role ): RedirectResponse {
            $this -> authorize ( 'delete', $role );
            try {
                DB ::beginTransaction ();
                ( new RoleService() ) -> delete ( $role );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Role has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::error ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
