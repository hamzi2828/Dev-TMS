<?php
    
    namespace App\Policies;
    
    use App\Models\Principal;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class PrincipalPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'principals', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-principals', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-principals', $permissions );
        }
        
        public function edit ( User $user, Principal $principal ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-principals', $permissions );
        }
        
        public function update ( User $user, Principal $principal ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-principals', $permissions );
        }
        
        public function delete ( User $user, Principal $principal ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-principals', $permissions );
        }
        
        public function restore ( User $user, Principal $principal ): bool {
            //
        }
        
        public function forceDelete ( User $user, Principal $principal ): bool {
            //
        }
        
    }
