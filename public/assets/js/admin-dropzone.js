(function ($) {
  "use strict";

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
     Dropzone.autoDiscover = false;

        $(document).ready(function() {

          function updateImageCount() {

            let count = $(".dropzone .dz-preview").length;
            let remaining = 15 - count; // Calculate remaining images
            if (count > 15) {
              toastr.error("You can upload a maximum of 15 images.");
              remaining = 0; // Ensure remaining count does not go negative
              count = 15;
          }
            $("#imageCount").text(`${count} uploaded, ${remaining} remaining out of 15`).css({"color": "red", "font-weight": "bold"}); // Update text to show remaining count
          }


            // Dropzone initialization
            var myDropzone = new Dropzone("#my-dropzone", {
                acceptedFiles: '.png, .jpg, .jpeg',
                maxFiles: 15,
                url: storeUrl,
                success: function(file, response)
                {
                    var dataId = response.file_id;

                    file.previewElement.dataset.id = dataId;

                    $("#sliders").append(`<input type="hidden" name="slider_images[]" data-id="${dataId}" value="${dataId}">`);

                    var removeButton = Dropzone.createElement("<button class='rmv-btn'><i class='fa fa-times'></i></button>");

                    var chkBox = Dropzone.createElement(`<div><input class='form-check-input customRadio' value='${dataId}' type='radio' name='flexRadioDefault' id='chkbo'><label class='customRadiolabel'> Set cover</label></div>`);

                    var rotateButton = Dropzone.createElement("<button class='rotate-btn' title='rotate'><i class='fa fa-undo'></i></button>");

                    var _this = this;

                    removeButton.addEventListener("click", function (e) {
                      e.preventDefault();
                      e.stopPropagation();
                      _this.removeFile(file);
                      $(`input[data-id="${dataId}"]`).remove();
                      rmvimg(dataId);
                      updateImageCount(); // Update count on remove
                  });


                    var rotationAngle = 0;
                    rotateButton.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var imageElement = file.previewElement.querySelector('img');

                        if (imageElement) {
                            rotationAngle += 90;
                            imageElement.style.transform = "rotate(" + rotationAngle + "deg)";

                            if (rotationAngle === 360) {
                                rotationAngle = 0;
                            }

                            rotateSave(dataId, rotationAngle);
                        }
                    });

                    file.previewElement.appendChild(removeButton);
                    file.previewElement.appendChild(chkBox);
                    file.previewElement.appendChild(rotateButton);

                    if (typeof response.error !== 'undefined') {
                        if (typeof response.file !== 'undefined') {
                            document.getElementById('errpreimg').innerHTML = response.file[0];
                        }
                    }

                    // Initialize sortable
                    $(".dropzone").sortable({
                        items: '.dz-preview',
                        cursor: 'move',
                        opacity: 0.5,
                        containment: '.dropzone',
                        distance: 20,
                        tolerance: 'pointer',
                        stop: function(event, ui)
                        {
                            var newOrder = [];
                            $('.dropzone .dz-complete').each(function(index)
                            {
                                var dataId = $(this).data('id');
                                newOrder.push({ id: dataId, priority: index + 1 });
                            });

                            $.ajax({
                                type: "POST",
                                url: "/customer/ad-management/img-drag",
                                data: { order: newOrder },
                                success: function(response)
                                {
                                    console.log("Priority updated successfully: " + response);
                                },
                                error: function(xhr, status, error)
                                {
                                    console.error("Failed to update priority: " + error);
                                }
                            });

                            var cloned = $('div#sliders').clone();
                            $('#sliders').html("");
                            newOrder.forEach(function(item) {
                                $(cloned).find(`input[data-id="${item.id}"]`).clone().appendTo($('#sliders'));
                            });
                        }
                    });
                    updateImageCount(); // Update count on add

                },
                removedfile: function (file) {
                  var dataId = file.previewElement.dataset.id;
                  $(`input[data-id="${dataId}"]`).remove();
                  file.previewElement.remove();
                  rmvimg(dataId); // Call custom function to handle backend removal
                  updateImageCount(); // Update count on remove
              }

            });
            updateImageCount(); // Initialize count on page load

        });

    function rotateSave(fileid , rotationEvnt)
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

  function rmvimg(fileid) {
    // If you want to the delete the file on the server as well,
    // you can do the AJAX request here.

    $.ajax({
      url: removeUrl,
      type: 'POST',
      data: {
        fileid: fileid
      },
      success: function (data) {
        $("#slider" + fileid).remove();
      }
    });

  }


    $(document).on('click', '.customRadio', function ()
    {
         var imageContainer = $(this).closest('.dz-preview');

            // Move this container to the top of its parent
            imageContainer.parent().prepend(imageContainer);

        $("#defaultImg").val($(this).val());
    });


  //remove existing images
  $(document).on('click', '.rmvbtndb', function () {
    let indb = $(this).data('indb');
    $(".request-loader").addClass("show");
    $.ajax({
      url: rmvdbUrl,
      type: 'POST',
      data: {
        fileid: indb
      },
      success: function (data) {
        $(".request-loader").removeClass("show");
        var content = {};
        if (data == 'false') {
          content.message = "You can't delete all images.!!";
          content.title = 'Warning';
          var type = 'warning';
        } else {
          $("#trdb" + indb).remove();
          content.message = 'Image deleted successfully!';
          content.title = 'Success';
          var type = 'success';
        }

        content.icon = 'fa fa-bell';

        $.notify(content, {
          type: type,
          placement: {
            from: 'top',
            align: 'right'
          },
          showProgressbar: true,
          time: 1000,
          delay: 4000
        });
      }
    });
  });
})(jQuery);
