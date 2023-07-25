<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Database\Seeder;

class HouseSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

            $i =1;
            while($i<15){

               
                $requestData = [];
                $userId = 1;
                $resourceObj = new Car;
                $resourceObj->user_id = 1;
    
                $resourceObj->year = "200".$i;
                $resourceObj->make = "make".$i;
                $resourceObj->model = $requestData['model'] ?? "model";
                // $resourceObj->car_fuel_type = $requestData['car_fuel_type'] ?? null;
                $resourceObj->car_number = $requestData['car_number_plate'] ?? generate_string('');;
                $resourceObj->engine_size = $requestData['engine_size'] ?? null;
                $resourceObj->amount = "1234".$i."00";
                $resourceObj->description = $requestData['description'] ?? null;
                // $resourceObj->car_type = $request->car_type ? $request->car_type:"shipping";
    
               
                $resourceObj->find_me_buyer =  false;
                $resourceObj->post_ad_number = generate_string(''); // uniqid('post_', true);
    
                $resourceObj->lat = $requestData['lat'] ?? ($requestData['latitude'] ?? '26.1128562');
                $resourceObj->lng = $requestData['lng'] ?? ($requestData['longitude'] ?? '-80.1426190');
                $resourceObj->city = $requestData['city'] ?? null;
                $resourceObj->state = $requestData['state'] ?? null;
                $resourceObj->condition = $requestData['condition'] ?? null;
                $resourceObj->color = $requestData['color'] ?? null;
                // $resourceObj->exterior_color = $requestData['exterior_color'] ?? null;
    
                $resourceObj->category_id = $requestData['category_id'] ?? 1;
    
    
                
                $resourceObj->title_status = $requestData['title_status'] ?? "title-".$i;
    
                if ($resourceObj->save()) {
                       // $files = uploadImages($request->file('file'), IMAGE_UPLOAD_PATH);
                       $files = [['file_name'=>'house_img1.jpg'],['file_name'=>'house_img2.jpg'],['id' =>1,'file_name'=>'house_img3.jpg'],['id' =>1,'file_name'=>'house_img4.jpg'],['id' =>1,'file_name'=>'house_img5.jpg']];
                        foreach ($files as $file) {
                            $giftImagesObj = new CarImage();
                            $giftImagesObj->image = $file['file_name'];
                            $giftImagesObj->user_id = $userId;
                            $giftImagesObj->car_id = $resourceObj->id;
                            $giftImagesObj->save();
                        
                    }
    
                }  
                $i++;
            }
           
             

           
        }
    
}
