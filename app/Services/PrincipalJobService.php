<?php
    
    namespace App\Services;
    
    use App\Models\Agent;
    use App\Models\Principal;
    use App\Models\PrincipalJob;
    use Illuminate\Support\Facades\File;
    
    class PrincipalJobService {
        
        public function save ( $request, $principal ): void {
            $jobs = $request -> input ( 'job' );
            
            if ( count ( $jobs ) > 0 ) {
                foreach ( $jobs as $key => $job_id ) {
                    if ( $job_id > 0 ) {
                        $principalJob = PrincipalJob ::create ( [
                                                                    'user_id'      => auth () -> user () -> id,
                                                                    'principal_id' => $principal -> id,
                                                                    'job_id'       => $job_id,
                                                                    'fee'          => $request -> input ( 'fee.' . $key ),
                                                                ] );
                        ( new LogService() ) -> log ( 'principal-job-added', $principalJob );
                    }
                }
            }
        }
        
        public function edit ( $request, $principal ): void {
            $principal -> user_id = auth () -> user () -> id;
            $principal -> city_id = $request -> input ( 'city-id' );
            $principal -> name    = $request -> input ( 'title' );
            $principal -> contact = $request -> input ( 'contact' );
            $principal -> address = $request -> input ( 'address' );
            $principal -> update ();
            ( new LogService() ) -> log ( 'principal-job-updated', $principal );
        }
        
        public function delete ( $principal ): void {
            PrincipalJob ::where ( [ 'principal_id' => $principal -> id ] ) -> delete ();
            ( new LogService() ) -> log ( 'principal-job-deleted', $principal );
        }
    }