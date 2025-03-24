<?php
    
    namespace App\Services;
    
    use App\Models\Agreement;
    use App\Models\Country;
    use App\Models\SiteSetting;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\File;
    
    class SiteSettingService {
        
        public function settings () {
            return SiteSetting ::first ();
        }
        
        public function save ( $request ): void {
            
            $settings = SiteSetting ::where ( [ 'slug' => 'site-settings' ] ) -> first ();
            
            $info = [
                'slug'     => 'site-settings',
                'settings' => json_encode ( [
                                                'title'   => $request -> input ( 'title' ),
                                                'email'   => $request -> input ( 'email' ),
                                                'phone'   => $request -> input ( 'phone' ),
                                                'address' => $request -> input ( 'address' ),
                                                'logo'    => $this -> upload_image ( $request, $settings ),
                                            ] )
            ];
            
            if ( !empty( $settings ) )
                $settings -> update ( $info );
            else
                SiteSetting ::create ( $info );
            
            ( new LogService() ) -> log ( 'site-setting-added', $info );
        }
        
        private function upload_image ( $request, $settings ) {
            $path = 'uploads/site-settings/';
            $dir  = public_path ( $path );
            
            if ( !File ::isDirectory ( $dir ) ) {
                File ::makeDirectory ( $dir, 0755, true, true );
            }
            
            if ( $request -> hasFile ( 'logo' ) ) {
                $file     = request () -> file ( 'logo' );
                $fileName = time () . '-' . $file -> getClientOriginalName ();
                $file -> move ( $dir, $fileName );
                return ( asset ( $path . $fileName ) );
            }
            
            if ( !empty( $settings ) )
                return $settings -> settings -> logo;
            
        }
    }