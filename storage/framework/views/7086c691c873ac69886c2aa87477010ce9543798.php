<div class="autocomplete-suggestions">
    <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="autocomplete-suggestion pt-2 pb-2"><?php echo e($searchTerm); ?> <a href="<?php echo e(route('frontend.cars', ['title' => $searchTerm, 'category'=>$car->category->slug])); ?>"> in <?php echo e($car->category->name); ?></a></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/home/autocomplete.blade.php ENDPATH**/ ?>