<?php
    
    namespace App\Policies;
    
    use App\Models\Candidate;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CandidatePolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'candidates', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-candidates', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-candidates', $permissions );
        }
        
        public function edit ( User $user, Candidate $candidate ): bool {
            $permissions = $user -> permissions ();
            return ( in_array ( 'edit-candidates', $permissions ) && $candidate -> active == '1' );
        }
        
        public function view ( User $user, Candidate $candidate ): bool {
            $permissions = $user -> permissions ();
            return ( in_array ( 'view-candidates', $permissions ) && $candidate -> active == '1' );
        }
        
        public function update ( User $user, Candidate $candidate ): bool {
            $permissions = $user -> permissions ();
            return ( in_array ( 'edit-candidates', $permissions ) && $candidate -> active == '1' );
        }
        
        public function delete ( User $user, Candidate $candidate ): bool {
            $permissions = $user -> permissions ();
            return ( in_array ( 'delete-candidates', $permissions ) && $candidate -> active == '1' );
        }
        
        public function print_test_slip ( User $user, Candidate $candidate ): bool {
            $permissions = $user -> permissions ();
            return ( in_array ( 'print-candidates-test-receipt', $permissions ) && $candidate -> active == '1' );
        }
        
        public function print_bio_data_form ( User $user, Candidate $candidate ): bool {
            $permissions = $user -> permissions ();
            return ( in_array ( 'print-candidates-bio-data-form', $permissions ) && $candidate -> active == '1' );
        }
        
        public function print_candidates_ticket ( User $user, Candidate $candidate ): bool {
            $permissions = $user -> permissions ();
            return ( in_array ( 'print-candidates-ticket', $permissions ) && $candidate -> active == '1' );
        }
        
        public function case_closed ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'case-closed-candidates', $permissions );
        }
        
        public function trade_change ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'trade-change', $permissions );
        }
        
        public function billing ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'billing-candidates', $permissions );
        }
        
        public function attachments ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'candidates-attachments', $permissions );
        }
        
        public function candidate_discount_flat ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'candidate-discount-flat', $permissions );
        }
        
        public function candidate_clear_accounts ( User $user, Candidate $candidate ): bool {
            $permissions = $user -> permissions ();
            return ( in_array ( 'candidate-clear-accounts', $permissions ) && $candidate -> active == '1' );
        }
        
        public function candidate_proceed_to_visa ( User $user, Candidate $candidate ): bool {
            $permissions = $user -> permissions ();
            return ( in_array ( 'proceed-to-visa', $permissions ) && $candidate -> active == '1' );
        }
        
        public function status_change ( User $user, Candidate $candidate ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'change-candidate-status', $permissions );
        }
        
        public function restore ( User $user, Candidate $candidate ): bool {
            //
        }
        
        public function forceDelete ( User $user, Candidate $candidate ): bool {
            //
        }
    }
