jQuery(document).ready(function($) {
	
	console.log(BOOKING_DATA);
	/**
	 * Configuratin of date picker for pickupdate
	 *
	 * @since 1.0.0
	 * @return null
	 */	
	$('#pickup-date').datetimepicker({
	  	timepicker:false,
	  	scrollMonth: false,
	  	format:'m/d/Y',	  	
	  	minDate: 0,
	  	disabledDates: BOOKING_DATA.block_dates,
	  	formatDate: 'm/d/Y',	  	
	  	onShow:function( ct ){
			this.setOptions({
		    	maxDate:jQuery('#dropoff-date').val()?jQuery('#dropoff-date').val():false,		    	
		   	})
		},	  	 
	});


	/**
	 * Configuratin of time picker for pickuptime
	 *
	 * @since 1.0.0
	 * @return null
	 */	
	$('#pickup-time').datetimepicker({
	  	datepicker:false,
	  	format:'H:i',	  	 
	  	step:5
	});


	/**
	 * Configuratin of time picker for dropoffdate
	 *
	 * @since 1.0.0
	 * @return null
	 */	
	$('#dropoff-date').datetimepicker({
	  	timepicker:false,
	  	scrollMonth: false,
	  	format:'m/d/Y',	  	
	  	minDate: 0,
	  	disabledDates: BOOKING_DATA.block_dates,
	  	formatDate: 'm/d/Y',
	  	formatTime : 'H:i',
	  	onShow:function( ct ){
			this.setOptions({
		    	minDate:jQuery('#pickup-date').val()?jQuery('#pickup-date').val():false,		    	
		   	})
		},	  	 
	});


	/**
	 * Configuratin of time picker for dropofftime
	 *
	 * @since 1.0.0
	 * @return null
	 */	
	$('#dropoff-time').datetimepicker({
	  	datepicker:false,
	  	format:'H:i',
	  	onShow:function( ct ){
			this.setOptions({
		    	minTime:jQuery('#pickup-time').val()?jQuery('#pickup-time').val():false,		    	
		   	})
		},
	  	step:5
	});


	/**
	 * Configuratin others pluins
	 *
	 * @since 1.0.0
	 * @return null
	 */	
	$('.redq-select-boxes').chosen();
	$('.price-showing').flip();


});