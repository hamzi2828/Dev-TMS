<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\District;
    use App\Models\Fee;
    use App\Models\Province;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Pagination\LengthAwarePaginator;
    
    class DistrictService {
        
        public function all (): Collection {
            return District ::latest () -> get ();
        }
        
        
        public function save ( $request ) {
            $district = District ::create ( [
                                                'user_id' => auth () -> user () -> id,
                                                'title'   => $request -> input ( 'title' ),
                                            ] );
            ( new LogService() ) -> log ( 'district-added', $district );
            return $district;
        }
        
        public function edit ( $request, $model ): void {
            $model -> user_id = auth () -> user () -> id;
            $model -> title   = $request -> input ( 'title' );
            $model -> update ();
            ( new LogService() ) -> log ( 'district-updated', $model );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'district-deleted', $model );
        }
    }