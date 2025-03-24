<?php
    
    namespace App\Policies;
    
    use App\Models\Province;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class ProvincePolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'provinces', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-provinces', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-provinces', $permissions );
        }
        
        public function edit ( User $user, Province $province ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-provinces', $permissions );
        }
        
        public function update ( User $user, Province $province ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-provinces', $permissions );
        }
        
        public function delete ( User $user, Province $province ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-provinces', $permissions );
        }
        
        public function restore ( User $user, Province $province ): bool {
            //
        }
        
        public function forceDelete ( User $user, Province $province ): bool {
            //
        }
    }
