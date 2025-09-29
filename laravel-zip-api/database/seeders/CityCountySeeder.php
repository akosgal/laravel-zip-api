<?php

namespace Database\Seeders;

use App\Models\County;
use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CityCountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = storage_path('iranyitoszamok.csv');

        if (file_exists($filePath))
        {
            $lines = file($filePath, FILE_IGNORE_NEW_LINES);
            $cities = [];
            $counties = [];
            for ($i=5; $i < count($lines); $i++) 
            {
                $data = explode(';', $lines[$i]);
                if (!in_array($data[2], $counties) && $data[2] != "")
                {
                    $counties[] = $data[2];
                }
                if ($data[0] != "")
                {
                    $cities[] = [$data[0], $data[1], array_search($data[2], $counties) + 1];
                }
            }
            for ($i = 0; $i < count($counties); $i++)
            {
                County::create([
                    'id' => $i + 1,
                    'name' => $counties[$i]
                ]);
            }
            for ($i=0; $i < count($cities); $i++)
            { 
                City::create([
                    'id' => $i + 1,
                    'postal_code' => $cities[$i][0],
                    'name' => $cities[$i][1],
                    'county_id' => $cities[$i][2]
                ]);
            }
        } else
        {
            echo "File not found: $filePath\n";
        }
    }
}
