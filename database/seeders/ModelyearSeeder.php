<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modelyear;
use App\Models\Carmake;
use App\Models\Carmodel;
class ModelyearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Modelyear::count() == 0) {
        
        
            $carmodelyear = new Modelyear;
            $carmodelyear->year = '2021';
            $carmodelyear->save();

            $Carmodel = new Carmodel;
            $Carmodel->year_id = $carmodelyear->id;
            $Carmodel->name =  'Volkswagen';
            $Carmodel->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'F-750';
            $model->save();


            $carmodelyear = new Modelyear;
            $carmodelyear->year = '2022';
            $carmodelyear->save();

            $Carmodel = new Carmodel;
            $Carmodel->year_id = $carmodelyear->id;
            $Carmodel->name = 'Lucid';
            $Carmodel->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'F-750';
            $model->save();

            $carmodelyear = new Modelyear;
            $carmodelyear->year = '2023';
            $carmodelyear->save();

            $Carmodel = new Carmodel;
            $Carmodel->year_id = $carmodelyear->id;
            $Carmodel->name = 'Nissan';
            $Carmodel->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'F-750';
            $model->save();


            $carmodelyear = new Modelyear;
            $carmodelyear->year = '2024';
            $carmodelyear->save();



            $carmodelyear = new Modelyear;
            $carmodelyear->year = '2017';
            $carmodelyear->save();

            $Carmodel = new Carmodel;
            $Carmodel->year_id = $carmodelyear->id;
            $Carmodel->name =  'GMC';
            $Carmodel->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Acadia';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Canyon Crew Cab';
            $model->save();



            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Canyon Extended Cab';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Hummer EV';
            $model->save();

            

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = ' Hummer EV SUV';
            $model->save();



            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = '  Savana 2500 Cargo	';
            $model->save();



            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = ' Savana 2500 Passenger';
            $model->save();

            
            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = '  Savana 3500 Passenger';
            $model->save();



            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Sierra 1500 Crew Cab';
            $model->save();



            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = ' Sierra 1500 Limited Double Cab	';
            $model->save();



            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = ' Sierra 3500 HD Regular Cab	';
            $model->save();

            
            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Sierra 3500 HD Regular Cab';
            $model->save();



            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Sierra 2500';
            $model->save();



            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Sierra 1500 Limited Crew Cab';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = ' Sierra 1500 Regular Cab';
            $model->save();
        //    ===============================================================
            $carmodelyear = new Modelyear;
            $carmodelyear->year = '2018';
            $carmodelyear->save();

            $Carmodel = new Carmodel;
            $Carmodel->year_id = $carmodelyear->id;
            $Carmodel->name =  'Ford';
            $Carmodel->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Bronco Sport';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name ='Bronco	Ford';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name ='Bronco Sport	Ford';
            $model->save();

            
            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name ='Escape	Ford';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name ='Expedition	Ford';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name ='Explorer	Ford';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name ='F150 SuperCrew Cab	Ford';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'F250 Super Duty Crew Cab';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'F250 Super Duty Regular Cab';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'F250 Super Duty Super Cab';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'F350 Super Duty Crew Cab';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'F350 Super Duty Regular Cab';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'F350 Super Duty Super Cab';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'F450 Super Duty Crew Cab';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'F450 Super Duty Regular Cab';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name ='Transit 150 Cargo Van';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name ='Transit 150 Crew Van';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name ='Transit 150 Passenger Van';
            $model->save();



            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name ='Transit 250 Cargo Van';
            $model->save();


       

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name ='Transit 350 Cargo Van';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name ='Transit 350 Crew Van';
            $model->save();

        //  ==================================================
        
        $carmodelyear = new Modelyear;
        $carmodelyear->year = '2022';
        $carmodelyear->save();

        $Carmodel = new Carmodel;
        $Carmodel->year_id = $carmodelyear->id;
        $Carmodel->name =  'Mercedes-Benz';
        $Carmodel->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;
                    $model->name = 'Mercedes-AMG A-Class';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;
        $model->name ='Mercedes-AMG C-Class';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;         
        $model->name ='Mercedes-AMG CLA';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;             
        $model->name ='Mercedes-AMG CLS';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;                
        $model->name ='Mercedes-AMG E-Class';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name ='Mercedes-AMG EQS';
        $model->save();


        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name ='Mercedes-AMG G-Class';
        $model->save();


        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name ='Mercedes-AMG GLA';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name ='Mercedes-AMG GLB';
        $model->save();


        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name ='Mercedes-AMG GLC';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name ='Mercedes-AMG GLC Coupe';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name ='Mercedes-AMG GLE';
        $model->save();


        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name ='Mercedes-AMG GLE Coupe';
        $model->save();


        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name ='Mercedes-AMG GLS';
        $model->save();


        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name ='Mercedes-AMG GT';
        $model->save();


        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name ='Mercedes-AMG S-Class';
        $model->save();


        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name ='Mercedes-AMG SL';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Mercedes-EQ EQB';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Mercedes-EQ EQE';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Mercedes-EQ EQS';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Mercedes-EQ EQS SUV';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Mercedes-Maybach GLS';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Mercedes-Maybach S-Class';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Metris Cargo';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Metris Passenger';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Sprinter 1500 Cargo';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Sprinter 1500 Passenger';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Sprinter 2500 Cargo';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Sprinter 2500 Crew';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Sprinter 2500 Passenger';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Sprinter 3500 Cargo';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Sprinter 3500 Crew';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Sprinter 3500 XD Cargo';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Sprinter 3500 XD Crew';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Sprinter 4500 Cargo';
        $model->save();

        $model = new Carmake;
        $model->year_id = $carmodelyear->id;
        $model->model_id = $Carmodel->id;   
        $model->name = 'Sprinter 4500 Crew';
        $model->save();


            $carmodelyear = new Modelyear;  
            $carmodelyear->year = '2021';
            $carmodelyear->save();

            $Carmodel = new Carmodel;
            $Carmodel->year_id = $carmodelyear->id;
            $Carmodel->name =  'Audi';
            $Carmodel->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Mercedes-AMG A-Class';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;            
            $model->name = 'A3';	
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'A4';	
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'A4'; 
            $model->save();



            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'ad';	
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'A5';	
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'A6';	
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'A6'; 
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'all';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'ad';	
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'A7';	
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'A8';	
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'e-tron';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'e-tron GT';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'e-tron S';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'e-tron S Sportback';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'e-tron Sportback';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Q4 e-tron';
            $model->save();


            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Q4 Sportback e-tron';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Q3';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Q5';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Q5 Sportback';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Q7';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Q8';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = '8'	;
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'RS 3'	;
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'RS 5'	;
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'RS 6'	;
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'RS 7';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'RS e-tron GT';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'RS Q8'	;
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'S3'	;
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'S4'	;
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'S5'	;
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'S6'	;
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'S7';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'S8';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'SQ5';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'SQ5';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'Sportback';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'SQ7';
            $model->save();

            $model = new Carmake;
            $model->year_id = $carmodelyear->id;
            $model->model_id = $Carmodel->id;
            $model->name = 'SQ8';
            $model->save();
      
          
     
            
            



            
            
            
            
            
            
            
            
            
            












    }
}

}
    

