<?php
    
    namespace Database\Seeders;
    
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Str;
    
    class UserSeeder extends Seeder {
        
        public function run (): void {
            User ::create ( [
                                'name'              => 'Administrator',
                                'email'             => 'waleedikhlaq2@gmail.com',
                                'email_verified_at' => Carbon ::now (),
                                'password'          => Hash ::make ( 'k[H)52+HC~3+' ),
                                'active'            => '1',
                                'remember_token'    => Str ::random ()
                            ] );
        }
    }
