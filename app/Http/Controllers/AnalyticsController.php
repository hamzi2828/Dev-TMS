<?php
    
    namespace App\Http\Controllers;
    
    use App\Services\AnalyticsService;
    use Illuminate\Http\Request;
    
    class AnalyticsController extends Controller {
        
        public function payable_count () {
            return ( new AnalyticsService() ) -> payable ();
        }
        
        public function receivable_count () {
            return ( new AnalyticsService() ) -> receivable ();
        }
        
        public function income_from_test () {
            return ( new AnalyticsService() ) -> income_from_test ();
        }
        
        public function income_from_medical () {
            return ( new AnalyticsService() ) -> income_from_medical ();
        }
        
        public function income_from_candidate () {
            return ( new AnalyticsService() ) -> income_from_candidate ();
        }
    }
