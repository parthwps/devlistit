<?php $__env->startSection('content'); ?>

<main id="main" class="main">
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-2">
                    <h5 class="mt-2 mb-3" style="margin-left:15px;">Form Fields</h5>
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <select name="category" class="form-control catData">
                                    <option>Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <h3 class="text-light" style="font-size:15px;padding:10px 10px;border:1px solid #e8ebf0;border-radius:4px;margin-bottom:6px;background:#08c;border-color:#08c;">
                                    All Categories</h3>
                                <div class="card p-2 mt-2" id="dataRowContainer" style="border:1px solid #e8ebf0; border-radius:4px;">
                                    <div class=" ml-2" id="dataRow"> </div>
                                </div>
                            </div>
                            
                <div class="col-md-12 mt-3"> 
                <div class="alert alert-success" role="alert" style="display:none;" id="messgess">
                </div></div>


                        </div>
                        <div class="parentdiv" id="form_div" style="margin-left:-2px; margin-top: 20px;"> </div>
                        <div class="row" style="margin-left:-2px;" id="form_btn_submit">
                            <div class="col-md-12 mt-3"> <a id='submit-form' class="btn btn-outline-primary btn-sm mb-2">Submit</a> </div>
                        </div>
                    </form>
                    <div class="row" style="margin-left:-2px;" id="form_btn">
                        <div class="col-md-12 mt-3">
                            <input type="hidden" value="0" id="fval">
                            <input type="hidden" value="0" id="chval">
                            <button class="btn btn-outline-secondary btn-sm textfield mb-2"> <i class="fa fa-plus"></i> Text Field</button>
                            <button class="btn btn-outline-secondary btn-sm textarea mb-2"> <i class="fa fa-plus"></i> Text Area</button>
                            <button class="btn btn-outline-secondary btn-sm checkbox mb-2"> <i class="fa fa-plus"></i> Checkbox</button>
                            <button class="btn btn-outline-secondary btn-sm radio mb-2"> <i class="fa fa-plus"></i> Radio Button</button>
                            <button class="btn btn-outline-secondary btn-sm dropdown mb-2"> <i class="fa fa-plus"></i> Drop Down</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php $__env->stopSection(); ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function() {
    let lastcid = 1;
    $('#form_btn').hide();
    $('#submit-form').hide();
    $('#dataRowContainer').hide();
    $.ajax({
        'type': "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'url': "<?php echo e(url('/admin/car-specification/categoryData')); ?>",
        success: function(data) {
           // alert(data);
            $.each(data, function(key, value) {
                $('.catData').append(`<option value="${value.id}">${value.name}</option>`);
            });
        }
    });
    
    $(document).on('click', '.textfield', function() {
        var fval = $('#fval').val();
        fval++;
        $('#form_div').append('<div class="container-fluid">            <div class="row   mb-2" id="div' + fval + '" name="input"><div style="display: flex;"> <div class="col-md-2 col-3"> <h6 class="mt-2">Text Field <i class="ml-4 fa text-danger fa-trash delete" id="' + fval + '"></i>  </h6></div>  <div class="col-sm-8">    <div class="input-group mb-3">      <input type="text" name="textfield-label[]" class="form-control" placeholder="Enter a Label">      <div class="input-group-append">        <span class="input-group-text">          <input name="textfield-chk[]" type="checkbox" class="" style="margin-right:5px;"> Required field </span>      </div>    </div>  </div> </div>   <hr  id="hr' + fval + '" style="margin:10px; flex: 100%; "></div></div>');
        $('#fval').val(fval);
    });
    $(document).on('click', '.textarea', function() {
        var fval = $('#fval').val();
        fval++;
        $('#form_div').append('<div class="container-fluid"><div class="row mb-2" id="div' + fval + '" name="textarea"><div style="display: flex;"> <div class="col-md-2 col-3"><h6 class="mt-2">Text Area <i class="ml-4 fa text-danger fa-trash delete" id="' + fval + '"></i> </h6></div><div class="col-sm-8"><div class="input-group mb-3"><input type="text" name="textarea-label[]" class="form-control" placeholder="Enter a Label"><div class="input-group-append"><span class="input-group-text"><input name="textarea-chk[]" type="checkbox" class="" style="margin-right:5px;"> Required field</span></div></div></div></div><hr id="hr' + fval + '" style="margin:10px; flex: 100%;"></div></div>');
        $('#fval').val(fval);
    });
    $(document).on('click', '.checkbox', function() 
    {
        var fval = $('#fval').val();
        fval++;
        $('#form_div').append('<div class="container-fluid"><div class="row mb-2" id="div' + fval + '" name="checkbox"><input type="hidden" value="' + fval + '" id="fchkvalue' + fval + '"><div style="display: flex;"> <div class="col-md-2 col-3"><h6 class="mt-2">Checkbox <i class="ml-4 fa text-danger fa-trash delete" id="' + fval + '"></i> </h6></div><div class="col-sm-8"><div class="input-group mb-3"><input type="text" name="checkbox-label[]" class="form-control" placeholder="Enter a Label"><div class="input-group-append"><span class="input-group-text"><input name="textfield-chk[]" type="checkbox" class="" style="margin-right:5px;"> Required field</span></div></div></div></div><div class=" div' + fval + '" id="divchk' + fval + '"><div class="row div' + fval + '" id="div' + fval + 'chkrow1" style="margin-left: -5px;display: flex !important;"><div class="col-sm-2"></div><div class="col-sm-7 mb-3"><input type="text" name="checkbox-child-label[]" class="form-control" placeholder="Enter a Label"></div><div class="col-sm-3"><i class="ml-4 fa text-danger fa-trash childdelete" id="' + fval + 'chkrow1"" style="margin-top:10px;"></i></div></div></div></div><div class="row div' + fval + '"><div class="col-sm-4"></div>      <div class="col-4"><button type="button" data="' + fval + '" class="btn btn-outline-secondary btn-sm morechk mb-2"> <i class="fa fa-plus"></i> Checkbox</button></div></div><hr id="hr' + fval + '" style="margin:10px;"></div>');
        $('#fval').val(fval);
    });
    
    $(document).on('click', '.radio', function() 
    {
        var fval = $('#fval').val();
        fval++;
        $('#form_div').append('<div class="container-fluid">  <div class="row mb-2" id="div' + fval + '" name="radio">    <input type="hidden" value="' + fval + '" id="fradiovalue' + fval + '"> <div style="display: flex;"> <div class="col-md-2 col-3">      <h6 class="mt-2">Radio Button <i class="ml-4 fa text-danger fa-trash delete" id="' + fval + '"></i>      </h6>    </div>    <div class="col-sm-8">      <div class="input-group mb-3">        <input type="text" name="radio-label[]" class="form-control" placeholder="Enter a Label">        <div class="input-group-append"><span class="input-group-text"><input name="textfield-chk[]" type="checkbox" class="" style="margin-right:5px;    display: flex !important;"> Required field </span>        </div>      </div>    </div>    </div>    <div class=" div' + fval + '" id="divradio' + fval + '">      <div class="row div' + fval + '" id="div' + fval + 'radiorow1" style="margin-left: -5px;display: flex !important;">         <div class="col-sm-2"></div>        <div class="col-sm-7 mb-3"><input type="text" name="radio-child-label[]" class="form-control" placeholder="Enter a Label">        </div>        <div class="col-sm-3">          <i class="ml-4 fa text-danger fa-trash childdelete" id="' + fval + 'radiorow1"" style=" margin-top:10px;"></i>        </div>      </div>    </div>    <div class="row div' + fval + '">      <div class="col-sm-4"></div>      <div class="col-4">        <button type="button" data="' + fval + '" class="btn btn-outline-secondary btn-sm moreradio mb-2">          <i class="fa fa-plus"></i> Radio Button </button>      </div>    </div></div>');
        $('#fval').val(fval);
    });
    
    
    $(document).on('click', '.dropdown', function() 
    {
        var fval = $('#fval').val();
        var chval = $('#chval').val();
        fval++;
        chval++;
        $('#form_div').append('<div class="container-fluid">  <div class="row mb-2" id="div' + fval + '" name="select">    <input type="hidden" value="' + fval + '" id="fdropdownvalue' + fval + '">  <div style="display: flex;"> <div class="col-md-2 col-3">  <h6 class="mt-2">Drop Down <i class="ml-4 fa text-danger fa-trash delete" id="' + fval + '"></i>      </h6>    </div>    <div class="col-sm-8">      <div class="input-group mb-3">        <input type="text" name="dropdown-label[]" class="form-control" placeholder="Enter a Label">        <div class="input-group-append">          <span class="input-group-text">            <input name="textfield-chk[]" type="checkbox" class="" style="margin-right:5px;    display: flex !important;"> Required field </span>        </div>      </div>    </div>    </div>    <div class=" div' + fval + '" id="divdropdown' + fval + '">      <div class="row div' + fval + '" id="div' + fval + 'dropdownrow1" style="margin-left: -5px;display: flex !important;">        <div class="col-sm-2" ></div>        <div class="col-sm-7 mb-3" >          <input type="text" name="dropdown-child-label[]" class="form-control" placeholder="Enter a Label">        </div>        <div class="col-sm-3 ">          <i class="ml-4 fa text-danger fa-trash childdelete" id="' + fval + 'dropdownrow1"" style=" margin-top:10px;"></i></div></div></div></div>  <div class="row div' + fval + '">      <div class="col-sm-4"></div>      <div class="col-4">        <button type="button" data="' + fval + '" class="btn btn-outline-secondary btn-sm moredropdown mb-2">          <i class="fa fa-plus"></i> Option </button>      </div>    </div></div>');
        $('#fval').val(fval);
    });
    
    
    $(document).on('click', '.delete', function() 
    {
        var id = $(this).attr('id');
        $("#div" + id).remove();
        $(".div" + id).remove();
        $("#hr" + id).remove();
    });
    
    $(document).on('click', '.childdelete', function() 
    {
        var id = $(this).attr('id');
        console.log(id);
        $("#div" + id).remove();
    });
    
    $(document).on('click', '.morechk', function() 
    {
        var id = $(this).attr('data');
        
        var checkLength =  $('#divchk'+id).children().length;
           
        var fval = checkLength;
        
        fval++;
        $('#divchk' + id).append('<div class="row div' + id + '" id="div' + id + 'chkrow' + fval + '" style="margin-left: -5px;display:flex !important"><div class="col-sm-2"></div><div class="col-sm-7 mb-3"><input type="text" name="checkbox-label[]" class="form-control" placeholder="Enter a Label"></div><div class="col-sm-3 col-1"><i class="ml-4 fa text-danger fa-trash childdelete" id="' + id + 'chkrow' + fval + '" style="margin-top:10px;"></i></div></div></div>');
        $('#fchkvalue' + id).val(fval);
    });
    
    
    $(document).on('click', '.moreradio', function() 
    {
        var id = $(this).attr('data');
        var checkLength =  $('#divradio'+id).children().length;
        var fval = checkLength;
        fval++;
        $('#divradio' + id).append('<div class="row div' + id + '" id="div' + id + 'radiorow' + fval + '" style="margin-left: -5px;display:flex !important"><div class="col-sm-2"></div><div class="col-sm-7 mb-3"><input type="text" name="radio-label[]" class="form-control" placeholder="Enter a Label"></div><div class="col-sm-3 col-1"><i class="ml-4 fa text-danger fa-trash childdelete" id="' + id + 'radiorow' + fval + '" style="margin-top:10px;"></i></div></div></div>');
        $('#fradiovalue' + id).val(fval);
    });
    
    
    $(document).on('click', '.moredropdown', function() {
        var id = $(this).attr('data');
        var checkLength =  $('#divdropdown'+id).children().length;
        var fval = checkLength;
        fval++;
        $('#divdropdown' + id).append('<div class="row div' + id + '" id="div' + id + 'dropdownrow' + fval + '" style="margin-left: -5px;display:flex !important"><div class="col-sm-2"></div><div class="col-sm-7 mb-3"><input type="text" name="dropdown-label[]" class="form-control" placeholder="Enter a Label"></div><div class="col-sm-3 col-1"><i class="ml-4 fa text-danger fa-trash childdelete" id="' + id + 'dropdownrow' + fval + '" style="margin-top:10px;"></i></div></div></div>');
        $('#fdropdownvalue' + id).val(fval);
        console.log(fval);
    });
    $(".btn-light:eq(1)").click(function() {
        $("[data-toggle='popover']").popover('hide');
    });
    $(document).on('click', '.full', function() {
        let cid = $(this).attr('data');
        fetchCategoryData2(cid);
    });
    $(document).on('change', '.catData', function() {
        let cid = $(this).val();
        fetchCategoryData2(cid);
    });
    let dropdown = '';
    async function optionData(cid) {
        $.ajax({
            url: "<?php echo e(url('admin/fetchOptions')); ?>",
            type: "POST",
            data: {
                id: cid
            },
            success: function(res) {
                console.log(res);
            },
        });
    }

    function fetchCategoryData2(parent) {
        var cid = lastcid = parent;
        $.ajax({
            'type': "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
    'url': "<?php echo e(url('/admin/car-specification/fetch-subcategory-data')); ?>",
            data: {
                cid: cid
            },
            success: function(data) {
                if(data.length > 0) {
                    $('.nosub').hide();
                    $('.addsub').show();
                    $('#dataRowContainer').show();
                    $('#form_btn').hide();
                    $('#submit-form').hide();
                } else {
                    $('.nosub').show();
                    $('.addsub').show();
                    $('#form_btn').show();
                    $('#dataRowContainer').hide();
                    $('#submit-form').show();
                   // alert(cid);
                    $.ajax({
                        url: "<?php echo e(url('/admin/car-specification/fetchForm')); ?>",
                        type: "POST",
                        data: {
                            id: cid
                        },
                        success: function(res) {
                            $('#form_div').html(res.html);
                            $('#fval').val(res.divlen);
                        },
                    });
                }
                $('#dataRow').html("");
                $.each(data, function(key, value) {
                    $('#dataRow').append(`
                                <div class=" mb-2 p-2 border border-secondary"><div class="col-md-6 col-6 full" data="${value.id}">
                                    <i class="fal fa-bars" value="${value.id}" id="info"></i>&nbsp;&nbsp;&nbsp;${value.name}
                                </div>
                                
                                    
                                </div>
                            </div>
                        `);
                });
            }
        });
    }
    $(document).on('click', '#submit-form', function() {
        let selectValue = '';
        let textareaValue = '';
        let inputValue = '';
        let radioValue = '';
        let checkBoxValue = '';
        let optionValue = [];
        let radioOptionValue = [];
        let checkBoxOptionValue = [];
        let data = [];
        let formDivChildCount = $('#form_div > .container-fluid').length;


    $('#form_div > .container-fluid').each(function(index, element) 
    {
        let childID = $(element).find('.row').attr('id');
        let divName = $(element).find('.row').attr('name');

        if (divName == 'select') 
        {
            let div = $(element).find('.row').children();
            selectValue = $(div[1]).find('input').val();
            select_editable = $(div[1]).find('#select_editable').val();
            let i = 0;

            let IdIndex = childID.match(/\d+/)[0];

            $('#divdropdown'+IdIndex).children().each(function() 
            {
                let optDiv = $(this).attr('id');
                optionValue[i] = $('#' + optDiv).find('input').val();
                i++;
            });

            data.push({
                'label': selectValue,
                'is_editable': select_editable,
                'option': optionValue,
                'type': 'select'
            });

            optionValue = [];
        }
        
        else if (divName == 'input') 
        {
            let div = $(element).find('.row').children();
            inputValue = $(div).find('input').val();
            input_editable = $(div).find('#input_editable').val();
            
            data.push({
                'is_editable': input_editable,
                'label': inputValue,
                'type': 'input',
            });
        } 
        else if (divName == 'checkbox') 
        {
            let i = 0;
            let div = $(element).find('.row').children();
            
            
            checkBoxValue = $(div[1]).find('input').val();
            checkbox_editable = $(div[1]).find('#checkbox_editable').val();
        
            let IdIndex = childID.match(/\d+/)[0];

            $('#divchk'+IdIndex).children().each(function() 
            {
                let optDiv = $(this).attr('id');
                checkBoxOptionValue[i] = $('#' + optDiv).find('input').val();
                i++;
            });
            
            data.push({
                'is_editable': checkbox_editable,
                'label': checkBoxValue,
                'option': checkBoxOptionValue,
                'type': 'checkbox',
            });
             
            checkBoxOptionValue = [];
        } 
        else if (divName == 'textarea') 
        {
            let div = $(element).find('.row').children();
            textareaValue = $(div).find('input').val();
            textarea_editable = $(div[2]).find('#textarea_editable').val();
            
            
            data.push({
                'is_editable': textarea_editable,
                'label': textareaValue,
                'type': 'textarea',
            });
        } 
        else if (divName == 'radio') 
        {
            let i = 0;
            let div = $(element).find('.row').children();
            radioValue = $(div[1]).find('input').val();
            radio_editable = $(div[1]).find('#radio_editable').val();
            
            let IdIndex = childID.match(/\d+/)[0];

            $('#divradio'+IdIndex).children().each(function() 
            {
                let optDiv = $(this).attr('id');
                radioOptionValue[i] = $('#' + optDiv).find('input').val();
                i++;
            });
            
            data.push({
                'is_editable': radio_editable,
                'label': radioValue,
                'option': radioOptionValue,
                'type': 'radio',
            });
            
            radioOptionValue = [];
        }

      
    });

        $.ajax({
            url: "<?php echo e(url('/admin/car-specification/save-form-structure')); ?>",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: 
            {
                form: data,
                cid: lastcid,
            },
            success: function(response) 
            {
                if(response == 'success') 
                {
                    $('#messgess').removeClass('alert-danger');
                    $('#messgess').addClass('alert-success');
                    $('#messgess').html('Your filter has been saved successfully.');
                    $('#messgess').show();
                } 
                else if(response == 'fail') 
                {
                    $('#messgess').removeClass('alert-success');
                    $('#messgess').addClass('alert-danger');
                    $('#messgess').html('Something went wrong please refresh the page and try again.');
                    $('#messgess').show();
                }
                
               $('html, body').animate({ scrollTop: 0 }, 'slow');
            
            }
        });
    });
});
</script>
<style>
   .parentdiv .row {
        display: block !important;
    }
    #form_div {
        margin-left: 20px !important;
        margin-right: 20px !important;
        font-size: 14px !important;
    }
</style>

<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/car/category/formfields.blade.php ENDPATH**/ ?>