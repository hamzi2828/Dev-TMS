<?php
    
    namespace App\Policies;
    
    use App\Models\CandidateDocumentReady;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class CandidateDocumentReadyPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'documents-ready', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-documents-ready', $permissions );
        }
        
        public function edit ( User $user, CandidateDocumentReady $document_ready ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-documents-ready', $permissions );
        }
        
        public function update ( User $user, CandidateDocumentReady $document_ready ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-documents-ready', $permissions );
        }
        
        public function delete ( User $user, CandidateDocumentReady $document_ready ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-documents-ready', $permissions );
        }
        
        public function restore ( User $user, CandidateDocumentReady $document_ready ): bool {
            //
        }
        
        public function forceDelete ( User $user, CandidateDocumentReady $document_ready ): bool {
            //
        }
    }
