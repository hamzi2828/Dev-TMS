<?php
    
    namespace App\Services;
    
    use App\Models\PaymentMethod;
    
    class PaymentMethodService {
        
        public function all () {
            return PaymentMethod ::latest () -> get ();
        }
        
        public function save ( $request ) {
            $method = PaymentMethod ::create ( [
                                                   'user_id' => auth () -> user () -> id,
                                                   'title'   => $request -> input ( 'title' ),
                                                   'slug'    => str ( $request -> input ( 'title' ) ) -> slug ( '-' )
                                               ] );
            ( new LogService() ) -> log ( 'payment-method-added', $method );
            return $method;
        }
        
        public function edit ( $request, $model ): void {
            $model -> user_id = auth () -> user () -> id;
            $model -> title   = $request -> input ( 'title' );
            $model -> update ();
            ( new LogService() ) -> log ( 'payment-method-updated', $model );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'payment-method-deleted', $model );
        }
        
    }