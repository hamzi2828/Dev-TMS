<?php
    
    namespace App\Policies;
    
    use App\Models\Agreement;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class AgreementPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'agreements', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-agreements', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-agreements', $permissions );
        }
        
        public function edit ( User $user, Agreement $agreement ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-agreements', $permissions );
        }
        
        public function update ( User $user, Agreement $agreement ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-agreements', $permissions );
        }
        
        public function delete ( User $user, Agreement $agreement ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-agreements', $permissions );
        }
        
        public function restore ( User $user, Agreement $agreement ): bool {
            //
        }
        
        public function forceDelete ( User $user, Agreement $agreement ): bool {
            //
        }
    }
