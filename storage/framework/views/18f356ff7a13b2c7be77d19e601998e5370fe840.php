<div class="autocomplete-suggestions suggestionbox">
<div class="autocomplete-suggestion pt-2 pb-2" style="border-bottom:1px solid #e8e8e8;"><i class="fal fa-search"></i> My Last Search<br>
<?php
                        $lSearch = array();
                        if (Auth::guard('vendor')->check()){
                            $lastSearch = App\Models\Car\CustomerSearch::where('customer_id', Auth::guard('vendor')->user()->id)->first();
                            if($lastSearch){
                            $lSearch = $lastSearch->customer_filters;
                            }
                        } elseif(session()->has('lastSearch')) { 
                            $lSearch = Session::get('lastSearch');
                        }
                     ?>
                     <?php if(!empty($lSearch)): ?>
                     
                     <a style="font-size:11px;" href="ads?<?php echo e(http_build_query(json_decode($lSearch))); ?>">
                                  <?php $__currentLoopData = json_decode($lSearch); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <?php if($key!='_token'): ?>
                                  <?php if(!is_array($value)): ?>
                                    <?php echo e(Str::slug($value, ' ')); ?> <small style="font-size:9px;">-></small>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </a>
                     <?php endif; ?>   </div>

<!-- <div class="autocomplete-suggestion pt-2 pb-2"><a href="<?php echo e(route('frontend.cars', ['category'=>'cars'])); ?>"><i class="fal fa-check"></i> &nbsp;Cars from Trusted Dealerships  <b>in Cars</b></a></div>
<div class="autocomplete-suggestion pt-2 pb-2"><a href="<?php echo e(route('frontend.cars', ['category'=>'cars'])); ?>"><i class="fal fa-check"></i> &nbsp;Cars with a Warranty  <b>in Cars</b></a></div>
<div class="autocomplete-suggestion pt-2 pb-2"><a href="<?php echo e(route('frontend.cars', ['category'=>'cars'])); ?>"><i class="fal fa-check"></i> &nbsp;Cars with Greenlight History Check  <b>in Cars</b></a></div>
<div class="autocomplete-suggestion pt-2 pb-2"> <a href="<?php echo e(route('frontend.cars', ['category'=>'cars'])); ?>"><i class="fal fa-check"></i> &nbsp;Cars with Finance  <b>in Cars</b></a></div>
<div class="autocomplete-suggestion pt-2 pb-2"><a href="<?php echo e(route('frontend.cars', ['category'=>'cars'])); ?>"><i class="fal fa-check"></i> &nbsp; New Cars  <b>in Cars</b></a></div> -->

</div>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/home/autocompletefilled.blade.php ENDPATH**/ ?>