<?php $__env->startSection('pageHeading'); ?>
  <?php if(!empty($pageHeading)): ?>
    <?php echo e($pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Ads')); ?>

  <?php else: ?>
    <?php echo e(__('Ads')); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('metaKeywords'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_keywords_vendor_signup); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaDescription'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_description_vendor_signup); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if ($__env->exists('frontend.partials.breadcrumb', [
'breadcrumb' => $bgImg->breadcrumb,
'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Ads'),
])) echo $__env->make('frontend.partials.breadcrumb', [
'breadcrumb' => $bgImg->breadcrumb,
'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Ads'),
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
$carContent = App\Models\Car\CarContent::where('car_id', $car->id)->first();
$categories = App\Models\Car\Category::where('id', $carContent->category_id)->first();

?>
<div class="user-dashboard pt-20 pb-60">
    <div class="container">
      
  <div class="row gx-xl-5">
  
       <?php if ($__env->exists('vendors.partials.side-custom')) echo $__env->make('vendors.partials.side-custom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="col-md-9">      
  

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block"><?php echo e(__('Edit Ad')); ?></div>
          <a style="float: right;" class="btn btn-info btn-sm float-right d-inline-block"
            href="<?php echo e(route('vendor.car_management.car', ['language' => $defaultLang->code])); ?>">
            <span class="btn-label">
              <i class="fas fa-backward"></i>
            </span>
            <?php echo e(__('Back')); ?>

          </a>
          <?php
            $dCarContent = App\Models\Car\CarContent::where('car_id', $car->id)
                ->where('language_id', $defaultLang->id)
                ->first();
          ?>
          <a style="float: right;margin-right: 1rem;" class="mr-2 btn btn-success btn-sm float-right d-inline-block"
            href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($dCarContent->category_id), 'slug' => $dCarContent->slug, 'id' => $car->id])); ?>" target="_blank">
            <span class="btn-label">
              <i class="fas fa-eye"></i>
            </span>
            <?php echo e(__('Preview')); ?>

          </a>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="alert alert-danger pb-1 dis-none" id="carErrors">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <ul></ul>
              </div>
              
              <div class="col-lg-12">
                <label for="" class="mb-2"><strong><?php echo e(__('Gallery Images')); ?> **</strong> <br> <small class="text-danger">load up to <?php echo e($car->package ? $car->package->photo_allowed : 15); ?> images .jpg, .png, & .gif</small> </label>
                <div class="row">
                  <div class="col-12">
                    <?php
                // Sort galleries by priority
                $sortedGalleries = $car->galleries->sortBy('priority');
                
                // Extract the feature image
                $featureImage = $sortedGalleries->firstWhere('image', $car->feature_image);
                
                // Remove the feature image from the sorted galleries
                if ($featureImage) {
                $sortedGalleries = $sortedGalleries->reject(function($item) use ($featureImage) {
                return $item->id === $featureImage->id;
                });
                
                // Prepend the feature image to the sorted galleries
                $sortedGalleries->prepend($featureImage);
                }
                ?>
                
                <table class="table table-striped" id="imgtable">
                <?php $__currentLoopData = $sortedGalleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="trdb table-row" id="trdb<?php echo e($item->id); ?>">
                <td>
                <div class="">
                    <img class="thumb-preview wf-150"
                         src="<?php echo e(asset('assets/admin/img/car-gallery/' . $item->image)); ?>"
                         id="img_<?php echo e($item->id); ?>"
                         alt="Ad Image"
                         style="height: 120px;width:120px; object-fit: cover; transform: rotate(<?php echo e($item->rotation_point); ?>deg);">
                </div>
                <?php if($item->image != $car->feature_image): ?>
                    <div style="text-align: center; margin-bottom: 5px; color: gray;">
                        Set Cover  <input class='form-check-input' value="<?php echo e($item['id']); ?>" onclick="setCoverPhoto(<?php echo e($item['id']); ?>)" type='radio' name='flexRadioDefault'>
                    </div>
                <?php endif; ?>
                </td>
                
                <td>
                <i class="fa fa-times" onclick="removethis(<?php echo e($item->id); ?>)"></i>
                <i class="fa fa-undo rotatebtndb" onclick="rotatePhoto(<?php echo e($item->id); ?>)"></i>
                <?php if($item->image == $car->feature_image): ?>
                    <label class="cover_label">Cover photo</label>
                <?php endif; ?>
                </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>

                  </div>
                </div>
                <form action="<?php echo e(route('vendor.car.imagesstore')); ?>" id="my-dropzone" enctype="multipart/formdata"
                  class="dropzone create us_dropzone ">
                  <?php echo csrf_field(); ?>
                  <div class="fallback">
                    <input name="file" type="file" multiple />
                  </div>
                  <input type="hidden" value="<?php echo e($car->id); ?>" name="car_id">
                </form>
                <p class="em text-danger mb-0" id="errslider_images"></p>
              </div>

              <form id="carForm" action="<?php echo e(route('vendor.car_management.update_car', $car->id)); ?>" method="POST"
                enctype="multipart/form-data" >
                <?php echo csrf_field(); ?>
                <input type="hidden" name="car_id" value="<?php echo e($car->id); ?>">
                <input type="hidden" name="can_car_add" value="1">
                <input type="hidden" id="defaultImg" name="car_cover_image" value="">
                
              
               
                <?php if($car->car_content->main_category_id == 24 && !empty($car->car_content->brand_id)): ?>
                
                    <?php if(in_array('make', json_decode($categories->filters))): ?> 
                        <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                            <h3><?php echo e(__('Vehicle Details')); ?> </h3>
                                       
                              </div>
                          </div>
                        </div>
                    <?php endif; ?>

                <div class="row">
                    <?php if(in_array('make', json_decode($categories->filters))): ?> 
                    
                     <?php
                        $brands = App\Models\Car\Brand::where('id', $carContent->brand_id)->first();
                    ?>
                    
                    <?php if($brands == true): ?>
                      <div class="col-lg-6 col-sm-6">
                        <div class="form-group editAdLabel">
                       
                          <label><?php echo e(__('Make:')); ?> </label>
                          <b><?php echo e($brands->name); ?></b>
                        </div>
                      </div>
                   <?php endif; ?> 
                   
                  <?php endif; ?> 
                  
                  <?php if(in_array('model', json_decode($categories->filters))): ?> 
                  
                    <?php
                        $models = App\Models\Car\CarModel::where('id', $carContent->car_model_id)->first();
                    ?>
                    
                    <?php if($models == true): ?>
                      <div class="col-lg-6 col-sm-6">
                        <div class="form-group editAdLabel">
                      
                          <label><?php echo e(__('Model:')); ?> </label>
                          <b><?php echo e($models->name); ?></b>
                        </div>
                      </div>
                    <?php endif; ?> 
                    
                  <?php endif; ?> 

                  <?php if(in_array('year', json_decode($categories->filters))): ?> 
                  <?php if(!empty($car->year)): ?>
                  <div class="col-lg-6 col-sm-6">
                    <div class="form-group editAdLabel">
                      <label><?php echo e(__('Year:')); ?> </label>
                      <b><?php echo e($car->year); ?></b>
                    </div>
                  </div>
                  <?php endif; ?>
                  <?php endif; ?>
                  
                  <?php if(in_array('fuel_types', json_decode($categories->filters))): ?>
                   <?php
                     $fuel_types = App\Models\Car\FuelType::where('id', $carContent->fuel_type_id)->first();
                     ?>
                     <?php if($fuel_types == true): ?>
                  <div class="col-lg-6 col-sm-6">
                    <div class="form-group editAdLabel">
                   
                      <label><?php echo e(__('Fuel Type:')); ?> </label>
                      <b><?php echo e($fuel_types->name); ?></b>
                    </div>
                  </div>
                  <?php endif; ?>
                   <?php endif; ?>
                   

             <?php if(in_array('engine', json_decode($categories->filters))  && !empty($fuel_types->id) &&  in_array($fuel_types->id , [14,15]) ): ?>
                <div class="col-lg-4">
                    <div class="form-group">
                    <?php
                        $engine_sizes = App\Models\Car\EngineSize::where('status', 1)->get();
                    ?>
                    <label><?php echo e(__('Engine size (litres)')); ?> </label>
                    <select name="engineCapacity" id="engine_sizes" class="form-control" >
                        <option value="" ><?php echo e(__('Select')); ?></option>
                        <?php $__currentLoopData = $engine_sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $engine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <option  value="<?php echo e($engine->name); ?>"  <?php if($engine->name == $car->engineCapacity): echo 'selected'; endif; ?>><?php echo e(($engine->name)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>   
                
                <?php else: ?>
                
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Engine size (KW) </label>
                        
                        <input type="text" name="engineCapacity" value="<?php echo e($car->engineCapacity); ?>" class="form-control" />
                    </div>
                </div> 
            <?php endif; ?>


                <?php if(in_array('transmision_type', json_decode($categories->filters))): ?>
                <div class="col-lg-4"  <?php if( !empty($fuel_types->id) && !in_array($fuel_types->id , [14,15]) ): ?>  style="display:none;" <?php endif; ?>  >
                    <div class="form-group">
                        <?php
                        $transmission_types = App\Models\Car\TransmissionType::where('status', 1)
                            ->get();
                        ?>
                
                        <label><?php echo e(__('Transmission Type')); ?> </label>
                        <select name="transmission_type_id" class="form-control" id="transmissionType">
                        <option value="" ><?php echo e(__('Select')); ?></option>
                        
                        <?php $__currentLoopData = $transmission_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transmission_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($transmission_type->id); ?>" <?php if($transmission_type->id == $carContent->transmission_type_id): echo 'selected'; endif; ?>><?php echo e($transmission_type->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(in_array('body_type', json_decode($categories->filters))): ?>
                <div class="col-lg-4">
                    <div class="form-group">
                        <?php
                        $body_types = App\Models\Car\BodyType::where('status', 1)->get();
                        ?>
                        <label><?php echo e(__('Body Type')); ?> </label>
                        <select name="body_type_id" id="bodyType" class="form-control">
                        <?php $__currentLoopData = $body_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $body_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                            <option value="<?php echo e($body_type->id); ?>" <?php if($body_type->id == $carContent->body_type_id): echo 'selected'; endif; ?>><?php echo e($body_type->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div> 
                <?php endif; ?>
                <?php if(in_array('colour', json_decode($categories->filters))): ?>
                <div class="col-lg-4">
                    <div class="form-group ">
                    <?php
                        $colour = App\Models\Car\CarColor::where('status', 1)->get();
                    ?>
                
                    <label><?php echo e(__('Colour')); ?> </label>
                    <select name="car_colour_id" class="form-control" id="carColour">
                        <option value=""><?php echo e(__('Select Colour')); ?></option>
                        
                        <?php $__currentLoopData = $colour; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($colour->id); ?>"  <?php if($colour->id == $carContent->car_color_id): echo 'selected'; endif; ?>><?php echo e($colour->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(in_array('doors', json_decode($categories->filters))): ?>
                <div class="col-lg-4">
                    <div class="form-group">
                    <label><?php echo e(__('Number of doors')); ?> </label>
                    <select name="doors"  class="form-control" id="carDoors" >
                    <option value="">Please select...</option>
                    <option value="2" <?php if($car->doors == 2): echo 'selected'; endif; ?>>2</option>
                    <option value="3" <?php if($car->doors == 3): echo 'selected'; endif; ?>>3</option>
                    <option value="4" <?php if($car->doors == 4): echo 'selected'; endif; ?>>4</option>
                    <option value="5" <?php if($car->doors == 5): echo 'selected'; endif; ?>>5</option>
                    <option value="6" <?php if($car->doors == 6): echo 'selected'; endif; ?>>6</option>
                    <option value="7" <?php if($car->doors == 7): echo 'selected'; endif; ?>>7</option>
                    <option value="8" <?php if($car->doors == 8): echo 'selected'; endif; ?>>8</option>
                    </select>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(in_array('seat_count', json_decode($categories->filters))): ?>
                <div class="col-lg-4">
                    <div class="form-group">
                    <label><?php echo e(__('Seat count')); ?> </label>
                    <select name="seats" id="seats" class="form-control">
                    <option value="">Please select...</option>
                    <option value="2" <?php if($car->seats == 2): echo 'selected'; endif; ?>>2</option>
                    <option value="3" <?php if($car->seats == 3): echo 'selected'; endif; ?>>3</option>
                    <option value="4" <?php if($car->seats == 4): echo 'selected'; endif; ?>>4</option>
                    <option value="5" <?php if($car->seats == 5): echo 'selected'; endif; ?>>5</option>
                    <option value="6" <?php if($car->seats == 6): echo 'selected'; endif; ?>>6</option>
                    <option value="7" <?php if($car->seats == 7): echo 'selected'; endif; ?>>7</option>
                    <option value="8" <?php if($car->seats == 8): echo 'selected'; endif; ?>>8</option>
                    </select>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(in_array('power', json_decode($categories->filters))): ?>
                <div class="col-lg-4">
                    <div class="form-group ">
                   
                
                    <label><?php echo e(__('Power')); ?> </label>
                    
                    <input type="number" class="form-control"  value="<?php echo e($car->power); ?>"   placeholder="Enter Power HP"  name="power"/>

                   
                    </div>
                </div>
                <?php endif; ?>
                <?php if(in_array('battery', json_decode($categories->filters)) && !empty($fuel_types->id) &&  !in_array($fuel_types->id , [14,15])): ?>
                <div class="col-lg-4">
                    <div class="form-group ">
                   
                    <label><?php echo e(__('Battery')); ?> </label>
                    <select name="battery" class="form-control" id="battery">
                        <option value=""><?php echo e(__('Select battery')); ?></option>
                
                        <option value=""><?php echo e(__('Any')); ?></option>
                        <option value="100" <?php if($car->battery == 100): echo 'selected'; endif; ?>>100+ M</option>
                        <option value="200" <?php if($car->battery == 200): echo 'selected'; endif; ?>>200+ M</option>
                        <option value="300" <?php if($car->battery == 300): echo 'selected'; endif; ?>>300+ M</option>
                        <option value="400" <?php if($car->battery == 400): echo 'selected'; endif; ?>>400+ M</option>
                        <option value="500" <?php if($car->battery == 500): echo 'selected'; endif; ?>>500+ M</option>
                    </select>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(in_array('owners', json_decode($categories->filters))): ?>
                <div class="col-lg-4">
                    <div class="form-group ">
                   
                    <label><?php echo e(__('Number of owners')); ?> </label>
                    <select id="owners" class="form-select form-control"  name="owners">
                        <option value=""><?php echo e(__('Any')); ?></option>
                        <option value="1" <?php if($car->owners == 1): echo 'selected'; endif; ?>>1</option>
                        <option value="2" <?php if($car->owners == 2): echo 'selected'; endif; ?>>2</option>
                        <option value="3" <?php if($car->owners == 3): echo 'selected'; endif; ?>>3</option>
                        <option value="4" <?php if($car->owners == 4): echo 'selected'; endif; ?>>4</option>
                        <option value="5" <?php if($car->owners == 5): echo 'selected'; endif; ?>>5</option>
                        <option value="6" <?php if($car->owners == 6): echo 'selected'; endif; ?>>6</option>
                        <option value="7" <?php if($car->owners == 7): echo 'selected'; endif; ?>>7</option>
                        <option value="8" <?php if($car->owners == 8): echo 'selected'; endif; ?>>8</option>
                        
                    </select>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(in_array('road-tax', json_decode($categories->filters))): ?>
                <div class="col-lg-4">
                    <div class="form-group ">
                   
                    <label><?php echo e(__('Annual road tax')); ?> </label>
                    
                    <input type="number" class="form-control"  value="<?php echo e($car->road_tax); ?>"   placeholder="Enter annual road tax"  name="road_tax"/>
                    
                    
                    </div>
                </div>
                <?php endif; ?>
                
                
                
                <?php endif; ?>
                
                
                  <?php if(!empty($output)): ?>
                    <?php echo $output; ?>

                <?php endif; ?>
               

                <div id="accordion" class="mt-3">
                  <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   
                   
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label><?php echo e(__('Title*')); ?></label>
                                <input type="text" class="form-control" name="<?php echo e($language->code); ?>_title"
                                  placeholder="Enter Title" value="<?php echo e($carContent ? $carContent->title : ''); ?>">
                              </div>
                            </div>

                            <!-- <div class="col-lg-3">
                              <div class="form-group ">
                                <?php
                                  $categories = App\Models\Car\Category::where('language_id', $language->id)
                                      ->where('status', 1)
                                      ->get();
                                ?>

                                <label><?php echo e(__('Category')); ?> *</label>
                                <select name="<?php echo e($language->code); ?>_category_id"
                                  class="form-control js-example-basic-single2">
                                  <option selected disabled><?php echo e(__('Select a Category')); ?></option>

                                  <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                      <?php echo e(($carContent ? $carContent->category_id : '' == $category->id) ? 'selected' : ''); ?>

                                      value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                              </div>
                            </div> -->

                               
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label><?php echo e(__('Description')); ?> *</label>
                                <textarea class="form-control" id="<?php echo e($language->code); ?>_description"
                                  name="<?php echo e($language->code); ?>_description" data-height="300" style="height: 300px;" ><?php echo e($carContent ? $carContent->description : ''); ?></textarea>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                 
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label><?php echo e(__('Price')); ?> </label>
                              <input type="number" class="form-control" <?php if($carContent->main_category_id == 233 || $carContent->main_category_id == 347 ): ?> readonly <?php endif; ?> name="previous_price" placeholder="Enter Previous Price"
                                value="<?php echo e((!empty($car->previous_price)) ? $car->previous_price :  $car->price); ?>">
                            </div>
                          </div>
                          <div class="col-lg-6 ">
                            <div class="form-group">
                              <label><?php echo e(__('Optional YouTube Video')); ?> </label>
                                 <input type="text" class="form-control" name="youtube_video" value="<?php echo e($car->youtube_video); ?>" placeholder="Enter youtube Video URL">
                              </div>
                              </div>                      
                           </div>
                           
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="row pt-20">
                        <div class="col-lg-12">
                        <div class="row " >
                        <div class="col-lg-8 ">
                          <div class="form-group">
                            <h4><?php echo e(__('Contact Details')); ?> </h4>
                          </div>
                        </div>
                        </div>
                        </div>
                        </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label><?php echo e(__('Full Name')); ?></label>
                      <input type="text" class="form-control" name="full_name" value="<?php echo e($vendor->vendor_info->name); ?>">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label><?php echo e(__('Email')); ?></label>
                      <input type="text" value="<?php echo e($vendor->email); ?>" class="form-control" name="email" disabled>
                    </div>
                  </div> 
                  <div class="col-lg-6">
                    <label style="margin-top: 5px;margin-left: 10px;font-size: 21px;color: #7b7b7b;"><?php echo e(__('Phone')); ?></label>
                    <div class="form-group input-group">
                      
                      <div class="d-flex" style="    margin-top: -12px;">
                        <div class="custom-select">
                        <div class="select-selected">
                            
                            <?php
                                $ct = $country_codes->firstWhere('country', 'United Kingdom');
                                
                                $flagUrl = $ct->flag_url;
                                $flagcode = $ct->code;
                                $s_code = $ct->short_code;
                                
                                if(!empty($vendor->country_code))
                                {
                                    $ct = $country_codes->firstWhere('code', $vendor->country_code);
                                    
                                    $flagUrl = $ct->flag_url;
                                    $flagcode = $ct->code;
                                    $s_code = $ct->short_code;
                                
                                }
                                
                            ?>
                        <img src="<?php echo e($flagUrl); ?>" alt="UK Flag" class="flag">
                        <span class="short_code"> <?php echo e($s_code); ?> </span> (<?php echo e($flagcode); ?>)
                        </div>
                        <div class="select-items select-hide">
                        <div class="search-box">
                        <input type="text" id="country-search" placeholder="Search country...">
                        </div>
                        <?php $__currentLoopData = $country_codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="country-option" data-value="<?php echo e($country->code); ?>" data-flag="<?php echo e($country->flag_url); ?>">
                        <img src="<?php echo e($country->flag_url); ?>" alt="<?php echo e($country->country); ?>" class="flag">
                        <span  class="short_code">  <?php echo e($country->short_code); ?> </span> <span style="display:none;"><?php echo e($country->country); ?></span> (<?php echo e($country->code); ?>)
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        </div>
                        
                        <input type="hidden" name="c_code" id="c_code" value="<?php echo e(!empty(Auth::guard('vendor')->user()->country_code) ? Auth::guard('vendor')->user()->country_code : '+44'); ?>"/>
        
                        <input  type="number" value="<?php echo e($vendor->phone); ?>" style="height: 40px;margin-top: 10px;    margin-right: 5px;" class="form-control" name="phone" required> 
                      
                      
                       <?php if($vendor->phone_verified == 1): ?>
                        <button disabled   class="btn  btn-success2"  style="    height: 40px;
                        margin-top: 10px;
                        font-size: 25px;
                        padding-top: 5px;
                        width: 50px;
                        padding-left: 12px;
                        background: transparent;
                        color: #1b87f4;" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                         <?php else: ?>
                        <button  id="verifyPhone" class="btn btn-outline-secondary"  style="height: 40px;
                        margin-top: 10px;
                        font-size: 25px;
                        padding-top: 5px;
                        width: 50px;
                        padding-left: 12px;
                        background: transparent;
                        color: #1b87f4;" type="button" title="verify"><i class='fas fa-fingerprint'></i></button>
                        <?php endif; ?>
                        
                        </div>
                        
                        
                     <small style="    margin-top: 10px;">Verify your phone number and help reduce fraud and scams on Listit</small>
                      <p id="editErr_phone" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  
                  
                  <div class="col-lg-6">
                       
                      <div class="form-group checkbox-xl row">
                          <div> <label><?php echo e(__('Allow contact by')); ?></label></div>
                      <div class="col-lg-6">
                        
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="message_center" id="inlineRadio1" value="yes" required  <?= ($car->message_center == 1) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="message_center">Message </label>
                        </div>
                      </div>
                        
                      <div class="col-lg-6">
                        <div class="form-check form-check-inline">
                             <input class="form-check-input" type="checkbox" name="phone_text" id="inlineRadio2" value="yes"  <?= ($car->phone_text == 1) ? 'checked' : '' ?> >
                            <label class="form-check-label" for="message_center">Phone/Text</label>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                  
                  
                  <div class="col-lg-6" style="display:none;">
                    <div class="form-group">
                     <label><?php echo e(__('Area')); ?></label>
                     
                     <input id ="promoStatus" type="hidden" name="promo_status" value="0">
                      <select name="city" id="" class="form-control">
                    <option value="">Please select...</option>
                    <?php $__currentLoopData = $countryArea; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($area->slug); ?>" <?php echo e($area->slug == $vendor->vendor_info->city ? 'selected' : ''); ?>><?php echo e($area->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    </div>
                  </div> 
                  
                
                  <div class="row">
            <div class="col-12 text-center">
              <button type="submit" id="CarSubmit" class="btn btn-primary">
                <?php echo e(__('Update')); ?>

              </button>
            </div>
          </div>
                  </div> 
                <input type="hidden" id="max_file_upload" name="max_file_upload" value="<?php echo e($car->package ? $car->package->photo_allowed : 15); ?>" />

                <div id="sliders">
                    <?php if(!empty($sortedGalleries) && count($sortedGalleries) > 0 ): ?>
                        <?php $__currentLoopData = $sortedGalleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="slider_images[]" id="slider<?php echo e($itm->id); ?>" value="<?php echo e($itm->id); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    
                </div>
              </form>
            </div>
          </div>
        </div>
        </div>

        <div class="card-footer">
         
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div> </div>
  </div>
  
   <input type="hidden" id="request_method" value="GET" />
   
   
  <?php $__env->stopSection(); ?>
<?php
  $languages = App\Models\Language::get();
  $labels = '';
  $values = '';
  foreach ($languages as $language) {
      $label_name = $language->code . '_label[]';
      $value_name = $language->code . '_value[]';
      if ($language->direction == 1) {
          $direction = 'form-group rtl text-right';
      } else {
          $direction = 'form-group';
      }
  
      $labels .= "<div class='$direction'><input type='text' name='" . $label_name . "' class='form-control' placeholder='Label ($language->name)'></div>";
      $values .= "<div class='$direction'><input type='text' name='$value_name' class='form-control' placeholder='Value ($language->name)'></div>";
  }
?>

<?php $__env->startSection('script'); ?>

<link rel="stylesheet" href="<?php echo e(asset('assets/css/dropzone.min.css')); ?>">




<link rel="stylesheet" href="<?php echo e(asset('assets/css/select2.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/pages/inner-pages.css')); ?>">

<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin-main.css')); ?>">
<style type="">
  #carForm .form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem !important;
    font-size: 16px !important;
    font-weight: 400;
    line-height: 1.3 !important;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out
}
option {
  padding: 0px 8px 8px;
}

 #carForm .btn-secondary{
  line-height: 16px !important;
  left:-4px;
 }
 .customRadio{
  width: 1.2em !important;
    height: 1.2em !important;
    border-color:#b1b1b1 !important;
    margin-right:4px !important;
 }
 .customRadiolabel{
  margin-top:3px !important;
  font-size: 14px;
  font-weight: 600;
 }
 .editAdLabel label{
  
  width:150px;
 }
 
  
  button.rotate-btn {
    font-size: 12px;
    position: absolute;
    top: 40px;
    right: 10px;
    z-index: 30;
    border-radius: 5px;
    background-color: #004eabd6;
    color: #fff;
    outline: 0;
    border: none;
    cursor: pointer !important;
}


