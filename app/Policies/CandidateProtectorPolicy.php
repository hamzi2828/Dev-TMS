<?php
    
    namespace App\Policies;
    
    use App\Models\CandidateProtector;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CandidateProtectorPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'protector-candidates', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-protector-candidates', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-protector-candidates', $permissions );
        }
        
        public function edit ( User $user, CandidateProtector $protector ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-protector-candidates', $permissions );
        }
        
        public function update ( User $user, CandidateProtector $protector ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-protector-candidates', $permissions );
        }
        
        public function delete ( User $user, CandidateProtector $protector ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-protector-candidates', $permissions );
        }
        
        public function restore ( User $user, CandidateProtector $protector ): bool {
            //
        }
        
        public function forceDelete ( User $user, CandidateProtector $protector ): bool {
            //
        }
    }
