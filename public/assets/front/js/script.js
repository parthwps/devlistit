!(function($) {
    "use strict";

    /*============================================
        Mobile menu
    ============================================*/



    /*============================================
        Navlink active class
    ============================================*/
    var a = $("#mainMenu .nav-link"),
        c = window.location;
    for (var i = 0; i < a.length; i++) {
        const el = a[i];

        if (el.href == c) {
            el.classList.add("active");
        }
    }

    /*============================================
        Sticky header
    ============================================*/
    $(window).on("scroll", function() {
        var header = $(".header-area");
        // If window scroll down .is-sticky class will added to header
        if ($(window).scrollTop() >= 100) {
            header.addClass("is-sticky");
        } else {
           // header.removeClass("is-sticky");
        }
    });


    /*============================================
        Password icon toggle
    ============================================*/
    $(".show-password-field").on("click", function() {
        var showIcon = $(this).children(".show-icon");
        var passwordField = $(this).prev("input");
        showIcon.toggleClass("show");
        if (passwordField.attr("type") == "password") {
            passwordField.attr("type", "text")
        } else {
            passwordField.attr("type", "password");
        }
    })


    /*============================================
        Image to background image
    ============================================*/
    var bgImage = $(".bg-img")
    bgImage.each(function() {
        var el = $(this),
            src = el.attr("data-bg-image");

        el.css({
            "background-image": "url(" + src + ")",
            "background-size": "cover",
            "background-position": "center",
            "display": "block"
        });
    });

    /*============================================
    Price range
    ============================================*/
    var range_slider_max = document.getElementById('min');
    if (range_slider_max) {
        var sliders = document.querySelectorAll("[data-range-slider='priceSlider']");
        var filterSliders = document.querySelector("[data-range-slider='filterPriceSlider']");
        var input0 = document.getElementById('min');
        var input1 = document.getElementById('max');
        var min = document.getElementById('min').value;
        var max = document.getElementById('max').value;

        var o_min = document.getElementById('o_min').value;
        var o_max = document.getElementById('o_max').value;

        var currency_symbol = document.getElementById('currency_symbol').value;
        var min = parseFloat(min);
        var max = parseFloat(max);

        var o_min = parseFloat(o_min);
        var o_max = parseFloat(o_max);
        var inputs = [input0, input1];
        // Home price slider
        for (let i = 0; i < sliders.length; i++) {
            const el = sliders[i];

            noUiSlider.create(el, {
                start: [min, max],
                connect: true,
                step: 10,
                margin: 0,
                range: {
                    'min': o_min,
                    'max': o_max
                }
            }), el.noUiSlider.on("update", function(values, handle) {
                $("[data-range-value='priceSliderValue']").text(currency_symbol + values.join(" - " + currency_symbol));

                inputs[handle].value = values[handle];
            })
        }
        // Filter frice slider
        if (filterSliders) {
            var currency_symbol = document.getElementById('currency_symbol').value;
            noUiSlider.create(filterSliders, {

                start: [min, max],
                connect: !0,
                step: 10,
                margin: 40,
                range: {
                    'min': o_min,
                    'max': o_max
                }
            }), filterSliders.noUiSlider.on("update", function(values, handle) {
                $("[data-range-value='filterPriceSliderValue']").text(currency_symbol + values.join(" - " + currency_symbol));

                inputs[handle].value = values[handle];
            }), filterSliders.noUiSlider.on("change", function(values, handle) {
                updateUrl();
            })

            inputs.forEach(function(input, handle) {
                if (input) {
                    input.addEventListener('change', function() {
                        filterSliders.noUiSlider.setHandle(handle, this.value);
                    });
                }
            });
        }
    }


    /*============================================
        Sidebar toggle
    ============================================*/
    $(".category-toggle").on("click", function(t) {
        var i = $(this).closest("li"),
            o = i.find("ul").eq(0);

        if (i.hasClass("open")) {
            o.slideUp(300, function() {
                i.removeClass("open")
            })
        } else {
            o.slideDown(300, function() {
                i.addClass("open")
            })
        }
        t.stopPropagation(), t.preventDefault()
    })


    /*============================================
        Sliders
    ============================================*/

    // Home Slider 1
    var homeSlider1 = new Swiper("#home-slider-1", {
        loop: true,
        speed: 1000,
        grabCursor: true,
        parallax: true,
        slidesPerView: 1,

        // Navigation arrows
        navigation: {
            nextEl: '#home-slider-1-next',
            prevEl: '#home-slider-1-prev',
        },

        pagination: {
            el: '#home-slider-1-pagination',
            clickable: false,
            renderBullet: function(index, className) {
                return '<span class="' + className + '">' + "0" + (index + 1) + "</span>";
            },
        },
    });
    var homeImageSlider1 = new Swiper("#home-img-slider-1", {
        loop: true,
        speed: 1000,
        grabCursor: true,
        slidesPerView: 1
    });
    // Sync both slider
    homeImageSlider1.controller.control = homeSlider1;
    homeSlider1.controller.control = homeImageSlider1;

    // Home Slider 2
    var homeSlider2 = new Swiper("#home-slider-2", {
        loop: true,
        speed: 1000,
        slidesPerView: 1,
        effect: "fade",
        fadeEffect: {
            crossFade: true
        },
        allowTouchMove: false
    });
    var homeImageSlider2 = new Swiper("#home-img-slider-2", {
        loop: true,
        speed: 1000,
        grabCursor: true,
        slidesPerView: 1,
        autoplay: true,
        pagination: {
            el: "#home-img-slider-2-pagination",
            clickable: true,
        },
    });
    // Sync both slider
    homeImageSlider2.controller.control = homeSlider2;

    // Home Slider 3
    var homeSlider3 = new Swiper("#home-slider-3", {
        loop: true,
        speed: 1000,
        slidesPerView: 1,
        effect: "fade",
        fadeEffect: {
            crossFade: true
        },
        allowTouchMove: false
    });
    var homeImageSlider3 = new Swiper("#home-img-slider-3", {
        loop: true,
        speed: 1000,
        grabCursor: true,
        slidesPerView: 1,
        autoplay: true,
        pagination: {
            el: "#home-img-slider-3-pagination",
            clickable: true,
        },
    });
    // Sync both slider
    homeImageSlider3.controller.control = homeSlider3;

    // Testimonial Slider
    var testimonialSlider1 = new Swiper("#testimonial-slider-1", {
        speed: 400,
        spaceBetween: 25,
        loop: true,
        slidesPerView: 2,

        // Navigation arrows
        navigation: {
            nextEl: '#testimonial-slider-btn-next',
            prevEl: '#testimonial-slider-btn-prev',
        },

        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1
            },
            // when window width is >= 400px
            768: {
                slidesPerView: 2
            }
        }
    });
    var testimonialSlider2 = new Swiper("#testimonial-slider-2", {
        speed: 400,
        spaceBetween: 25,
        loop: true,
        slidesPerView: 1,
        pagination: {
            el: "#testimonial-slider-2-pagination",
            clickable: true,
        },
    });

    // Shop single slider
    var proSingleThumb = new Swiper(".slider-thumbnails", {
        loop: true,
        speed: 1000,
        spaceBetween: 20,
        slidesPerView: 3,
        breakpoints: {
            0: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            576: {
                slidesPerView: 4,
                spaceBetween: 15,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
        }
    });

var proSingleSlider = new Swiper(".product-single-slider", {
    loop: false, // Disable loop as per requirement
    speed: 1000, // Transition speed between slides
    autoplay: {
        enabled: false, // Disable autoplay
    },
    watchSlidesProgress: false,
    thumbs: {
        swiper: proSingleThumb, // Thumbnail swiper configuration
    },
    navigation: {
        nextEl: ".slider-btn-next", // Selector for next slide button
        prevEl: ".slider-btn-prev", // Selector for previous slide button
    },
    on: {
        init: function () {
            // Enable the previous button on init
            const prevButton = document.querySelector(".slider-btn-prev");
            prevButton.disabled = false;

            numberSlides.innerHTML = (this.activeIndex + 1) + '/' + this.slides.length + ' <i class="fa fa-camera" aria-hidden="true"></i>';
        },
        slideChange: function () {
            numberSlides.innerHTML = (this.activeIndex + 1) + '/' + this.slides.length + ' <i class="fa fa-camera" aria-hidden="true"></i>';
        },
        reachEnd: function () {
            let swiperInstance = this;
            const nextButton = document.querySelector(".slider-btn-next");

            // Re-enable the next button in case it gets disabled
            nextButton.disabled = false;

            nextButton.addEventListener('click', function () {
                // If we're on the last slide, reset to the first slide
                if (swiperInstance.activeIndex === swiperInstance.slides.length - 1) {
                    swiperInstance.slideTo(0); // Manually move to the first slide
                }
            });
        },
        slideChangeTransitionEnd: function () {
            const nextButton = document.querySelector(".slider-btn-next");
            const prevButton = document.querySelector(".slider-btn-prev");

            // Make sure both the next and previous buttons are always enabled after a transition
            nextButton.disabled = false;
            prevButton.disabled = false;
        }
    }
});

// Ensure the Swiper instance and the navigation buttons are available before attaching event listeners
if (document.querySelector(".slider-btn-prev") && proSingleSlider) {
    const prevButton = document.querySelector(".slider-btn-prev");

    prevButton.addEventListener('click', function () {
        // Check if we're on the first slide
        if (proSingleSlider.activeIndex === 0) {
            proSingleSlider.slideTo(proSingleSlider.slides.length - 1); // Move to the last slide
        }
    });
}





    // Category Slider
    $(".category-slider").each(function() {
        var id = $(this).attr("id");
        var sliderId = "#" + id;

        var swiper = new Swiper(sliderId, {
            speed: 400,
            spaceBetween: 25,
            loop: true,
            slidesPerView: 3,

            // Navigation arrows
            navigation: {
                nextEl: sliderId + "-next",
                prevEl: sliderId + "-prev",
            },

            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                576: {
                    slidesPerView: 3
                },
            }
        })
    })

    var catSlider2 = new Swiper(".category-slider-2", {
        speed: 400,
        spaceBetween: 25,
        loop: true,
        slidesPerView: 3,

        // Navigation arrows
        navigation: {
            nextEl: "#category-slider-2-next",
            prevEl: "#category-slider-2-prev",
        },

        breakpoints: {
            320: {
                slidesPerView: 1
            },
            576: {
                slidesPerView: 3
            },
            992: {
                slidesPerView: 2
            },
            1440: {
                slidesPerView: 3
            },
        }
    })

    // Product Slider
    $(".product-slider").each(function() {
        var id = $(this).attr("id");
        var sliderId = "#" + id;

        var swiper = new Swiper(sliderId, {
            speed: 400,
            spaceBetween: 25,
            loop: true,
            slidesPerView: 3,

            // Navigation arrows
            navigation: {
                nextEl: sliderId + "-next",
                prevEl: sliderId + "-prev",
            },

            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                1200: {
                    slidesPerView: 3
                },
            }
        })
    })


    /*============================================
        Product single popup
    ============================================*/
