<?php
    
    namespace App\Services;
    
    use App\Models\Qualification;
    
    class QualificationService {
        
        public function all () {
            return Qualification ::latest () -> get ();
        }
        
        public function save ( $request ) {
            $qualification = Qualification ::create ( [
                                                          'user_id' => auth () -> user () -> id,
                                                          'title'   => $request -> input ( 'title' ),
                                                          'slug'    => str ( $request -> input ( 'title' ) ) -> slug ( '-' )
                                                      ] );
            ( new LogService() ) -> log ( 'qualification-added', $qualification );
            return $qualification;
        }
        
        public function edit ( $request, $model ): void {
            $model -> user_id = auth () -> user () -> id;
            $model -> title   = $request -> input ( 'title' );
            $model -> update ();
            ( new LogService() ) -> log ( 'qualification-updated', $model );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'qualification-deleted', $model );
        }
        
    }