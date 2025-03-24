<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\CandidateInterview;
    use App\Models\CandidateProtector;
    use App\Models\CandidateTicket;
    use App\Models\CandidateVisa;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\File;
    
    class CandidateProtectorService {
        
        public function save ( $request, $candidate ) {
            $candidate -> current_status = 'protector';
            $candidate -> update ();
            
            $protector = CandidateProtector ::create ( [
                                                           'user_id'        => auth () -> user () -> id,
                                                           'candidate_id'   => $candidate -> id,
                                                           'reg_no'         => $request -> input ( 'reg-no' ),
                                                           'protector_date' => $request -> input ( 'protector-date' ),
                                                           'price'          => $request -> input ( 'price' ),
                                                           'status'         => $request -> input ( 'status' ),
                                                           'file'           => $request -> has ( 'file' ) ? $this -> upload_file ( 'file', $candidate -> id . '/protector' ) : null,
                                                           'video'          => $request -> has ( 'video' ) ? $this -> upload_file ( 'video', $candidate -> id . '/video' ) : null,
                                                       ] );
            ( new LogService() ) -> log ( 'candidate-protector-added', $protector );
            return $protector;
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
        
        public function edit ( $request, $candidate, $protector ): void {
            $protector -> user_id        = auth () -> user () -> id;
            $protector -> reg_no         = $request -> input ( 'reg-no' );
            $protector -> protector_date = $request -> input ( 'protector-date' );
            $protector -> price          = $request -> input ( 'price' );
            
            if ( $request -> filled ( 'status' ) )
                $protector -> status = $request -> input ( 'status' );
            
            if ( $request -> has ( 'file' ) )
                $protector -> file = $this -> upload_file ( 'file', $candidate -> id . '/protector' );
            
            if ( $request -> has ( 'video' ) )
                $protector -> video = $this -> upload_file ( 'video', $candidate -> id . '/video' );
            
            $protector -> update ();
            ( new LogService() ) -> log ( 'candidate-protector-updated', $protector );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
        }
        
        public function bulk_status_update ( $request ): void {
            $candidates = $request -> input ( 'candidates' );
            $status     = $request -> input ( 'status' );
            $candidates = explode ( ',', $candidates );
            
            if ( count ( $candidates ) > 0 ) {
                foreach ( $candidates as $candidate_id ) {
                    if ( is_numeric ( $candidate_id ) && $candidate_id > 0 ) {
                        $protector = CandidateProtector ::updateOrCreate ( [
                                                                               'candidate_id' => $candidate_id
                                                                           ],
                                                                           [
                                                                               'user_id'      => auth () -> user () -> id,
                                                                               'candidate_id' => $candidate_id,
                                                                               'status'       => $status,
                                                                           ] );
                        ( new LogService() ) -> log ( 'candidate-protector-bulk-updated', $protector );
                        
                        $candidate                   = Candidate ::find ( $candidate_id );
                        $candidate -> current_status = 'protector';
                        $candidate -> update ();
                    }
                }
            }
        }
        
        public function save_ticket ( $request, $candidate ) {
            $candidate -> current_status = 'ticket';
            $candidate -> update ();
            
            return CandidateTicket ::create ( [
                                                  'user_id'      => null,
                                                  'candidate_id' => $candidate -> id,
                                                  'status'       => 'waiting',
                                              ] );
        }
    }