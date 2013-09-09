//gallery group -> 0 = image 1 = caption
var gallerygroup = new Array();
var isImageOverlayActive = false;

var selectedGallery = 0;
var selectedImage = 0;

var lockImageProgression = false;

jQuery(document).ready(function () {


	//looks for each gallery grouping
	jQuery(".gallery").each(function(){

		var gallery = new Array();
		jQuery("#"+ this.id + " .gallery-item").each(function(associatedImgID)
		{
			if(jQuery(this).find("a[href$='.jpg'],a[href$='.png']").length === 0)
			{
				jQuery(this).find(".wp-caption-text").css("display","block");
			}
			else
			{

				var item = new Array();
				item.push(jQuery(this).find("a").attr("href")); //push href onto item
				jQuery(this).find("a").attr("href", "#");//reassign href to #
				item.push(jQuery(this).find(".wp-caption-text").html());//push caption
				gallery.push(item);

				jQuery(this).find("a").on("click",{galleryID :(gallerygroup.length) , imageID : (gallery.length-1)},function(event){
					ImageOverlay(event.data.galleryID,event.data.imageID);
					return false;
				});

			}
		});

		gallerygroup.push(gallery);
	});

	jQuery("#image-overlay-close").on("click",function(){
		ImageOverlayClose();
		return false;
	});

	jQuery("#overlay-backdrop").on("click",function(){
		ImageOverlayClose();
		return false;
	});

	jQuery("#overlay-enlarged-image-container").on("click",function(){
		ImageOverlayClose();
		return false;
	});

	jQuery("#image-overlay-left").on("click",function(event){
		selectedImage--;
		if(selectedImage < 0)
		{
			selectedImage = gallerygroup[selectedGallery].length -1;
		}
		ImageOverlay(selectedGallery,selectedImage);
		event.stopImmediatePropagation();
		return false;
	});
	jQuery("#image-overlay-right").on("click",function(event){
		selectedImage++;
		if(selectedImage >= gallerygroup[selectedGallery].length)
		{
			selectedImage = 0;
		}
		ImageOverlay(selectedGallery,selectedImage);
		event.stopImmediatePropagation();
		return false;
	});


});

function ImageOverlay( gallerID,  itemID){

	if(isImageOverlayActive !== true)
	{
		isImageOverlayActive = true;

		jQuery("#overlay-backdrop").css({"display":"block","opacity":0});
		jQuery("#overlay-enlarged-image-container").css({"display":"block","opacity":0});
		jQuery("#overlay-backdrop").transition({opacity:1},500);
		jQuery("#overlay-enlarged-image-container").transition({opacity:1,top: (jQuery(document).scrollTop()+95)},500);
	}
	

	if(lockImageProgression === false)
	{
		lockImageProgression = true;
		selectedGallery = gallerID;
		selectedImage = itemID;

		var lItem = gallerygroup[gallerID][itemID];
		if(jQuery("#overlay-image img").attr("src") !== lItem[0])
		{
			//set caption
			jQuery("#image-overlay-caption .image-caption").html(lItem[1]);
			jQuery("#image-overlay-caption .num-images").html("image "+ (selectedImage +1)+" of " + gallerygroup[selectedGallery].length );

			jQuery("#image-over-loading").css({display:"block"});

			jQuery("#overlay-image img").transition({"opacity":0},300,function(){
				jQuery("#overlay-image img").on("load",function(){
					jQuery("#overlay-image img").css({width:"auto",height:"auto"});

						var lImageWidth = jQuery("#overlay-image img").width();
						var lImageHeight = jQuery("#overlay-image img").height();
						var laspectRatio =lImageWidth/lImageHeight;
						var lScreenWidth = jQuery(window).width();
						var lScreenHeight = jQuery(window).height();

						//make sure image dosent leave screen
						if((lImageHeight+95) > lScreenHeight )
						{
							lImageWidth = laspectRatio*(lScreenHeight-150);
							lImageHeight = (lScreenHeight-150);
						}
						if(lImageWidth > lScreenWidth)
						{
							lImageWidth = (lScreenWidth-25);
							lImageHeight =(lScreenWidth-25)/(laspectRatio);
						}
						jQuery("#overlay-image img").width(lImageWidth);
						jQuery("#overlay-image img").height(lImageHeight);

						jQuery("#overlay-image").transition({height:(lImageHeight + jQuery("#image-overlay-caption").height()),width:lImageWidth},300);
						jQuery("#overlay-image img").transition({"opacity":1},400,function(){
							lockImageProgression = false;
							jQuery("#image-overlay-caption").css("display","block");
							jQuery("#overlay-image").transition({height:(lImageHeight + jQuery("#image-overlay-caption").height())},10);
						});	
						jQuery("#image-over-loading").css({display:"none"});
							

				}); 
				jQuery("#overlay-image img").attr("src",lItem[0]); 
			});	
		}
	}


}

function ImageOverlayClose()
{
	if(isImageOverlayActive === true)
	{
		isImageOverlayActive = false;
		jQuery("#overlay-backdrop").transition({opacity:0},500);
		jQuery("#overlay-enlarged-image-container").transition({opacity:0},500,function(){
			jQuery("#overlay-backdrop").css({"display":"none"});
			jQuery("#overlay-enlarged-image-container").css({"display":"none"});
			
		});

	}

}



