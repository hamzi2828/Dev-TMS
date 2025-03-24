<?php
    
    namespace App\Services;
    
    use App\Models\AccountType;
    
    class AccountTypeService {
        
        /**
         * --------------
         * @return mixed
         * get all account types
         * --------------
         */
        
        public function all () {
            return AccountType ::latest () -> get ();
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save account types
         * --------------
         */
        
        public function save ( $request ) {
            $type = AccountType ::create ( [
                                               'user_id' => auth () -> user () -> id,
                                               'title'   => $request -> input ( 'title' ),
                                               'type'    => $request -> input ( 'type' ),
                                           ] );
            ( new LogService() ) -> log ( 'account-type-added', $type );
            return $type;
        }
        
        /**
         * --------------
         * @param $request
         * @param $type
         * @return void
         * update account types
         * --------------
         */
        
        public function edit ( $request, $type ) {
            $type -> user_id = auth () -> user () -> id;
            $type -> title   = $request -> input ( 'title' );
            $type -> type    = $request -> input ( 'type' );
            $type -> update ();
            ( new LogService() ) -> log ( 'account-type-updated', $type );
        }
    }