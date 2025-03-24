<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'users', function ( Blueprint $table ) {
                $table -> after ( 'email', function ( $table ) {
                    $table -> string ( 'cnic' ) -> nullable ();
                    $table -> string ( 'mobile' ) -> nullable ();
                    $table -> string ( 'address' ) -> nullable ();
                } );
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'users', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'cnic', 'mobile', 'address' ] );
            } );
        }
    };
