<?php
    
    namespace App\Policies;
    
    use App\Models\Country;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CountryPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'countries', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-countries', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-countries', $permissions );
        }
        
        public function edit ( User $user, Country $country ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-countries', $permissions );
        }
        
        public function update ( User $user, Country $country ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-countries', $permissions );
        }
        
        public function delete ( User $user, Country $country ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-countries', $permissions );
        }
        
        public function restore ( User $user, Country $country ): bool {
            //
        }
        
        public function forceDelete ( User $user, Country $country ): bool {
            //
        }
    }
