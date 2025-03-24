<?php
    
    namespace App\Services;
    
    use App\Models\Company;
    use App\Models\Log;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Str;
    
    class LogService {
        
        public function log ( $action, $log ): void {
            Log ::create ( [
                               'user_id' => auth () -> user () -> id,
                               'action'  => $action,
                               'log'     => $log,
                           ] );
        }
    }