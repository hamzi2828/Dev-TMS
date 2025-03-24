<?php
    
    namespace App\Services;
    
    use App\Models\Fee;
    use App\Models\PaymentMethod;
    
    class FeeService {
        
        public function all () {
            return Fee ::latest () -> get ();
        }
        
        public function save ( $request ) {
            $fee = Fee ::create ( [
                                      'user_id' => auth () -> user () -> id,
                                      'title'   => $request -> input ( 'title' ),
                                      'slug'    => str ( $request -> input ( 'title' ) ) -> slug ( '-' ),
                                      'amount'  => $request -> input ( 'amount' ),
                                  ] );
            ( new LogService() ) -> log ( 'fee-added', $fee );
            return $fee;
        }
        
        public function edit ( $request, $model ): void {
            $model -> user_id = auth () -> user () -> id;
            $model -> title   = $request -> input ( 'title' );
            $model -> amount  = $request -> input ( 'amount' );
            $model -> update ();
            ( new LogService() ) -> log ( 'fee-updated', $model );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'fee-deleted', $model );
        }
        
    }