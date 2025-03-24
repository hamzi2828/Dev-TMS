<?php
    
    namespace App\Services;
    
    use App\Models\Agent;
    use App\Models\Principal;
    use App\Models\Referral;
    use Illuminate\Support\Facades\File;
    
    class ReferralService {
        
        public function all () {
            return Referral ::latest () -> get ();
        }
        
        public function save ( $request ) {
            $referral = Referral ::create ( [
                                                'user_id' => auth () -> user () -> id,
                                                'name'    => $request -> input ( 'title' ),
                                                'contact' => $request -> input ( 'contact' ),
                                                'address' => $request -> input ( 'address' ),
                                                'file'    => $request -> has ( 'file' ) ? $this -> upload_file ( 'file', '/agents' ) : null,
                                            ] );
            ( new LogService() ) -> log ( 'referral-added', $referral );
            return $referral;
        }
        
        public function upload_file ( $file_name, $folder ): string {
            $path = 'uploads/' . $folder . '/';
            $dir  = public_path ( $path );
            $file = request () -> file ( $file_name );
            
            if ( !File ::isDirectory ( $dir ) ) {
                File ::makeDirectory ( $dir, 0755, true, true );
            }
            
            $fileName = time () . '-' . $file -> getClientOriginalName ();
            $file -> move ( $dir, $fileName );
            return ( asset ( $path . $fileName ) );
        }
        
        public function edit ( $request, $referral ): void {
            $referral -> user_id = auth () -> user () -> id;
            $referral -> name    = $request -> input ( 'title' );
            $referral -> contact = $request -> input ( 'contact' );
            $referral -> address = $request -> input ( 'address' );
            
            if ( $request -> has ( 'file' ) )
                $referral -> file = $this -> upload_file ( 'file', '/agents' );
            
            $referral -> update ();
            ( new LogService() ) -> log ( 'referral-updated', $referral );
        }
        
        public function delete ( $referral ): void {
            $referral -> delete ();
            ( new LogService() ) -> log ( 'referral-deleted', $referral );
        }
    }