jQuery(document).ready(function($) {

	   
	$( '.add_redq_row' ).click(function(){		
		$(this).closest('table').find('tbody').append( $( this ).data( 'row' ) );
		$('body').trigger('row_added');
		return false;
	});

	$('body').on('click', 'button.remove_row', function(){
		$(this).closest('.redq-remove-rows').remove();
		return false;
	});

	$('.redq-hide-row').hide();

	$('body').on('click', '.show-or-hide', function(e) {
        $(this).closest('div.redq-show-bar').next('div.redq-hide-row').slideToggle();
        return false;
    });	

	$( ".sortable" ).sortable({
		cursor: 'move'
	});
    $( ".sortable" ).disableSelection();


    $('.daily-pricing-panel').hide();
    $('.monthly-pricing-panel').hide();

    var pricingType = $('#pricing_type').val();

    if(pricingType == 'daily_pricing'){
		$('.daily-pricing-panel').show();
		$('.general-pricing-panel').hide();
		$('.monthly-pricing-panel').hide();
        $('.redq-days-range-panel').hide();
	}else if(pricingType == 'monthly_pricing'){
		$('.daily-pricing-panel').hide();
		$('.general-pricing-panel').hide();
		$('.monthly-pricing-panel').show();
         $('.redq-days-range-panel').hide();
	}else if(pricingType == 'days_range'){
        $('.daily-pricing-panel').hide();
        $('.general-pricing-panel').hide();
        $('.monthly-pricing-panel').hide();
        $('.redq-days-range-panel').show();
    }else{
		$('.daily-pricing-panel').hide();
		$('.general-pricing-panel').show();
		$('.monthly-pricing-panel').hide();
        $('.redq-days-range-panel').hide();
	}


    $('#pricing_type').change(function(){
    	var pricingType = this.value;

    	if(pricingType == 'daily_pricing'){
            $('.daily-pricing-panel').show();
            $('.general-pricing-panel').hide();
            $('.monthly-pricing-panel').hide();
            $('.redq-days-range-panel').hide();
        }else if(pricingType == 'monthly_pricing'){
            $('.daily-pricing-panel').hide();
            $('.general-pricing-panel').hide();
            $('.monthly-pricing-panel').show();
             $('.redq-days-range-panel').hide();
        }else if(pricingType == 'days_range'){
            $('.daily-pricing-panel').hide();
            $('.general-pricing-panel').hide();
            $('.monthly-pricing-panel').hide();
            $('.redq-days-range-panel').show();
        }else{
            $('.daily-pricing-panel').hide();
            $('.general-pricing-panel').show();
            $('.monthly-pricing-panel').hide();
            $('.redq-days-range-panel').hide();
        }

    })

    $('body').on('.add_redq_row', function(){       
    	
        $( '.date-picker' ).datepicker({
            dateFormat: 'mm/dd/yy',
            numberOfMonths: 1,
            showButtonPanel: true,
            showOn: 'button',            
            buttonImageOnly: true
        });
    });



    // date date-picker
    var date_format;
    if(redq_rental_writepanel_js_params.all_data.choose_date_format != undefined){
        if(redq_rental_writepanel_js_params.all_data.choose_date_format.toLowerCase() === 'd/m/y'){
        date_format = 'd/m/yy'; 
        }

        if(redq_rental_writepanel_js_params.all_data.choose_date_format.toLowerCase() === 'm/d/y'){
            date_format = 'm/d/yy'; 
        }

        if(redq_rental_writepanel_js_params.all_data.choose_date_format.toLowerCase() === 'Y/m/d'){
            date_format = 'yy/m/d'; 
        }
    }
    

    $('body').on('row_added', function(){
        $( '.date-picker' ).datepicker({
            dateFormat: date_format,
            numberOfMonths: 1,
            showButtonPanel: true,
            showOn: 'button',
            buttonImage: redq_rental_writepanel_js_params.calendar_image,
            buttonImageOnly: true
        });
    });
    

    $('body').on('click', 'td.remove', function(){
        $(this).closest('tr').remove();
        return false;
    });

    $(function() {
        $('.up-icon-picker').iconPicker();
    });


    $('body').on('click','.resource-handle-div',function(){
        if($(this).closest('.redq-show-bar').next('.redq-hide-row').children('p.resource_applicable_field').children('select#resource_applicable').val() == 'per_day'){
            $(this).closest('.redq-show-bar').next('.redq-hide-row').children('p.resource_hourly_cost_field').show();       
        }else{
            $(this).closest('.redq-show-bar').next('.redq-hide-row').children('p.resource_hourly_cost_field').hide();
        }        
    });


    $('body').on('change', 'select#resource_applicable', function(){        
        if($(this).val() != 'one_time'){
            $(this).closest('.resource_applicable_field').next('p.resource_hourly_cost_field').show();     
        }else{
            $(this).closest('.resource_applicable_field').next('p.resource_hourly_cost_field').hide();
        }
        return false;
    });


    $('body').on('click','.person-handle-div',function(){
        if($(this).closest('.redq-show-bar').next('.redq-hide-row').children('p.person_cost_applicable_field').children('select#person_cost_applicable').val() == 'per_day'){
            $(this).closest('.redq-show-bar').next('.redq-hide-row').children('p.person_hourly_cost_field').show();       
        }else{
            $(this).closest('.redq-show-bar').next('.redq-hide-row').children('p.person_hourly_cost_field').hide();
        }        
    });
    
    $('body').on('change', 'select#person_cost_applicable', function(){        
        if($(this).val() != 'one_time'){
            $(this).closest('.person_cost_applicable_field').next('p.person_hourly_cost_field').show();     
        }else{
            $(this).closest('.person_cost_applicable_field').next('p.person_hourly_cost_field').hide();
        }
        return false;
    });


     $('body').on('click','.security_deposite-handle-div',function(){
        if($(this).closest('.redq-show-bar').next('.redq-hide-row').children('p.security_deposite_applicable_field').children('select#security_deposite_applicable').val() == 'per_day'){
            $(this).closest('.redq-show-bar').next('.redq-hide-row').children('p.security_deposite_hourly_cost_field').show();       
        }else{
            $(this).closest('.redq-show-bar').next('.redq-hide-row').children('p.security_deposite_hourly_cost_field').hide();
        }        
    });


    $('body').on('change', 'select#security_deposite_applicable', function(){        
        if($(this).val() != 'one_time'){
            $(this).closest('.security_deposite_applicable_field').next('p.security_deposite_hourly_cost_field').show();     
        }else{
            $(this).closest('.security_deposite_applicable_field').next('p.security_deposite_hourly_cost_field').hide();
        }
        return false;
    });




});