var tickerItems = new Array();
var count = new Array();
var tickerText = new Array();
var c = new Array();

function scroll_ticker_create(id){
   	var scroll_ticker = function()
	{
		setTimeout(function(){
            if (!jQuery(id+" ul.ticker li:first").is(":hover")){
    			jQuery(id+" ul.ticker li:first").animate( {marginTop: '-50px'}, 800, function()
    			{
    				jQuery(this).detach().appendTo(id+" ul.ticker").removeAttr("style");	
    			});
            };
			scroll_ticker();
		}, 5000);
	};
	scroll_ticker();
}
jQuery.fn.liScroll = function(settings) {
	settings = jQuery.extend({
	travelocity: 0.07
	}, settings);
	return this.each(function(){
		var $strip = jQuery(this);
		$strip.addClass("newsticker")
		var stripWidth = 1;
					
		var containerWidth = $strip.parent().parent().width();	//a.k.a. 'mask' width 	
		
        $strip.find("li").each(function(i){
            stripWidth += jQuery(this, i).outerWidth(true) + 100; // thanks to Michael Haszprunar and Fabien Volpi
        });
        
		$strip.width(stripWidth);			
		var totalTravel = stripWidth+containerWidth;
		var defTiming = totalTravel/settings.travelocity;	// thanks to Scott Waye		
		function scrollnews(spazio, tempo){
		  $strip.animate({right: '-='+ spazio}, tempo, "linear", function(){$strip.css("right", containerWidth); scrollnews(totalTravel, defTiming);});
		}
		scrollnews(totalTravel, defTiming);				
		$strip.hover(function(){
		  jQuery(this).stop();
		},
		function(){
    		var offset = jQuery(this).offset();
    		var residualSpace = offset.left + stripWidth;
    		var residualTime = residualSpace/settings.travelocity;
    		scrollnews(residualSpace, residualTime);
		});			
	});	
};