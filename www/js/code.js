this.tooltip = function(){	
	/* CONFIG */		
		xOffset = -12;
		yOffset = -86;		
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result		
	/* END CONFIG */		
	$(".tooltip").hover(function(e){											  
		this.t = this.title;
		this.title = "";									  
		$("body").append("<p id='tooltip'>"+ this.t +"</p>");
		$("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");		
    },
	function(){
		this.title = this.t;		
		$("#tooltip").remove();
    });	
	$(".tooltip").mousemove(function(e){
		$("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};


$(document).ready(function() {

		
		/* tooltip */
		tooltip();


	  /* menu options */
	    $("#option_menu").hide();
		
		$('#option_btn').click(function(){
	    	$('#option_menu').slideDown();
	    });
		
	    $("body").mouseup(function(){ 
			$('#option_menu').slideUp();
	    });

	  /* menu tags */
	    $("#tags_menu").hide();
		
		$('#tags_btn').click(function(){
	    	$('#tags_menu').slideToggle();
	    });
   
   	/* gestion des images */
	
	var max_width = 128;
	$('.ilu_billet').each(function () {
		if ( $(this).width() > max_width ) {
			$(this).css("width", "128px");
			$(this).css("max-height", "80px");
		}
	});
	
   
   
});




	 
