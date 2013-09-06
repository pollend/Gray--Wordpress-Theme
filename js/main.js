var slides = new Array();
var slideSelect = new Array();
var currentPage = 1;
var menuChain = new Array();

function SizeElements()
{
	var slideWidth = jQuery("#slide").width();
	jQuery("#slide").height(slideWidth/2);

}


function SetUpSlide()
{
	jQuery("#slides li").each(function(element){
		slides.push( "#"+this.id);
		jQuery("#slideSelect").append("<li id=\"slideSelect"+element+"\"></li>");
		slideSelect.push("#"+"slideSelect"+element);

		jQuery("#slideSelect"+element).on("click",{index : element},function(event){
			SwitchToSlide(event.data.index);
		});

	});
	SwitchToSlide(0);
}

function SwitchToSlide(index)
{
	var left= true;
	if(!jQuery(slides[currentPage]).is(':animated'))
	{
		if(index != currentPage){
			var oldPage = currentPage; 
			if(index >= slides.length)
			{
				currentPage = 0;
				left = false;
			}
			else if(index < 0)
			{
				currentPage = slides.length-1;
				left = true;
			}
			else
			{
				currentPage = index;
				if(currentPage > oldPage)
					left = false;
				else
					left = true;
			}

			jQuery(slideSelect[currentPage]).css({"box-shadow":"0px 0px 0px black", background : "#444444"});
			jQuery(slideSelect[oldPage]).css({background:"","box-shadow":""});

			if(left)
			{
				jQuery(slides[currentPage]).css({"z-index":3,left:"200%"});
				jQuery(slides[currentPage]).animate({left : "0%"},500,function()
				{
					jQuery(slides[currentPage]).css({"z-index":2});
					jQuery(slides[oldPage]).css({"z-index":1});
				});
			}
			else
			{
				jQuery(slides[currentPage]).css({"z-index":3,left:"-100%"});
				jQuery(slides[currentPage]).animate({left : "0%"},500,function()
				{
					jQuery(slides[currentPage]).css({"z-index":2});
					jQuery(slides[oldPage]).css({"z-index":1});
				});
			}
		}
	}
}

function pageUpdate()
{
	jQuery("#page").height("auto");
	var extraSpace = jQuery(document).height() - jQuery("#page").height();

	if(extraSpace != 0)
		jQuery("#page").height(jQuery("#page").height() + extraSpace); 
}

jQuery(document).ready(function () {

jQuery(".menu li").each(function(element){
	if(jQuery(this).find(".sub-menu").length > 0)
	{
		jQuery("#"+this.id + ", #" + this.id + ">.sub-menu").on("mouseenter",{submenu:jQuery("#"+this.id + ">.sub-menu")},function(event){
			event.data.submenu.css("display","block");

		});

		jQuery("#"+this.id + " , #" + this.id + ">.sub-menu").on("mouseleave",{submenu:jQuery("#"+this.id + ">.sub-menu")},function(event){
			event.data.submenu.css("display","none");
		});
	}

});

SizeElements();
SetUpSlide();

jQuery("#slideLeft").on("click",function(){
	SwitchToSlide(currentPage-1);
});

jQuery("#slideRight").on("click",function(){
SwitchToSlide(currentPage+1);
});


jQuery("#comment").on('click', function() {
	jQuery("#additonalCommentFields").animate({height:jQuery("#additonalCommentFieldsContainer").height()},500);
	jQuery("html, body").animate({ scrollTop: (jQuery(document).scrollTop() + jQuery("#additonalCommentFieldsContainer").height()) }, "slow");
});

jQuery(".comment-reply-link").on('click',function(){
	jQuery("#additonalCommentFields").css({height:jQuery("#additonalCommentFieldsContainer").height()});
});



});

jQuery(window).resize(function () {
SizeElements();
pageUpdate();
});


jQuery(window).load(function(){
pageUpdate();
});



