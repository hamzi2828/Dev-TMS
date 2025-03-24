<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_medicals', function ( Blueprint $table ) {
                $table -> float ( 'payable', 15, 2 ) -> after ( 'amount' ) -> default ( 1500 );
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_medicals', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'payable' ] );
            } );
        }
    };
