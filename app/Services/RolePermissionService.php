<?php
    
    namespace App\Services;
    
    use App\Models\Role;
    use App\Models\RolePermission;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Str;
    
    class RolePermissionService {
        
        public function add ( $request, $role ): void {
            $permissions = $request -> input ( 'permission', [] );
            
            if ( count ( $permissions ) > 0 ) {
                foreach ( $permissions as $permission ) {
                    $rolePermission = RolePermission ::create ( [
                                                                    'role_id'    => $role -> id,
                                                                    'permission' => $permission,
                                                                ] );
                    ( new LogService() ) -> log ( 'permission-added', $rolePermission );
                }
            }
        }
        
        public function delete ( $role ): void {
            RolePermission :: where ( [ 'role_id' => $role -> id ] ) -> delete ();
            ( new LogService() ) -> log ( 'permission-deleted', $role );
        }
    }