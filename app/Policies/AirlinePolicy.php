<?php
    
    namespace App\Policies;
    
    use App\Models\Airline;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class AirlinePolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'airlines', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-airlines', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-airlines', $permissions );
        }
        
        public function edit ( User $user, Airline $airline ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-airlines', $permissions );
        }
        
        public function update ( User $user, Airline $airline ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-airlines', $permissions );
        }
        
        public function delete ( User $user, Airline $airline ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-airlines', $permissions );
        }
        
        public function restore ( User $user, Airline $airline ): bool {
            //
        }
        
        public function forceDelete ( User $user, Airline $airline ): bool {
            //
        }
    }
