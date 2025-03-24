<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\CandidateInterview;
    use App\Models\CandidateTicket;
    use App\Models\CandidateVisa;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\File;
    
    class CandidateTicketService {
        
        public function save ( $request, $candidate ) {
            $candidate -> current_status = 'ticket';
            $candidate -> update ();
            
            $ticket = CandidateTicket ::create ( [
                                                     'user_id'      => auth () -> user () -> id,
                                                     'candidate_id' => $candidate -> id,
                                                     'airline_id'   => $request -> input ( 'airline-id' ),
                                                     'from_city_id' => $request -> input ( 'city-from' ),
                                                     'to_city_id'   => $request -> input ( 'city-to' ),
                                                     'agent_id'     => $request -> input ( 'agent-id' ),
                                                     'ticket_no'    => $request -> input ( 'ticket-no' ),
                                                     'flight_no'    => $request -> input ( 'flight-no' ),
                                                     'pnr'          => $request -> input ( 'pnr' ),
                                                     'dept_date'    => $request -> input ( 'dept-date' ),
                                                     'dept_time'    => $request -> input ( 'dept-time' ),
                                                     'status'       => $request -> input ( 'status' ),
                                                     'price'        => $request -> input ( 'price' ),
                                                     'file'         => $request -> has ( 'file' ) ? $this -> upload_file ( 'file', $candidate -> id . '/ticket' ) : null,
                                                 ] );
            ( new LogService() ) -> log ( 'candidate-ticket-added', $ticket );
            return $ticket;
        }
        
        public function upsert ( $request ): void {
            
            $candidates = $request -> input ( 'candidates', [] );
            $tickets    = $request -> input ( 'tickets', [] );
            $price      = $request -> input ( 'price', [] );
            $status     = $request -> input ( 'status' );
            $pnr        = $request -> input ( 'pnr' );
            
            if ( count ( $candidates ) > 0 ) {
                foreach ( $candidates as $key => $candidate_id ) {
                    $candidate = Candidate ::find ( $candidate_id );
                    if ( $candidate_id > 0 ) {
                        
                        $candidate -> current_status = 'ticket';
                        $candidate -> update ();
                        
                        $ticket = CandidateTicket ::updateOrCreate (
                            [
                                'candidate_id' => $candidate_id
                            ],
                            [
                                'user_id'      => auth () -> user () -> id,
                                'candidate_id' => $candidate -> id,
                                'airline_id'   => $request -> input ( 'airline-id' ),
                                'from_city_id' => $request -> input ( 'city-from' ),
                                'to_city_id'   => $request -> input ( 'city-to' ),
                                'agent_id'     => $request -> input ( 'agent-id' ),
                                'ticket_no'    => $tickets[ $key ],
                                'flight_no'    => $request -> input ( 'flight-no' ),
                                'pnr'          => $request -> input ( 'pnr' ),
                                'dept_date'    => $request -> input ( 'dept-date' ),
                                'dept_time'    => $request -> input ( 'dept-time' ),
                                'price'        => $price[ $key ],
                                'status'       => $status,
                            ] );
                        ( new LogService() ) -> log ( 'candidate-ticket-added', $ticket );
                    }
                }
            }
        }
        
        public function upload_file ( $file_name, $folder ): string {
            $path = 'uploads/candidates/' . $folder . '/';
            $dir  = public_path ( $path );
            $file = request () -> file ( $file_name );
            
            if ( !File ::isDirectory ( $dir ) ) {
                File ::makeDirectory ( $dir, 0755, true, true );
            }
            
            $fileName = time () . '-' . $file -> getClientOriginalName ();
            $file -> move ( $dir, $fileName );
            return ( asset ( $path . $fileName ) );
        }
        
        public function edit ( $request, $candidate, $ticket ): void {
            if ( $request -> filled ( 'status' ) )
                $ticket -> status = $request -> input ( 'status' );
            
            $ticket -> user_id      = auth () -> user () -> id;
            $ticket -> airline_id   = $request -> input ( 'airline-id' );
            $ticket -> from_city_id = $request -> input ( 'city-from' );
            $ticket -> to_city_id   = $request -> input ( 'city-to' );
            $ticket -> agent_id     = $request -> input ( 'agent-id' );
            $ticket -> ticket_no    = $request -> input ( 'ticket-no' );
            $ticket -> flight_no    = $request -> input ( 'flight-no' );
            $ticket -> pnr          = $request -> input ( 'pnr' );
            $ticket -> dept_date    = $request -> input ( 'dept-date' );
            $ticket -> dept_time    = $request -> input ( 'dept-time' );
            $ticket -> price        = $request -> input ( 'price' );
            
            if ( $request -> has ( 'file' ) )
                $ticket -> file = $this -> upload_file ( 'file', $candidate -> id . '/ticket' );
            
            $ticket -> update ();
            ( new LogService() ) -> log ( 'candidate-ticket-updated', $ticket );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'candidate-ticket-deleted', $model );
        }
        
        public function bulk_status_update ( $request ): void {
            $candidates = $request -> input ( 'candidates' );
            $status     = $request -> input ( 'status' );
            $candidates = explode ( ',', $candidates );
            
            if ( count ( $candidates ) > 0 ) {
                foreach ( $candidates as $candidate_id ) {
                    if ( is_numeric ( $candidate_id ) && $candidate_id > 0 ) {
                        $ticket = CandidateTicket ::updateOrCreate ( [
                                                                         'candidate_id' => $candidate_id
                                                                     ],
                                                                     [
                                                                         'user_id'      => auth () -> user () -> id,
                                                                         'candidate_id' => $candidate_id,
                                                                         'status'       => $status,
                                                                     ] );
                        ( new LogService() ) -> log ( 'candidate-ticket-bulk-updated', $ticket );
                        
                        $candidate                   = Candidate ::find ( $candidate_id );
                        $candidate -> current_status = 'ticket';
                        $candidate -> update ();
                    }
                }
            }
        }
    }