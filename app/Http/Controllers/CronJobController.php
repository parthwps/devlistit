<?php

namespace App\Http\Controllers;

use App\Http\Helpers\VendorPermissionHelper;
use App\Jobs\SubscriptionExpiredMail;
use App\Jobs\SubscriptionReminderMail;
use App\Models\BasicSettings\Basic;
use App\Models\Membership;
use Carbon\Carbon;
use App\Models\Car;
use App\Models\Car\Brand;
use App\Models\Car\CarModel;
use App\Models\Vendor;
use App\Models\Car\Category;
use App\Models\PrivatePackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use DB;
use Auth;
use Illuminate\Support\Str;

class CronJobController extends Controller
{
   
   
   function removeImage()
   {
     $vendor =  Vendor::find(Auth::guard('vendor')->user()->id);
     
     if($vendor && !empty($vendor->photo))
     {
        if (file_exists(public_path('assets/admin/img/vendor-photo/' . $vendor->photo))) 
        {
            unlink(public_path('assets/admin/img/vendor-photo/' . $vendor->photo));
        }

         $vendor->photo = null;
         $vendor->save();
     }
     
   }
   
    function addModels()
    {
       
            $formdatas = DB::table('form_fields')->where('label' , 'Number Of People For This Job')->get();
            
            foreach($formdatas as $formdata)
            {
                
                
                 $formdatass = DB::table('form_select_data')->where('form_fields_id' , $formdata->form_field_id )->first();
                 if($formdatass == false)
                 {
                     DB::table('form_fields')->where('form_field_id' , $formdata->form_field_id)->delete();
                 }
                 
            }
    
    }

    public function readCsvFile()
    {
    $filePath = public_path('registration_api_csv/VRMInfo.csv');
    $indexFilePath = storage_path('app/last_processed_row.txt');

    // Check if the CSV file exists
    if (!File::exists($filePath)) {
        
      if (File::exists($indexFilePath))
      {
            File::delete($indexFilePath);
      }
      
        return response()->json(['error' => 'File not found'], 404);
    }

    // Get the last processed row index from the text file
    $lastProcessedRow = 0;
    if (File::exists($indexFilePath)) {
        $lastProcessedRow = (int) File::get($indexFilePath);
    }

    // Open the CSV file for reading
    $handle = fopen($filePath, 'r');
    if ($handle === false) {
        return response()->json(['error' => 'Unable to open the file'], 500);
    }

    $header = [];
    $rowCount = 0;
    $rowsToProcess = 10000; // Process 10k rows at a time
    $processedRows = 0;

    // Read the header row first
    if (($header = fgetcsv($handle)) === false) {
        fclose($handle); // Close the file if we can't read the header
        return response()->json(['error' => 'Unable to read the header row'], 500);
    }

    // Skip the rows we've already processed
    while (!feof($handle) && $rowCount < $lastProcessedRow) {
        fgetcsv($handle); // Advance file pointer
        $rowCount++;
    }

    // Now process the next 10k rows
    while ($processedRows < $rowsToProcess) 
    {
        if (feof($handle)) 
        {
            break; // Exit loop if we reach the end of the file
        }

        // Read each row
        $row = fgetcsv($handle);
        if ($row === false || count($row) !== count($header)) {
            continue; // Skip invalid rows or rows with mismatched column counts
        }

        $rowData = array_combine($header, $row);
        
        if ($rowData === false) 
        {
            continue; // Skip invalid rows that do not match the header format
        }

        $reg_no = $rowData['VRM'];
        $make = $rowData['MAKE'];
        $model = $rowData['MODEL'];
        $color = $rowData['COLOUR'];
        $transmission = $rowData['TRANS'] == 'CVT' ? 'Automatic' : $rowData['TRANS'];
        $seats = $rowData['SEATS'];
        $fuel = $rowData['FUEL TYPE']; // Get the fuel type from the row data
        
        
        if (in_array(strtoupper($fuel), ['ELECTRIC PETROL', 'ELECTRICITY'])) 
        {
            $fuel = 'Electric';
        } 
        elseif (strtoupper($fuel) === 'HYBRID ELECTRIC') 
        {
            $fuel = 'Hybrid';
        }
        
        $year = $rowData['YoMANF'];
        $tax_fee = $rowData['TAX FEE'] ? $rowData['TAX FEE'] : 0;
        $tax_duration = $rowData['TAX DURATION'];
        
        $dataArray = [
            'vrm' => $reg_no,
            'make' => $make,
            'model' => $model,
            'color' => $color,
            'transmission' => $transmission,
            'seats' => $seats,
            'fuel_type' => $fuel,
            'year' => $year,
            'tax_fee' => $tax_fee,
            'tax_duration' => $tax_duration,
            'created_at' => now()
        ];

        // Insert or update logic
        $check_post = DB::table('registration_records')->where('vrm', $reg_no)->first();
        
        if (!$check_post) 
        {
            DB::table('registration_records')->insert($dataArray);
            
            $check_brand = Brand::where('name', ucfirst(strtolower($make)))->first();
            
            if ($check_brand == false) 
            {
                $new_brand = Brand::create([
                    'language_id' => 20,
                    'cat_id' => 44,
                    'name' => ucfirst(strtolower($make)),
                    'slug' => strtolower(str_replace(' ', '-', ucfirst(strtolower($make)))),
                    'status' => 1,
                    'created_at' => now()
                ]);
            
                $check_brand = $new_brand;
            }
            
            if($check_brand)
            {
                    $check_model = CarModel::where('brand_id', $check_brand->id)
                    ->where('name', ucfirst(strtolower($model)))
                    ->first();
                    
                    if (!$check_model) {
                    // Create the CarModel if it doesn't exist
                        CarModel::create([
                        'language_id' => 20, // Adjust if necessary
                        'brand_id' => $check_brand->id,
                        'name' => ucfirst(strtolower($model)),
                        'slug' => strtolower(str_replace(' ', '-', ucfirst(strtolower($model)))),
                        'status' => 1, // Active status
                        'created_at' => now()
                        ]);
                    }
            }
        } 
        else 
        {
            DB::table('registration_records')->where('id', $check_post->id)->update($dataArray);
        }

        $rowCount++;
        $processedRows++;
    }

    // Update the index file with the last processed row index
    File::put($indexFilePath, $rowCount);

    // Close the file
    fclose($handle);

    // If we've processed all rows, remove the CSV and index files
    if ($processedRows < $rowsToProcess) {
        File::delete($filePath);
        File::delete($indexFilePath);
        return response()->json(['success' => 'All rows processed and file removed']);
    }

    return response()->json(['success' => 'Processed ' . $processedRows . ' rows']);
}



