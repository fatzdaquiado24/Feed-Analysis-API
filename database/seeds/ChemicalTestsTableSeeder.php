<?php

use Illuminate\Database\Seeder;
use App\ChemicalTest;

class ChemicalTestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChemicalTest::truncate();
        
        $chemicalTests = [
            [
                'parameter' => 'Crude Protein',
                'method' => 'Kjeldahl Method',
                'fee' => 216,
            ],
            [
                'parameter' => 'Crude Fat',
                'method' => 'Soxhlet Method',
                'fee' => 216,
            ],
            [
                'parameter' => 'Crude Fat w/ Acid Hydrolysis',
                'method' => 'Soxhlet Method',
                'fee' => 456,
            ],
            [
                'parameter' => 'Crude Fiber',
                'method' => 'Weende Method',
                'fee' => 240,
            ],
            [
                'parameter' => 'Ash',
                'method' => 'Combustion Method',
                'fee' => 120,
            ],
            [
                'parameter' => 'Moisture',
                'method' => 'Oven Drying Method',
                'fee' => 120,
            ],
            [
                'parameter' => 'Calcium',
                'method' => 'Titrimetric Method',
                'fee' => 240,
            ],
            [
                'parameter' => 'Phosphorus',
                'method' => 'Spectrophotometric Method',
                'fee' => 240,
            ],
            [
                'parameter' => 'Salt',
                'method' => 'Mohr Method',
                'fee' => 240,
            ],
            [
                'parameter' => 'Urease Activity Test',
                'method' => 'Knapps Method',
                'fee' => 216,
            ],
            [
                'parameter' => 'Feed Microscopy',
                'method' => 'Qualitative Method',
                'fee' => 120,
            ],
            [
                'parameter' => 'Mycotoxin',
                'method' => 'ELISA Method',
                'fee' => 1300,
            ],
        ];
        foreach($chemicalTests as $chemicalTest) {
            ChemicalTest::create($chemicalTest);
        }
    }
}