.rotatebtndb
{
     
    top: 30px !important;
   
    color: #004eabd6 !important;
   
    cursor: pointer !important;
}
.form-group label, .form-check label {
 color:gray !important;   
}


.row h3,b,h4,label
{
     color:gray !important; 
}

</style>
<script>
  'use strict';

  const baseUrl = "<?php echo e(url('/')); ?>";
</script>






<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery-ui.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.ui.touch-punch.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.timepicker.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.scrollbar.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap-notify.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/sweet-alert.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap-tagsinput.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap-datepicker.min.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/js/jscolor.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/fontawesome-iconpicker.min.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/js/tinymce/js/tinymce/tinymce.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/datatables-1.10.23.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/datatables.bootstrap4.min.js')); ?>"></script>



<script type="text/javascript" src="<?php echo e(asset('assets/js/dropzone.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/atlantis.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/webfont.min.js')); ?>"></script>

<!-- <?php if(session()->has('success')): ?>
  <script>
    'use strict';
    var content = {};

    content.message = '<?php echo e(session('success')); ?>';
    content.title = 'Success';
    content.icon = 'fa fa-bell';

    $.notify(content, {
      type: 'success',
      placement: {
        from: 'top',
        align: 'right'
      },
      showProgressbar: true,
      time: 1000,
      delay: 4000
    });
  </script>
