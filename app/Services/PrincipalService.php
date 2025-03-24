<?php
    
    namespace App\Services;
    
    use App\Models\Agent;
    use App\Models\Principal;
    use Illuminate\Support\Facades\File;
    
    class PrincipalService {
        
        public function all () {
            return Principal ::latest () -> get ();
        }
        
        public function save ( $request ) {
            $principal = Principal ::create ( [
                                                  'user_id' => auth () -> user () -> id,
                                                  'city_id' => $request -> input ( 'city-id' ),
                                                  'name'    => $request -> input ( 'title' ),
                                                  'contact' => $request -> input ( 'contact' ),
                                                  'address' => $request -> input ( 'address' ),
                                                  'file'    => $request -> has ( 'file' ) ? $this -> upload_file ( 'file', '/principals' ) : null,
                                                  'footer'  => $request -> has ( 'footer' ) ? $this -> upload_file ( 'footer', '/principals' ) : null,
                                              ] );
            ( new LogService() ) -> log ( 'principal-added', $principal );
            return $principal;
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
        
        public function edit ( $request, $principal ): void {
            $principal -> user_id = auth () -> user () -> id;
            $principal -> city_id = $request -> input ( 'city-id' );
            $principal -> name    = $request -> input ( 'title' );
            $principal -> contact = $request -> input ( 'contact' );
            $principal -> address = $request -> input ( 'address' );
            
            if ( $request -> has ( 'logo' ) )
                $principal -> file = $this -> upload_file ( 'logo', '/principals' );
            
            if ( $request -> has ( 'footer' ) )
                $principal -> footer = $this -> upload_file ( 'footer', '/principals' );
            
            $principal -> update ();
            ( new LogService() ) -> log ( 'principal-updated', $principal );
        }
        
        public function delete ( $principal ): void {
            $principal -> delete ();
            ( new LogService() ) -> log ( 'principal-deleted', $principal );
        }
    }