<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'role_permissions', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'role_id' );
                $table -> string ( 'permission' ) -> index ();
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'role_id' ) -> on ( 'roles' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'user_role_permissions' );
        }
    };
