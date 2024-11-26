<script>
  'use strict';
   const baseUrl = "<?php echo e(url('/')); ?>";
</script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/popper.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery-ui.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.ui.touch-punch.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.timepicker.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.scrollbar.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap-notify.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/sweet-alert.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap-tagsinput.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap-datepicker.min.js')); ?>"></script>


<script src="<?php echo e(asset('assets/js/tinymce/js/tinymce/tinymce.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/jscolor.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/fontawesome-iconpicker.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/datatables-1.10.23.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/datatables.bootstrap4.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/dropzone.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/atlantis.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/webfont.min.js')); ?>"></script>


  
  
        <div class="modal fade" id="showremarkModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">User Remarks</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                 <div class="row" id="remarks_body"> </div>
              </div>
              
            </div>
          </div>
        </div>


        <script type="text/javascript">
        
        
      document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const passwordField = this.closest('.input-group').querySelector('input');
            const icon = this.querySelector('i');

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
            
         });
      });
    
 
         function remarksRead(self)
        {
          var remove_option = $(self).data("remark");
          var recommendation = $(self).data("recommendation");
          var remove_remarks = $(self).data("remove_remarks");
          console.log(remove_option)
          
          $('#remarks_body').html(' <div class="col-md-12"> <label style="font-weight: bold;">Status  </label> <div>'+remove_option+'</div></div> <div class="col-md-12" style="margin-top: 1rem;"> <label style="font-weight: bold;" >Recommendation for other users </label><div>'+recommendation+'</div></div><div class="col-md-12" style="margin-top: 1rem;" ><label style="font-weight: bold;" >Remarks</label><div>'+remove_remarks+'</div></div>');
          
          $('#showremarkModal').modal('show')
        }
         
        $(document).ready(function() 
        {
            let startYear = 1800;
            let endYear = new Date().getFullYear();
            let selectedValue = $('#selected_value').val(); // Get the selected year value

            // Check if selectedValue is valid
            if (selectedValue && !isNaN(selectedValue)) {
                // Convert selectedValue to a number
                selectedValue = parseInt(selectedValue);
            } else {
                // Set default if selectedValue is invalid
                selectedValue = null;
            }

            // Ensure yearpicker is empty before appending options
            $('#yearpicker').empty();

            for (let i = endYear; i >= startYear; i--) {
                let option = $('<option />').val(i).html(i);
                $('#yearpicker').append(option);

                // Check if the current option value matches the selected value
                if (i === selectedValue) {
                    option.prop('selected', true); // Set this option as selected
                }
            }
        });
    </script>
    
<?php if(session()->has('success')): ?>
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
<?php endif; ?>

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

<script>
  'use strict';
  const account_status = 1;
  const secret_login = 1;
</script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/select2.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/admin-main.js')); ?>"></script>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/partials/scripts.blade.php ENDPATH**/ ?>