<?php
    
    namespace App\Policies;
    
    use App\Models\City;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CityPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'cities', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-cities', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-cities', $permissions );
        }
        
        public function edit ( User $user, City $city ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-cities', $permissions );
        }
        
        public function update ( User $user, City $city ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-cities', $permissions );
        }
        
        public function delete ( User $user, City $city ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-cities', $permissions );
        }
        
        public function restore ( User $user, City $city ): bool {
            //
        }
        
        public function forceDelete ( User $user, City $city ): bool {
            //
        }
    }
