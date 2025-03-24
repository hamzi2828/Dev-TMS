<?php
    
    namespace App\Policies;
    
    use App\Models\Bank;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class BankPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'banks', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-banks', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-banks', $permissions );
        }
        
        public function edit ( User $user, Bank $bank ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-banks', $permissions );
        }
        
        public function update ( User $user, Bank $bank ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-banks', $permissions );
        }
        
        public function delete ( User $user, Bank $bank ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-banks', $permissions );
        }
        
        public function restore ( User $user, Bank $bank ): bool {
        }
        
        public function forceDelete ( User $user, Bank $bank ): bool {
            //
        }
    }
