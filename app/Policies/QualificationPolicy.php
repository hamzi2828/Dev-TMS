<?php
    
    namespace App\Policies;
    
    use App\Models\Qualification;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class QualificationPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'qualifications', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-qualifications', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-qualifications', $permissions );
        }
        
        public function edit ( User $user, Qualification $qualification ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-qualifications', $permissions );
        }
        
        public function update ( User $user, Qualification $qualification ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-qualifications', $permissions );
        }
        
        public function delete ( User $user, Qualification $qualification ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-qualifications', $permissions );
        }
        
        public function restore ( User $user, Qualification $qualification ): bool {
            //
        }
        
        public function forceDelete ( User $user, Qualification $qualification ): bool {
            //
        }
    }