    function adPerformance()
    {
        $vendors = Vendor::with(['cars' => function ($query) {
        $query->where('status', 1); // Filter cars with status 1
    }])
    ->where('vendor_type', 'dealer') // Ensure the vendor is of type 'dealer'
    ->whereHas('cars', function ($query) {
        $query->where('status', 1); // Ensure the dealer has cars with status 1
    })
    ->orderBy('id', 'desc')
    ->get();

      if($vendors->count() > 0 )
      {
          foreach($vendors as $vendor)
          {
                $cars = $vendor->cars;
              
                $HTML =  view('email.ad-performance', compact('cars'))->render();
                
                $data = ['recipient' => $vendor->email  , 'subject' => 'Ad Performance Stats'  , 'body' => $HTML ];
                
                \App\Http\Helpers\BasicMailer::sendMail($data);    
          }
      }
    }
    
    function imgTransfer()
    {
        $category = Category::where('parent_id' , 0)->get(['image']);
        
        foreach($category as $cat)
        {
            $sourcePath = public_path('assets/admin/img/car-category/'.$cat->image); // Path to the source image
            $destinationPath = public_path('assets/admin/img/cat-cat/'.$cat->image); // Path to the destination
            
            if (File::exists($sourcePath)) 
            {
                File::copy($sourcePath, $destinationPath);
            }
        }
    }
    
    function create_session(Request $request)
    {
        $request->session()->forget('dealer_loggedin');
        
        session(['dealer_loggedin' => $request->session_vname ]);
        
        $url = env('SUBDOMAIN_APP_URL').'vendor/car-management?language=en&tab=publish';
        
        return Redirect::to($url);
    }
    
