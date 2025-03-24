<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidates', function ( Blueprint $table ) {
                $table -> string ( 'docs_provided' ) -> nullable () -> after ( 'free_candidate' );
            } );
        }
        
        /**
         * Reverse the migrations.
         */
        public function down (): void {
            Schema ::table ( 'candidates', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'docs_provided' ] );
            } );
        }
    };
