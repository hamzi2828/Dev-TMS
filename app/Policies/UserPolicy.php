<?php
    
    namespace App\Policies;
    
    use App\Models\User;
    use Illuminate\Auth\Access\Response;
    
    class UserPolicy {
        
        public function mainMenu ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'users', $permissions );
        }
        
        public function all ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'all-users', $permissions );
        }
        
        public function create ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'add-users', $permissions );
        }
        
        public function edit ( User $user, User $model ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-users', $permissions );
        }
        
        public function update ( User $user, User $model ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'edit-users', $permissions );
        }
        
        public function delete ( User $user, User $model ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'delete-users', $permissions );
        }
        
        public function status ( User $user, User $model ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'status-users', $permissions );
        }
        
        public function restore ( User $user, User $model ): bool {
            //
        }
        
        public function forceDelete ( User $user, User $model ): bool {
            //
        }
        
        public function reporting ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'reporting', $permissions );
        }
        
        public function status_check ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'status-check', $permissions );
        }
        
        public function summary_report ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'summary-report', $permissions );
        }
        
        public function follow_up_report ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'follow-up-report', $permissions );
        }
        
        public function missing_docs_report ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'missing-docs-report', $permissions );
        }
        
        public function settings ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'settings', $permissions );
        }
        
        public function dashboard ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'dashboard', $permissions );
        }
        
        public function cheque_details_report ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'cheque-details-report', $permissions );
        }
        
        public function gross_profit_report ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'gross-profit-report', $permissions );
        }
        
        public function qj_medical_report ( User $user ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'qj-medical-report', $permissions );
        }
    }
