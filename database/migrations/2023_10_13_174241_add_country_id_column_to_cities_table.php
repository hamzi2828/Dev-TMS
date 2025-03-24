<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'cities', function ( Blueprint $table ) {
                $table -> foreignId ( 'country_id' ) -> after ( 'user_id' );
                $table -> foreign ( 'country_id' ) -> on ( 'countries' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'cities', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'country_id' ] );
            } );
        }
    };
