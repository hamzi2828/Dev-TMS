<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'vendors', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> foreignId ( 'account_head_id' ) -> nullable ();
                $table -> string ( 'title' ) -> unique ();
                $table -> string ( 'slug' ) -> unique ();
                $table -> string ( 'contact' ) -> nullable ();
                $table -> string ( 'address' ) -> nullable ();
                $table -> string ( 'left_logo' ) -> nullable ();
                $table -> string ( 'right_logo' ) -> nullable ();
                $table -> float ( 'fee' ) -> nullable ();
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'account_head_id' ) -> on ( 'account_heads' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'vendors' );
        }
    };
