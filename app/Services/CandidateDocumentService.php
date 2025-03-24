<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\CandidateDocument;
    use App\Models\Country;
    use Illuminate\Support\Facades\File;
    
    class CandidateDocumentService {
        
        public function save ( $request, $candidate ) {
            $document = CandidateDocument ::create ( [
                                                         'candidate_id' => $candidate -> id,
                                                         'picture'      => $request -> has ( 'picture' ) ? $this -> upload_file ( 'picture', $candidate -> id . '/picture' ) : null,
                                                         'passport'     => $request -> has ( 'passport-image' ) ? $this -> upload_file ( 'passport-image', $candidate -> id . '/passport' ) : null,
                                                         'cnic_front'   => $request -> has ( 'cnic-front' ) ? $this -> upload_file ( 'cnic-front', $candidate -> id . '/cnic' ) : null,
                                                         'cnic_back'    => $request -> has ( 'cnic-back' ) ? $this -> upload_file ( 'cnic-back', $candidate -> id . '/cnic' ) : null,
                                                         'nicop_front'  => $request -> has ( 'nicop-front' ) ? $this -> upload_file ( 'nicop-front', $candidate -> id . '/nicop' ) : null,
                                                         'nicop_back'   => $request -> has ( 'nicop-back' ) ? $this -> upload_file ( 'nicop-back', $candidate -> id . '/nicop' ) : null,
                                                         'nok_1'        => $request -> has ( 'nok-1' ) ? $this -> upload_file ( 'nok-1', $candidate -> id . '/nok' ) : null,
                                                         'nok_2'        => $request -> has ( 'nok-2' ) ? $this -> upload_file ( 'nok-2', $candidate -> id . '/nok' ) : null,
                                                     ] );
            ( new LogService() ) -> log ( 'candidate-document-created', $document );
            return $document;
        }
        
        public function edit ( $request, $candidate ): void {
            
            $document = CandidateDocument ::where ( [ 'candidate_id' => $candidate -> id ] ) -> first ();
            
            if ( $document ) {
                if ( $request -> has ( 'picture' ) )
                    $document -> picture = $this -> upload_file ( 'picture', $candidate -> id . '/picture' );
                
                if ( $request -> has ( 'passport-image' ) )
                    $document -> passport = $this -> upload_file ( 'passport-image', $candidate -> id . '/passport' );
                
                if ( $request -> has ( 'cnic-front' ) )
                    $document -> cnic_front = $this -> upload_file ( 'cnic-front', $candidate -> id . '/cnic' );
                
                if ( $request -> has ( 'cnic-back' ) )
                    $document -> cnic_back = $this -> upload_file ( 'cnic-back', $candidate -> id . '/cnic' );
                
                if ( $request -> has ( 'nicop-front' ) )
                    $document -> nicop_front = $this -> upload_file ( 'nicop-front', $candidate -> id . '/nicop' );
                
                if ( $request -> has ( 'nicop-back' ) )
                    $document -> nicop_back = $this -> upload_file ( 'nicop-back', $candidate -> id . '/nicop' );
                
                if ( $request -> has ( 'nok-1' ) )
                    $document -> nok_1 = $this -> upload_file ( 'nok-1', $candidate -> id . '/nok' );
                
                if ( $request -> has ( 'nok-2' ) )
                    $document -> nok_2 = $this -> upload_file ( 'nok-2', $candidate -> id . '/nok' );
                
                $document -> update ();
                ( new LogService() ) -> log ( 'candidate-document-updated', $document );
            }
            else {
                $this -> save ( $request, $candidate );
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