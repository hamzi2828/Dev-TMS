<?php
    
    namespace App\Services;
    
    use App\Models\Country;
    use App\Models\Vendor;
    use Illuminate\Support\Facades\File;
    
    class VendorService {
        
        public function all () {
            return Vendor ::latest () -> get ();
        }
        
        public function save ( $request ) {
            $vendor = Vendor ::create ( [
                                            'user_id'        => auth () -> user () -> id,
                                            'title'          => $request -> input ( 'title' ),
                                            'slug'           => str ( $request -> input ( 'title' ) ) -> slug ( '-' ),
                                            'contact'        => $request -> input ( 'contact' ),
                                            'address'        => $request -> input ( 'address' ),
                                            'fee'            => $request -> input ( 'fee' ),
                                            'vendor_payable' => $request -> input ( 'vendor-payable' ),
                                            'left_logo'      => $request -> has ( 'left-logo' ) ? $this -> upload_file ( 'left-logo', '/vendors' ) : null,
                                            'right_logo'     => $request -> has ( 'right-logo' ) ? $this -> upload_file ( 'right-logo', '/vendors' ) : null,
                                        ] );
            ( new LogService() ) -> log ( 'vendor-added', $vendor );
            return $vendor;
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
        
        public function edit ( $request, $vendor ): void {
            $vendor -> user_id        = auth () -> user () -> id;
            $vendor -> title          = $request -> input ( 'title' );
            $vendor -> contact        = $request -> input ( 'contact' );
            $vendor -> address        = $request -> input ( 'address' );
            $vendor -> fee            = $request -> input ( 'fee' );
            $vendor -> vendor_payable = $request -> input ( 'vendor-payable' );
            
            if ( $request -> has ( 'left-logo' ) )
                $vendor -> left_logo = $this -> upload_file ( 'left-logo', '/vendors' );
            
            if ( $request -> has ( 'right-logo' ) )
                $vendor -> right_logo = $this -> upload_file ( 'right-logo', '/vendors' );
            
            $vendor -> update ();
            ( new LogService() ) -> log ( 'vendor-updated', $vendor );
        }
        
        public function delete ( $vendor ): void {
            $vendor -> delete ();
            ( new LogService() ) -> log ( 'vendor-deleted', $vendor );
        }
    }