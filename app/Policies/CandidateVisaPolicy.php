<?php
    
    namespace App\Policies;
    
    use App\Models\CandidateVisa;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CandidateVisaPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'visa-candidates', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-visa-candidates', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-visa-candidates', $permissions );
        }
        
        public function edit ( User $user, CandidateVisa $visa ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-visa-candidates', $permissions );
        }
        
        public function update ( User $user, CandidateVisa $visa ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-visa-candidates', $permissions );
        }
        
        public function delete ( User $user, CandidateVisa $visa ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-visa-candidates', $permissions );
        }
        
        public function follow_up ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'visa-follow-up', $permissions );
        }
        
        public function restore ( User $user, CandidateVisa $visa ): bool {
            //
        }
        
        public function forceDelete ( User $user, CandidateVisa $visa ): bool {
            //
        }
    }
