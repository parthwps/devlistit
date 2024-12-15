
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
    //  alert( "Change" );
    var adsmainCatId = $('#adsSubcat').val();
    $('#searcfilters').html("");
    $("#searcfiltersdata").html("");

    
    var url = '/vendor/package/payoptions/'+adsmainCatId;
    $.ajax({
      type: 'GET',
      url: url,
      
      success: function (response) {
       
        if(response.make==1){
        
         // $('.cararea').show();
          $('#searcfilters').html(response.filters);
         
        } else{
    
          $('.cararea').hide();
          $('#searcfilters').html(response.filters);
        }
       
          $('#payplans').html(response.data);
                
      }
    });
    
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
  
      var url = '/vendor/package/promoupdte?package_id='+$(this).data("id")+'&promo='+promoPrice;
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


  $(document).on("click", '.choosepackage', function(event) { 
    $(".card-pricing-vendor").removeClass('pricing-selected');
    $(this).parent().parent().addClass('pricing-selected');
    $('#packageId').val($(this).data("id"));
    $('.choosepackage').html('Choose');
    $(this).html('<span class="c_check"><i class="fal fa-check fa-lg"></i></span> Choose');
    
    
        var url = '/vendor/package/selected/'+$(this).data("id");
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




$("#getVehData").click(function(event) {
    //  alert( "Change" );
   var reg = $('#vregNo').val();
   if(reg.trim() == '') {
   alert("hello");
   } else {
    
     event.preventDefault();
      var url = '/vehicle-data/'+reg;
         $.ajax({
                type:'GET',
                url: url,
              
                success:function(data){
                  // alert(data.data.response);
                   $(".carmake").val(data.data.makeID).attr("selected","selected");
                   $('select[name="en_brand_id"]').find('option[value="'+data.data.makeID+'"]').attr("selected",true);
                   $('#carModel').append($('<option></option>').val(data.data.modelID).html(data.data.Model));
                   $('#carYear').val(data.data.BuildYear);
                   $('select[name="en_fuel_type_id"]').find('option:contains("'+data.data.FuelType+'")').attr("selected",true);
                    const   word = data.data.BodyType.charAt(0) + data.data.BodyType.substring(1).toLowerCase();
                   $('select[name="en_transmission_type_id"]').find('option:contains("'+data.data.Transmission+'")').attr("selected",true);
                    const   colour = data.data.Colour.charAt(0) + data.data.Colour.substring(1).toLowerCase();
                   $('select[name="en_car_condition_id"]').find('option:contains("'+colour+'")').attr("selected",true);
                   $('select[name="BodyType"]').find('option:contains("'+word+'")').attr("selected",true);
                   $('#engineCapacity').val(data.data.EngineCapacity);
                   // $('.subhidden').removeAttr('disabled');
                    //$("#adsSubcat").html(data);
                }
            });
       }
  });


$(document).on("click", '#getVehData2', function(event) { 

    //  alert( "Change" );
   var reg = $('#vregNo').val();
   if(reg.trim() == '') {
   //alert("hello");
   } else {
    
     event.preventDefault();
      var url = '/vehicle-data2/'+reg+'?catid='+ $("#adsSubcat option:selected").val();
         $.ajax({
                type:'GET',
                url: url,
              
                success:function(response){
               
                    $("#searcfiltersdata").html(response.data);
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
      var url = '/vehicle-data2/'+reg+'?catid='+ $("#adsSubcat option:selected").val();
         $.ajax({
                type:'GET',
                url: url,
              
                success:function(response){
               
                    $("#searcfiltersdata").html(response.data);
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
