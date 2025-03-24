<?php
    
    namespace App\Services;
    
    use App\Models\Role;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Str;
    
    class RoleService {
        
        public function roles (): Collection | array {
            return Role ::with ( [ 'user' ] ) -> latest () -> get ();
        }
        
        public function add ( $request ) {
            $role = Role ::create ( [
                                        'user_id' => auth () -> user () -> id,
                                        'title'   => $request -> input ( 'title' ),
                                        'slug'    => Str ::slug ( $request -> input ( 'title' ), '-' ),
                                    ] );
            ( new LogService() ) -> log ( 'role-added', $role );
            return $role;
        }
        
        public function update ( $request, $role ): void {
            $role -> user_id = auth () -> user () -> id;
            $role -> title   = $request -> input ( 'title' );
            $role -> update ();
            ( new LogService() ) -> log ( 'role-updated', $role );
        }
        
        public function delete ( $role ): void {
            $role -> delete ();
            ( new LogService() ) -> log ( 'role-deleted', $role );
        }
    }