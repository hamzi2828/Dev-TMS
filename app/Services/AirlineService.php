<?php
    
    namespace App\Services;
    
    use App\Models\Airline;
    use App\Models\Country;
    
    class AirlineService {
        
        public function all () {
            return Airline ::latest () -> get ();
        }
        
        public function save ( $request ) {
            $airline = Airline ::create ( [
                                              'user_id' => auth () -> user () -> id,
                                              'title'   => $request -> input ( 'title' ),
                                              'code' => $request->input('code'),
                                              'slug'    => str ( $request -> input ( 'title' ) ) -> slug ( '-' )
                                          ] );
            ( new LogService() ) -> log ( 'airline-created', $airline );
            return $airline;
        }
        
        public function edit ( $request, $airline ): void {
            $airline -> user_id = auth () -> user () -> id;
            $airline -> title   = $request -> input ( 'title' );
            $airline -> code = $request->input('code');
            $airline -> update ();
            ( new LogService() ) -> log ( 'airline-updated', $airline );
        }
        
        public function delete ( $airline ): void {
            $airline -> delete ();
            ( new LogService() ) -> log ( 'airline-deleted', $airline );
        }
        
    }