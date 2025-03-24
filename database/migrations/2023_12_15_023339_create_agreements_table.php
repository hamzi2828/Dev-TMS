<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'agreements', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> foreignId ( 'job_id' );
                $table -> foreignId ( 'principal_id' );
                $table -> string ( 'title' );
                $table -> longText ( 'template' );
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'job_id' ) -> on ( 'jobs' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'principal_id' ) -> on ( 'principals' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'agreements' );
        }
    };
