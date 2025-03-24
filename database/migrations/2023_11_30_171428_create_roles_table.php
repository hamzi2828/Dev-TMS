<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'roles', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' ) -> nullable ();
                $table -> string ( 'title' ) -> index () -> unique ();
                $table -> string ( 'slug' ) -> index () -> unique ();
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'roles' );
        }
    };
