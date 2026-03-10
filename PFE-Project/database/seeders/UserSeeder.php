<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        $path = database_path("seeders/data/users.csv");
        
        if (!File::exists($path)) {
            $this->command->warn("Data file not found: $path");
            return;
        }

        $data = str_getcsv(File::get($path), "\n");
        $header = str_getcsv(array_shift($data), ",");

        foreach ($data as $row) {
            if (empty(trim($row))) continue;
            $values = str_getcsv($row, ",");
            
            $uniqueKey = [$header[0] => $values[0]];
            $record = array_combine($header, $values);
            
            DB::table('users')->updateOrInsert($uniqueKey, $record);
        }
    }
}
