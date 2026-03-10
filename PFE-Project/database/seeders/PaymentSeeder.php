<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path("seeders/data/payments.csv");
        
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
            
            DB::table('payments')->updateOrInsert($uniqueKey, $record);
        }
    }
}
