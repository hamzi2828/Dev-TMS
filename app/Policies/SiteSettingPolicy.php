<?php
    
    namespace App\Policies;
    
    use App\Models\SiteSetting;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class SiteSettingPolicy {
        
        public function mainMenu ( User $user ): bool {
            //
        }
        
        public function all ( User $user ): bool {
            //
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'site-settings', $permissions );
        }
        
        public function edit ( User $user, SiteSetting $siteSetting ): bool {
            //
        }
        
        public function update ( User $user, SiteSetting $siteSetting ): bool {
            //
        }
        
        public function delete ( User $user, SiteSetting $siteSetting ): bool {
            //
        }
        
        public function restore ( User $user, SiteSetting $siteSetting ): bool {
            //
        }
        
        public function forceDelete ( User $user, SiteSetting $siteSetting ): bool {
            //
        }
    }