// Initialize Magnific Popup with dynamic thumbnail extraction
// Initialize Magnific Popup with dynamic thumbnail extraction
$(".lightbox-single").magnificPopup({
    type: "image",
    mainClass: 'mfp-with-zoom',
    gallery: {
        enabled: true
    },
    items: function() {
        // Collect all unique gallery images into an array
        var items = [];
        var seenImages = new Set();  // To track unique images
        document.querySelectorAll('.swiper-slide img').forEach(function(slide) {
            var imgSrc = slide.getAttribute('data-src') || slide.src;
            if (!seenImages.has(imgSrc)) {  // Check if image has already been added
                seenImages.add(imgSrc);  // Mark this image as seen
                items.push({
                    src: imgSrc
                });
            }
        });
        return items;
    }(),
    callbacks: {
        open: function() {
            // Clear any existing thumbnails to avoid duplication
            $('.mfp-thumbnails').remove();

            // Inject the thumbnails into the popup
            var thumbnailHtml = '<div class="mfp-thumbnails" style="position: fixed; right: 0;  z-index: 9999; height: 120px; display: flex; flex-direction: row; overflow-x: auto; overflow-y: hidden;">';
            var items = $.magnificPopup.instance.items; // Access the items from Magnific Popup

            items.forEach(function(item, index) {
                thumbnailHtml += '<img class="mfp-thumb mfp-prevent-close" src="' + item.src + '" data-index="' + index + '" style="width: 100px; height: auto; cursor: pointer; margin: 10px; display: block;">';
            });

            thumbnailHtml += '</div>';

            $('.mfp-content').append(thumbnailHtml);

            // Thumbnail click event to update the main image
            $('.mfp-thumb').on('click', function() {
                var clickedIndex = $(this).data('index');
                $.magnificPopup.instance.goTo(clickedIndex);  // Directly navigate to the clicked image
            });
        },
        close: function() {
            // Remove the thumbnails when closing the popup
            $('.mfp-thumbnails').remove();
        }
    }
});



    /*============================================
        Youtube popup
    ============================================*/
    $(".youtube-popup").magnificPopup({
        disableOn: 300,
        type: "iframe",
        mainClass: "mfp-fade",
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    })


    /*============================================
        Go to top
    ============================================*/
    $(window).on("scroll", function() {
        // If window scroll down .active class will added to go-top
        var goTop = $(".go-top");

        if ($(window).scrollTop() >= 200) {
            goTop.addClass("active");
        } else {
            goTop.removeClass("active")
        }
    })
    $(".go-top").on("click", function(e) {
        $("html, body").animate({
            scrollTop: 0,
        }, 0);
    });


    /*============================================
        Lazyload image
    ============================================*/
    var lazyLoad = function() {
        window.lazySizesConfig = window.lazySizesConfig || {};
        window.lazySizesConfig.loadMode = 2;
        lazySizesConfig.preloadAfterLoad = true;
    }

    /*============================================
        Odometer
    ============================================*/
    $(".counter").counterUp({
        delay: 10,
        time: 1000
    });


    /*============================================
        Nice select
    ============================================*/
    $(".nice-select").niceSelect();

    var selectList = $(".nice-select .list")
    $(".nice-select .list").each(function() {
        var list = $(this).children();
        if (list.length > 5) {
            $(this).css({
                "height": "160px",
                "overflow-y": "scroll"
            })
        }
    })


    /*============================================
        Sidebar scroll
    ============================================*/
    $(document).ready(function() {
        $(".widget").each(function() {
            var child = $(this).find(".accordion-body.scroll-y");
            if (child.height() >= 245) {
                child.css({
                    "padding-inline-end": "10px",
                })
            }
        })
    })


    /*============================================
        Data tables
    ============================================*/
    var dataTable = function() {
        var dTable = $("#myTable");

        if (dTable.length) {
            dTable.DataTable({
                ordering: false,
            })
        }
    }


    /*============================================
        Tabs mouse hover animation
    ============================================*/
    $("[data-hover='fancyHover']").mouseHover();


    /*============================================
        Image upload
    ============================================*/
    var fileReader = function(input) {
        var regEx = new RegExp(/\.(gif|jpe?g|tiff?|png|webp|bmp)$/i);
        var errorMsg = $("#errorMsg");

        if (input.files && input.files[0] && regEx.test(input.value)) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            errorMsg.html("Please upload a valid file type")
        }
    }
    $("#imageUpload").on("change", function() {
        fileReader(this);
    });


    /*============================================
        Cookiebar
    ============================================*/
    window.setTimeout(function() {
        $(".cookie-bar").addClass("show")
    }, 1000);
    $(".cookie-bar .btn").on("click", function() {
        $(".cookie-bar").removeClass("show")
    });


    /*============================================
        Tooltip
    ============================================*/
    var tooltipTriggerList = [].slice.call($('[data-tooltip="tooltip"]'))

    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })


    /*============================================
        Footer date
    ============================================*/
    var date = new Date().getFullYear();
    $("#footerDate").text(date);


    /*============================================
      Read more toggle button
    ============================================*/
    $(".read-more-btn").on("click", function() {
        $(this).prev().toggleClass('show');

        if ($(this).prev().hasClass("show")) {
            $(this).text(read_less);
        } else {
            $(this).text(read_more);
        }
    })

    /*============================================
      Toggle List
    ============================================*/
    $("#toggleList").each(function(i) {
        var list = $(this).children();
        var listShow = $(this).data("toggle-show");
        var listShowBtn = $(this).next("[data-toggle-btn]");

        if (list.length > listShow) {
            listShowBtn.show()
            list.slice(listShow).toggle(300);

            listShowBtn.on("click", function() {
                list.slice(listShow).slideToggle(300);

                $(this).prev().toggleClass('show');
                if ($(this).prev().hasClass("show")) {
                    $(this).text(show_less);
                } else {
                    $(this).text(show_more);
                }
            })
        } else {
            listShowBtn.hide()
        }
    })


    /*============================================
        Document on ready
    ============================================*/
    $(document).ready(function() {
        lazyLoad()
        dataTable()
    })

    $('.car_condition').on('click', function() {
        $('.condition').val($(this).attr('data-id'));
        let mainCatID = $(this).attr('data-id');
        let carfilteronAjax = $(this).attr('data-cars-filter');
    $(".hero-banner.hero-banner-2").css("background-image", 'url(/assets/img/'+$(this).attr('data-image')+')');
    if(mainCatID == 39 || mainCatID == 0 || mainCatID == 28)
    {
        if(mainCatID == 39)
        {
            $('#tabsCat').val("property");
        }

        if(mainCatID == 28)
        {
            $('#tabsCat').val("farming");
        }


        if(mainCatID == 0){
            $('#tabsCat').val("");
            }
       $('.carform').hide();
       $('.carformtxt').show();
    }else if(mainCatID == 24){
        $('#tabsCat').val("cars-&-motors");
        $('.carform').show();
        $('.carformtxt').hide();

    }

    let formURL = '/tabs-data/'+$(this).attr('data-id');
    let formMethod = "GET";

       $.ajax({
        url: formURL,
        method: formMethod,
        dataType: 'json',
        success: function(response) {
            //$('input[name="email_id"]').val('');
            $('.tabsHtmlData').html(response.data);
            if(carfilteronAjax == 1){
                $('#filterCSS0').css('filter', 'none');
                $('#filterCSS23').css('filter', 'none');
            }
            if(mainCatID == 0){
                console.log(mainCatID , 'carfilteronAjax')
                $('#filterCSS2').css('filter', 'none');
                $('#filterCSS10').css('filter', 'none');
                $('#filterCSS12').css('filter', 'none');
            }
            if(mainCatID == 28){
                let ids = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16];//market place icons id
                $.each(ids, function(index, value) {
                        $('#filterCSS' + value).css('filter', 'none');
                    });
            }
            $('.car-button').on('click', function() {
                console.log("click here farah ----")
                $('#filterCSS23').css('filter', 'none'); // Remove the filter
            });
        },
        error: function(errorData) {
            // throw error -----
        }
    });


    })

})(jQuery);

