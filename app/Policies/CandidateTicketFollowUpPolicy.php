<?php
    
    namespace App\Policies;
    
    use App\Models\CandidateTicketFollowUp;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CandidateTicketFollowUpPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'candidates-ticket-follow-up', $permissions );
        }
        
        public function viewAny ( User $user ): bool {
            //
        }
        
        public function view ( User $user, CandidateTicketFollowUp $candidateTicketFollowUp ): bool {
            //
        }
        
        public function create ( User $user ): bool {
            //
        }
        
        public function update ( User $user, CandidateTicketFollowUp $candidateTicketFollowUp ): bool {
            //
        }
        
        public function delete ( User $user, CandidateTicketFollowUp $candidateTicketFollowUp ): bool {
            //
        }
        
        public function restore ( User $user, CandidateTicketFollowUp $candidateTicketFollowUp ): bool {
            //
        }
        
        public function forceDelete ( User $user, CandidateTicketFollowUp $candidateTicketFollowUp ): bool {
            //
        }
    }
