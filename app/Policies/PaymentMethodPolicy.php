<?php
    
    namespace App\Policies;
    
    use App\Models\PaymentMethod;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class PaymentMethodPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'payment-methods', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-payment-methods', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-payment-methods', $permissions );
        }
        
        public function edit ( User $user, PaymentMethod $payment_method ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-payment-methods', $permissions );
        }
        
        public function update ( User $user, PaymentMethod $payment_method ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-payment-methods', $permissions );
        }
        
        public function delete ( User $user, PaymentMethod $payment_method ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-payment-methods', $permissions );
        }
        
        public function restore ( User $user, PaymentMethod $payment_method ): bool {
            //
        }
        
        public function forceDelete ( User $user, PaymentMethod $payment_method ): bool {
            //
        }
    }
