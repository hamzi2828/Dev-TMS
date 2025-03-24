<?php
    
    namespace App\Services;
    
    use App\Models\Contact;
    use App\Models\LeadSource;
    use Illuminate\Support\Str;
    
    class LeadSourceService {
        
        public function sources () {
            return LeadSource ::active () -> get ();
        }
        
        public function save ( $request ) {
            $source = LeadSource ::create ( [
                                                'user_id' => auth () -> user () -> id,
                                                'title'   => $request -> input ( 'title' ),
                                                'slug'    => Str ::slug ( $request -> input ( 'title' ), '-' ),
                                            ] );
            ( new LogService() ) -> log ( 'lead-source-added', $source );
            return $source;
        }
        
        public function update ( $request, $model ): void {
            $model -> user_id = auth () -> user () -> id;
            $model -> title   = $request -> input ( 'title' );
            $model -> update ();
            ( new LogService() ) -> log ( 'lead-source-updated', $model );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'lead-source-deleted', $model );
        }
    }