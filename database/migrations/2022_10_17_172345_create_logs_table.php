<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'logs', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' ) -> nullable ();
                $table -> morphs ( 'logable' );
                $table -> longText ( 'action' );
                $table -> longText ( 'log' );
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'logs' );
        }
    };
