<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_protectors', function ( Blueprint $table ) {
                $table -> float ( 'price' ) -> nullable () -> after ( 'protector_date' );
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_protectors', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'price' ] );
            } );
        }
    };
