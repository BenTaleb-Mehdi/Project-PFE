<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            StaffSeeder::class,
            ClientSeeder::class,
            MealCategorySeeder::class,
            MealSeeder::class,
            ProgramSeeder::class,
            EvolutionSeeder::class,
            ProgramItemSeeder::class,
            PaymentSeeder::class,
        ]);
    }
}
