<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'payment_methods', function ( Blueprint $table ) {
                $table -> foreignId ( 'account_head_id' ) -> after ( 'user_id' ) -> nullable ();
                $table -> foreign ( 'account_head_id' ) -> on ( 'account_heads' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'payment_methods', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'account_head_id' ] );
            } );
        }
    };
