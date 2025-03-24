<?php
    
    namespace App\Policies;
    
    use App\Models\Account;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class AccountPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'accounts', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'chart-of-accounts', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-account-heads', $permissions );
        }
        
        public function edit ( User $user, Account $account ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-account-heads', $permissions );
        }
        
        public function update ( User $user, Account $account ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-account-heads', $permissions );
        }
        
        public function delete ( User $user, Account $account ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-account-heads', $permissions );
        }
        
        public function accounts_settings ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'accounts-settings', $permissions );
        }
        
        public function delete_transaction ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-transaction', $permissions );
        }
        
        public function status ( User $user, Account $account ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'active-inactive-account-heads', $permissions );
        }
    }
