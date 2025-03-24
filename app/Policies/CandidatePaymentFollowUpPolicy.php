<?php
    
    namespace App\Policies;
    
    use App\Models\CandidatePaymentFollowUp;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CandidatePaymentFollowUpPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'candidates-payment-follow-up', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-candidates-payment-follow-up', $permissions );
        }
        
        public function edit ( User $user, CandidatePaymentFollowUp $payment_follow_up ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-candidates-payment-follow-up', $permissions );
        }
        
        public function update ( User $user, CandidatePaymentFollowUp $payment_follow_up ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-candidates-payment-follow-up', $permissions );
        }
        
        public function delete ( User $user, CandidatePaymentFollowUp $payment_follow_up ): bool {
            //
        }
        
        public function restore ( User $user, CandidatePaymentFollowUp $payment_follow_up ): bool {
            //
        }
        
        public function forceDelete ( User $user, CandidatePaymentFollowUp $payment_follow_up ): bool {
            //
        }
    }