$(window).on("load", function() {
    const delay = 350;

    /*============================================
    Preloader
    ============================================*/
    $("#preLoader").delay(delay).fadeOut('slow');

    /*============================================
        Aos animation
    ============================================*/
    var aosAnimation = function() {
        AOS.init({
            easing: "ease",
            duration: 1500,
            once: true,
            offset: 60,
            disable: 'mobile'
        });
    }
    if ($("#preLoader")) {
        setTimeout(() => {
            aosAnimation()
        }, delay);
    } else {
        aosAnimation();
    }
})


$('document').ready(function() {
    $('#car_brand').on('change', function() {
        let id = $(this).val();
        let route = $('#getModel').val();
        $('#model option').remove();
        $.ajax({
            url: route + '?id=' + id,
            type: 'GET',
            contentType: false,
            processData: false,
            success: function(data) {
                //$('#model').niceSelect('destroy');
                $('#model').empty();
                $('#model').append('<option value="">All</option>');
                $(data).each(function(index, value) {
                    $('#model').append('<option value="' + value.slug + '">' + value.name + '</option>');
                })
                // Initialize Select2 on the select element
               // $('#model').niceSelect();
                $('#model').attr('name', 'models[]');

            }
        });
    });

    $('.showLoader').on('click', function() {
        $('#preLoader').show();
    });
})

