<?php

    namespace App\Services;

    use App\Models\Company;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Str;

    class CompanyService {

        public function companies (): Collection {
            return Company ::with ( [ 'manager', 'user' ] ) -> latest () -> get ();
        }

        public function add ( $request ) {
            $company = Company ::create ( [
                                              'user_id'  => auth () -> user () -> id,
                                              'code'     => $request -> input ( 'code' ),
                                              'title'    => $request -> input ( 'title' ),
                                              'slug'     => $this -> generate_slug ( $request ),
                                              'landline' => $request -> input ( 'landline' ),
                                              'mobile'   => $request -> input ( 'mobile' ),
                                              'address'  => $request -> input ( 'address' ),
                                              'account_head_id' => $request -> input ( 'account_head_id' ),
                                          ] );
            ( new LogService() ) -> log ( 'mrf-added', $company );
            return $company;
        }

        public function update ( $request, $company ): void {
            $company -> user_id  = auth () -> user () -> id;
            $company -> code     = $request -> input ( 'code' );
            $company -> title    = $request -> input ( 'title' );
            $company -> landline = $request -> input ( 'landline' );
            $company -> mobile   = $request -> input ( 'mobile' );
            $company -> address  = $request -> input ( 'address' );
            $company -> update ();
            ( new LogService() ) -> log ( 'mrf-updated', $company );
        }

        public function delete ( $company ): void {
            $company -> delete ();
            ( new LogService() ) -> log ( 'mrf-deleted', $company );
        }

        public function generate_slug ( $request ): string {
            $title     = $request -> input ( 'title' );
            $slug      = Str ::slug ( $title, '-' );
            $companies = Company ::where ( 'slug', 'LIKE', $slug . '-%' ) -> count ();
            return $companies > 0 ? $slug . '-' . count ( $companies ) : $slug;
        }
    }
