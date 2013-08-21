var slides = new Array();
var slideSelect = new Array();
var currentPage = 1;

function SizeElements()
{
	var slideWidth = $("#slide").width();
	$("#slide").height(slideWidth/2);

}


function SetUpSlide()
{
	$("#slides li").each(function(element){
		slides.push( "#"+this.id);
		$("#slideSelect").append("<li id=\"slideSelect"+element+"\"></li>");
		slideSelect.push("#"+"slideSelect"+element);

		$("#slideSelect"+element).on("click",{index : element},function(event){
			SwitchToSlide(event.data.index);
		});

	});
	SwitchToSlide(0);
}

function SwitchToSlide(index)
{
	var left= true;
	if(!$(slides[currentPage]).is(':animated'))
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

			$(slideSelect[currentPage]).css({"box-shadow":"0px 0px 0px black", background : "#444444"});
			$(slideSelect[oldPage]).css({background:"","box-shadow":""});

			if(left)
			{
				$(slides[currentPage]).css({"z-index":3,left:"200%"});
				$(slides[currentPage]).animate({left : "0%"},500,function()
				{
					$(slides[currentPage]).css({"z-index":2});
					$(slides[oldPage]).css({"z-index":1});
				});
			}
			else
			{
				$(slides[currentPage]).css({"z-index":3,left:"-100%"});
				$(slides[currentPage]).animate({left : "0%"},500,function()
				{
					$(slides[currentPage]).css({"z-index":2});
					$(slides[oldPage]).css({"z-index":1});
				});
			}
		}
	}
}

function pageUpdate()
{
	$("#page").height("auto");
	var extraSpace = $(document).height() - $("#page").height();

	if(extraSpace != 0)
		$("#page").height($("#page").height() + extraSpace); 
}

$(document).ready(function () {
SizeElements();
SetUpSlide();

$("#slideLeft").on("click",function(){
	SwitchToSlide(currentPage-1);
});

$("#slideRight").on("click",function(){
SwitchToSlide(currentPage+1);
});


$("#comment").on('click', function() {
	$("#additonalCommentFields").animate({height:$("#additonalCommentFieldsContainer").height()},500);
	$("html, body").animate({ scrollTop: ($(document).scrollTop() + $("#additonalCommentFieldsContainer").height()) }, "slow");
});

$(".comment-reply-link").on('click',function(){
	$("#additonalCommentFields").css({height:$("#additonalCommentFieldsContainer").height()});
});


});

$(window).resize(function () {
SizeElements();
pageUpdate();
});


$(window).load(function(){
pageUpdate();
});



