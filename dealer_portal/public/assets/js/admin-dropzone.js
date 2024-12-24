(function ($) {
  "use strict";

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  // Dropzone initialization
    // Dropzone.options.myDropzone = {
    // acceptedFiles: '.png, .jpg, .jpeg',
    // maxFiles: 15,
    // url: storeUrl,
    // success: function (file, response) {
    //   function updateImageCount() {
    //     let count = $(".dropzone .dz-preview").length;
    //     let remaining = 15 - count; // Calculate remaining images
    //     $("#imageCount").text(`${count} uploaded, ${remaining} remaining out of 15`).css({"color": "red", "font-weight": "bold"}); // Update text to show remaining count
    //   }
    //    var dataId = response.file_id;

    //     file.previewElement.dataset.id = dataId;

    //     $("#sliders").append(`<input type="hidden" name="slider_images[]" data-id="${dataId}" value="${dataId}">`);

    //     var removeButton = Dropzone.createElement("<button class='rmv-btn'><i class='fa fa-times'></i></button>");

    //     var chkBox = Dropzone.createElement(`<div><input class='form-check-input customRadio' value='${dataId}' type='radio' name='flexRadioDefault' id='chkbo'><label class='customRadiolabel'> Set cover</label></div>`);

    //     var rotateButton = Dropzone.createElement("<button class='rotate-btn' title='rotate'><i class='fa fa-undo'></i></button>");

    //   // Capture the Dropzone instance as closure.
    //   var _this = this;
    //   // Listen to the click event
    //   removeButton.addEventListener("click", function (e) {
    //     // Make sure the button click doesn't submit the form:
    //     e.preventDefault();
    //     e.stopPropagation();

    //     _this.removeFile(file);

    //     rmvimg(response.file_id);
    //     updateImageCount();
    //   });

    //   var rotationAngle = 0;
    //  rotateButton.addEventListener("click", function (e) {
    // // Make sure the button click doesn't submit the form:
    // e.preventDefault();
    // e.stopPropagation();

    // // Find the image element within the file preview element
    // var imageElement = file.previewElement.querySelector('img');

    // if (imageElement) {
    //     // Increment the rotation angle by 90 degrees
    //     rotationAngle += 90;

    //     // Apply the rotation to the image element
    //     imageElement.style.transform = "rotate(" + rotationAngle + "deg)";

    //     // Reset rotation to 0 if it reaches 360 degrees
    //     if (rotationAngle === 360) {
    //         rotationAngle = 0;
    //     }

    //     rotateSave(response.file_id , rotationAngle);

    //      }
    // });


    //   // Add the button to the file preview element.
    //   file.previewElement.appendChild(removeButton);
    //   file.previewElement.appendChild(chkBox);
    //   file.previewElement.appendChild(rotateButton);

    //   if (typeof response.error != 'undefined') {
    //     if (typeof response.file != 'undefined') {
    //       document.getElementById('errpreimg').innerHTML = response.file[0];
    //     }
    //   }


    //    // Initialize sortable
    //                 $(".dropzone").sortable({
    //                     items: '.dz-preview',
    //                     cursor: 'move',
    //                     opacity: 0.5,
    //                     containment: '.dropzone',
    //                     distance: 20,
    //                     tolerance: 'pointer',
    //                     stop: function(event, ui)
    //                     {
    //                         var newOrder = [];
    //                         $('.dropzone .dz-complete').each(function(index)
    //                         {
    //                             var dataId = $(this).data('id');
    //                             newOrder.push({ id: dataId, priority: index + 1 });
    //                         });

    //                         $.ajax({
    //                             type: "POST",
    //                             url: "/vendor/car-management/img-drag",
    //                             data: { order: newOrder },
    //                             success: function(response)
    //                             {
    //                                 console.log("Priority updated successfully: " + response);
    //                             },
    //                             error: function(xhr, status, error)
    //                             {
    //                                 console.error("Failed to update priority: " + error);
    //                             }
    //                         });

    //                         var cloned = $('div#sliders').clone();
    //                         $('#sliders').html("");
    //                         newOrder.forEach(function(item) {
    //                             $(cloned).find(`input[data-id="${item.id}"]`).clone().appendTo($('#sliders'));
    //                         });
    //                     }
    //                 });

    //                 updateImageCount();

    // }

    // };
    // updateImageCount();
    Dropzone.options.myDropzone = {
      acceptedFiles: '.png, .jpg, .jpeg',
      maxFiles: 15,
      url: storeUrl,
      init: function () {
          let _this = this;
          this.on("maxfilesexceeded", function (file) {
            this.removeFile(file); // Automatically remove the excess file
            toastr.error("You can only upload up to 15 files.");
        });
          function updateImageCount() {
            let count = $(".dropzone .dz-preview").length; // Get the current count of files
              let remaining = 15 - count;    // Calculate remaining slots
              $("#imageCount")
                  .text(`${count} uploaded, ${remaining} remaining out of 15`)
                  .css({ "color": "red", "font-weight": "bold" });
          }

          this.on("success", function (file, response) {
              if (response.error) {
                  $("#errpreimg").text(response.error);
                  return;
              }

              var dataId = response.file_id;
              file.previewElement.dataset.id = dataId;

              $("#sliders").append(
                  `<input type="hidden" name="slider_images[]" data-id="${dataId}" value="${dataId}">`
              );

              var removeButton = Dropzone.createElement(
                  "<button class='rmv-btn'><i class='fa fa-times'></i></button>"
              );
              var chkBox = Dropzone.createElement(
                  `<div><input class='form-check-input customRadio' value='${dataId}' type='radio' name='flexRadioDefault' id='chkbo'>
                   <label class='customRadiolabel'> Set cover</label></div>`
              );
              var rotateButton = Dropzone.createElement(
                  "<button class='rotate-btn' title='rotate'><i class='fa fa-undo'></i></button>"
              );

              // Add functionality to buttons
              let rotationAngle = 0;

              removeButton.addEventListener("click", function (e) {
                  e.preventDefault();
                  e.stopPropagation();

                  _this.removeFile(file); // Remove file from Dropzone
                  rmvimg(dataId); // Custom function for backend removal
                  updateImageCount(); // Update the count
              });

              rotateButton.addEventListener("click", function (e) {
                  e.preventDefault();
                  e.stopPropagation();

                  let imageElement = file.previewElement.querySelector("img");
                  if (imageElement) {
                      rotationAngle += 90;
                      if (rotationAngle === 360) rotationAngle = 0;

                      imageElement.style.transform = `rotate(${rotationAngle}deg)`;
                      rotateSave(dataId, rotationAngle); // Custom function for saving rotation
                  }
              });

              // Append buttons to file preview element
              file.previewElement.appendChild(removeButton);
              file.previewElement.appendChild(chkBox);
              file.previewElement.appendChild(rotateButton);

              // Make previews sortable
              $(".dropzone").sortable({
                  items: ".dz-preview",
                  cursor: "move",
                  opacity: 0.5,
                  containment: ".dropzone",
                  distance: 20,
                  tolerance: "pointer",
                  stop: function () {
                      let newOrder = [];
                      $(".dropzone .dz-complete").each(function (index) {
                          let dataId = $(this).data("id");
                          newOrder.push({ id: dataId, priority: index + 1 });
                      });

                      $.ajax({
                          type: "POST",
                          url: "/vendor/car-management/img-drag",
                          data: { order: newOrder },
                          success: function (response) {
                              console.log("Priority updated successfully:", response);
                          },
                          error: function (xhr, status, error) {
                              console.error("Failed to update priority:", error);
                          }
                      });

                      let cloned = $("#sliders").clone();
                      $("#sliders").empty();
                      newOrder.forEach(function (item) {
                          cloned
                              .find(`input[data-id="${item.id}"]`)
                              .clone()
                              .appendTo($("#sliders"));
                      });
                  }
              });

              updateImageCount(); // Update count after successful upload
          });

          this.on("removedfile", function () {
              updateImageCount(); // Ensure count updates after any file removal
          });
      }
  };


    function rotateSave(fileid , rotationEvnt)
    {
        var requestMethid = "POST";

        if($('#request_method').val() != '')
        {
           var requestMethid = "GET";
        }

       $.ajax({
      url: '/vendor/car-management/img-db-rotate',
      type: requestMethid,
      data: {
        fileid: fileid , rotationEvnt:rotationEvnt
      },
      success: function (data)
      {

      }
    });
    }

  function rmvimg(fileid)
  {

    $.ajax({
      url: removeUrl,
      type: requestMethid,
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
          content.message = 'Slider image deleted successfully!';
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