$('#userphonebutton').on('click', function() {
        $("#userphonebutton").html($('input[name="userphone"]').val());
});
$('#showform').on('click', function() {
       $('.contactForm').show();
       $(this).hide();
});


function maskPhoneNumber(phone) {
    // Replace all but the last 4 digits with asterisks
    let maskedPhone = phone.slice(0, -4).replace(/\d/g, '*') + phone.slice(-4);
    return maskedPhone;
}



$('#verifyPhone').on('click', function()
{
      let countryCode = $('input[name="c_code"]').val(); // Assuming you have a separate input field for the country code
    let phoneNumber = $('input[name="phone"]').val();


    let formURL = '/vendor/verify-phone/'+phoneNumber+'?code='+countryCode;

    let formMethod = "GET";
   // $('.mycode').html('We have send you a verification code to <strong>'+$('input[name="phone"]').val()+'</strong>, verify your phone number to get  extra trust merit on your profile!');


    //return false;

    $.ajax({
        url: formURL,
        type: "GET",


        success: function(response) {


            if(response.status == 'success'){
                $('#verifyProfilePhone').modal('show');
            // toastr[response.status]('Enter the code via text to <strong>'+maskPhoneNumber(response.phone)+'</strong> ')
            // toastr.options = {
            //     "closeButton": true,
            //     "progressBar": true,
            //     "timeOut ": 10000,
            //     "extendedTimeOut": 10000,
            //     "positionClass": "toast-top-right",
            // }
            $('#phonecode').hide();
            $('#verifycode').show();
            $('.mycode').html('We have sent you a verification code to <strong>'+maskPhoneNumber(response.phone)+'</strong>, Please verify your phone number.');
            $('#verifyProfilePhone').modal('show');
            } else {
            toastr[response.status]('Destination number <strong>'+maskPhoneNumber(response.phone)+'</strong> is invalid ')
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut ": 10000,
                "extendedTimeOut": 10000,
                "positionClass": "toast-top-right",
            }

        }
        },
        error: function(errorData) {
           // toastr['error'](errorData.responseJSON.error.email_id[0]);
        }
    });
});
/*****************************************************
==========TinyMCE initialization start==========
******************************************************/
$(".tinyMce").each(function(i) {

    tinymce.init({
        selector: '.tinyMce',
        plugins: 'preview importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media  table charmap  nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
        toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | charmap emoticons | fullscreen  preview print | insertfile image media link anchor | ltr rtl',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        promotion: false,
        mergetags_list: [{
                value: 'First.Name',
                title: 'First Name'
            },
            {
                value: 'Email',
                title: 'Email'
            },
        ]
    });

});

