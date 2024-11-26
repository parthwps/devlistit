<div id="appendNewFilters">
                
                <?php
                    $category_filters = null;
                    
                    if(!empty($category->filters))
                    {
                        $category_filters = json_decode($category->filters , true );
                    }
                    
                ?>
                 
               <?php if(!empty($filters) && $category->brands()->count() == 0 &&  $category->id != 24): ?>
               
                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#select"
                        aria-expanded="true" aria-controls="select">
                        <?php echo e(__('Category')); ?>

                      </button> 
                    </h5>
                  
                    <div id="select" class="collapse show">
                      <div class="accordion-body  ">
                        <div class="row gx-sm-3">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                              <input type="hidden" name="category" id="category" />
                              <input type="hidden" name="pid" id="pid" />
                               <input type="hidden" name="page" value="1" id="pageno">
                               <input type="hidden" name="request_type" value="by_default" id="request_type">
                                <div class="list-group list-group-flush">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="javascript:void(0);" style="display:<?= ($key > 4) ?  'none' : '' ?>" data-category="<?php echo e($category->slug); ?>"  data-pid="<?php echo e($category->parent_id); ?>" onclick="updatecate(this)" class="us_cat_cls2  <?= ($key > 4) ?  'us_hidden_by_default' : '' ?> " > 
                                            <?php echo e($category->name); ?> 
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <?php if(count($categories) > 5): ?>
                                        <a href="javascript:void(0);" style="color: red;font-size: 11px;margin-top: 7px;font-weight: bold;" id="us_load_more" onclick="loadAllCat(this)">load more+</a>
                                    <?php endif; ?>
                                </div>  
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                
                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#location"
                        aria-expanded="true" aria-controls="location">
                        <?php echo e(__('Location')); ?>

                      </button>
                    </h5>
                    <div id="location" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row gx-sm-3">
                          <div class="col-12">
                             <div class="form-group" style="padding:10px 0px;">
                             <div class="col-12 float-start"> 
                              <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()" name="location">
                                <option value=""><?php echo e(__('Any')); ?></option>
                                    <?php $__currentLoopData = $carlocation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($clocation->slug); ?>" <?php if(request()->input('location') == $clocation->slug): echo 'selected'; endif; ?>><?php echo e($clocation->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                    <?php if($category_filters && in_array('pricing' , $category_filters)): ?>
                <div class="widget widget-price p-0 mb-20">
                    
                    <h5 class="title">
                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#price" aria-expanded="true" aria-controls="price">
                                <?php echo e(__('Pricing')); ?> £
                          </button>
                    </h5>
                    
                    <div id="price" class="collapse show">
                        <div class="accordion-body scroll-y mt-20">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group" style="padding:10px 0px;">
                                         <?php if($category->id == 24 || $category->parent_id == 24 || $category->id == 39 || $category->parent_id == 39): ?>
                                         
                                        <div class="col-6 float-start"> 
                                       
                                            <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()"
                                            id="min" name="min">
                                                        <option value="">
                                                            <?php echo e(__('Min Price')); ?>

                                                        </option>
                                                    <?php $__currentLoopData = $adsprices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prices): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option  value="<?php echo e($prices->name); ?>" <?php if(request()->input('min') == $prices->name): echo 'selected'; endif; ?>>
                                                            <?php echo e(symbolPrice($prices->name)); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            
                                        </div>
                                        <div class="col-6 float-end">
                                            <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()"
                                            id="max" name="max">
                                                <option value=""><?php echo e(__('Max Price')); ?></option>
                                                <?php $__currentLoopData = $adsprices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prices): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option  value="<?php echo e($prices->name); ?>" <?php if(request()->input('max') == $prices->name): echo 'selected'; endif; ?>><?php echo e(symbolPrice($prices->name)); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        
                                        
                                            <?php else: ?>
                                            <div class="col-6 float-start"> 
                                            <input type="number" name="min" onblur="updateUrl()" class="form-control" value="<?php echo e(request()->input('min')); ?>" placeholder="min" />
                                            </div>
                                            <div class="col-6 float-end">
                                            <input type="number" name="max" onblur="updateUrl()" class="form-control" value="<?php echo e(request()->input('max')); ?>" placeholder="max" />
                                             </div>
                                            <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <input type="hidden" id="currency_symbol" value="<?php echo e($basicInfo->base_currency_symbol); ?>">
                        
                        </div>
                    </div>
                  </div>
                 <?php endif; ?>
                 <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 
                 <?php
                   $key = str_replace('::'.$filter->type , '' ,  $key);
                 ?>
                    <div class="widget widget-select p-0 mb-20">
                        <h5 class="title">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#location"
                            aria-expanded="true" aria-controls="location">
                            <?php echo e($key); ?>

                            </button>
                        </h5>
                        
                        <?php if($filter->type == 'select' && !empty($filter->form_options) ): ?>
                        <div id="location" class="collapse show">
                            <div class="accordion-body scroll-y">
                                <div class="row gx-sm-3">
                                    <div class="col-12">
                                         <div class="form-group" style="padding:10px 0px;">
                                             <div class="col-12 float-start"> 
                                                  <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()"  name="filters_select_<?php echo e(strtolower(str_replace(' ' , '_' , $key ))); ?>">
                                                    <option value="">Choose Option</option>
                                                        <?php $__currentLoopData = $filter->form_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form_option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($form_option->value); ?>" ><?php echo e($form_option->value); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php elseif($filter->type == 'radio' && !empty($filter->form_options) ): ?>
                        <div id="location" class="collapse show">
                            <div class="accordion-body scroll-y">
                                <div class="row gx-sm-3">
                                    <div class="col-12">
                                         <div class="form-group" style="padding:10px 0px;">
                                             <div class="col-12 float-start"> 
                                                 <div class="row">
                                                        <?php $__currentLoopData = $filter->form_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form_option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="col-md-6">
                                                               <input type="radio" name="filters_radio_<?php echo e(strtolower(str_replace(' ' , '_' , $key ))); ?>" onchange="updateUrl()" value="<?php echo e($form_option->value); ?>" />  &nbsp;  <b ><?php echo e($form_option->value); ?></b>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php elseif($filter->type == 'checkbox' && !empty($filter->form_options)): ?>
                        <div id="location" class="collapse show">
                            <div class="accordion-body scroll-y">
                                <div class="row gx-sm-3">
                                    <div class="col-12">
                                         <div class="form-group" style="padding:10px 0px;">
                                             <div class="col-12 float-start"> 
                                                <!-- <ul> -->
                                                 <!-- <div class="row"> -->
                                                        
                                                 <!-- </div> -->
                                                <!-- </ul> -->

                                                <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()"  name="filters_select_<?php echo e(strtolower(str_replace(' ' , '_' , $key ))); ?>">
                                                    <option value="">Choose Option</option>
                                                        <?php $__currentLoopData = $filter->form_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form_option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                          <option value="<?php echo e($form_option->value); ?>" name="filters_checkbox_<?php echo e(strtolower(str_replace(' ' , '_' , $key ))); ?>[]" onchange="updateUrl()" >
                                                            &nbsp;  <b ><?php echo e($form_option->value); ?></b>
                                                          </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 <?php else: ?>
                 
              
                 
                 <?php if($categories->count() > 0 ): ?>
                 
                 <div class="widget widget-select p-0 mb-20">
                    <h5 class="title">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#select"
                        aria-expanded="true" aria-controls="select" style="color: rgb(88, 97, 118) !important;font-size: 16px;font-family:Lato,sans-serif">
                        <!-- <?php echo e(__('Category')); ?>  -->
                        <?php echo e(__('Section')); ?> 
                      </button> 
                    </h5>
                  
                    <div id="select" class="collapse show">
                      <div class="accordion-body  ">
                        <div class="row gx-sm-3">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                              <input type="hidden" name="category" id="category" />
                              <input type="hidden" name="pid" id="pid" />
                               <input type="hidden" name="page" value="1" id="pageno">
                               <input type="hidden" name="request_type" value="by_default" id="request_type">
                                <div class="list-group list-group-flush" id="cat_lisitnfg">
                                    
                                    <?php if(empty(request()->category)): ?>
                                    
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="javascript:void(0);"  data-category="<?php echo e($category->slug); ?>"  data-pid="<?php echo e($category->parent_id); ?>" onclick="updatecate(this)" class="us_cat_cls2" > 
                                            <?php echo e($category->name); ?> 
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <?php else: ?>
                                    
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="javascript:void(0);" style="display:<?= ($key > 4) ?  'none' : '' ?>" data-category="<?php echo e($category->slug); ?>"  data-pid="<?php echo e($category->parent_id); ?>" onclick="updatecate(this)" class="us_cat_cls2  <?= ($key > 4) ?  'us_hidden_by_default' : '' ?> " > 
                                            <?php echo e($category->name); ?> 
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <?php if(count($categories) > 5): ?>
                                        <a href="javascript:void(0);" style="color: red;font-size: 11px;margin-top: 7px;font-weight: bold;" id="us_load_more" onclick="loadAllCat(this)">load more+</a>
                                    <?php endif; ?>
                                    
                                    
                                    <?php endif; ?>   
                                </div>  
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                
                <?php endif; ?>
                
                <span <?php if(empty(request()->category)): ?> style="display:none;" <?php endif; ?>  id="carsFiltrs"> 
                
                
                <?php if($category_filters && in_array('location' , $category_filters)): ?>
                
                  <div class="widget widget-select p-0 mb-20">
                    <h5 class="title">
                      <button class="accordion-button mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#location"
                        aria-expanded="true" aria-controls="location">
                        <?php echo e(__('Location')); ?>

                      </button>
                    </h5>
                    <div id="location" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row gx-sm-3">
                          <div class="col-12">
                             <div class="form-group" style="padding:10px 0px;">
                             <div class="col-12 float-start"> 
                              <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()" name="location">
                                <option value=""><?php echo e(__('Any')); ?></option>
                                    <?php $__currentLoopData = $carlocation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($clocation->slug); ?>" <?php if(request()->input('location') == $clocation->slug): echo 'selected'; endif; ?>><?php echo e($clocation->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <hr/>
                <?php endif; ?> 
                
                
                <?php if($category_filters && in_array('pricing' , $category_filters)): ?>
                
                <div class="widget widget-price p-0 mb-20">
                    
                    <h5 class="title">
                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#price" aria-expanded="true" aria-controls="price">
                                <?php echo e(__('Pricing')); ?> £
                          </button>
                    </h5>
                    
                    <div id="price" class="collapse show">
                        <div class="accordion-body scroll-y mt-20">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group" style="padding:10px 0px;">
                                        
                                         <?php if($category->id == 24 || $category->parent_id == 24 || $category->id == 39 || $category->parent_id == 39): ?>
                                         
                                        <div class="col-6 float-start custom_col"> 
                                       
                                            <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()" name="min">
                                                        <option value="">
                                                            <?php echo e(__('Min Price')); ?>

                                                        </option>
                                                    <?php $__currentLoopData = $adsprices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prices): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option  value="<?php echo e($prices->name); ?>" <?php if(request()->input('min') == $prices->name): echo 'selected'; endif; ?>>
                                                            <?php echo e(symbolPrice($prices->name)); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            
                                        </div>
                                        <div class="col-6 float-end custom_col">
                                            <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()" 
                                            name="max">
                                                <option value=""><?php echo e(__('Max Price')); ?></option>
                                                <?php $__currentLoopData = $adsprices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prices): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option  value="<?php echo e($prices->name); ?>" <?php if(request()->input('max') == $prices->name): echo 'selected'; endif; ?>><?php echo e(symbolPrice($prices->name)); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        
                                        
                                            <?php else: ?>
                                            <div class="col-6 float-start"> 
                                            <input type="number" name="min" onblur="updateUrl()" class="form-control" value="<?php echo e(request()->input('min')); ?>" placeholder="min" />
                                            </div>
                                            <div class="col-6 float-end">
                                            <input type="number" name="max" onblur="updateUrl()" class="form-control" value="<?php echo e(request()->input('max')); ?>" placeholder="max" />
                                             </div>
                                            <?php endif; ?>
                                            
                                            
                                    </div>
                                </div>
                            </div>
                            
                            <input type="hidden" id="currency_symbol" value="<?php echo e($basicInfo->base_currency_symbol); ?>">
                        
                        </div>
                    </div>
                  </div>
                  <hr/>
                  <?php endif; ?>
                  
              
              <?php if($category_filters && in_array('make' , $category_filters)): ?>
              
                <div class="widget widget-ratings p-0 mb-20">
                    <h5 class="title">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ratings"
                        aria-expanded="true" aria-controls="ratings">
                        <?php echo e(__('Makes')); ?>

                      </button>
                    </h5>
                    <div id="ratings" class="collapse show">
                      <div class="accordion-body scroll-y mt-20">
                        <ul class="list-group custom-checkbox">
                          <?php
                            if (!empty(request()->input('brands'))) {
                                $selected_brands = [];
                                if (is_array(request()->input('brands'))) {
                                    $selected_brands = request()->input('brands');
                                } else {
                                    array_push($selected_brands, request()->input('brands'));
                                }
                            } else {
                                $selected_brands = [];
                            }
                          ?>

                        <select class="form-select form-control js-example-basic-single1 makeclickable" onchange="updateUrl()" name="brands[]">
                         
                                <option value=""><?php echo e(__('All Makes')); ?></option>
                                <option disabled>-- Popular Brands --</option>
                            <?php $__currentLoopData = $brands->sortBy('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($brand->slug); ?>" <?php echo e($category_filters && in_array($brand->slug, $selected_brands) ? 'selected' : ''); ?> ><?php echo e($brand->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                                <option disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Other Makes --</option>
                            <?php $__currentLoopData = $otherBrands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($brand->slug); ?>" <?php echo e($category_filters && in_array($brand->slug, $selected_brands) ? 'selected' : ''); ?> ><?php echo e($brand->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                        </select>

                        </ul>
                      </div>
                    </div>
                  </div>
                  <hr/>
                  <?php endif; ?>
                
                <?php if($category_filters && in_array('model' , $category_filters)): ?>
                
                    <div class="widget widget-ratings p-0 mb-20">
                      <h5 class="title">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                          data-bs-target="#models" aria-expanded="true" aria-controls="models">
                          <?php echo e(__('Models')); ?>

                        </button>
                      </h5>
                      
                      <div id="models" class="collapse show">
                        <div class="accordion-body scroll-y mt-20">
                          <ul class="list-group custom-checkbox" id="appendModels" >
                           
                              <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()" name="models[]">
                                <option value=""><?php echo e(__('Select Model')); ?></option>
                              
                               </select>
                             
                          </ul>
                        </div>
                      </div>
                    </div>
                    <hr/>
                <?php endif; ?>
           
           <?php if($category_filters && in_array('year' , $category_filters)): ?>
           
                  <!-- Year -->
                  <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        <?php echo e(__('Year')); ?>

                      </button>
                    </h5>
                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                             <div class="col-6 float-start custom_col"float-start> 
                              <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()" id="year_min" name="year_min">
                                <option value=""><?php echo e(__('Min Year')); ?></option>
                                <?php $__currentLoopData = $caryear; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option 
                                    value="<?php echo e($year->name); ?>" <?php if(request()->input('year_min') == $year->name): echo 'selected'; endif; ?>><?php echo e($year->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>

                             
                            </div>
                        <div class="col-6 float-end custom_col">
                        <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()" id="year_max" name="year_max">
                                <option value=""><?php echo e(__('Max Year')); ?></option>
                                <?php $__currentLoopData = $caryear; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option 
                                    value="<?php echo e($year->name); ?>" <?php if(request()->input('year_max') == $year->name): echo 'selected'; endif; ?>><?php echo e($year->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr/>
                  <?php endif; ?>
                 
                 
                 <?php if($category_filters && in_array('mileage' , $category_filters)): ?>
                 
                  <!-- Mileage -->
                  <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        <?php echo e(__('Mileage (Miles)')); ?>

                      </button>
                    </h5>
                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                             <div class="col-6 float-start custom_col"float-start> 
                              <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()" id="mileage_min" name="mileage_min">
                                <option value=""><?php echo e(__('Min ')); ?></option>
                               <?php $__currentLoopData = $adsmileage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mileage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option 
                                    value="<?php echo e($mileage->name); ?>" <?php if(request()->input('mileage_min') == $mileage->name): echo 'selected'; endif; ?>><?php echo e(($mileage->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                            </div>
                        <div class="col-6 float-end custom_col">
                        <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()" id="mileage_max" name="mileage_max">
                                <option value=""><?php echo e(__('Max ')); ?></option>
                                <?php $__currentLoopData = $adsmileage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mileage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option 
                                    value="<?php echo e($mileage->name); ?>" <?php if(request()->input('mileage_max') == $mileage->name): echo 'selected'; endif; ?>><?php echo e(($mileage->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr/>
                  <?php endif; ?>
                  
                   <?php if($category_filters && in_array('fuel_types' , $category_filters)): ?>
               
                  <!-- Fuel Types -->
                  <div class="widget widget-select p-0 mb-20 mt-2">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        <?php echo e(__('Fuel Types')); ?>

                      </button>
                    </h5>
                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row gx-sm-3">
                          <div class="col-xl-12">
                            <div class="form-group" style="padding:10px 0px;">
                              <select class="form-select form-control" onchange="updateUrl()" name="fuel_type">
                                <option value=""><?php echo e(__('All')); ?></option>
                                <?php $__currentLoopData = $fuel_types->sortBy('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fuel_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option <?php echo e(request()->input('fuel_type') == $fuel_type->slug ? 'selected' : ''); ?>

                                    value="<?php echo e($fuel_type->slug); ?>"><?php echo e($fuel_type->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr/>
                  <?php endif; ?>
                  
                  
                  <?php if($category_filters && in_array('body_type' , $category_filters)): ?>
               
                  <!-- Body Types -->
                  <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        <?php echo e(__('Body Types')); ?>

                      </button>
                    </h5>
                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row gx-sm-3">
                          <div class="col-xl-12">
                            <div class="form-group" style="padding:10px 0px;">
                              <select class="form-select form-control" onchange="updateUrl()" name="body_type">
                                <option value=""><?php echo e(__('All')); ?></option>
                                <?php $__currentLoopData = $body_type->sortBy('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bodytype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option <?php echo e(request()->input('body_type') == $bodytype->slug ? 'selected' : ''); ?>

                                    value="<?php echo e($bodytype->slug); ?>"><?php echo e($bodytype->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr/>
                  
                  <?php endif; ?>
                  
                  
                     <?php if($category_filters && in_array('transmision_type' , $category_filters)): ?>
                     
                    <!-- Transmission Types -->
                  <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#transmission" aria-expanded="true" aria-controls="transmission">
                        <?php echo e(__('Transmission Types')); ?>

                      </button>
                    </h5>
                    <div id="transmission" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row gx-sm-3">
                          <div class="col-xl-12">
                            <div class="form-group" style="padding:10px 0px;">
                              <select class="form-select form-control" name="transmission" onchange="updateUrl()">
                                <option value=""><?php echo e(__('All')); ?></option>
                                <?php $__currentLoopData = $transmission_types->sortBy('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transmission_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option
                                    <?php echo e(request()->input('transmission') == $transmission_type->slug ? 'selected' : ''); ?>

                                    value="<?php echo e($transmission_type->slug); ?>"><?php echo e($transmission_type->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr/>
                  
                  <?php endif; ?> 
                   <!-- Colour -->
                   
                    <?php if($category_filters && in_array('colour' , $category_filters)): ?>
                    
                  <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#select2" aria-expanded="true" aria-controls="select">
                        <?php echo e(__('Colour')); ?>

                      </button>
                    </h5>
                    <div id="select2" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row gx-sm-3">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                              <select class="form-select form-control js-example-basic-single1" name="condition" onchange="updateUrl()">
                                <option value=""><?php echo e(__('All')); ?></option>
                                <?php $__currentLoopData = $car_conditions->sortBy('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car_condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option <?php echo e(request()->input('condition') == $car_condition->slug ? 'selected' : ''); ?>

                                    value="<?php echo e($car_condition->slug); ?>"><?php echo e($car_condition->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr/>
                  <?php endif; ?>
                  
                 <?php if($category_filters && in_array('owners' , $category_filters)): ?>
              <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        <?php echo e(__('Number of owners')); ?>

                      </button>
                    </h5>
                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                             <div class="col-12 float-start"float-start> 
                              <select class="form-select form-control" onchange="updateUrl()" name="owners">
                                <option value=""><?php echo e(__('Any')); ?></option>
                                <option value="1" <?php if(request()->input('owners') == 1): echo 'selected'; endif; ?>>1</option>
                                <option value="2" <?php if(request()->input('owners') == 2): echo 'selected'; endif; ?>>2</option>
                                <option value="3" <?php if(request()->input('owners') == 3): echo 'selected'; endif; ?>>3</option>
                                <option value="4" <?php if(request()->input('owners') == 4): echo 'selected'; endif; ?>>4</option>
                                <option value="5" <?php if(request()->input('owners') == 5): echo 'selected'; endif; ?>>5</option>
                                <option value="6" <?php if(request()->input('owners') == 6): echo 'selected'; endif; ?>>6</option>
                                <option value="7" <?php if(request()->input('owners') == 7): echo 'selected'; endif; ?>>7</option>
                                <option value="8" <?php if(request()->input('owners') == 8): echo 'selected'; endif; ?>>8</option>
                                
                              </select>

                             
                            </div>
                       
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
               </div>
               <hr/>
               
               <?php endif; ?>
               
                <?php if($category_filters && in_array('doors' , $category_filters)): ?>
                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        <?php echo e(__('Number of doors')); ?>

                      </button>
                    </h5>
                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                             <div class="col-12 float-start"float-start> 
                              <select class="form-select form-control" onchange="updateUrl()" name="doors">
                                <option value=""><?php echo e(__('Any')); ?></option>
                                <option value="2" <?php if(request()->input('doors') == 2): echo 'selected'; endif; ?>>2</option>
                                <option value="3" <?php if(request()->input('doors') == 3): echo 'selected'; endif; ?>>3</option>
                                <option value="4" <?php if(request()->input('doors') == 4): echo 'selected'; endif; ?>>4</option>
                                <option value="5" <?php if(request()->input('doors') == 5): echo 'selected'; endif; ?>>5</option>
                                <option value="6" <?php if(request()->input('doors') == 6): echo 'selected'; endif; ?>>6</option>
                                
                              </select>

                             
                            </div>
                       
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
               </div>
               <hr/>
               <?php endif; ?>
              
              
                <?php if($category_filters && in_array('seat_count' , $category_filters)): ?>
                
              <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        <?php echo e(__('Seat count')); ?>

                      </button>
                    </h5>
                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                             <div class="col-6 float-start custom_col"> 
                              <select class="form-select form-control" onchange="updateUrl()" name="seat_min">
                                <option value=""><?php echo e(__('Min')); ?></option>
                               <option value="2" <?php if(request()->input('seat_min') == 2): echo 'selected'; endif; ?>>2</option>
                                <option value="3" <?php if(request()->input('seat_min') == 3): echo 'selected'; endif; ?>>3</option>
                                <option value="4" <?php if(request()->input('seat_min') == 4): echo 'selected'; endif; ?>>4</option>
                                <option value="5" <?php if(request()->input('seat_min') == 5): echo 'selected'; endif; ?>>5</option>
                                <option value="6" <?php if(request()->input('seat_min') == 6): echo 'selected'; endif; ?>>6</option>
                                <option value="7" <?php if(request()->input('seat_min') == 7): echo 'selected'; endif; ?>>7</option>
                                <option value="8" <?php if(request()->input('seat_min') == 8): echo 'selected'; endif; ?>>8</option>
                              </select>

                             
                            </div>
                        <div class="col-6 float-end custom_col">
                        <select class="form-select form-control" onchange="updateUrl()" name="seat_max">
                                <option value=""><?php echo e(__('Max')); ?></option>
                              <option value="2" <?php if(request()->input('seat_max') == 2): echo 'selected'; endif; ?>>2</option>
                                <option value="3" <?php if(request()->input('seat_max') == 3): echo 'selected'; endif; ?>>3</option>
                                <option value="4" <?php if(request()->input('seat_max') == 4): echo 'selected'; endif; ?>>4</option>
                                <option value="5" <?php if(request()->input('seat_max') == 5): echo 'selected'; endif; ?>>5</option>
                                <option value="6" <?php if(request()->input('seat_max') == 6): echo 'selected'; endif; ?>>6</option>
                                <option value="7" <?php if(request()->input('seat_max') == 7): echo 'selected'; endif; ?>>7</option>
                                <option value="8" <?php if(request()->input('seat_max') == 8): echo 'selected'; endif; ?>>8</option>
                              </select>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr/>
                  <?php endif; ?>
                  
                   <!-- Car filters end here -->
                    <!-- Seller Type -->
                  <div class="widget widget-select p-0 mb-20 us">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        <?php echo e(__('Seller Type')); ?>

                      </button>
                    </h5>
                    <?php
                    $classSs= '';
                    $classWw= '';
                    $classWr = '';
                    
                    if(request()->input('dealertype') == 'any')
                    {
                        $classSs ='active';
                    }
                    else if(request()->input('dealertype') == 'dealer') 
                    {
                        $classWr ='active';
                    }
                    else if(request()->input('dealertype') == 'private') 
                    {
                        $classWw ='active';
                    }
                    ?>
                    
                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                             <div class="col-4 float-start"float-start> 
                              <input type="hidden" id="seller_type"  name="stype" value="">
                                <button name="sellertype"  value="any" type="button" class="cumButton<?php echo e($classSs); ?> us_delr_type w-100 custom_btn" ><?php echo e(__('Any')); ?></button>
                             </div>
                            <input type="hidden" id="ad_dealer"  name="dealertype" value="<?php echo e(request()->filled('dealertype') ? request()->input('dealertype') : 'any'); ?>">
                            <div class="col-4 float-end">
                              <button type="button" class="cumButton<?php echo e($classWr); ?>  us_delr_type w-100 custom_btn" value="dealer" ><?php echo e(__('Dealer')); ?></button>
                            </div>
                             <div class="col-4 float-end">
                             <button type="button" class="cumButton<?php echo e($classWw); ?>  us_delr_type w-100 custom_btn" value="private" ><?php echo e(__('Private')); ?></button>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr/>
                  <!-- Aad Type -->
                  
                  <?php if($category->id != '347'): ?>
                  
                  <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        <?php echo e(__('Ad Type')); ?> 
                      </button>
                    </h5>
                    <?php
                    
                    $classS= '';
                    
                    $classW= '';
                    
                    if(request()->input('adtype') == 'sale')
                    {
                        $classS ='active';
                    }
                    else if(request()->input('adtype') == 'wanted') 
                    {
                        $classW ='active';
                    }
                    
                    ?>
                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                             <div class="col-6 float-start custom_col"float-start> 
                                <input type="hidden" id="ad_type"  name="adtype" value="<?php echo e(request()->filled('adtype') ? request()->input('adtype') : ''); ?>">
                                <button id="adtypeSale"  value="sale" type="button" class="cumButton<?php echo e($classS); ?> w-100 "><?php echo e(__('For Sale')); ?></button>
                            </div>
                            
                            <div class="col-6 float-end custom_col">
                                 <button id="adtypeWanted"  value="wanted" type="button" class="cumButton<?php echo e($classW); ?> w-100 " ><?php echo e(__('Wanted')); ?></button>
                            </div>
                            
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr/>
                  <?php endif; ?>
                  
                  
                   <?php if( !empty($filters)): ?>
                
                 <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 
                 <?php
                   $key = str_replace('::'.$filter->type , '' ,  $key);
                 ?>
                    <div class="widget widget-select p-0 mb-20">
                        <h5 class="title mb-3">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#location"
                            aria-expanded="true" aria-controls="location">
                            <?php echo e($key); ?>

                            </button>
                        </h5>
                        
                        <?php if($filter->type == 'select' && !empty($filter->form_options) ): ?>
                        <div id="location" class="collapse show">
                            <div class="accordion-body scroll-y">
                                <div class="row gx-sm-3">
                                    <div class="col-12">
                                         <div class="form-group" style="padding:10px 0px;">
                                             <div class="col-12 float-start"> 
                                                  <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()"  name="filters_select_<?php echo e(strtolower(str_replace(' ' , '_' , $key ))); ?>">
                                                    <option value="">Choose Option</option>
                                                        <?php $__currentLoopData = $filter->form_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form_option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($form_option->value); ?>" ><?php echo e($form_option->value); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php elseif($filter->type == 'radio' && !empty($filter->form_options) ): ?>
                        <div id="location" class="collapse show">
                            <div class="accordion-body scroll-y">
                                <div class="row gx-sm-3">
                                    <div class="col-12">
                                         <div class="form-group" style="padding:10px 0px;">
                                             <div class="col-12 float-start"> 
                                                 <div class="row">
                                                        <?php $__currentLoopData = $filter->form_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form_option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="col-md-6">
                                                               <input type="radio" name="filters_radio_<?php echo e(strtolower(str_replace(' ' , '_' , $key ))); ?>" onchange="updateUrl()" value="<?php echo e($form_option->value); ?>" />  &nbsp;  <b ><?php echo e($form_option->value); ?></b>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php elseif($filter->type == 'checkbox' && !empty($filter->form_options)): ?>
                        <div id="location" class="collapse show">
                            <div class="accordion-body scroll-y">
                                <div class="row gx-sm-3">
                                    <div class="col-12">
                                         <div class="form-group" style="padding:10px 0px;">
                                             <div class="col-12 float-start"> 
                                                 <div class="row">
                                                        <?php $__currentLoopData = $filter->form_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form_option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="col-md-6">
                                                               <input type="checkbox" name="filters_checkbox_<?php echo e(strtolower(str_replace(' ' , '_' , $key ))); ?>[]" onchange="updateUrl()" value="<?php echo e($form_option->value); ?>" />  &nbsp;  <b ><?php echo e($form_option->value); ?></b>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <hr/>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </span>
            
                <!-----------------Filter Model ------------------->
                
                <div class="modal fade" id="saveSearchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index: 999;">
                    
                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                        
                        <div class="modal-content">
                         
                          <div class="modal-body">
                              
                            <div class="alert alert-success" role="alert" style="display:none;" id="alertSuccess">
                                 Your Searches has been saved!
                            </div>

                            <h5 style="margin-bottom: 1rem;margin-top: 1rem;"><i class="fal fa-star fa-lg" style="color: orange;" ></i> &nbsp; Save this search</h5>
                            
                                <label class="mb-2">Name Your Search</label>
                                
                                <input type=text name="save_search_name" required id="save_search_name" class="form-control" />
                                
                                <input type="hidden" name="search_url" value="" id="search_url" /> 
                                
                                <div style="margin-top: 1rem;background: #f1f1f1;padding: 1rem;border-radius: 7px;">
                                
                                <label class="mb-2">How you want to get notify for this search?</label>
                                
                                <p>
                                    <input type="radio" name="alertType" value="2" required /> <span style="font-size: 13px;font-weight: 600;font-family: sans-serif;"> Yes, daily alert</span>
                                </p>
                                
                                <p>
                                    <input type="radio" name="alertType" value="1"  required /> <span style="font-size: 13px;font-weight: 600;font-family: sans-serif;"> Yes, instant alert</span>
                                </p>
                                
                                <p>
                                    <input type="radio" name="alertType" value="0"  required /> <span style="font-size: 13px;font-weight: 600;font-family: sans-serif;"> No alert</span>
                                </p>
                                
                            </div>
                          </div>
                          
                          <div class="modal-footer" style="">
                            <button type="button" style="background: transparent !important;border: 1px solid gray !important;color: gray;padding-left: 1.9rem;padding-right: 1.9rem;" class="btn btn-secondary" onclick="closeSaveModal()" >Cancel</button>
                            <button type="button" class="btn btn-info" id="searchFormBtn" style="background: #0000c1 !important;color: white;" onclick="saveSearch()">Save Search</button>
                            
                          </div>
                        </div>
                    </div>
                </div>
                
                <!-------------END--------------------------------->
               
         
            </div>
            <script>
$(document).ready(function() {
    // Store all the original options of max year dropdown
    var $yearMax = $('#mileage_max');
    var originalOptions = $yearMax.find('option').clone();

    $('#mileage_min').change(function() {
        var selectedMinYear = parseInt($(this).val());

        // Reset max year dropdown
        $yearMax.empty().append('<option value=""><?php echo e(__('Max ')); ?></option>');

        // Filter and add options greater than the selected min year
        originalOptions.filter(function() {
            var yearValue = parseInt($(this).val());
            return yearValue === "" || yearValue > selectedMinYear;
        }).appendTo($yearMax);

        // Trigger change event on max year dropdown to update any dependent elements
        $yearMax.trigger('change');
    });
});

  // year limit min max             
  $(document).ready(function() {
    // Store all the original options of max year dropdown
    var $yearMax = $('#year_max');
    var originalOptions = $yearMax.find('option').clone();

    $('#year_min').change(function() {
        var selectedMinYear = parseInt($(this).val());

        // Reset max year dropdown
        $yearMax.empty().append('<option value=""><?php echo e(__('Max Year')); ?></option>');

        // Filter and add options greater than the selected min year
        originalOptions.filter(function() {
            var yearValue = parseInt($(this).val());
            return yearValue === "" || yearValue > selectedMinYear;
        }).appendTo($yearMax);

        // Trigger change event on max year dropdown to update any dependent elements
        $yearMax.trigger('change');
    });
});


function formatCurrency(number) {
    return '£' + new Intl.NumberFormat('en-GB', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(number);
}
// format and limit min price 
$(document).ready(function() {
    // Function to format number as currency without symbol
    function formatCurrency(number) {
        return new Intl.NumberFormat('en-GB', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }

    // Store all the original options of max price dropdown
    var $priceMax = $('#max');
    var originalOptions = $priceMax.find('option').clone();

    // Format initial options
    $('#min option, #max option').each(function() {
        var value = $(this).val();
        if (value !== "") {
            $(this).text(formatCurrency(parseInt(value)));
        }
    });

    $('#min').change(function() {
        var selectedMinPrice = parseInt($(this).val());
        $priceMax.empty().append('<option value=""><?php echo e(__('Max Price')); ?></option>');
        originalOptions.filter(function() {
            var priceValue = parseInt($(this).val());
            return priceValue === "" || priceValue > selectedMinPrice;
        }).each(function() {
            var $option = $(this).clone();
            if ($option.val() !== "") {
                $option.text(formatCurrency(parseInt($option.val())));
            }
            $option.appendTo($priceMax);
        });
        $priceMax.trigger('change');
    });
});
            </script><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/car/carfilter.blade.php ENDPATH**/ ?>