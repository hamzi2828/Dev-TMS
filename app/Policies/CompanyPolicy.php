<?php
    
    namespace App\Policies;
    
    use App\Models\Company;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CompanyPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'companies', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-companies', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-companies', $permissions );
        }
        
        public function edit ( User $user, Company $company ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-companies', $permissions );
        }
        
        public function update ( User $user, Company $company ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-companies', $permissions );
        }
        
        public function delete ( User $user, Company $company ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-companies', $permissions );
        }
        
        public function restore ( User $user, Company $company ): bool {
            //
        }
        
        public function forceDelete ( User $user, Company $company ): bool {
            //
        }
    }
