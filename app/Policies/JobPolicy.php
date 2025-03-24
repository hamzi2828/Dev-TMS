<?php
    
    namespace App\Policies;
    
    use App\Models\Job;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class JobPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'jobs', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-jobs', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-jobs', $permissions );
        }
        
        public function edit ( User $user, Job $job ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-jobs', $permissions );
        }
        
        public function update ( User $user, Job $job ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-jobs', $permissions );
        }
        
        public function delete ( User $user, Job $job ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-jobs', $permissions );
        }
        
        public function restore ( User $user, Job $job ): bool {
            //
        }
        
        public function forceDelete ( User $user, Job $job ): bool {
            //
        }
    }
