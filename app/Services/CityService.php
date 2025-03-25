<?php
    
    namespace App\Services;
    
    use App\Models\City;
    use App\Models\Country;
    
    class CityService {
        
        public function all () {
            return City ::with ( 'country' ) -> get ();
        }
        
        public function get_cities_by_country ( $contact ) {
            $city_id = $contact -> city_id;
            if ( $city_id > 0 ) {
                $city       = City ::with ( [ 'country' ] ) -> find ( $city_id );
                $country_id = $city -> country_id;
                return City ::where ( [ 'country_id' => $country_id ] ) -> get ();
            }
            return [];
        }
        
        public function get_cities_by_country_id ( $country_id ) {
            return City ::where ( [ 'country_id' => $country_id ] ) -> get ();
        }
        
        public function save ( $request ) {
            $city = City ::create ( [
                                        'user_id'    => auth () -> user () -> id,
                                        'country_id' => $request -> input ( 'country-id' ),
                                        'title'      => $request -> input ( 'title' ),
                                        'code'       => $request -> input ( 'code' ), //'code'
                                        'slug'       => str ( $request -> input ( 'title' ) ) -> slug ( '-' )
                                    ] );
            ( new LogService() ) -> log ( 'city-added', $city );
            return $city;
        }
        
        public function edit ( $request, $city ): void {
            $city -> user_id    = auth () -> user () -> id;
            $city -> country_id = $request -> input ( 'country-id' );
            $city -> title      = $request -> input ( 'title' );
            $city -> code       = $request -> input ( 'code' ); //'code'
            $city -> update ();
            ( new LogService() ) -> log ( 'city-updated', $city );
        }
        
    }