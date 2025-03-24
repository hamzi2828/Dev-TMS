<?php
    
    namespace App\Policies;
    
    use App\Models\DataBank;
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class DataBankPolicy {
        
        public function menu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'data-banks', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-data-banks', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-data-banks', $permissions );
        }
        
        public function edit ( User $user, DataBank $data_bank ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-data-banks', $permissions );
        }
        
        public function update ( User $user, DataBank $data_bank ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-data-banks', $permissions );
        }
        
        public function delete ( User $user, DataBank $data_bank ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-data-banks', $permissions );
        }
    }