$(document).on('click', ".note-video-btn", function() {
    let i = $(this).index();

    if ($(".tinyMce").eq(i).parents(".modal").length > 0) {
        setTimeout(() => {
            $("body").addClass('modal-open');
        }, 500);
    }
});
/*****************************************************
==========TinyMCE initialization end==========
******************************************************/

/*=======================location search=====================
=============================================================*/


$('body').on('enter', '#topSearchForm', function(event) {
    if (event.which === 13) { // 13 is the keycode for 'Enter' key
        $('#topSearchForm').submit();
    }
});
// Autocomplete
$('body').on('keyup', '#searchByTitle', function(event){
    $("#suggesstion-box").show();

    let selectedCat = sessionStorage.getItem('tabCategory');

    if (selectedCat == null) {
        selectedCat = 'cars-&-motors';
    }
    if($(this).val() && $(this).val().length >2){

        $.ajax({
            type: "GET",
            url: "/autocomplete/suggestions",
            data: {
                keyword: $(this).val(),
                selectedCat : selectedCat,
            },
            beforeSend: function() {
                //$("#search-box").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(response) {
                $("#suggesstion-box").show();
                $("#suggesstion-box").html(response.data);
                //$("#search-box").css("background", "#FFF");
            }
        });
    }
});
// Autocomplete  top
$('body').on('keyup', '#searchByTitleTop', function(event){
   // $("#suggesstion-box").show();

    if($(this).val() && $(this).val().length >2){

        sessionStorage.setItem('tabCategory','all');
        $.ajax({
            type: "GET",
            url: "/autocomplete/suggestions",
            data: 'keyword=' + $(this).val(),
            beforeSend: function() {
                //$("#search-box").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(response) {
                //$("#suggesstion-box").show();
                $(".suggestionbox").html(response.data);
                //$("#search-box").css("background", "#FFF");
            }
        });
    } else{

        $.ajax({
            type: "GET",
            url: "/autocomplete/defaultsuggestions",
            data: 'keyword=',
            beforeSend: function() {
                //$("#search-box").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(response) {
                $(".suggestionbox").html(response.data);
                //$("#search-box").css("background", "#FFF");
            }
        });

    }
});
$('body').on('focus', '#searchByTitle', function(event){

        $.ajax({
            type: "GET",
            url: "/autocomplete/defaultsuggestions",
            data: 'keyword=',
            beforeSend: function() {
                //$("#search-box").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(response) {
                $("#suggesstion-box").show();
                $("#suggesstion-box").html(response.data);
                //$("#search-box").css("background", "#FFF");
            }
        });

});

$('body').on('focusout', '#searchByTitle', function(event){
    window.setTimeout(function(){
    $("#suggesstion-box").html("");
    $("#suggesstion-box").hide();
}, 1000);
  });
// add user email for subscription
$('.subscription-form').on('submit', function(event) {
    event.preventDefault();
    let formURL = $(this).attr('action');
    let formMethod = $(this).attr('method');

    let formData = new FormData($(this)[0]);

    $.ajax({
        url: formURL,
        method: formMethod,
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            $('input[name="email_id"]').val('');
            toastr[response.alert_type](response.message)
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut ": 10000,
                "extendedTimeOut": 10000,
                "positionClass": "toast-top-right",
            }
        },
        error: function(errorData) {
            toastr['error'](errorData.responseJSON.error.email_id[0]);
        }
    });
});

