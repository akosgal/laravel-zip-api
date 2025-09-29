<?php

namespace Database\Seeders;

use App\Models\County;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountySeeder extends Seeder
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
            $counties = [];
            for ($i=5; $i < count($lines); $i++) 
            {
                $data = explode(';', $lines[$i]);
                if (!in_array($data[2], $counties) && $data[2] != "")
                {
                    $counties[] = $data[2];
                }
            }
            for ($i = 0; $i < count($counties); $i++)
            {
                County::create([
                    'id' => $i + 1,
                    'name' => $counties[$i],
                ]);
            }
        } else
        {
            echo "File not found: $filePath\n";
        }
    }
}
