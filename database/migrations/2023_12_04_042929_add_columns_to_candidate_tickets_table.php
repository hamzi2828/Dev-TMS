<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_tickets', function ( Blueprint $table ) {
                $table -> after ( 'airline_id', function ( $table ) {
                    $table -> foreignId ( 'from_city_id' ) -> nullable ();
                    $table -> foreignId ( 'to_city_id' ) -> nullable ();
                } );
                
                $table -> foreign ( 'from_city_id' ) -> on ( 'cities' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'to_city_id' ) -> on ( 'cities' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_tickets', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'from_city_id', 'to_city_id' ] );
            } );
        }
    };
