<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'candidate_medicals', function ( Blueprint $table ) {
                $table -> foreignId ( 'vendor_id' ) -> after ( 'payment_method_id' );
                $table -> foreign ( 'vendor_id' ) -> on ( 'vendors' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'candidate_medicals', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'vendor_id' ] );
            } );
        }
    };