// add user email for subscription
$('.verifyopt-form').on('submit', function(event) {
    event.preventDefault();
    let formURL = $(this).attr('action');
    let formMethod = $(this).attr('method');

    let formData = new FormData($(this)[0]);

    $.ajax({
        url: formURL,
        method: formMethod,
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {


            if(response.status == 'success'){
            toastr[response.status]('Enter the code via text to <strong>'+response.phone+'</strong>')
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut ": 10000,
                "extendedTimeOut": 10000,
                "positionClass": "toast-top-right",
            }
            $('#phonecode').hide();
            $('#verifycode').show();
            $('.mycode').html('Enter the code via text to <strong>'+response.phone+'</strong>');
        } else {
            toastr[response.status]('Destination number <strong>'+response.phone+'</strong> is invalid ')
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut ": 10000,
                "extendedTimeOut": 10000,
                "positionClass": "toast-top-right",
            }

        }
        },
        error: function(errorData) {
           // toastr['error'](errorData.responseJSON.error.email_id[0]);
        }
    });
});
$('.verifyopt-code').on('submit', function(event) {
    event.preventDefault();
    let formURL = $(this).attr('action');
    let formMethod = $(this).attr('method');
    let formData = new FormData($(this)[0]);
    $.ajax({
        url: formURL,
        method: formMethod,
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {

            if (response.status == 'success') {
                window.location.href= "/";
              } else {

            toastr[response.status](response.message)
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut ": 10000,
                "extendedTimeOut": 10000,
                "positionClass": "toast-top-right",
            }
            $('.text-danger-code').show();
        }
           // $('.text-danger-code').html(response.message);
        },
        error: function(errorData) {
            toastr['error'](errorData.responseJSON.error.email_id[0]);
        }
    });

});

$('.verifyoptProfile-code').on('submit', function(event) {
    event.preventDefault();
    let formURL = $(this).attr('action');
    let formMethod = $(this).attr('method');
    let formData = new FormData($(this)[0]);
    $.ajax({
        url: formURL,
        method: formMethod,
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {

            if (response.status == 'success') {
                window.location.reload();
              } else {

            //toastr[response.status](response.message)
            // toastr.options = {
            //     "closeButton": true,
            //     "progressBar": true,
            //     "timeOut ": 10000,
            //     "extendedTimeOut": 10000,
            //     "positionClass": "toast-top-right",
            // }
            window.location.reload();
            //$('.text-danger-code').show();
        }
           // $('.text-danger-code').html(response.message);
        },
        error: function(errorData) {
            toastr['error'](errorData.responseJSON.error.email_id[0]);
        }
    });

});


// add user email for subscription
$('.subscriptionForm').on('submit', function(event) {
    event.preventDefault();
    let formURL = $(this).attr('action');
    let formMethod = $(this).attr('method');

    let formData = new FormData($(this)[0]);

    $.ajax({
        url: formURL,
        method: formMethod,
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            $('input[name="email_id"]').val('');
            toastr[response.alert_type](response.message)
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut ": 10000,
                "extendedTimeOut": 10000,
                "positionClass": "toast-top-right",
            }
        },
        error: function(errorData) {
            toastr['error'](errorData.responseJSON.error.email_id[0]);
        }
    });
});



