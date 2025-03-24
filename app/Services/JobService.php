<?php
    
    namespace App\Services;
    
    use App\Models\Job;
    
    class JobService {
        
        public function all () {
            return Job ::latest () -> get ();
        }
        
        public function save ( $request ) {
            $job = Job ::create ( [
                                      'user_id' => auth () -> user () -> id,
                                      'title'   => $request -> input ( 'title' ),
                                      'slug'    => str ( $request -> input ( 'title' ) ) -> slug ( '-' ),
                                      'fee'     => $request -> input ( 'fee' ),
                                  ] );
            ( new LogService() ) -> log ( 'job-added', $job );
            return $job;
        }
        
        public function edit ( $request, $model ): void {
            $model -> user_id = auth () -> user () -> id;
            $model -> title   = $request -> input ( 'title' );
            $model -> fee     = $request -> input ( 'fee' );
            $model -> update ();
            ( new LogService() ) -> log ( 'job-updated', $model );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'job-deleted', $model );
        }
        
    }