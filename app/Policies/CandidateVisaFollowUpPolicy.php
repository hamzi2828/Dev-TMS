<?php
    
    namespace App\Policies;
    
    use App\Models\CandidateVisaFollowUp;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CandidateVisaFollowUpPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'candidates-visa-follow-up', $permissions );
        }
        
        public function viewAny ( User $user ): bool {
            //
        }
        
        public function view ( User $user, CandidateVisaFollowUp $candidateVisaFollowUp ): bool {
            //
        }
        
        public function create ( User $user ): bool {
            //
        }
        
        public function update ( User $user, CandidateVisaFollowUp $candidateVisaFollowUp ): bool {
            //
        }
        
        public function delete ( User $user, CandidateVisaFollowUp $candidateVisaFollowUp ): bool {
            //
        }
        
        public function restore ( User $user, CandidateVisaFollowUp $candidateVisaFollowUp ): bool {
            //
        }
        
        public function forceDelete ( User $user, CandidateVisaFollowUp $candidateVisaFollowUp ): bool {
            //
        }
    }
