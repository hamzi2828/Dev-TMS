<?php
    
    namespace App\Services;
    
    use App\Models\Bank;
    
    class BankService {
        
        public function all () {
            return Bank ::latest () -> get ();
        }
        
        public function save ( $request ) {
            $bank = Bank ::create ( [
                                        'user_id' => auth () -> user () -> id,
                                        'title'   => $request -> input ( 'title' ),
                                        'slug'    => str ( $request -> input ( 'title' ) ) -> slug ( '-' )
                                    ] );
            ( new LogService() ) -> log ( 'bank-created', $bank );
            return $bank;
        }
        
        public function edit ( $request, $model ): void {
            $model -> user_id = auth () -> user () -> id;
            $model -> title   = $request -> input ( 'title' );
            $model -> update ();
            ( new LogService() ) -> log ( 'bank-updated', $model );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'bank-deleted', $model );
        }
        
    }