<?php
    
    namespace Database\Seeders;
    
    // use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    
    class DatabaseSeeder extends Seeder {
        
        public function run (): void {
            $this -> call ( [
                                UserSeeder::class,
                                AccountTypeSeeder::class,
                                LeadSourceSeeder::class,
                                LeadStatusSeeder::class,
                                IndustrySeeder::class
                            ] );
        }
    }
