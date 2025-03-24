<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'account_heads', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> foreignId ( 'account_head_id' ) -> nullable ();
                $table -> foreignId ( 'account_type_id' ) -> nullable ();
                $table -> string ( 'name' );
                $table -> string ( 'phone' ) -> nullable ();
                $table -> text ( 'description' ) -> nullable ();
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'account_head_id' ) -> on ( 'account_heads' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'account_type_id' ) -> on ( 'account_types' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'account_heads' );
        }
    };
