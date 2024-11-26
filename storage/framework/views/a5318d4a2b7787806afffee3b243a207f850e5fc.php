<?php
const url_params = ['/ads?type=list&type=pro',
                    '/ads?type=list&bodyType=SUV&bodyType=Van&bodyType=Estate&bodyType=MPV&seats_from=5',
                    '/ads?type=list&bodyType=Hatchback&bodyType=Coupe&price_to=20000&engine_to=1600&roadTax_to=300',
                    '/ads?type=list&fuelType=Electric&fuelType=Hybrid',
                    '/ads?type=list&make=Audi&make=BMW&make=Mercedes-Benz&sellerType=pro&price_from=50000',
                    '/ads?type=list&fuelType=Petrol&fuelType=Electric&fuelType=Hybrid&bodyType=Hatchback&engine_to=1600&seats_to=5'
                     ]
?>



<!--- start Browse cars by lifestyle  ---->       
<section class="px-5 px-sm-5 px-lg-5 bg-red pt-20 pb-20 pt-sm-40 pb-sm-40 mt-sm-4  ">

    <div class="d-flex flex-sm-row flex-column justify-content-between align-items-center mb-3 px-1 px-sm-4">
        <div>
            <h6  class="browseCars">What are you looking for in your new car?</h6>
        </div>
        <div class="d-flex gap-2" >
            <div>
            <button id="prev-btn" class="prevBtn" disabled>
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M17 2L7 12l10 10"></path>
                </svg>
            </button>
</div>
            <div>
            <button class="nextBtn" id="next-btn">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M7 2l10 10L7 22"></path>
                </svg>
            </button>
        </div>
        </div>
    </div>
    
        
        <!-- boxes container start -->
        <div class="car-container" id="car-container">
            
            <?php $__currentLoopData = $browse_by_lifestyle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
             $url = url_params[$key] ?? '#';
            ?>
        <a href="<?php echo e($url); ?>" class="browser_by_lifestyle"
         data-cat="<?php echo e($value->custom_cat); ?>">
            <div class="car-box">
                <div class="d-flex justify-content-center align-items-center" style="height: 101px; width: 100%;">
                    <img width="180px" class="" 
                    src="<?php echo e('assets/img/'. $value->image_path); ?>" 
                         alt="First Car"></img>
                </div>
                <div class="text-center pt-10 pb-1" style="font-size: 16px; font-weight: 600;"><?php echo e($value->title); ?></div>
                <div class="text-center carsNumber" style="font-size: 14px; font-weight: 400;" data-carsNumbers="<?php echo e($value->car_count); ?>"><?php echo e($value->car_count); ?></div>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <!-- boxes container end -->
</section>
<!--- end Browse cars by lifestyle  ---->

<script>
    const nextBtn = document.getElementById('next-btn');
    const prevBtn = document.getElementById('prev-btn');
    const carContainer = document.getElementById('car-container');
    const carBoxes = document.querySelectorAll('.car-box');
    const boxWidth = carBoxes[0].offsetWidth + 10; 
    const style='background: transparent; cursor: not-allowed;'
    let scrollPosition = 0;
    function updateButtonState() {
        if (scrollPosition <= 0) {
            prevBtn.disabled = true;
            prevBtn.style= style;
        } else {
            prevBtn.disabled = false;
        }
        
        if (scrollPosition >= carContainer.scrollWidth - carContainer.offsetWidth) {
            console.log(scrollPosition, "scrollPosition")
            nextBtn.disabled = true;

            prevBtn.style= style;
        } else {
            nextBtn.disabled = false;
        }
    }
    nextBtn.addEventListener('click', () => {
        scrollPosition += boxWidth;
        carContainer.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
        });
        updateButtonState();
    });
    prevBtn.addEventListener('click', () => {
        scrollPosition -= boxWidth;
        carContainer.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
        });
        updateButtonState();
    });
    updateButtonState();


    setTimeout(() => {
    function formatCurrency(number) {
        return new Intl.NumberFormat('en-GB', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }

    function formatAllPrices() {
        $('.carsNumber').each(function() { // Use class selector instead of ID
            var priceElement = $(this);
            var price = parseFloat(priceElement.data('carsnumbers')); // Corrected attribute name (case-sensitive)
            
            // Check if the price is valid
            if (!isNaN(price)) {
                priceElement.text(formatCurrency(price));
            } else {
                priceElement.text('Invalid number'); // Handle invalid number gracefully
            }
        });
    }

    formatAllPrices();
}, 1000);

</script>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/home/browseBycars.blade.php ENDPATH**/ ?>