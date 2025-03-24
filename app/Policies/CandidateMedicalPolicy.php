<?php
    
    namespace App\Policies;
    
    use App\Models\Candidate;
    use App\Models\CandidateMedical;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CandidateMedicalPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'medical-candidates', $permissions );
        }


        public function candidate_medical_payment_method ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'candidate-medical-payment-method', $permissions );
        }

        public function candidate_medical_vendor ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'candidate-medical-vendor', $permissions );
        }

        public function medical_candidates_trasaction_no ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'medical-candidate-trasaction-no', $permissions );
        }


        public function medical_candidates_status ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'medical-candidate-status', $permissions );
        }


        public function medical_candidates_test_result ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'medical-candidate-test-result', $permissions );
        }


        public function medical_candidates_blood_group ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'medical-candidate-blood-group', $permissions );
        }


        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-medical-candidates', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-medical-candidates', $permissions );
        }
        
        public function edit ( User $user, CandidateMedical $medical ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-medical-candidates', $permissions );
        }
        
        public function update ( User $user, CandidateMedical $medical ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-medical-candidates', $permissions );
        }
        
        public function delete ( User $user, CandidateMedical $medical ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-medical-candidates', $permissions );
        }
        
        public function print_medical_slip ( User $user, CandidateMedical $medical ): bool {
            $permissions = $user -> permissions ();
            $candidate   = Candidate ::find ( $medical -> candidate_id );
            return ( in_array ( 'print-candidates-medical-receipt', $permissions ) && $candidate -> active == '1' );
        }
        
        // public function status_dropdown ( User $user ): bool {
        //     $permissions = $user -> permissions ();
        //     return in_array ( 'candidates-medical-status', $permissions );
        // }
        
        public function restore ( User $user, CandidateMedical $medical ): bool {
            //
        }
        
        public function forceDelete ( User $user, CandidateMedical $medical ): bool {
            //
        }
    }
