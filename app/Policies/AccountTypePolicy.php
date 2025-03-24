<?php
    
    namespace App\Policies;
    
    use App\Models\AccountType;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class AccountTypePolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'account-types', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-account-types', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-account-types', $permissions );
        }
        
        public function edit ( User $user, AccountType $accountType ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-account-types', $permissions );
        }
        
        public function update ( User $user, AccountType $accountType ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-account-types', $permissions );
        }
        
        public function delete ( User $user, AccountType $accountType ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-account-types', $permissions );
        }
        
        public function restore ( User $user, AccountType $accountType ): bool {
            //
        }
        
        public function forceDelete ( User $user, AccountType $accountType ): bool {
            //
        }
    }
