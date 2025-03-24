<?php
    
    namespace App\Policies;
    
    use App\Models\CandidateTicket;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CandidateTicketPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'ticket-candidates', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-ticket-candidates', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-ticket-candidates', $permissions );
        }
        
        public function edit ( User $user, CandidateTicket $ticket ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-ticket-candidates', $permissions );
        }
        
        public function update ( User $user, CandidateTicket $ticket ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-ticket-candidates', $permissions );
        }
        
        public function delete ( User $user, CandidateTicket $ticket ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-ticket-candidates', $permissions );
        }
        
        public function follow_up ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'ticket-follow-up', $permissions );
        }
        
        public function restore ( User $user, CandidateTicket $ticket ): bool {
            //
        }
        
        public function forceDelete ( User $user, CandidateTicket $ticket ): bool {
            //
        }
    }