$('body').on('submit', '#vendorContactForm', function(e) {
    e.preventDefault();

    let vendorContactForm = document.getElementById('vendorContactForm');
    $('.request-loader').addClass('show');
    var url = $(this).attr('action');
    var method = $(this).attr('method');

    let fd = new FormData(vendorContactForm);
    $.ajax({
        url: url,
        method: method,
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
            $('.request-loader').removeClass('show');
            $('.em').each(function() {
                $(this).html('');
            });

            if (data == 'success') {
                location.reload();
            }
        },
        error: function(error) {
            $('.em').each(function() {
                $(this).html('');
            });

            for (let x in error.responseJSON.errors) {
                document.getElementById('err_' + x).innerHTML = error.responseJSON.errors[x][0];
            }

            $('.request-loader').removeClass('show');
        }
    })
});
// $(document).on('change','.delivery_available',function(){
//   updateUrl();
// });

    $(document).on('change','.dealer_type',function(){
        updateUrl();
    });
    // $('.us_delr_type').on('click', function(event) {
    // $('#ad_dealer').val($(this).val());
    // $('.us_delr_type').removeClass('usCumButton')
    // $(this).addClass('usCumButton')
    // });


    $('#adtypeSale').on('click', function(event) {
    $('#ad_type').val('sale');
    $('#adtypeWanted').removeClass('usCumButton')
    $(this).addClass('usCumButton')
    updateUrl();
    });


    $('#adtypeWanted').on('click', function(event) {

    $('#ad_type').val('wanted');

    $('#adtypeSale').removeClass('usCumButton');

    $(this).addClass('usCumButton')

    updateUrl();

    });

    function updatecate(self)
    {
        var pid = $('option:selected',self).data("pid");
        var cid = $('option:selected',self).data("cid");
        var category = $('option:selected',self).data("category");

        // $('.us_cat_cls').removeAttr('style');
        //
        // $(self).css({
        // 'font-weight': 'bold',
        // 'color': '#EE2C7B'
        // });

        $('#pid').val(pid);

        $('#category').val(category);

        //  if ($('#us_load_more').length)
        // {
        //     $('.us_hidden_by_default').hide();
        // }

            $.ajax({
                type: 'GET',
                url: 'load-filters',
                dataType:'json',
                data:{category:category , pid : pid},
                success:function(data)
                {
                  if(data.result == 'ok')
                  {

                      $('#carsFiltrs').hide();
                      console.log("Cateogry id" + pid);
                      $('#appendNewFilters').html(data.output);
                      $('.category-for-make').attr("cid", cid);
                      $('.category-for-make').attr("category", category);
                      $('#category').val(data.category_slug)
                  }
                }
            });

        updateUrl();
        loadBreadCrum(pid , category)
    }

    function updateUrl(request_type = 1,category = null)
    {
        if(request_type == 1 )
        {
            $('#pageno').val('1')
        }

        var formData = $('#searchForm').serializeArray();
        var queryParams = [];
        if(category === 'make-change'){
            formData.push({name: 'make-change', value: true});
        }

        if (category !== null && category !== '' && category !== 'make-change')
        {
            formData.forEach(function(item) {
                if (item.name === 'category') {
                    item.value = category; // Update the existing category value
                }
            });

            if (category === 'all')
            {
                formData.forEach(function(item) {
                    if (item.name === 'category') {
                        item.value = '';
                    }
                });
            }
        }else{
            formData.forEach(function(item) {
                if (item.name === 'category') {

                    if ((item.value == '' || item.value == null) && sessionStorage.getItem('tabCategory')) {
                        item.value = sessionStorage.getItem('tabCategory');
                    }else{
                        sessionStorage.setItem('tabCategory', item.value)
                    }
                }
            });
        }


            let categoryField = formData.find(item => item.name === 'category');

            $.each(formData, function(index, input)
            {
                if (input.value !== '') {
                    queryParams.push(encodeURIComponent(input.name) + '=' + encodeURIComponent(input.value));
                }
            });

            var queryString = queryParams.join('&');
            var newUrl = baseURL + '/ads';

            if (queryString !== '') {
                newUrl += '?' + queryString;
            }

            //console.log(newUrl);
           // return;
            $.ajax({
                type: 'GET',
                url: newUrl,
                dataType:'json',
                success:function(data)
                {

                    let optionHtml = '<option value="">Select Model</option>';
                    if(typeof(data.carModels) != 'undefined' && data.makeChange){
                        $.each(data.carModels, function (index,value) { 
                            optionHtml += `<option value="${value.slug}">${value.name}</option>`;
                        });
                        $('.car-models').html(optionHtml);
                    }
                    if($('.car-models').length){
                        initSelect2Element('.car-models');
                    }


                    $('#ajaxListing').html(data.html_view);
                    $('#total_counter_with_category').html(data.countHeading);
                    jQuery('.total_counter_with_category2').text(data.countHeading.match(/\d+/)[0]);
                    // $('.us_btn_close').click();
                    if (categoryField.value !== null && categoryField.value == 'cars-&-motors' || categoryField.value == 'all' ) {
                        setTimeout(function(){
                            $('#carFeature').css('display','');
                            $('#browse_style').css('display','');
                        },1000);

                    }else{
                        $('#carFeature').css('display','none');
                        $('#browse_style').css('display','none');
                    }

                    $('#total_counter_with_category').css('display','');
                    $('.main-skeleton-container').hide();//dataloader for grid view
                    $('.skeleton').hide();//dataloader for list view
                    
                    setTimeout(function(){
                        $('#ajaxListing').css('display','');
                    },500);


                }
            });
    }

    function updateBySorting(){

        let selectedCat = sessionStorage.getItem('tabCategory');
        if (selectedCat && selectedCat === 'market-place') {
            updateUrl(0,selectedCat)
        }else{
            updateUrl(0);
        }
    }

    function initSelect2Element(selector){
        $(selector).select2({
            allowClear: true
        });
    }

    $(document).on('click','.add-another-filter',function(){
        if($('.car-make').val()){
            let html = '';
            let carMake = $('.car-make').val();
            let carModels = $('.car-models').val();
            
            if(carModels.length){
                let additionalModelText = carModels.length > 1 ? ` (+${carModels.length - 1})` : "";
                let valueHtml = '';
                $.each(carModels, function (index, value) { 
                    valueHtml += '<input type="hidden" value="'+value+'" name="models[]">';
                    $(".car-models option[value='"+ value + "']").attr('disabled', true); 
                });
                html += `<div class="filter-item mt-1">
                        <span>${$(".car-make option:selected").text()} - ${$('.car-models option:selected').first().text()}${additionalModelText}</span> <span class="ms-2 remove-filter-item" role="button"><i class="fa fa-times text-danger"></i></span>
                        <input type="hidden" name="brands[]" value="${carMake}">
                        <input type="hidden" name="selected_brands[]" value="${carMake}">
                        ${valueHtml}
                    </div>`;
                $('.select-filter-list').append(html);
                $(".car-make option[value='"+ carMake + "']").attr('disabled', true); 
                $(".car-models option").remove();
                $('.car-make').val('').select2();
                $('.car-models').val('').select2();
            }
            else{
                html += `<div class="filter-item mt-1">
                            <span>${$(".car-make option:selected").text()} - (All Models)</span> <span class="ms-2 remove-filter-item" role="button"><i class="fa fa-times text-danger"></i></span>
                            <input type="hidden" name="brands[]" value="${carMake}">
                            <input type="hidden" name="selected_brands[]" value="${carMake}">
                        </div>`;
                $('.select-filter-list').append(html);
                $('.car-make').val('').select2();
                $(".car-make option[value='"+ carMake + "']").attr('disabled', true); 
            }


        }else{
            toastr.error('Please select make of the car.');
        }
    });

    $(document).on('click','.remove-filter-item',function(){
        let selectedMake = $(this).parent().find('input[name="brands[]"]').val();
        $(".car-make option[value='"+ selectedMake + "']").attr('disabled', false);
        $(this).parent().remove();
        $('.car-make').trigger('change');
    });

    //this function used for recents adds accordingly selected tabs
    $(document).ready(function() {

        $('.tab-category').on('click',function(){
            let tabCategory = '';
            var index = $(this).index('.tab-category');
            // alert('Current tab index: ' + index);
            if (index == 0) {
                tabCategory = 'Cars-&-Motors';

            }else if(index == 1){
                tabCategory = 'market-place';
            }
            else if(index == 2){
                tabCategory = 'property';
            }
            else if(index == 3){
                tabCategory = 'farming';
            }
            // Store the tabCategory value in sessionStorage
            sessionStorage.setItem('tabCategory', tabCategory);
        });

        /* --------------------------- */
        $('.category_icon_link').on('click',function(){
            var currentElement = $(this);
            var categoryName = currentElement.data('cat');
             console.log(categoryName);
             console.log(typeof(categoryName));
            // Store the category value in sessionStorage
            sessionStorage.setItem('tabCategory', categoryName);

            return console.log(sessionStorage.getItem('tabCategory'));
        });
        $('.browser_by_lifestyle').on('click',function(){
            var currentElement = $(this);
            var categoryName = currentElement.data('cat');
             console.log(categoryName);
             console.log(typeof(categoryName));
            // Store the category value in sessionStorage
            sessionStorage.setItem('tabCategory', categoryName);

            return console.log(sessionStorage.getItem('tabCategory'));
        });


    });



    $('.filter-reset-link').on('click',function(){

        sessionStorage.setItem('tabCategory', 'all');

        // alert(sessionStorage.getItem('tabCategory'));
    });


    $('#ajaxListing').on('click', '.us_pagination_default a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var pageNum = $(this).text();
        $('#pageno').val(pageNum)
        updateUrl(0)
    });


    $('#ajaxListing').on('click', '.us_pagination_filtered a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var pageNum = $(this).text();
        $('#pageno').val(pageNum)
        let selectedCat = sessionStorage.getItem('tabCategory');
        if (selectedCat && selectedCat === 'market-place') {
            updateUrl(0,selectedCat)
        }else{
            updateUrl(0);
        }

    });



    function updateUrlHome() {
    var formData = $('#homesearchform').serializeArray();
    var queryParams = [];

    $.each(formData, function(index, input) {
        if (input.value !== '') {
            queryParams.push(encodeURIComponent(input.name) + '=' + encodeURIComponent(input.value));
        }
    });

    var queryString = queryParams.join('&');
    var newUrl = baseURL + '/ads';

    if (queryString !== '') {
        newUrl += '?' + queryString;
    }

    // Update the browser URL without reloading the page
    window.location.href = newUrl;
}

