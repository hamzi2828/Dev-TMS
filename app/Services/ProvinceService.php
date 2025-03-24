<?php
    
    namespace App\Services;
    
    use App\Models\Candidate;
    use App\Models\Fee;
    use App\Models\Province;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Pagination\LengthAwarePaginator;
    
    class ProvinceService {
        
        public function all (): Collection {
            return Province ::latest () -> get ();
        }
        
        
        public function save ( $request ) {
            $province = Province ::create ( [
                                                'user_id' => auth () -> user () -> id,
                                                'title'   => $request -> input ( 'title' ),
                                            ] );
            ( new LogService() ) -> log ( 'province-added', $province );
            return $province;
        }
        
        public function edit ( $request, $model ): void {
            $model -> user_id = auth () -> user () -> id;
            $model -> title   = $request -> input ( 'title' );
            $model -> update ();
            ( new LogService() ) -> log ( 'province-updated', $model );
        }
        
        public function delete ( $model ): void {
            $model -> delete ();
            ( new LogService() ) -> log ( 'province-deleted', $model );
        }
    }