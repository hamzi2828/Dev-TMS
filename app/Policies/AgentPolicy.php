<?php
    
    namespace App\Policies;
    
    use App\Models\Agent;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class AgentPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'agents', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-agents', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-agents', $permissions );
        }
        
        public function edit ( User $user, Agent $agent ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-agents', $permissions );
        }
        
        public function update ( User $user, Agent $agent ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-agents', $permissions );
        }
        
        public function delete ( User $user, Agent $agent ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-agents', $permissions );
        }
        
        public function restore ( User $user, Agent $agent ): bool {
            //
        }
        
        public function forceDelete ( User $user, Agent $agent ): bool {
            //
        }
    }