function updateUrl2(request_type = 1)
    {

    if(request_type == 1 )
    {
        $('#pageno').val('1')
    }

    var formData = $('#SortForm').serializeArray();
    var queryParams = [];

    $.each(formData, function(index, input) {
        if (input.value !== '') {
            queryParams.push(encodeURIComponent(input.name) + '=' + encodeURIComponent(input.value));
        }
    });

    var queryString = queryParams.join('&');
    var newUrl = baseURL + '/ads';

    if (queryString !== '') {
        newUrl += '?' + queryString;
    }

    // Update the browser URL without reloading the page
    // window.location.href = newUrl;


      $.ajax({
            type: 'GET',
            url: newUrl,
            dataType:'json',
            success:function(data){
             $('#ajaxListing').html(data.html_view);
             $('#total_counter_with_category').html(data.countHeading);
             console.log("tetsafdsa");
             $('#total_counter_with_category2').html(data.countHeading);
            }
        });


}

$('body').on('keypress', '#searchByTitle', function(event) {
    if (event.which === 13) { // 13 is the keycode for 'Enter' key
        updateUrl();
    }
});

$('body').on('keypress', '#searchByLocation', function(event) {
    if (event.which === 13) { // 13 is the keycode for 'Enter' key
        updateUrl();
    }
});
$('body').on('click', '.brands', function(event) {
    if (event.which === 13) { // 13 is the keycode for 'Enter' key
        updateUrl();
    }
});

if ($('.messages').length > 0) {
    $('.messages')[0].scrollTop = $('.messages')[0].scrollHeight;
}


$('body').on('click', '.view_type', function (e) {
    e.preventDefault();
    var formData = $('#searchForm').serializeArray();
    var queryParams = [];

    $.each(formData, function (index, input) {
        if (input.value !== '') {
            queryParams.push(encodeURIComponent(input.name) + '=' + encodeURIComponent(input.value));
        }
    });

    var queryString = queryParams.join('&');
    var newUrl = baseURL + '/ads';

    if (queryString !== '') {
        newUrl += '?' + queryString;
        alert('hi');
        window.location.href = newUrl + '&type=' + $(this).attr('data-type');

    } else{
        alert('hielse');
        window.location.href = newUrl + '?type=' + $(this).attr('data-type');
    }

    // Update the browser URL without reloading the page

})

// Body Type Filter
$('.body-type-filter .form-check-input, .colour-filter .form-check-input').on('change', function () {
    const $formCheck = $(this).closest('.form-check'); // Get the parent .form-check
    if ($(this).is(':checked')) {
        $formCheck.addClass('checked'); // Add the class when checked
    } else {
        $formCheck.removeClass('checked'); // Remove the class when unchecked
    }
});
updateUrl();
