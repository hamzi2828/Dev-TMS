<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\CandidateInterview;
    use App\Models\CandidateVisa;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\File;
    
    class CandidateVisaService {
        
        public function save ( $request, $candidate ) {
            $candidate -> current_status = 'visa';
            $candidate -> update ();
            
            $visa = CandidateVisa ::create ( [
                                                 'user_id'      => auth () -> user () -> id,
                                                 'candidate_id' => $candidate -> id,
                                                 'tgid'         => $request -> input ( 'tgid' ),
                                                 'status'       => $request -> input ( 'status' ),
                                                 'file'         => $request -> has ( 'file' ) ? $this -> upload_file ( 'file', $candidate -> id . '/visa' ) : null,
                                             ] );
            ( new LogService() ) -> log ( 'candidate-visa-added', $visa );
            return $visa;
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
        
        public function edit ( $request, $candidate, $visa ): void {
            $candidate -> current_status = 'visa';
            $candidate -> update ();
            
            $visa -> user_id = auth () -> user () -> id;
            $visa -> tgid    = $request -> input ( 'tgid' );
            $visa -> status  = $request -> input ( 'status' );
            
            if ( $request -> has ( 'file' ) )
                $visa -> file = $this -> upload_file ( 'file', $candidate -> id . '/visa' );
            
            $visa -> update ();
            ( new LogService() ) -> log ( 'candidate-visa-updated', $visa );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'candidate-visa-deleted', $model );
        }
        
        public function bulk_status_update ( $request ): void {
            $candidates = $request -> input ( 'candidates', [] );
            $status     = $request -> input ( 'status' );
            
            if ( count ( $candidates ) > 0 ) {
                foreach ( $candidates as $key => $candidate_id ) {
                    $candidate                   = Candidate ::find ( $candidate_id );
                    $candidate -> current_status = 'visa';
                    $candidate -> update ();
                    
                    if ( is_numeric ( $candidate_id ) && $candidate_id > 0 ) {
                        $visa = CandidateVisa ::where ( [ 'candidate_id' => $candidate_id ] ) -> first ();
                        if ( !empty( $visa ) ) {
                            $visa -> status = $status;
                            
                            if ( $request -> hasFile ( 'file-' . $candidate_id ) ) {
                                $file         = $this -> upload_file ( 'file-' . $candidate_id, $candidate_id . '/visa' );
                                $visa -> file = $file;
                            }
                            
                            $visa -> update ();
                            ( new LogService() ) -> log ( 'candidate-visa-bulk-updated', $visa );
                        }
                        else {
                            $visa = CandidateVisa ::create ( [
                                                                 'user_id'      => auth () -> user () -> id,
                                                                 'candidate_id' => $candidate_id,
                                                                 'status'       => $status,
                                                                 'file'         => $request -> has ( 'file-' . $candidate_id ) ? $this -> upload_file ( 'file-' . $candidate_id, $candidate_id . '/visa' ) : null,
                                                             ] );
                            ( new LogService() ) -> log ( 'candidate-visa-bulk-added', $visa );
                        }
                    }
                }
            }
        }
        
        public function get_tgid_candidates () {
            return CandidateVisa ::whereNotNull ( 'tgid' )
                -> whereIn ( 'candidate_id', function ( $query ) {
                    $query
                        -> select ( 'id' )
                        -> from ( 'candidates' )
                        -> where ( [ 'case_closed' => '0' ] )
                        -> whereIn ( 'current_status', [ 'visa', 'document-ready' ] );
                } )
                -> get ();
        }
    }
