<?php
    
    namespace App\Policies;
    
    use App\Models\CandidateCompanyRequisitionJob;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CandidateCompanyRequisitionJobPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'mrf-candidates', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-mrf-candidates', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-mrf-candidates', $permissions );
        }
        
        public function edit ( User $user, CandidateCompanyRequisitionJob $candidateCompanyRequisitionJob ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-mrf-candidates', $permissions );
        }
        
        public function update ( User $user, CandidateCompanyRequisitionJob $candidateCompanyRequisitionJob ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-mrf-candidates', $permissions );
        }
        
        public function delete ( User $user, CandidateCompanyRequisitionJob $candidateCompanyRequisitionJob ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-mrf-candidates', $permissions );
        }
        
        public function restore ( User $user, CandidateCompanyRequisitionJob $candidateCompanyRequisitionJob ): bool {
            //
        }
        
        public function forceDelete ( User $user, CandidateCompanyRequisitionJob $candidateCompanyRequisitionJob ): bool {
            //
        }
    }
