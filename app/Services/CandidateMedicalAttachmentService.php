<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\CandidateDocument;
    use App\Models\CandidateInterviewDocument;
    use App\Models\CandidateMedicalAttachment;
    use App\Models\Country;
    use Illuminate\Support\Facades\File;
    
    class CandidateMedicalAttachmentService {
        
        public function save ( $request, $candidate, $medical ): void {
            $path = 'uploads/candidates/medical/';
            $dir  = public_path ( $path );
            if ( $request -> hasFile ( 'results' ) ) {
                $files = $request -> file ( 'results' );
                
                foreach ( $files as $file ) {
                    $originalName = $file -> getClientOriginalName ();
                    
                    if ( !File ::isDirectory ( $dir ) ) {
                        File ::makeDirectory ( $dir, 0755, true, true );
                    }
                    
                    $file -> move ( $dir, $originalName );
                    
                    $document = CandidateMedicalAttachment ::create ( [
                                                                          'user_id'              => auth () -> user () -> id,
                                                                          'candidate_id'         => $candidate -> id,
                                                                          'candidate_medical_id' => $medical -> id,
                                                                          'file'                 => ( asset ( $path . $originalName ) ),
                                                                      ] );
                    ( new LogService() ) -> log ( 'candidate-medical-document-added', $document );
                }
            }
        }
        
        public function edit ( $request, $candidate, $interview ): void {
            
            $document = CandidateInterviewDocument ::where ( [ 'candidate_interview_id' => $interview -> id ] ) -> first ();
            
            if ( $document ) {
                if ( $request -> has ( 'ept-result' ) )
                    $document -> ept = $this -> upload_file ( 'ept-result', $candidate -> id . '/ept-result' );
                
                if ( $request -> has ( 'experience-letter' ) )
                    $document -> experience = $this -> upload_file ( 'experience-letter', $candidate -> id . '/experience-letter' );
                
                if ( $request -> has ( 'spoken-english' ) )
                    $document -> english = $this -> upload_file ( 'spoken-english', $candidate -> id . '/spoken-english' );
                
                $document -> update ();
                ( new LogService() ) -> log ( 'candidate-medical-document-updated', $document );
            }
            else {
                $this -> save ( $request, $candidate, $interview );
            }
        }
    }