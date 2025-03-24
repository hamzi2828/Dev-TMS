<?php
    
    namespace App\Policies;
    
    use App\Models\Fee;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class FeePolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'fees', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-fees', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-fees', $permissions );
        }
        
        public function edit ( User $user, Fee $fee ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-fees', $permissions );
        }
        
        public function update ( User $user, Fee $fee ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-fees', $permissions );
        }
        
        public function delete ( User $user, Fee $fee ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-fees', $permissions );
        }
        
        public function restore ( User $user, Fee $fee ): bool {
            //
        }
        
        public function forceDelete ( User $user, Fee $fee ): bool {
            //
        }
    }
