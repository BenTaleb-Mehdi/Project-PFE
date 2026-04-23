<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class EvolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path("seeders/data/evolutions.csv");
        
        if (!File::exists($path)) {
            $this->command->warn("Data file not found: $path");
            return;
        }

        $data = str_getcsv(File::get($path), "\n");
        $header = str_getcsv(array_shift($data), ",");

        foreach ($data as $row) {
            if (empty(trim($row))) continue;
            $values = str_getcsv($row, ",");
            
            $record = array_combine($header, $values);
            
            // Handle transition from body_img_url to images
            if (isset($record['body_img_url'])) {
                $record['images'] = json_encode([$record['body_img_url']]);
                unset($record['body_img_url']);
            } elseif (isset($record['images']) && !is_string($record['images'])) {
                $record['images'] = json_encode($record['images']);
            }

            $uniqueKey = ['id' => $record['id']];
            
            DB::table('evolutions')->updateOrInsert($uniqueKey, $record);
        }
    }
}
