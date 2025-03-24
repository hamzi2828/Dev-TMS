<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'referrals', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> string ( 'name' );
                $table -> string ( 'contact' ) -> nullable ();
                $table -> string ( 'address' ) -> nullable ();
                $table -> string ( 'file' ) -> nullable ();
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'referrals' );
        }
    };
