jQuery(document).ready(function($) {

	$('.show_if_time').hide();
	$('.single_add_to_cart_button').attr('disabled','disabled');

	$('form.cart').on('change',function(){

		var formData = $(this).serializeArray(),
			dataObj = {};

		$(formData).each(function(i, field){
		  	dataObj[field.name] = field.value;
		});



		// calcute days and prices
		if(dataObj.pickup_date != undefined && dataObj.pickup_date != '' && dataObj.dropoff_date != undefined && dataObj.dropoff_date != '' && dataObj.pickup_time !=undefined && dataObj.pickup_time!=''){

			$('.booking_cost').show();
			$('.single_add_to_cart_button').removeAttr('disabled','disabled');


			/**
			 * Handling days and hours
			 *
			 * @since 1.0.0
			 * @return null
			 */
			var pickupDate  = Date.parse(dataObj.pickup_date).toString('M/d/yyyy'),
				dropoffDate = Date.parse(dataObj.dropoff_date).toString('M/d/yyyy');
			

			if(dataObj.pickup_time != '' && dataObj.dropoff_time == ''){
				var	pickupTime  = dataObj.pickup_time,
					dropoffTime = pickupTime;
			}else{
				var	pickupTime  = dataObj.pickup_time,
					dropoffTime = dataObj.dropoff_time;
			}




			var pickupDateTime = pickupDate + ' ' +pickupTime,
				dropoffDateTime = dropoffDate + ' ' +dropoffTime;

			var start = new Date(pickupDateTime),
				end   = new Date(dropoffDateTime),
				diff  = end.getTime() - start.getTime(),
				hours = diff/3600000,
				days,total_hours;


			if(hours < 24){
			  	days = 0;
			  	total_hours = Math.ceil(hours);

			  	$('.additional_person_info').trigger("chosen:updated");

			  	$('.show_person_cost_if_day').hide();
			  	$('.show_person_cost_if_time').show();

			  	// $('.show_if_day').children('.amount').css({'visibility': 'hidden'});
			  	$('.show_if_day').children('span').hide();
			  	$('.show_if_time').show();
			  	$('.single_add_to_cart_button').removeAttr('disabled','disabled');

			}else{
			  	days = parseInt(hours/24);
			  	var extra_hours = hours%24;
			  	if(extra_hours > parseFloat(BOOKING_DATA.all_data.max_time_late) ){
			  		days = days + 1;
			  	}

			  	$('.show_person_cost_if_day').show();
			  	$('.show_person_cost_if_time').hide();

			  	$('.additional_person_info').trigger("chosen:updated");
			  	$('.show_if_day').children('span').show();
			  	$('.show_if_time').hide();
			}


			/**
			 * Handling book now button on/off
			 *
			 * @since 1.0.0
			 * @return null
			 */
			var selected_days = new Array(),
				flag = 0,
				format;

			if(BOOKING_DATA.all_data.choose_date_format === 'Y/m/d'){
				format = 'yyyy/MM/dd';
			}

			if(BOOKING_DATA.all_data.choose_date_format === 'm/d/Y'){
				format = 'MM/dd/yyyy';
			}

			if(BOOKING_DATA.all_data.choose_date_format === 'd/m/Y'){
				format = 'dd/MM/yyyy';
			}

			for(var i = 0; i<parseInt(days) ; i++){
				if(i == 0){
					selected_days.push(Date.parse(pickupDate).toString(format));
				}else{
					selected_days.push(Date.parse(pickupDate).add(i).day().toString(format));
				}
			}


			for (var i = 0; i < selected_days.length; i++) {
			    for (var j = 0; j < BOOKING_DATA.block_dates.length; j++) {
			    	if(flag==0){
				        if (selected_days[i] == BOOKING_DATA.block_dates[j]) {
				        	$('.single_add_to_cart_button').attr('disabled','disabled');
				            sweetAlert("Oops...", "This date range is unavailable", "error");
				            flag = 1;
			          	}else{
			        		$('.single_add_to_cart_button').removeAttr('disabled','disabled');
			        	}
			        }
			    }
			}


			/**
			 * Calculate general pricing
			 *
			 * @since 1.0.0
			 * @return null
			 */
			if(BOOKING_DATA.all_data.pricing_type ==="general_pricing"){
				if(days > 0){
					var cost = parseInt(days)*parseFloat(BOOKING_DATA.all_data.general_pricing);
					cost = calculate_third_party_cost(cost);
				}else{
					var cost = parseInt(total_hours)*parseFloat(BOOKING_DATA.all_data.hourly_pricing);

					cost = calculate_hourly_third_party_cost(cost);
				}
			}


			/**
			 * Calculate resources and person cost
			 *
			 * @since 1.0.0
			 * @return number
			 */
			function calculate_third_party_cost(cost){
				return cost;
			}


			/**
			 * Calculate hourly resources and person cost
			 *
			 * @since 1.0.0
			 * @return number
			 */
			function calculate_hourly_third_party_cost(cost){
				return cost;
			}

			var currency = $('.currency-symbol').val();

			$('h3.booking_cost span').html(accounting.formatMoney(cost,currency));

		}else{


		}
	});

});