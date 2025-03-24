<?php
    
    namespace App\Policies;
    
    use App\Models\CandidateInterview;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CandidateInterviewPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'interview-candidates', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-interview-candidates', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-interview-candidates', $permissions );
        }
        
        public function edit ( User $user, CandidateInterview $interview ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-interview-candidates', $permissions );
        }
        
        public function update ( User $user, CandidateInterview $interview ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-interview-candidates', $permissions );
        }
        
        public function delete ( User $user, CandidateInterview $interview ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-interview-candidates', $permissions );
        }
        
        public function restore ( User $user, CandidateInterview $interview ): bool {
            //
        }
        
        public function forceDelete ( User $user, CandidateInterview $interview ): bool {
            //
        }
    }
