<?php
    
    namespace App\Services;
    
    use App\Models\User;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Hash;
    
    class UserService {
        
        public function users (): Collection | array {
            return User ::with ( [ 'company' ] ) -> latest () -> get ();
        }
        
        public function get_trashed_users (): Collection {
            return User ::onlyTrashed () -> get ();
        }
        
        public function add ( $request ) {
            $user = User ::create ( [
                                        'user_id'    => auth () -> user () -> id,
                                        'company_id' => $request -> input ( 'company-id' ),
                                        'name'       => $request -> input ( 'name' ),
                                        'email'      => $request -> input ( 'email' ),
                                        'cnic'       => $request -> input ( 'cnic' ),
                                        'mobile'     => $request -> input ( 'mobile' ),
                                        'address'    => $request -> input ( 'address' ),
                                        'password'   => Hash ::make ( $request -> input ( 'password' ) ),
                                        'image'      => $request -> hasFile ( 'file' ) ? $this -> upload_image ( $request ) : null,
                                    ] );
            ( new LogService() ) -> log ( 'user-added', $user );
            return $user;
        }
        
        public function update ( $request, $user ): void {
            $user -> company_id = $request -> input ( 'company-id' );
            $user -> name       = $request -> input ( 'name' );
            $user -> email      = $request -> input ( 'email' );
            $user -> cnic       = $request -> input ( 'cnic' );
            $user -> mobile     = $request -> input ( 'mobile' );
            $user -> address    = $request -> input ( 'address' );
            
            if ( $request -> has ( 'password' ) && $request -> filled ( 'password' ) )
                $user -> password = Hash ::make ( $request -> input ( 'password' ) );
            
            if ( $request -> hasFile ( 'file' ) )
                $user -> image = $this -> upload_image ( $request );
            
            $user -> update ();
            ( new LogService() ) -> log ( 'user-updated', $user );
        }
        
        public function update_profile ( $request ): void {
            $user         = auth () -> user ();
            $user -> name = $request -> input ( 'name' );
            
            if ( $request -> has ( 'password' ) && $request -> filled ( 'password' ) )
                $user -> password = Hash ::make ( $request -> input ( 'password' ) );
            
            if ( $request -> hasFile ( 'file' ) )
                $user -> image = $this -> upload_image ( $request );
            
            $user -> update ();
        }
        
        public function upload_image ( $request ): string {
            $path = 'uploads/users/avatar/';
            $dir  = public_path ( $path );
            $file = $request -> file ( 'file' );
            
            if ( !File ::isDirectory ( $dir ) ) {
                File ::makeDirectory ( $dir, 0755, true, true );
            }
            
            $fileName = time () . '-' . $file -> getClientOriginalName ();
            $file -> move ( $dir, $fileName );
            return ( asset ( $path . $fileName ) );
        }
        
        public function delete ( $user ): void {
            $user -> delete ();
            ( new LogService() ) -> log ( 'user-deleted', $user );
        }
        
        public function restore ( $user_id ): void {
            $user = User ::withTrashed () -> find ( $user_id );
            $user -> restore ();
        }
        
        public function force_delete ( $user_id ): void {
            $user = User ::withTrashed () -> find ( $user_id );
            $user -> forceDelete ();
        }
        
        public function status ( $user ): void {
            $user -> active = !$user -> active;
            $user -> update ();
        }
        
    }