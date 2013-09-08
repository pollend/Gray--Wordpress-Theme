var slides = new Array();
var slideSelect = new Array();
var currentPage = 1;

var allVideos = 0;
var contentAreaWidth;

var smallWindowMenu = false;

function resizeMainArea(){

	jQuery("#page").height("auto");
	var extraSpace = jQuery(document).height() - jQuery("#page").height();


	if(extraSpace != 0)
		jQuery("#page").height(jQuery("#page").height() + extraSpace);


	if(jQuery(window).width() < 600)
	{
		jQuery(".sub-menu").css("display","block");
		smallWindowMenu = true;
	}
	else
	{
		jQuery(".sub-menu").css("display","none");
		smallWindowMenu = false;
	}

}

function pageUpdate()
{


	contentAreaWidth = jQuery(".entry").width();

	allVideos.each(function(){
		jQuery(this).width(contentAreaWidth);
		jQuery(this).height(contentAreaWidth * jQuery(this).data('aspectRatio'));
	});
	resizeMainArea();

}

jQuery(document).ready(function () {

	if (!jQuery.support.transition)
  		jQuery.fn.transition = jQuery.fn.animate;

	jQuery(".menu li").each(function(element){
		if(jQuery(this).find(".sub-menu").length > 0)
		{
			jQuery("#"+this.id + ", #" + this.id + ">.sub-menu").on("mouseenter",{submenu:jQuery("#"+this.id + ">.sub-menu")},function(event){
				if(smallWindowMenu === false)
				event.data.submenu.css("display","block");

			});

			jQuery("#"+this.id + " , #" + this.id + ">.sub-menu").on("mouseleave",{submenu:jQuery("#"+this.id + ">.sub-menu")},function(event){
				if(smallWindowMenu === false)
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

	//on textarea resize, update the main area
	jQuery("textarea").on("autosize.resize",jQuery.debounce(1000,function()
	{
		resizeMainArea();
	}));

	//looks for each gallery grouping
	jQuery(".gallery").each(function(galleryID){
		jQuery("#"+ this.id + " .gallery-item").data("gallerID",galleryID);

		jQuery("#"+ this.id + " .gallery-item").each(function(associatedImgID)
		{
			if(jQuery(this).find("a[href$='.jpg'],a[href$='.png']").length === 0)
			{
				jQuery(this).find(".wp-caption-text").css("display","block");
			}
			else
			{
				jQuery(this).find("a[href$='.jpg'],a[href$='.png']").attr("data-lightbox", "gallery" +jQuery(this).data("gallerID") );
				jQuery(this).find("a[href$='.jpg'],a[href$='.png']").attr("data-caption", jQuery(this).find(".wp-caption-text").html() );
			}
		});
	});

	jQuery("#drop-down-button").on("click",function(){
		if(jQuery("#menu-container").hasClass('up'))
		{
	
			jQuery(".menu").css("height","auto");
			var menuHeight = jQuery(".menu").height();
			jQuery(".menu").css("height","0px");
			jQuery(".menu").transition({height:menuHeight},500);
			jQuery("#drop-down-icon").transition({rotate:"-180deg"},500,function()
			{
				jQuery("#drop-down-icon").attr("style","");
				jQuery("#menu-container").removeClass("up").addClass("down");
			});
		}
		else
		{
			jQuery(".menu").transition({height:0},500);
			jQuery("#drop-down-icon").transition({rotate:"180deg"},500,function()
			{
				jQuery("#drop-down-icon").attr("style","");
				jQuery("#menu-container").removeClass("down").addClass("up");
			});
		}
	});

});

jQuery(window).resize(jQuery.throttle(200,function () {
	SizeElements();
	pageUpdate();1
}));


jQuery(window).load(function(){

	allVideos = jQuery("#contentContainer iframe[src^='http://www.youtube.com']");

	allVideos.each(function(){
		jQuery(this).data('aspectRatio',this.height/this.width);
		jQuery(this).removeAttr('height').removeAttr('width');
	});

	pageUpdate();
});

//SLIDE SHOW--------------------------------------------------------------------------------------
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
				jQuery(slides[currentPage]).transition({left : "0%"},500,function()
				{
					jQuery(slides[currentPage]).css({"z-index":2});
					jQuery(slides[oldPage]).css({"z-index":1});
				});
			}
			else
			{
				jQuery(slides[currentPage]).css({"z-index":3,left:"-100%"});
				jQuery(slides[currentPage]).transition({left : "0%"},500,function()
				{
					jQuery(slides[currentPage]).css({"z-index":2});
					jQuery(slides[oldPage]).css({"z-index":1});
				});
			}
		}
	}
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

function SizeElements()
{
	var slideWidth = jQuery("#slide").width();
	jQuery("#slide").height(slideWidth/2);
}