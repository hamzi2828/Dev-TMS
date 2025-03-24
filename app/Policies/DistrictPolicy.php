<?php
    
    namespace App\Policies;
    
    use App\Models\District;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class DistrictPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'districts', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-districts', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-districts', $permissions );
        }
        
        public function edit ( User $user, District $district ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-districts', $permissions );
        }
        
        public function update ( User $user, District $district ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-districts', $permissions );
        }
        
        public function delete ( User $user, District $district ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-districts', $permissions );
        }
        
        public function restore ( User $user, District $district ): bool {
            //
        }
        
        public function forceDelete ( User $user, District $district ): bool {
            //
        }
    }
