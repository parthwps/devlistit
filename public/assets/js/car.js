
"use strict";
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$(document).ready(function () {
  /*$('.js-example-basic-single1').select2();
  $('.js-example-basic-single2').select2();
  $('.js-example-basic-single3').select2();
  $('.js-example-basic-single4').select2();
  $('.js-example-basic-single5').select2();
  $('.js-example-basic-single6').select2();
  $('.js-example-basic-single7').select2();*/
  //$('.subhidden').addClass('hidden');
});
// get sub category
$("#adsMaincat").change(function(event) {
    // alert( "Change" );
    var adsmainCatId = $('#adsMaincat').val();
     $('.cararea').hide();
    //alert(caryear);
   // exit;
     event.preventDefault();
      var url = 'ads-subcat/'+adsmainCatId;
         $.ajax({
                type:'GET',
                url: url,
              
                success:function(data){
                    $('.subhidden').removeAttr('disabled');
                    $("#adsSubcat").html(data);
                    $("#adsSubcat").change();
                }
            });
  });

// get sub category
$("#adsSubcat").change(function(event) {
    //  alert( "Change car yes" );
    var adsmainCatId = $('#adsSubcat').val();
    $('#searcfilters').html("");
    $("#searcfiltersdata").html("");

    
    var url = '/customer/package/payoptions/'+adsmainCatId;
    $.ajax({
      type: 'GET',
      url: url,
      
      success: function (response) {
       
        if(response.make==1){

          // alert("if");
        
         // $('.cararea').show();
          $('#searcfilters').html(response.filters);
         
        } else{

          // alert("else");
    
          $('.cararea').hide();
          $('#searcfilters').html(response.filters);
        }
          $('#getVehDataManual').click()
          $('#payplans').html(response.data);
                
      }
    });
    
  });
  $(document).on("click", '.choosepackage', function(event) 
  { 
    $(".card-pricing-vendor").removeClass('pricing-selected');
    $(this).parent().parent().addClass('pricing-selected');
    $('#packageId').val($(this).data("id"));
    $('.choosepackage').html('Choose');
    $(this).html('<span class="c_check"><i class="fal fa-check fa-lg"></i></span> Choose');
    
    
        var url = '/customer/package/selected/'+$(this).data("id");
            $.ajax({
                type:'GET',
                url: url,
              
                success:function(response)
                {
                   if(response.code==200)
                   {
                        $('#packageSelected').html(response.data);
                        $('#change_text_photo_allow').html(response.photo_allowed);
                        $('#max_file_upload').val(response.photo_allowed);
                   }
                }
            });
    //alert($(this).parent().parent().attr('class'));
});

$(document).on("click", '.choosepromo', function(event) { 
  if($(this).is(":checked")){
    var promoPrice = 1;
    $('#promoStatus').val(1);
    
}
else if($(this).is(":not(:checked)")){
  var promoPrice = 0;
  $('#promoStatus').val(0);
}
  
      var url = '/customer/package/promoupdte?package_id='+$(this).data("id")+'&promo='+promoPrice;
          $.ajax({
              type:'GET',
              url: url,
            
              success:function(response){
                 if(response.code==200){
                  $('#packageSelected').html(response.data);
                  
                 }
                
              }
          });
  //alert($(this).parent().parent().attr('class'));
});
$(document).on("click", '#getVehData', function(event) { 

  alert("yes");

   var reg = $('#vregNo').val();
   if(reg.trim() == '') {
  //  alert("hello");
   } else {
    
     event.preventDefault();
      var url = '/vehicle-data/'+reg+'?catid='+ $("#adsSubcat option:selected").val();
         $.ajax({
                type:'GET',
                url: url,
              
                success:function(response)
                {
               if(response.is_enable == 0)
                    {
                       $("#car_registration_section").hide();
                    }
                    
                    
                    $("#searcfiltersdata").html(response.data);
                    $('#fuelType').change();
                }
            });
       }
  });
  $(document).on("click", '#getVehDataManual', function(event) { 

    //  alert( "Change" );
   var reg = "7007";
   if(reg.trim() == '') {
   //alert("hello");
   } else {
    
     event.preventDefault();
      var url = '/vehicle-data/'+reg+'?catid='+ $("#adsSubcat option:selected").val();
         $.ajax({
                type:'GET',
                url: url,
              
                success:function(response){
                    
                    if(response.is_enable == 0)
                    {
                       $("#car_registration_section").hide();
                    }
               
                    $("#searcfiltersdata").html(response.data);
                }
            });
       }
  });





$('body').on('change', '.js-example-basic-single3', function () {
  $('.request-loader').addClass('show');
  var id = $(this).val();
  var lang = $(this).attr('data-code');
  var added = lang + "_car_brand_model_id";

  $('.' + added + ' option').remove();
  $.ajax({
    type: 'POST',
    url: getBrandUrl,
    data: {
      id: id,
      lang: lang
    },
    success: function (data) {
      $.each(data, function (key, value) {
        $('.' + added).append($('<option></option>').val(value.id).html(value
          .name));
      });

      $('.request-loader').removeClass('show');
    }
  });

});
