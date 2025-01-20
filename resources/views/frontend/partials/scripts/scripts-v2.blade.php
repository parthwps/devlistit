<script>
    'use strict';
    /*const baseURL = "{{ url('/') }}";
    const all_model = "{{ __('All') }}";
    const read_more = "{{ __('Read More') }}";
    const read_less = "{{ __('Read Less') }}";
    const show_more = "{{ __('Show More') . '+' }}";
    const show_less = "{{ __('Show Less') . '-' }}";*/
    var vapid_public_key = "{!! env('VAPID_PUBLIC_KEY') !!}";
</script>
<!-- Jquery JS -->
<script src="{{ asset('assets/front/js/vendors/jquery.min.js') }}"></script>
<!-- Popper JS -->
<script src="{{ asset('assets/front/js/vendors/popper.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('assets/front/js/vendors/bootstrap.min.js') }}"></script>

<!-- Data Tables JS -->
<script src="{{ asset('assets/front/js/vendors/datatables.min.js') }}"></script>
<!-- Counter JS -->
<script src="{{ asset('assets/front/js/vendors/jquery.counterup.min.js') }}"></script>
<!-- Nice Select JS -->
<script src="{{ asset('assets/front/js/vendors/jquery.nice-select.min.js') }}"></script>
<!-- Magnific Popup JS -->
<script src="{{ asset('assets/front/js/vendors/jquery.magnific-popup.min.js') }}"></script>
{{-- syotimer js --}}
<script src="{{ asset('assets/js/jquery-syotimer.min.js') }}"></script>
<!-- Swiper Slider JS -->
<script src="{{ asset('assets/front/js/vendors/swiper-bundle.min.js') }}"></script>
<!-- Lazysizes -->
<script src="{{ asset('assets/front/js/vendors/lazysizes.min.js') }}"></script>
<!-- Noui Range Slider JS -->
<script src="{{ asset('assets/front/js/vendors/nouislider.min.js') }}"></script>
<!-- AOS JS -->
<script src="{{ asset('assets/front/js/vendors/aos.min.js') }}"></script>
<!-- Mouse Hover JS -->
<script src="{{ asset('assets/front/js/vendors/mouse-hover-move.js') }}"></script>
<!-- Svg Loader JS -->
<script src="{{ asset('assets/front/js/vendors/svg-loader.min.js') }}"></script>
{{-- tinymce script js --}}
<script src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
{{-- toastr --}}
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
{{-- push notification js --}}
<script src="{{ asset('assets/js/push-notification.js') }}"></script>
<!-- Main script JS -->
<script src="{{ asset('assets/front/js/script.js?v=0.927') }}"></script>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<!-- Popper JS -->
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
{{-- whatsapp js --}}
<script src="{{ asset('assets/js/floating-whatsapp.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<div class="modal fade" id="removeAdRemarkModal" style="opacity: 1 !important;background: #111010a3;" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('vendor.cars_management.delete_add') }}" method="get">
                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-12">
                            <label
                                style="font-size: 15px;
                    margin-bottom: 10px;
                    margin-left: 5px;
                    ">Have
                                you sold the item?</label>
                        </div>

                        <div class="col-md-12">
                            <div style="background: #b8b8b8;
                color: white;
                padding: 7px;
                margin: 5px;cursor:pointer;"
                                onclick="selectRadio(this)">
                                I sold it on Listit <input style="float: right;zoom: 1.7;margin-top: 1px;"
                                    type="radio" value="I sold it on Listit" required name="remove_option" />
                            </div>


                            <div style="background: #b8b8b8;
                color: white;
                padding: 7px;
                margin: 5px;cursor:pointer;"
                                onclick="selectRadio(this)">
                                I sold it elsewhere <input type="radio"
                                    style="float: right;zoom: 1.7;margin-top: 1px;" value="I sold it elsewhere" required
                                    name="remove_option" />
                            </div>


                            <div style="background: #b8b8b8;
                color: white;
                padding: 7px;
                margin: 5px;cursor:pointer;"
                                onclick="selectRadio(this)">
                                I decide not to sell it <input type="radio"
                                    style="float: right;zoom: 1.7;margin-top: 1px;" value="I decide not to sell it"
                                    required name="remove_option" />
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="range_container">
                                <p style="text-align: left;margin-bottom: 2rem;margin-top: 1rem;">Would you recommend
                                    Listit to a friend</p>
                                <div class="range-container">
                                    <div class="number-labels">
                                        <span>1</span>
                                        <span>2</span>
                                        <span>3</span>
                                        <span>4</span>
                                        <span>5</span>
                                        <span>6</span>
                                        <span>7</span>
                                        <span>8</span>
                                        <span>9</span>
                                        <span>10</span>
                                    </div>
                                    <input type="range" min="1" max="10" value="1" required
                                        name="recommendation">
                                    <div class="text-labels">
                                        <span>Not Really</span>
                                        <span>Absolutely</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12" style="    margin-top: 1rem;">
                            <label
                                style="font-size: 15px;
                    margin-bottom: 10px;
                    margin-left: 5px;
                    ">Tell
                                us about your Listit experience</label>

                            <textarea class="form-control" rows="3" name="remove_remarks"
                                placeholder="This is not mandatory, but we would love to hear from you with your suggestions on how we can make List It a better place"></textarea>
                        </div>

                        <div id="parm_type" style='display:none;'>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="closemodal()">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm & Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="popupModals" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="    border-bottom: 0px;">

                <button type="button" class="close"
                    style="font-size: 30px;
        color: gray !important;
        position: absolute;
        right: 10px;"
                    onclick="closemodal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="popup_body">
                ...
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 30px;">
        <div class="modal-content">

            <button type="button" class="close" onclick="closemodal()"
                style="     border-top-right-radius: 10px;   border-top-left-radius: 10px;color: gray !important;float: right;font-size: 28px;padding: 0px;height: 20px;margin-top: -15px !important;">
                <span aria-hidden="true" style="float: right;margin-right: 1rem;">&times;</span>
            </button>

            <div class="modal-body" id="shareModalContent" style="text-align: center;margin: 2rem;">
                ...
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.dz-error-mark', function() {

        $(this).closest('.dz-error').remove();
    });


    function applyFilter() {
        $('#filterFormsssss').submit();
    }

    function filterFormSubmission() {

        var form = $('#filterFormsssss');
        var formData = form.serialize(); // Serialize the form data
        $('#serachBTN').html('<span style="font-size:15px">Searching...</span>')
        $('#serachBTN').prop('disabled', true)

        $.ajax({
            url: "{{ route('frontend.vendor.customer.filter') }}", // The URL to send the request to
            type: 'POST', // The HTTP method to use
            data: formData, // The serialized form data
            dataType: 'json', // Expected data type from server
            success: function(response) {
                $('#appendFilterListing').html(response.data)
                $('#car_counter').html(response.count)
                $('#serachBTN').prop('disabled', false)
                $('#serachBTN').html('<i class="fal fa-search" aria-hidden="true"></i>')
            },
            error: function(xhr, status, error) {
                // Handle errors here
                console.error('Error:', error);
            }
        });

        return false
    }

    function showFilterSection() {
        const filterSection = $('.us_hidden_by_default');

        // Check if the filter section is currently visible
        if (filterSection.is(':visible')) {
            // Hide the filter section
            filterSection.hide();
        } else {
            // Move and show the filter section
            filterSection.insertBefore($('#buttonRows')).removeClass('row').show();
        }
    }



    function removeImage() {

        $('#image-preview').html('<img src="{{ asset('assets/img/noimage.jpg') }}" alt="..." class="uploaded-img">');

        $('.img-input').val('');

        $.ajax({
            url: "{{ route('remove.image') }}",
            method: 'GET',
            success: function(response) {},
            error: function(xhr, status, error) {}
        });
    }

    let draggedRow = null;

    function dragStart(event) {
        draggedRow = event.target.closest('tr'); // Get the dragged row
        event.dataTransfer.effectAllowed = 'move'; // Allow move operation
    }

    function allowDrop(event) {
        event.preventDefault(); // Prevent default behavior to allow dropping
    }

    function drop(event) {
        event.preventDefault();

        const targetRow = event.target.closest('tr'); // Get the row being dropped onto
        if (draggedRow && targetRow && draggedRow !== targetRow) {
            const tbody = document.querySelector('#imgtable tbody'); // Get the table body
            let draggedIndex = Array.from(tbody.children).indexOf(draggedRow); // Index of dragged row
            let targetIndex = Array.from(tbody.children).indexOf(targetRow); // Index of target row

            // Insert the dragged row before or after the target row based on position
            if (draggedIndex < targetIndex) {
                tbody.insertBefore(draggedRow, targetRow.nextSibling);
            } else {
                tbody.insertBefore(draggedRow, targetRow);
            }
        }
    }

    function setCoverPhoto(id) {
        // Get the selected row
        let selectedRow = document.getElementById('trdb' + id);

        // Get the table body
        let tableBody = document.querySelector('#imgtable tbody');

        // Move the selected row to the first position
        if (selectedRow) {
            // Remove the selected row from its current position
            tableBody.removeChild(selectedRow);

            // Insert the selected row at the beginning of the table
            tableBody.insertBefore(selectedRow, tableBody.firstChild);
            $('.cover_label').remove()
            $("#defaultImg").val(id);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selectSelected = document.querySelector('.select-selected');
        const selectItems = document.querySelector('.select-items');
        const searchInput = document.getElementById('country-search');
        const phoneInput = document.getElementById('phone');
        const countryCodeInput = document.getElementById('c_code'); // Check if this is null


        // Toggle the dropdown
        selectSelected.addEventListener('click', function() {
            selectItems.classList.toggle('select-hide');
            selectSelected.classList.toggle('select-arrow-active');
            searchInput.focus(); // Focus on search input when dropdown is opened
        });

        // Handle item selection
        selectItems.addEventListener('click', function(e) {
            if (e.target.classList.contains('country-option')) {
                const code = e.target.getAttribute('data-value');
                const flag = e.target.getAttribute('data-flag');

                countryCodeInput.value = code;

                selectSelected.innerHTML = `<img src="${flag}" class="flag"> ${e.target.innerText}`;
                selectItems.classList.add('select-hide');
                selectSelected.classList.remove('select-arrow-active');
                phoneInput.setAttribute('data-country-code', code); // Store country code in phone input

            }
        });

        // Filter options based on search input
        searchInput.addEventListener('input', function() {
            const filter = searchInput.value.toLowerCase();
            const options = selectItems.querySelectorAll('.country-option');
            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                if (text.includes(filter)) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
        });

        // Close dropdown if clicked outside
        document.addEventListener('click', function(e) {
            if (!selectSelected.contains(e.target) && !selectItems.contains(e.target)) {
                selectItems.classList.add('select-hide');
                selectSelected.classList.remove('select-arrow-active');
            }
        });
    });




    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#password');

        const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
        const passwordConfirmationField = document.querySelector('#password_confirmation');

        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        togglePasswordConfirmation.addEventListener('click', function() {
            const type = passwordConfirmationField.getAttribute('type') === 'password' ? 'text' :
                'password';
            passwordConfirmationField.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });



    function copyLink(text) {

        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(function() {
                // Success feedback using Toastr
                toastr["success"]("Ad URL copied successfully.");
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": 10000,
                    "extendedTimeOut": 10000,
                    "positionClass": "toast-top-right",
                };
            }).catch(function(error) {
                console.error("Error copying text to clipboard: ", error);
                toastr["error"]("Failed to copy URL.");
            });
        } else {
            // Fallback for browsers without Clipboard API support
            var input = document.createElement('input');
            input.setAttribute('value', text);
            document.body.appendChild(input);
            input.select();
            try {
                document.execCommand('copy');
                toastr["success"]("Ad URL copied successfully.");
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": 10000,
                    "extendedTimeOut": 10000,
                    "positionClass": "toast-top-right",
                };
            } catch (err) {
                toastr["error"]("Failed to copy URL.");
                console.error("Fallback copy failed: ", err);
            }
            document.body.removeChild(input);
        }
    }


    function openShareModal(self) {

        var url = $(self).data("url");

        $('#shareModalContent').html(` <h3 style="text-align:justify;">Share</h3>
            <p style="text-align:justify;">Help spread the word</p>
            <p style="text-align:justify;">Share this ad with your friends or on your favourite social media network</p>

            <div class="social-link" style="margin-top: 1rem; style-2 mb-20" style="display: inline-block !important;">
                <a data-tooltip="tooltip" style="width: 50px;height: 50px;border-radius: 10%;line-height: 50px;background-color:white;color:black;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);" data-bs-placement="top"
                    title="facebook" href="https://www.facebook.com/sharer/sharer.php?quote=Check Out this ad on List It&utm_source=facebook&utm_medium=social&u=${encodeURIComponent(url)}"
                    target="_blank"><i class="fab fa-facebook-f"></i></a>

                <a data-tooltip="tooltip" style="width: 50px;height: 50px;border-radius: 10%;line-height: 50px;background-color:white;color:black;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);" data-bs-placement="top"
                    title="Twitter" href="//twitter.com/intent/tweet?text=Check Out this ad on List It&amp;url=${encodeURIComponent(url)}"
                    target="_blank"><i class="fab fa-twitter"></i></a>

                <a data-tooltip="tooltip" style="width: 50px;height: 50px;border-radius: 10%;line-height: 50px;background-color:white;color:black;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);" data-bs-placement="top"
                    title="Whatsapp" href="//wa.me/?text=Check Out this ad on List it ${encodeURIComponent(url)}&amp;title="
                    target="_blank"><i class="fab fa-whatsapp"></i></a>



                <a data-tooltip="tooltip" style="width: 50px;height: 50px;border-radius: 10%;line-height: 50px;background-color:white;color:black;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);" data-bs-placement="top"
                    title="Email" href="mailto:?subject=Check Out this ad on List it&amp;body=Check Out this ad on List it ${encodeURIComponent(url)}&amp;title="
                    target="_blank"><i class="fas fa-envelope"></i></a>

                <a data-tooltip="tooltip" style="width: 50px;height: 50px;border-radius: 10%;line-height: 50px;background-color:white;color:black;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);" data-bs-placement="top"
                    title="Copy Link"  onclick="copyLink('${url}')" href="javascript:void(0)">
                    <i class="fas fa-link"></i></a>
            </div>
        `);

        $('#shareModal').modal('show');
    }



    $(document).ready(function() {

        $(document).ready(function() {
            var interval = setInterval(function() {
                var dzMessage = $('.dz-default.dz-message');

                if (dzMessage.find('i.fa-cloud-upload-alt').length ===
                    0) { // Check if the icon hasn't been added yet
                    // Clear the existing content
                    dzMessage.empty();

                    // Append the cloud icon, a specific instruction message, and additional details
                    dzMessage.html(`
                    <i class="fa fa-cloud-upload-alt" style="font-size: 48px;color:gray;"></i>
                    <h3 style="margin-top: 1rem;color:gray;">Drag & Drop to Upload File</h3>
                    <p>or</p>
                    <button class="btn btn-primary" type="button">Click to Browse Files</button>
                `);
                } else {
                    // If the desired content is already there, clear the interval
                    clearInterval(interval);
                }
            }, 500); // Check every 500 milliseconds
        });
    });


    function selectRadio(div) {
        var radioButton = div.querySelector('input[type="radio"]');
        radioButton.checked = true;
    }

    function removeThisAd(status, car_id) {
        $('#parm_type').html('<input type="hidden" name="request_for" value="' + status +
            '" />  <input type="hidden" name="car_id" value="' + car_id + '" /> ');
        $('#removeAdRemarkModal').modal('show')
    }

    function openHours(self) {
        // Check if the element does not have the ID 'append_dropdown'
        if ($(self).attr('id') !== 'append_dropdown') {
            $('#append_dropdown').html($(self).html());
            $(self).remove();
            $('#append_dropdown').show();
        }

        $('.us_open_hours').toggle('slow');
    }

    $(document).ready(function() {
        $('#imageInput').change(function(event) {
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreview').show();
                $('.image-container').show();

            };

            reader.readAsDataURL(file);
        });
    });


    $(document).on('click', '.list-group.list-group-flush a', function() {
        var pid = $(this).data("pid");

        var category = $(this).data("category");

        loadBreadCrum(pid, category)
    });

    $(document).on('click', '.us_customize_bread_crum', function() {
        var pid = $(this).data("pid");

        var category = $(this).data("category");

        loadBreadCrum(pid, category)
    });


    function loadBreadCrum(pid, category) {
        $.ajax({
            url: "{{ route('get_categories_bread') }}",
            method: 'GET',
            data: {
                pid: pid,
                category: category
            },
            success: function(response) {
                $('#categories_breadcrium').html(response)
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    document.getElementById('whatsappButton').addEventListener('click', function() {
        document.getElementById('whatsappPopup').style.display = 'block';
        this.style.display = 'none';
    });

    document.getElementById('closePopup').addEventListener('click', function() {
        document.getElementById('whatsappPopup').style.display = 'none';
        document.getElementById('whatsappButton').style.display = 'flex';
    });

    function scroll_to_bottom() {
        $('html, body').animate({
            scrollTop: $("#packageSelected").offset().top
        }, 1000);
    }

    function addToWishlist(car_id) {
        $.ajax({
            url: "{{ url('addto') }}/" + car_id,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.alert_type == 'login') {
                    window.location.href = "/customer/login"
                } else if (response.alert_type == 'success') {
                    "use strict";
                    toastr['success'](response.message);

                    const wishlistItems = document.querySelectorAll(
                        `a[onclick="addToWishlist(${car_id})"]`);

                    wishlistItems.forEach(anchor => {
                        const iconElement = anchor.querySelector('i');
                        const imgElement = anchor.querySelector('img');
                        if (imgElement) {
                            const currentSrc = imgElement.getAttribute('src');
                            if (currentSrc.includes("assets/img/heart_dislike.svg")) {
                                imgElement.setAttribute('src', "assets/img/heart_like.svg");
                            }
                        }
                        if (iconElement) {

                            iconElement.classList.remove('fal', 'fa-heart');
                            iconElement.classList.add('fa', 'fa-heart');

                            // Animate the icon
                            iconElement.style.transition = 'transform 0.5s ease, color 0.5s ease';
                            iconElement.style.transform = 'scale(1.5)';
                            iconElement.style.color = 'red';

                            // Reset the animation after it's done
                            setTimeout(() => {
                                iconElement.style.transform = 'scale(1)';
                            }, 500);

                        }

                    });
                } else if (response.alert_type == 'error') {
                    "use strict";
                    toastr['error'](response.message);

                    const wishlistItems = document.querySelectorAll(
                        `a[onclick="addToWishlist(${car_id})"]`);

                    wishlistItems.forEach(anchor => {
                        // Change the icon within the <a> tag
                        const iconElement = anchor.querySelector('i');
                        const imgElement = anchor.querySelector('img');
                        if (imgElement) {
                            const currentSrc = imgElement.getAttribute('src');
                            if (currentSrc.includes("assets/img/heart_like.svg")) {
                                imgElement.setAttribute('src', "assets/img/heart_dislike.svg");
                            }
                        }
                        if (iconElement) {
                            iconElement.classList.remove('fa', 'fa-heart');
                            iconElement.classList.add('fal', 'fa-heart');

                            // Animate the icon (zoom in effect on error)
                            iconElement.style.transition = 'transform 0.5s ease, color 0.5s ease';
                            iconElement.style.transform = 'scale(1.5)';
                            iconElement.style.color = '#ccc'; // Default color or grey

                            // Reset the animation after it's done
                            setTimeout(() => {
                                iconElement.style.transform = 'scale(1)';
                            }, 500);


                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        return false;
    }


    function applyfilter(self, type) {
        var currentUrl = new URL(window.location.href); // Get the current URL

        if (type === 'categories') {
            var category_id = $(self).val();
            currentUrl.searchParams.set('category_id', category_id); // Append category_id parameter
        } else {
            var filter_type = $(self).val();
            currentUrl.searchParams.set('filter_type', filter_type); // Append filter_type parameter
        }

        // Redirect to the new URL with the appended parameter
        window.location.href = currentUrl.toString();
    }



    function gotothe(type, car_id) {

        var car_ids = $('#car_ids').val();

        $.ajax({
            url: "{{ route('get_compare_car_datas') }}",
            method: 'GET',
            data: {
                car_id: car_id,
                car_ids: car_ids,
                type: type
            },
            success: function(response) {
                if (type == 'f_previous' || type == 'f_next') {
                    $('#first_card').html(response);
                } else {
                    $('#second_card').html(response);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

    }

    document.addEventListener('DOMContentLoaded', function() {
        // Check if the URL has the attribute compare_from
        if (window.location.search.includes('compare_from=')) {
            // Interval to click the button with class us_open_modal
            var interval = setInterval(function() {
                var button = document.querySelector('.us_open_modal');
                if (button) {
                    button.click();
                    clearInterval(interval);
                }
            }, 1000); // Adjust the interval timing as needed (e.g., 1000 ms = 1 second)
        }
    });


    function getComparison(type) {
        $('#request_type').val(type)
        $('#comparsim_form').submit();
    }

    function compareCheckbox(self) {
        var checkboxes = $('.compare_checkbox');
        var checkedCheckboxes = checkboxes.filter(':checked').length;
        var stickySection = $('.us_com_flex');
        if (checkedCheckboxes > 1) {
            $('#comparebtn').show();
            stickySection.addClass('us_com_flexs');
        } else {
            $('#comparebtn').hide();
            stickySection.removeClass('us_com_flexs');
        }

        if (checkedCheckboxes > 0) {
            $('#removeBTN').show();
        } else {
            $('#removeBTN').hide();
        }

        $('#com_cal').html(checkedCheckboxes);

        if (checkedCheckboxes == 5) {
            $('.compare_checkbox:not(:checked)').prop('disabled', true);
        } else {
            $('.compare_checkbox:not(:checked)').prop('disabled', false);
        }
    }

    function reportAd() {

        $('#submtBtn').html('Processing...');
        $('#submtBtn').prop('disabled', true);

        const adId = $('#ad_id').val();
        const reasonOption = $('#reasonOption').val();
        const explaination = $('#explaination').val();

        // Send data via AJAX
        $.ajax({
            url: "{{ route('report.ad') }}",
            method: 'GET',
            data: {
                reasonOption: reasonOption,
                explaination: explaination,
                ad_id: adId
            },
            success: function(response) {
                $('#successMessage').show();
                $('#submtBtn').html('Report Ad');

                setTimeout(function() {
                    location.reload(true);
                }, 3000);


                // Uncomment if you still want to reload the page
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        return false; // Prevent form from submitting in the traditional way
    }

    function reportModal() {
        $('#reportModal').modal('show')
    }

    function showmore(type, self) {
        if (type == 1) {
            $('#showDisTxt').show();
            $('#readBtn').html(
                '<a href="javascript:void(0);" style="color: #0063fc;" onclick="showmore(0 , this)">read less</a>')
        } else {
            $('#showDisTxt').hide();
            $('#readBtn').html(
                '<a href="javascript:void(0);" style="color: #0063fc;" onclick="showmore(1 , this)">read more</a>')
        }
    }

    function saveDraftData(self, column_name = null) {

        if (column_name != null) {

            if (column_name == 'ad_type') {
                if ($(self).val() == 'Sale') {
                    $('#input-title').attr('placeholder', 'What you are selling?');
                    $('#CarSubmit').html('Sell Now')
                } else {
                    $('#input-title').attr('placeholder', 'What you are looking for?')
                    $('#CarSubmit').html('Publish Now')
                }
            }

            $.ajax({
                url: '{{ route('savetodraft') }}',
                method: 'GET',
                data: {
                    current_val: $(self).val(),
                    column_name: column_name
                },
                dataType: 'json',
                success: function(response) {
                    var $selectedElement = $(self).closest('.sub_sub_sub_category');
                    var $nextElements = $selectedElement.nextAll('.sub_sub_sub_category');
                    $nextElements.remove();


                    if (response.result == 'ok') {
                        $(".sub_sub_sub_category").last().after(response.output);
                    } else if (response.result == 'dataonline') {
                        $('#searcfiltersdata').html(response.output);
                    } else if (response.result == 'dataoffline') {
                        $('#searcfiltersdata').html('');
                    }

                    if ((column_name == 'sub_category_id' || column_name == 'category_id') && ($(
                            '#adsMaincat').val() == 233 || $('#adsMaincat').val() == 347)) {
                        $('#addTYAP').hide();
                        $('#ad_price').val(0);
                        $('#selling_label').hide();
                        $('#en_description').attr('placeholder',
                            'Tell us a bit more about your ad, giving us as much information as possible.'
                        );
                        $('#ad_price').attr('readonly', true);
                    } else {
                        $('#addTYAP').show();
                        $('#ad_price').val('');
                        $('#selling_label').show();
                        $('#en_description').attr('placeholder',
                            'Tell us a bit more about your ad, giving us as much information as possible to help sell your items.'
                        );
                        $('#ad_price').attr('readonly', false);
                    }

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $.ajax({
                url: '{{ route('savetodraft') }}',
                method: 'GET',
                data: {
                    current_val: $(self).val()
                },
                dataType: 'json',
                success: function(response) {
                    var $selectedElement = $(self).closest('.sub_sub_sub_category');
                    var $nextElements = $selectedElement.nextAll('.sub_sub_sub_category');
                    $nextElements.remove();

                    if (response.result == 'ok') {
                        $(".sub_sub_sub_category").last().after(response.output);
                    } else if (response.result == 'dataonline') {
                        $('#searcfiltersdata').html(response.output);
                    } else if (response.result == 'dataoffline') {
                        $('#searcfiltersdata').html('');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }

    function deletDarftAd() {
        $.ajax({
            url: '{{ route('deleteToDraft') }}',
            method: 'GET',

            success: function(response) {
                location.reload(true)
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }


    $(document).ready(function() {
        var hoverTimeout;
        var currentElement;

        $('.product-default').on('mouseover', function() {
            // Clear any existing timeout
            clearTimeout(hoverTimeout);

            // Store a reference to the current element
            currentElement = $(this);

            // Set a new timeout to trigger the AJAX request after 1000 milliseconds (1 second)
            hoverTimeout = setTimeout(function() {
                // Make your AJAX request here using the stored reference to the current element
                var ad_id = currentElement.attr("data-id");

                $.ajax({
                    url: '{{ route('ad.impression.count') }}',
                    method: 'GET',
                    data: {
                        ad_id: ad_id
                    },
                    success: function(response) {

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });

            }, 1000);
        });

        // Clear the timeout if the mouse leaves the element
        $('.product-default').on('mouseout', function() {
            clearTimeout(hoverTimeout);
        });
    });
</script>



<script type="text/javascript">
    function changeVal(self = null) {
        var selectedText = $('#fuelType').find('option:selected').text();
        var thisVal = $('#fuelType').val();
        var subcatVal = $('#adsSubcat').val();


        if (selectedText.trim() === 'Petrol' || selectedText.trim() === 'Diesel') {
            $('#betry_dropdown').hide();
            $('#trsmisn_type').show()
        } else {
            $('#betry_dropdown').show();
            $('#transmissionType').val(14);
            $('#transmissionType').change();
            $('#trsmisn_type').hide()
        }

        $.ajax({
            url: "{{ route('frontend.getEngineCapacity') }}",
            type: 'GET',
            data: {
                selectedText: selectedText,
                thisVal: thisVal,
                subcatVal: subcatVal
            },
            success: function(data) {
                $('#new_engine_caacity').html(data);
            }
        });

        $('#battery').val('');
    }

    function addnsjfjdfj(self) {
        var addCapacity = $(self).val();


        $.ajax({
            url: '{{ route('savetodraft') }}',
            method: 'GET',
            data: {
                current_val: $(self).val(),
                column_name: 'engine'
            },

            success: function(response) {

            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function notifyMe(self) {
        var year = $(self).data("year")
        var name = $(self).data("name")
        var brand = $(self).data("brand")
        var model = $(self).data("model")
        var fueltype = $(self).data("fueltype")
        var transmissiontype = $(self).data("transmissiontype")
        var category_slug = $(self).data("category_slug")

        var url = "{{ url('/') }}";

        $(self).html('Processing...');
        $(self).prop('disabled', true);

        url = url + '/ads?category=' + category_slug + '&page=1&fuel_type=' + fueltype + '&brands%5B%5D=' + brand +
            '&models%5B%5D=' + model + '&transmission=' + transmissiontype + '&year_min=' + year + '&year_max=' + year
        name = "Similar to " + name;
        //    return "yes hello";
        $.ajax({
            type: 'GET',
            url: "{{ route('frontend.save_search') }}",
            data: {
                search_url: url,
                save_search_name: name,
                selectedAlertType: 1
            },
            dataType: "json",
            success: function(data) {
                if (data.response == 'saved') {
                    $('#alertSuccess').show('slow');
                }

                setTimeout(function() {
                        $('#alertSuccess').hide('slow');
                        $(self).html('Notify Me');
                        $(self).prop('disabled', true);
                    },
                    5000);

            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function loadAllCat(self) {

        if ($(self).length) {
            $('.us_hidden_by_default').show();
            $(self).remove();
        } else {
            $('.us_hidden_by_default').hide();
        }

    }

    function submitFormBtn() {
        $('#submitForm').submit();
    }

    $(document).ready(function() {


        $('.overlay').click(function() {

            alert('Sorry this ad is already sold.')

        });


        $('#parentCheckbox').click(function() {
            var isChecked = $(this).is(':checked');
            $('.us_removeboxes').prop('checked', isChecked);
        });
    });

    $(document).ready(function() {

        $('.tab-category').on('click', function() {

            let selectedCat = sessionStorage.getItem('tabCategory');
            let categoryId = 24;

            if (selectedCat && selectedCat == 'market-place') {
                categoryId = 0;
            } else if (selectedCat && selectedCat == 'property') {
                categoryId = 39;
            } else if (selectedCat && selectedCat == 'farming') {
                categoryId = 28;
            }

            $('#carFeaterHomepage').css('display', 'none');
            $('#browse_style_home').css('display', 'none');
            if (categoryId == 24) {
                $('#carFeaterHomepage').css('display', '');
                $('#browse_style_home').css('display', '');
            }

            $.ajax({
                url: "{{ route('getnewads') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    categoryId: categoryId
                },
                success: function(res) {
                    if (res.response == 'yes') {
                        console.log(res)
                        $('#recent_all_ads').html(res.htmldata);
                        $('#rightside').val(res.rightside);
                        $('#leftside').val(res.leftside);

                        setTimeout(function() {
                            $('.skeleton').hide(); // Hide skeletons
                            $('.loading-section').removeClass('loading-section');
                        }, 1000);
                    }

                }
            });

        });

        $('.nextprevbtn').on('click', function() {

            let selectedCat = sessionStorage.getItem('tabCategory');
            let categoryId = 24;

            if (selectedCat && selectedCat == 'market-place') {
                categoryId = 0;
            } else if (selectedCat && selectedCat == 'property') {
                categoryId = 39;
            } else if (selectedCat && selectedCat == 'farming') {
                categoryId = 28;
            }

            var rightside = $('#rightside').val();
            var leftside = $('#leftside').val();

            $.ajax({
                url: "{{ route('getnewads') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    type: $(this).val(),
                    rightside: rightside,
                    leftside: leftside,
                    categoryId: categoryId
                },
                success: function(res) {
                    if (res.response == 'yes') {
                        console.log(res)
                        $('#recent_all_ads').html(res.htmldata);
                        $('#rightside').val(res.rightside);
                        $('#leftside').val(res.leftside);

                        setTimeout(function() {
                            $('.skeleton').hide(); // Hide skeletons
                            $('.loading-section').removeClass('loading-section');
                        }, 1000);
                    }

                }
            });

        });
    });


    function saveSearch() {
        // Serialize the form data
        var search_url = $('#search_url').val();
        var save_search_name = $('#save_search_name').val();
        var selectedAlertType = $('input[name="alertType"]:checked').val();
        $('#searchFormBtn').html('Processing...');
        $('#searchFormBtn').prop('disabled', true)
        $.ajax({
            type: 'GET',
            url: "{{ route('frontend.save_search') }}",
            data: {
                search_url: search_url,
                save_search_name: save_search_name,
                selectedAlertType: selectedAlertType
            },
            dataType: "json",
            success: function(data) {
                if (data.response == 'saved') {
                    $('#alertSuccess').show('slow');
                }

                setTimeout(function() {
                    $('#saveSearchModal').modal('hide');
                    $('#save_search_name').val('');
                    $('#search_url').val('');
                    $('#alertSuccess').hide('slow');
                    $('#searchFormBtn').prop('disabled', false)
                    $('#searchFormBtn').html('Save Search');
                }, 2000);

            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        return false; // Prevent the default form submission
    }



    function SaveSeraches() {

        @if (!Auth::guard('vendor')->check())
            window.location.href = "customer/login"
        @else

            var formData = $('#searchForm').serializeArray();

            var queryParams = [];

            $.each(formData, function(index, input) {
                // Exclude 'search_url' from the query parameters
                if (input.name !== 'search_url' && input.value !== '') {
                    queryParams.push(encodeURIComponent(input.name) + '=' + encodeURIComponent(input.value));
                }
            });

            var queryString = queryParams.join('&');
            var newUrl = baseURL + '/ads';

            if (queryString !== '') {
                newUrl += '?' + queryString;
            }

            $('#search_url').val(newUrl);

            $('#saveSearchModal').modal('show')
        @endif
    }

    function closeSaveModal() {
        $('#saveSearchModal').modal('hide')
    }

    function closeReportModal() {
        $('#reportModal').modal('hide')
    }


    function closemodal() {
        $('.modal').modal('hide')
    }

    function open_drop_down() {
        $('#auth_drop_down').toggle();
    }

    function open_drop_downdash() {
        $('#open_drop_downdash').toggle();
    }

    $(document).ready(function() {
        $('.js-example-basic-single1').select2();
        $('.js-example-basic-single2').select2();
        $('.js-example-basic-single3').select2();
        $('.js-example-basic-single4').select2();
        $('.js-example-basic-single5').select2();
        $('.js-example-basic-single6').select2();
        $('.js-example-basic-single7').select2();
        //$('.subhidden').addClass('hidden');
    });
</script>

<!--Start of Tawk.to Script-->
@if ($basicInfo->tawkto_status)
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = "{{ $basicInfo->tawkto_direct_chat_link }}";
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
@endif
<!--End of Tawk.to Script-->
@yield('script')
@if (session()->has('success'))
    <script>
        "use strict";
        toastr['success']("{{ __(session('success')) }}");
    </script>
@endif

@if (session()->has('error'))
    <script>
        "use strict";
        toastr['error']("{{ __(session('error')) }}");
    </script>
@endif
@if (session()->has('warning'))
    <script>
        "use strict";
        toastr['warning']("{{ __(session('warning')) }}");
    </script>
@endif
