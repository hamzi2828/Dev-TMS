<?php
    
    namespace App\Services;
    
    use App\Models\Company;
    use App\Models\CompanyRequisition;
    use App\Models\CompanyRequisitionJob;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Str;
    
    class CompanyRequisitionService {
        
        public function all (): Collection {
            return CompanyRequisition ::with ( [ 'user', 'company', 'jobs.job' ] ) -> latest () -> get ();
        }
        
        public function add ( $request ) {
            $requisition = CompanyRequisition ::create ( [
                                                             'user_id'      => auth () -> user () -> id,
                                                             'principal_id' => $request -> input ( 'principal-id' )
                                                         ] );
            ( new LogService() ) -> log ( 'requisition-added', $requisition );
            return $requisition;
        }
        
        public function update ( $request, $model ): void {
            $model -> user_id      = auth () -> user () -> id;
            $model -> principal_id = $request -> input ( 'principal-id' );
            $model -> update ();
            ( new LogService() ) -> log ( 'requisition-updated', $model );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'requisition-deleted', $model );
        }
        
        public function get_company_requisitions ( $request ) {
            $company_id   = $request -> input ( 'company_id' );
            $requisitions = CompanyRequisition ::where ( [ 'company_id' => $company_id ] ) -> get () -> pluck ( 'id' ) -> toArray ();
            if ( count ( $requisitions ) > 0 ) {
                return CompanyRequisitionJob ::whereIn ( 'company_requisition_id', $requisitions )
                    -> with ( [ 'job', 'company_requisition' ] )
                    -> get ();
            }
            return [];
        }
        
        public function get_company_requisitions_by_company_id ( $candidate ) {
            $company_id   = $candidate ?-> requisition ?-> company_requisition_job ?-> company_requisition ?-> company_id;
            $requisitions = CompanyRequisition ::where ( [ 'company_id' => $company_id ] ) -> get () -> pluck ( 'id' ) -> toArray ();
            if ( count ( $requisitions ) > 0 ) {
                return CompanyRequisitionJob ::whereIn ( 'company_requisition_id', $requisitions )
                    -> with ( [ 'job', 'company_requisition' ] )
                    -> get ();
            }
            return [];
        }
    }