    function changeStatusOfAd()
    {
        $cars = Car::where('status', 1)->get();
        
        foreach($cars as $car)
        {
            if($car->is_sold == 1 && $car->status == 1)
            {
                $car->status= 2; //sold
            }
            
            if(!empty($car->package_id) && $car->vendor->vendor_type == 'normal')
            {
                $created_at = $car->created_at;
                
                $adPackage = PrivatePackage::where('id', $car->package_id )->first();
                
                $createdAt = Carbon::parse($created_at);
                
                $currentDate = Carbon::now();
                
                $adDuration = $adPackage->days_listing; 
                
                $daysSincePosted  = $createdAt->diffInDays($currentDate);
                
                if($daysSincePosted > $adDuration)
                {
                    $car->status= 4; //expired
                }
            }
            
            $car->save();  
        }
    }
    
    public function expire_session()
    {
        session()->forget('dealer_loggedin');
        
        $url = env('SUBDOMAIN_APP_URL').'vendor/logout';
        
        return Redirect::to($url);
    }
    
    public function notifyFreeUser()
    {
        $bs = Basic::first();
        
        $expirationReminder = $bs->expiration_reminder;
        
        $currentDate = Carbon::now();
        
        $cars = Car::where('status', 1)
        ->whereHas('package', function ($query) 
        {
            $query->where('price', 0);
        })
        ->get();
        
        $filteredCars = $cars->filter(function ($car) use ($expirationReminder, $currentDate) 
        {
            $createdAt = Carbon::parse($car->created_at);
            
            $package = PrivatePackage::find($car->package_id);
            
            if (!$package) 
            {
                return false;
            }
        
            $adDuration = $package->days_listing;
            
            $daysSincePosted = $createdAt->diffInDays($currentDate);
            
            $remainingDays = $adDuration - $daysSincePosted;
            
            return $remainingDays == $expirationReminder;
        });

        foreach($filteredCars as $carContent)
        {
            $url =  route('frontend.car.details', ['cattitle' => catslug($carContent->car_content->category_id), 'slug' => $carContent->car_content->slug, 'id' => $carContent->id]);
            
            $manageUrl = url('customer/ad-management?language=en');
            
            $boost_url = route('vendor.package.payment_boost',  [$carContent->car_content->main_category_id,$carContent->id]);
            
            $image_path = $carContent->feature_image;
            
            $rotation = 0;
            
            if($carContent->rotation_point > 0 )
            {
                $rotation = $carContent->rotation_point;
            }
            
            if(!empty($image_path) && $carContent->rotation_point == 0 )
            {   
               $rotation = $carContent->galleries->where('image' , $image_path)->first();
               
               if($rotation == true)
               {
                    $rotation = $rotation->rotation_point;  
               }
               else
               {
                    $rotation = 0;   
               }
            }
            
            if(empty($carContent->feature_image))
            {
                $image_path = $carContent->galleries[0]->image;
                $rotation = $carContent->galleries[0]->rotation_point;
            }
            
            $imageUrl = $carContent->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path;
            
            $HTML = view('email.notify-user-for-expire' ,  compact('carContent' , 'url' , 'manageUrl' , 'imageUrl' , 'rotation' , 'boost_url' ))->render();
           
            $data = ['recipient' => $carContent->vendor->email  , 'subject' => 'Ad Expire Alert'  , 'body' => $HTML ];
            
            \App\Http\Helpers\BasicMailer::sendMail($data);  
        }
    }
    
    public function expired()
    {
        try 
        {
            $bs = Basic::first();

            $expired_members = Membership::whereDate('expire_date', Carbon::now()->subDays(1))->get();
            
            foreach ($expired_members as $key => $expired_member) 
            {
                if (!empty($expired_member->vendor)) {
                    $vendor = $expired_member->vendor;
                    $current_package = VendorPermissionHelper::userPackage($vendor->id);
                    if (is_null($current_package)) {
                        SubscriptionExpiredMail::dispatch($vendor, $bs);
                    }
                }
            }

            $remind_members = Membership::whereDate('expire_date', Carbon::now()->addDays($bs->expiration_reminder))->get();
            
            foreach ($remind_members as $key => $remind_member) 
            {
                if (!empty($remind_member->vendor)) 
                {
                    $vendor = $remind_member->vendor;

                    $nextPacakgeCount = Membership::where([
                        ['vendor_id', $vendor->id],
                        ['start_date', '>', Carbon::now()->toDateString()]
                    ])->where('status', '<>', 2)->count();

                    if ($nextPacakgeCount == 0) {
                        SubscriptionReminderMail::dispatch($vendor, $bs, $remind_member->expire_date);
                    }
                }
                \Artisan::call("queue:work --stop-when-empty");
            }
            
        } catch (\Exception $e) {
        }
    }
}
