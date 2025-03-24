<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_tickets', function ( Blueprint $table ) {
                $table -> foreignId ( 'airline_id' ) -> after ( 'candidate_id' ) -> nullable ();
                $table -> foreign ( 'airline_id' ) -> references ( 'id' ) -> on ( 'airlines' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_tickets', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'airline_id' ] );
            } );
        }
    };
