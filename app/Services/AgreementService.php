<?php
    
    namespace App\Services;
    
    use App\Models\Agreement;
    use App\Models\Country;
    use Illuminate\Database\Eloquent\Collection;
    
    class AgreementService {
        
        public function all () {
            return Agreement ::with ( [ 'job', 'principal' ] ) -> latest () -> get ();
        }
        
        public function get_agreements_by_job ( $job_id ): Collection {
            return Agreement ::with ( [ 'job', 'principal' ] ) -> where ( [ 'job_id' => $job_id ] ) -> get ();
        }
        
        public function save ( $request ) {
            $agreement = Agreement ::create ( [
                                                  'user_id'      => auth () -> user () -> id,
                                                  'job_id'       => $request -> input ( 'job-id' ),
                                                  'principal_id' => $request -> input ( 'principal-id' ),
                                                  'title'        => $request -> input ( 'title' ),
                                                  'template'     => $request -> input ( 'template' ),
                                              ] );
            ( new LogService() ) -> log ( 'agreement-created', $agreement );
            return $agreement;
        }
        
        public function edit ( $request, $agreement ): void {
            $agreement -> user_id      = auth () -> user () -> id;
            $agreement -> job_id       = $request -> input ( 'job-id' );
            $agreement -> principal_id = $request -> input ( 'principal-id' );
            $agreement -> title        = $request -> input ( 'title' );
            $agreement -> template     = $request -> input ( 'template' );
            $agreement -> update ();
            ( new LogService() ) -> log ( 'agreement-updated', $agreement );
        }
        
        public function delete ( $agreement ): void {
            $agreement -> delete ();
            ( new LogService() ) -> log ( 'agreement-deleted', $agreement );
        }
    }