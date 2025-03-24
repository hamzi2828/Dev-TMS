<?php
    
    namespace App\Policies;
    
    use App\Models\GeneralLedger;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class GeneralLedgerPolicy {
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'general-ledgers', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-transactions', $permissions );
        }
        
        public function search ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'search-transactions', $permissions );
        }
        
        public function add_multiple ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-transactions-multiple', $permissions );
        }
        
        public function add_opening_balance ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-opening-balance', $permissions );
        }
        
        public function edit ( User $user, GeneralLedger $generalLedger ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'chart-of-accounts', $permissions );
        }
        
        public function update ( User $user, GeneralLedger $generalLedger ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'chart-of-accounts', $permissions );
        }
        
        public function delete ( User $user, GeneralLedger $generalLedger ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'chart-of-accounts', $permissions );
        }
        
        public function accounts_reporting ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'accounts-reporting', $permissions );
        }
        
        public function trial_balance_sheet ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'trial-balance-sheet', $permissions );
        }
        
        public function profit_and_loss ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'profit-and-loss', $permissions );
        }
        
        public function balance_sheet ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'balance-sheet', $permissions );
        }
        
        public function customer_receivable ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'customer-receivable', $permissions );
        }
        
        public function vendor_payable ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'vendor-payable', $permissions );
        }
        
        public function restore ( User $user, GeneralLedger $generalLedger ): bool {
            //
        }
        
        public function forceDelete ( User $user, GeneralLedger $generalLedger ): bool {
            //
        }
    }
