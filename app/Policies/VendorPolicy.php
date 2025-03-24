<?php
    
    namespace App\Policies;
    
    use App\Models\User;
    use App\Models\Vendor;
    use Illuminate\Auth\Access\Response;
    
    class VendorPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'vendors', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-vendors', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-vendors', $permissions );
        }
        
        public function edit ( User $user, Vendor $vendor ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-vendors', $permissions );
        }
        
        public function update ( User $user, Vendor $vendor ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-vendors', $permissions );
        }
        
        public function delete ( User $user, Vendor $vendor ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-vendors', $permissions );
        }
        
        public function restore ( User $user, Vendor $vendor ): bool {
            //
        }
        
        public function forceDelete ( User $user, Vendor $vendor ): bool {
            //
        }
    }
