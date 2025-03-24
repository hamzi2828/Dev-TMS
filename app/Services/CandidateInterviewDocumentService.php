<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\CandidateDocument;
    use App\Models\CandidateInterviewDocument;
    use App\Models\Country;
    use Illuminate\Support\Facades\File;
    
    class CandidateInterviewDocumentService {
        
        public function save ( $request, $candidate, $interview ) {
            $document = CandidateInterviewDocument ::create ( [
                                                                  'user_id'                   => auth () -> user () -> id,
                                                                  'candidate_id'              => $candidate -> id,
                                                                  'candidate_interview_id'    => $interview -> id,
                                                                  'ept'                       => $request -> has ( 'ept-result' ) ? $this -> upload_file ( 'ept-result', $candidate -> id . '/ept-result' ) : null,
                                                                  'ept_back'                  => $request -> has ( 'ept-result-back' ) ? $this -> upload_file ( 'ept-result-back', $candidate -> id . '/ept-result-back' ) : null,
                                                                  'experience'                => $request -> has ( 'experience-letter' ) ? $this -> upload_file ( 'experience-letter', $candidate -> id . '/experience-letter' ) : null,
                                                                  'english'                   => $request -> has ( 'spoken-english' ) ? $this -> upload_file ( 'spoken-english', $candidate -> id . '/spoken-english' ) : null,
                                                                  'assessment_aptitude_front' => $request -> has ( 'assessment-aptitude-front' ) ? $this -> upload_file ( 'assessment-aptitude-front', $candidate -> id . '/assessment-aptitude-front' ) : null,
                                                                  'assessment_aptitude_back'  => $request -> has ( 'assessment-aptitude-back' ) ? $this -> upload_file ( 'assessment-aptitude-back', $candidate -> id . '/assessment-aptitude-back' ) : null,
                                                              ] );
            ( new LogService() ) -> log ( 'candidate-interview-document-created', $document );
            return $document;
        }
        
        public function edit ( $request, $candidate, $interview ): void {
            
            $document = CandidateInterviewDocument ::where ( [ 'candidate_interview_id' => $interview -> id ] ) -> first ();
            
            if ( $document ) {
                if ( $request -> has ( 'ept-result' ) )
                    $document -> ept = $this -> upload_file ( 'ept-result', $candidate -> id . '/ept-result' );
                
                if ( $request -> has ( 'ept-result-back' ) )
                    $document -> ept_back = $this -> upload_file ( 'ept-result-back', $candidate -> id . '/ept-result-back' );
                
                if ( $request -> has ( 'experience-letter' ) )
                    $document -> experience = $this -> upload_file ( 'experience-letter', $candidate -> id . '/experience-letter' );
                
                if ( $request -> has ( 'spoken-english' ) )
                    $document -> english = $this -> upload_file ( 'spoken-english', $candidate -> id . '/spoken-english' );
                
                if ( $request -> has ( 'assessment-aptitude-front' ) )
                    $document -> assessment_aptitude_front = $this -> upload_file ( 'assessment-aptitude-front', $candidate -> id . '/assessment-aptitude-front' );
                
                if ( $request -> has ( 'assessment-aptitude-back' ) )
                    $document -> assessment_aptitude_back = $this -> upload_file ( 'assessment-aptitude-back', $candidate -> id . '/assessment-aptitude-back' );
                
                $document -> update ();
                ( new LogService() ) -> log ( 'candidate-interview-document-updated', $document );
            }
            else {
                $this -> save ( $request, $candidate, $interview );
            }
        }
        
        public function upload_file ( $file_name, $folder ): string {
            $path = 'uploads/candidates/' . $folder . '/';
            $dir  = public_path ( $path );
            $file = request () -> file ( $file_name );
            
            if ( !File ::isDirectory ( $dir ) ) {
                File ::makeDirectory ( $dir, 0755, true, true );
            }
            
            $fileName = time () . '-' . $file -> getClientOriginalName ();
            $file -> move ( $dir, $fileName );
            return ( asset ( $path . $fileName ) );
        }
    }