<?php endif; ?> -->

<?php if(session()->has('warning')): ?>
  <script>
    'use strict';
    var content = {};

    content.message = '<?php echo e(session('warning')); ?>';
    content.title = 'Warning!';
    content.icon = 'fa fa-bell';

    $.notify(content, {
      type: 'warning',
      placement: {
        from: 'top',
        align: 'right'
      },
      showProgressbar: true,
      time: 1000,
      delay: 4000
    });
  </script>
<?php endif; ?>




<script type="text/javascript" src="<?php echo e(asset('assets/js/select2.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/admin-main.js')); ?>"></script>

  <script>
    'use strict';
    var storeUrl = "<?php echo e(route('car.imagesstore')); ?>";
    var removeUrl = "<?php echo e(route('user.car.imagermv')); ?>";
    var getBrandUrl = "<?php echo e(route('user.get-car.brand.model')); ?>";
    var rmvdbUrl = "<?php echo e(route('vendor.car.imgdbrmv')); ?>";
    const account_status = "<?php echo e(Auth::guard('vendor')->user()->status); ?>";
    const secret_login = "<?php echo e(Session::get('secret_login')); ?>";
    
    var rotationAngle1 = 0;
    
    function rotatePhoto(id) 
{
    // Find the image element within the file preview element
    var imageElement = $('#img_'+id);
    
    
    if (imageElement.length) {
        // Increment the rotation angle by 90 degrees
        rotationAngle1 += 90;
    
        // Apply the rotation to the image element
        imageElement.css('transform', 'rotate(' + rotationAngle1 + 'deg)');
    
        // Reset rotation to 0 if it reaches 360 degrees
        if (rotationAngle1 === 360) {
            rotationAngle1 = 0;
        }
        
        rotationSave(id, rotationAngle1);
    }
    
    return false;
}

    function removethis(fileid) 
    {
        $.ajax({
          url: removeUrl,
          type: 'POST',
          data: {
            fileid: fileid
          },
          success: function (data) {
            $("#slider" + fileid).remove();
            $('#trdb'+fileid).remove()
          }
        });
    }
    
    
     function rotationSave(fileid , rotationEvnt)
    {
        var requestMethid = "POST";
        
        if($('#request_method').val() != '')
        {
           var requestMethid = "GET"; 
        }
        
           $.ajax({
          url: '/customer/ad-management/img-db-rotate',
          type: requestMethid,
          data: {
            fileid: fileid , rotationEvnt:rotationEvnt
          },
          success: function (data) 
          {
           
          }
        }); 
    }
    
    
    
  </script>

   <script src="<?php echo e(asset('assets/js/car.js?v=0.9')); ?>"></script>
  <script>
    var labels = "<?php echo $labels; ?>";
    var values = "<?php echo $values; ?>";
  </script>
  <script type="text/javascript" src="<?php echo e(asset('assets/js/admin-partial.js?v=0.2')); ?>"></script>
  <script type="text/javascript" src="<?php echo e(asset('assets/js/admin-dropzone.js?v=0.9')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make("frontend.layouts.layout-v$settings->theme_version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/car/edit.blade.php ENDPATH**/ ?>