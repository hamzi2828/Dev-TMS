<?php
    
    namespace App\Policies;
    
    use App\Models\Referral;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class ReferralPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'referrals', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-referrals', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-referrals', $permissions );
        }
        
        public function edit ( User $user, Referral $referral ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-referrals', $permissions );
        }
        
        public function update ( User $user, Referral $referral ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-referrals', $permissions );
        }
        
        public function delete ( User $user, Referral $referral ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-referrals', $permissions );
        }
        
        public function restore ( User $user, Referral $referral ): bool {
            //
        }
        
        public function forceDelete ( User $user, Referral $referral ): bool {
            //
        }
    }
