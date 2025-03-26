<?php
    
    namespace App\Services;
    
    use App\Models\Airline;
    use App\Models\Country;
    use Illuminate\Support\Facades\File;
    
    class AirlineService {
        
        public function all () {
            return Airline ::latest () -> get ();
        }
        
        public function save ( $request ) {
            $airline = Airline ::create ( [
                                              'user_id' => auth () -> user () -> id,
                                              'title'   => $request -> input ( 'title' ),
                                              'code' => $request->input('code'),
                                              'slug'    => str ( $request -> input ( 'title' ) ) -> slug ( '-' ),
                                              'file'    => $request -> has ( 'logo' ) ? $this -> upload_file ( 'logo', '/airlines' ) : null,
                                          ] );
            ( new LogService() ) -> log ( 'airline-created', $airline );
            return $airline;
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

        public function edit($request, $airline): void {

            // Store old logo path to delete if new one uploaded
            $oldLogo = $airline->logo;

            $airline->user_id = auth()->user()->id;
            $airline->title = $request->input('title');
            $airline->code = $request->input('code');
            
            // Handle logo upload if new file provided
            if ($request->has('logo')) {
                $airline->file = $this->upload_file('logo', '/airlines');
                
                // Delete old logo file if exists
                if ($oldLogo && File::exists(public_path(parse_url($oldLogo, PHP_URL_PATH)))) {
                    File::delete(public_path(parse_url($oldLogo, PHP_URL_PATH)));
                }
            }

            $airline->update();
            (new LogService())->log('airline-updated', $airline);
        }
        
        public function delete ( $airline ): void {
            $airline -> delete ();
            ( new LogService() ) -> log ( 'airline-deleted', $airline );
        }
        
    }