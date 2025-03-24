<?php
    
    namespace App\Policies;
    
    use App\Models\CompanyRequisition;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CompanyRequisitionPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'mrf', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-mrf', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-mrf', $permissions );
        }
        
        public function edit ( User $user, CompanyRequisition $company_requisition ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-mrf', $permissions );
        }
        
        public function update ( User $user, CompanyRequisition $company_requisition ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-mrf', $permissions );
        }
        
        public function delete ( User $user, CompanyRequisition $company_requisition ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-mrf', $permissions );
        }
        
        public function restore ( User $user, CompanyRequisition $company_requisition ): bool {
            //
        }
        
        public function forceDelete ( User $user, CompanyRequisition $company_requisition ): bool {
            //
        }
    }
