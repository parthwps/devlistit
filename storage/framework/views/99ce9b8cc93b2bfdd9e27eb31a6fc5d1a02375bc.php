<div class="row " >
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
       
            <?php if($category->children->isNotEmpty()): ?>
             <div class="col-md-12 mb-30 " >
                 <b> <a href="<?php echo e(route('frontend.cars' , ['category' => $category->slug])); ?>"><?php echo e($category->name); ?></a></b>
                </div>
            <?php else: ?>
             <div class="col-md-3 mb-10">
               <a href="<?php echo e(route('frontend.cars' , ['category' => $category->slug])); ?>"><?php echo e($category->name); ?></a>
                 </div>
            <?php endif; ?>
       
            <?php if($category->children->isNotEmpty()): ?>
                    <?php echo $__env->make('frontend.car.category-list', ['categories' => $category->children], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

          
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/car/category-list.blade.php ENDPATH**/ ?>