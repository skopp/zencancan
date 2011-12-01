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
	    	$('#option_menu').slideToggle();
	    });
		
		/*
	    $("body").mouseup(function(){ 
			$('#option_menu').slideUp();
	    });
		*/
		
	  /* menu tags */
	    $("#tags_menu").hide();
		
		$('#tags_btn').click(function(){
	    	$('#tags_menu').slideToggle();
	    });
		$('#login_close_btn').click(function(){
	    	$('#tags_menu').slideUp();
	    });
		
		
		$(".liste_billet").click(function() {window.location.href = $(this).find("a").attr("href"); });
		$(".siteTR").click(function() {window.location.href = $(this).find("a").attr("href"); });
		
   
});




	 
