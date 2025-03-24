<?php
    
    namespace App\Services;
    
    use App\Models\Agent;
    use Illuminate\Support\Facades\File;
    
    class AgentService {
        
        public function all () {
            return Agent ::latest () -> get ();
        }
        
        public function save ( $request ) {
            $agent = Agent ::create ( [
                                          'user_id' => auth () -> user () -> id,
                                          'name'    => $request -> input ( 'title' ),
                                          'contact' => $request -> input ( 'contact' ),
                                          'address' => $request -> input ( 'address' ),
                                          'file'    => $request -> has ( 'file' ) ? $this -> upload_file ( 'file', '/agents' ) : null,
                                      ] );
            ( new LogService() ) -> log ( 'agent-added', $agent );
            return $agent;
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
        
        public function edit ( $request, $agent ): void {
            $agent -> user_id = auth () -> user () -> id;
            $agent -> name    = $request -> input ( 'title' );
            $agent -> contact = $request -> input ( 'contact' );
            $agent -> address = $request -> input ( 'address' );
            
            if ( $request -> has ( 'file' ) )
                $agent -> file = $this -> upload_file ( 'file', '/agents' );
            
            $agent -> update ();
            ( new LogService() ) -> log ( 'agent-updated', $agent );
        }
        
        public function delete ( $agent ): void {
            $agent -> delete ();
            ( new LogService() ) -> log ( 'agent-deleted', $agent );
        }
    }