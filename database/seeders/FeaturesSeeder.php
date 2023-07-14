<?php

namespace Database\Seeders;

use App\Models\Featurelist;
use Illuminate\Database\Seeder;

class FeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Featurelist::count() == 0) {
            $featuresListObj = new Featurelist;
            $featuresListObj->title = 'Exterior';
            $featuresListObj->save();

            $featuresListObj = new Featurelist;
            $featuresListObj->title = 'Interior';
            $featuresListObj->save();

            $featuresListObj = new Featurelist;
            $featuresListObj->title = 'Safety';
            $featuresListObj->save();

            $featuresListObj = new Featurelist;
            $featuresListObj->title = 'Mechanical';
            $featuresListObj->save();

            $featuresListObj = new Featurelist;
            $featuresListObj->title = 'Technology';
            $featuresListObj->save();

            $featuresListObj = new Featurelist;
            $featuresListObj->title = 'Other';
            $featuresListObj->save();
        }
    }
}
