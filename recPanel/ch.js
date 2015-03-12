var ch = {
	init: function (theme,color) {	
  	$('.checkboxesContainer > input').on('ifChanged', function(event){
  		var obj = ch.getRecommendationOptions();
  		var text = '';
  		var allSelected=true;
  		for(key in obj){
  			if (obj[key])
    			text+=translate(key)+', ';
    		else
    			allSelected=false;
  		};
  		text = text.substring(0, text.length - 2);
  		if (allSelected)
  			text=translate('All');
  	  $('#checkboxesValues').text(text)
  	});

  	$('.checkboxesContainer > input').iCheck({
  		// handle: 'checkbox',
  		checkboxClass: 'icheckbox_'+theme+'-'+color,
  	  // labelHover: false,
	    // increaseArea: '20%',
  	  // cursor: true,
  	});
		$('#checkboxesContainer').slideUp(0);

  	$('#checkboxesButton').click(function () {
  		$('#checkboxesContainer').slideToggle(100);
  	});
    $(window).on('click', function(e){ 
      $('#checkboxesContainer').slideUp(100);
    }); 
    $("#checkboxesContainer").on("click", function(e){e.stopPropagation();});
    $("#checkboxesButton").on("click", function(e){e.stopPropagation();});
  },
	getRecommendationOptions: function() {
		return {
			"artist": $('#checkbox1').is(':checked'),
			"volume": $('#checkbox2').is(':checked'),
			"tempo": $('#checkbox3').is(':checked'),
			"pitch": $('#checkbox4').is(':checked'),
			"genre": $('#checkbox5').is(':checked'),
			"year": $('#checkbox6').is(':checked')
		};
	}
}