<?php
    
    namespace App\Policies;
    
    use App\Models\CandidateBackOut;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CandidateBackOutPolicy {
        
        public function viewAny ( User $user ): bool {
            //
        }
        
        public function view ( User $user, CandidateBackOut $backOut ): bool {
            //
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'back-out-candidates', $permissions );
        }
        
        public function unback ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'un-back-out-candidates', $permissions );
        }
        
        public function update ( User $user, CandidateBackOut $backOut ): bool {
            //
        }
        
        public function delete ( User $user, CandidateBackOut $backOut ): bool {
            //
        }
        
        public function restore ( User $user, CandidateBackOut $backOut ): bool {
            //
        }
        
        public function forceDelete ( User $user, CandidateBackOut $backOut ): bool {
            //
        }
    }
