<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::create ( 'site_settings', function ( Blueprint $table ) {
                $table -> id ();
                $table -> string ( 'slug' );
                $table -> text ( 'settings' );
                $table -> timestamps ();
            } );
        }
        
        public function down (): void {
            Schema ::dropIfExists ( 'site_settings' );
        }
    };
