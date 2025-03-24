<?php
    
    namespace App\Services;
    
    use App\Models\User;
    
    class GeneralService {
        
        public function date_formatter ( $date ): string {
            return date ( 'd-m-Y H:i:s', strtotime ( $date ) );
        }
        
        public function only_date_formatter ( $date ): string {
            return date ( 'd-m-Y', strtotime ( $date ) );
        }
        
        public function timeline_icon ( $type ): string {
            return match ( $type ) {
                'task'       => 'timeline-point-danger',
                'meeting'    => 'timeline-point-primary',
                'call'       => 'timeline-point-success',
                'notes'      => 'timeline-point-dark',
                'attachment' => 'timeline-point-warning',
                'contact'    => 'timeline-point-info',
                'lead'       => 'timeline-point-gray',
                default      => 'timeline-point-indicator',
            };
        }
    }