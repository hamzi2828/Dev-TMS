<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'companies', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> string ( 'code' ) -> index ();
                $table -> string ( 'title' ) -> index () -> unique ();
                $table -> string ( 'slug' ) -> index () -> unique ();
                $table -> string ( 'landline' ) -> nullable ();
                $table -> string ( 'mobile' ) -> nullable ();
                $table -> string ( 'address' ) -> nullable ();
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'companies' );
        }
    };
