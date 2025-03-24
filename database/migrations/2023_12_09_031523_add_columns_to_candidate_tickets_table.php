<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_tickets', function ( Blueprint $table ) {
                $table -> foreignId ( 'agent_id' ) -> nullable () -> after ( 'to_city_id' );
                $table -> foreign ( 'agent_id' ) -> on ( 'agents' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_tickets', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'agent_id' ] );
            } );
        }
    };
