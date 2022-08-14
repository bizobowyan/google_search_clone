var timer;
$(document).ready(function(){
	$(".result").on("click", function(){
		var url = $(this).attr("href");
		var id = $(this).attr("data-linkId");

	//if the data-linkId was not found
	if (!id) {
		alert("data-linkId attribute not found");
	}

	increaseLinkClicks(id, url);

		return false;
	});

	var grid = $(".imageResults");

	grid.on("layoutComplete", function(){
		$(".gridItem ").css("visibility", "visible");
	});

	grid.masonry({
		itemSelector: ".gridItem",
		columnWidth: 200,
		gutter: 5,
		isInitLayout: false
	});

	Fancybox.bind("[data-fancybox]", {
		caption: function (fancybox, carousel, slide) {
		    let caption = slide.caption;
		    let siteUrl = slide.siteurl;
		    // let siteUrl = $(this).data('siteurl') || '';

		    if (slide.type === "image") {
		      caption =
		        (caption.length ? caption + "<br />" : "") 
		        + '<a target="_blank" href="' + slide.src + '">View Image</a><br>'
		        + '<a target="_blank" href="' + siteUrl + '">Visit Page</a><br>';
		    }

		    return caption;
		},

		on: {
			    load: (fancybox, slide) => {
			     	increaseImageClicks(slide.src);
			    },
		},

	});
});

function loadImage(src, className){
	var image = $("<img>");

	image.attr("src", src);
	//if the image link is correct and the image will display add the image url to the dom document inside the class called
	image.on("load", function(){
		$("." + className + " a").append(image);

		clearTimeout(timer);

		timer = setTimeout(function(){
			$(".imageResults").masonry();
		}, 500);
	});
	//IF THE IMAGES COULD not load due to internet connection or invalid link dont show it and then set it in the database in the broken column to 1
	image.on("error", function(){
		$("." + className).remove();
		$.post("ajax/setBroken.php", {src: src});
	});

	
	
}

function increaseLinkClicks(linkId, url){
	$.post("ajax/updateLinkCount.php", {linkId:linkId})
	.done(function(result){
		//if the output not empty, that is error has echoed therewhen updating no of clicks, return and dont go to the url
		if (result != "") {
			alert(result);
			return;
		}
		window.location.href=url;
	});
}

function increaseImageClicks(imageUrl){
	$.post("ajax/updateImageCount.php", {imageUrl:imageUrl})
	.done(function(result){
		//if the output not empty, that is error has echoed therewhen updating no of clicks, return and dont go to the url
		if (result != "") {
			alert(result);
			return;
		}
		
	});
}