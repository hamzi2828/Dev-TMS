<?php
    
    namespace App\Services;
    
    use App\Models\User;
    use App\Models\UserRole;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Hash;
    
    class UserRoleService {
        
        public function add ( $request, $user ): void {
            $roles = $request -> input ( 'roles', [] );
            
            if ( count ( $roles ) > 0 ) {
                foreach ( $roles as $role ) {
                    $userRole = UserRole ::create ( [
                                                        'user_id' => $user -> id,
                                                        'role_id' => $role,
                                                    ] );
                    ( new LogService() ) -> log ( 'user-role-added', $userRole );
                }
            }
        }
        
        public function delete ( $user ): void {
            UserRole ::where ( [ 'user_id' => $user -> id ] ) -> delete ();
            ( new LogService() ) -> log ( 'user-role-deleted', $user );
        }
        
    }