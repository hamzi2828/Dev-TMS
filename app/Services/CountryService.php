<?php
    
    namespace App\Services;
    
    use App\Models\Country;
    
    class CountryService {
        
        public function all () {
            return Country ::latest () -> get ();
        }
        
        public function save ( $request ) {
            $country = Country ::create ( [
                                              'user_id' => auth () -> user () -> id,
                                              'title'   => $request -> input ( 'title' ),
                                              'slug'    => str ( $request -> input ( 'title' ) ) -> slug ( '-' )
                                          ] );
            ( new LogService() ) -> log ( 'country-added', $country );
            return $country;
        }
        
        public function edit ( $request, $country ): void {
            $country -> user_id = auth () -> user () -> id;
            $country -> title   = $request -> input ( 'title' );
            $country -> update ();
            ( new LogService() ) -> log ( 'country-updated', $country );
        }
        
    }