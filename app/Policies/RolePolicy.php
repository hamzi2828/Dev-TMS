<?php
    
    namespace App\Policies;
    
    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class RolePolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'roles', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-roles', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-roles', $permissions );
        }
        
        public function edit ( User $user, Role $role ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-roles', $permissions );
        }
        
        public function update ( User $user, Role $role ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-roles', $permissions );
        }
        
        public function delete ( User $user, Role $role ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-roles', $permissions );
        }
        
        public function restore ( User $user, Role $role ): bool {
            //
        }
        
        public function forceDelete ( User $user, Role $role ): bool {
            //
        }
    }
