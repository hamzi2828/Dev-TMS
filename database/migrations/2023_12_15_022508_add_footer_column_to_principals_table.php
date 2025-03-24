<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'principals', function ( Blueprint $table ) {
                $table -> string ( 'footer' ) -> nullable () -> after ( 'file' );
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'principals', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'footer' ] );
            } );
        }
    };
