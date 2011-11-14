$(document).ready(function(){
	
	//Sidebar Accordion Menu:
		
		$("#main-nav li ul").hide(); // Hide all sub menus
		$("#main-nav li a.current").parent().find("ul").slideToggle("slow"); // Slide down the current menu item's sub menu
		
		$("#main-nav li a.nav-top-item").click( // When a top menu item is clicked...
			function () {
				$(this).parent().siblings().find("ul").slideUp("normal"); // Slide up all sub menus except the one clicked
				$(this).next().slideToggle("normal"); // Slide down the clicked sub menu
				return false;
			}
		);
		
		$("#main-nav li a.no-submenu").click( // When a menu item with no sub menu is clicked...
			function () {
				window.location.href=(this.href); // Just open the link instead of a sub menu
				return false;
			}
		); 

    // Sidebar Accordion Menu Hover Effect:
		
		$("#main-nav li .nav-top-item").hover(
			function () {
				$(this).stop().animate({ paddingRight: "25px" }, 200);
			}, 
			function () {
				$(this).stop().animate({ paddingRight: "15px" });
			}
		);

    //Minimize Content Box
		
		$(".content-box-header h3").css({ "cursor":"s-resize" }); // Give the h3 in Content Box Header a different cursor
		$(".closed-box .content-box-content").hide(); // Hide the content of the header if it has the class "closed"
		$(".closed-box .content-box-tabs").hide(); // Hide the tabs in the header if it has the class "closed"
		
		$(".content-box-header h3").click( // When the h3 is clicked...
			function () {
			  $(this).parent().next().toggle(); // Toggle the Content Box
			  $(this).parent().parent().toggleClass("closed-box"); // Toggle the class "closed-box" on the content box
			  $(this).parent().find(".content-box-tabs").toggle(); // Toggle the tabs
			}
		);

    // Content box tabs:
		
		$('.content-box .content-box-content div.tab-content').hide(); // Hide the content divs
		$('ul.content-box-tabs li a.default-tab').addClass('current'); // Add the class "current" to the default tab
		$('.content-box-content div.default-tab').show(); // Show the div with class "default-tab"
		
		$('.content-box ul.content-box-tabs li a.tab').click( // When a tab is clicked...
			function() { 
				$(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
				$(this).addClass('current'); // Add class "current" to clicked tab
				var currentTab = $(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
				$(currentTab).siblings().hide(); // Hide all content divs
				$(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
				return false; 
			}
		);

    //Close button:
		
		$(".close").click(
			function () {
				$(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
					$(this).slideUp(400);
				});
				return false;
			}
		);

    // Alternating table rows:
		
		$('tbody tr:even').addClass("alt-row"); // Add class "alt-row" to even table rows

    // Check all checkboxes when the one in a table head is checked:
		
		$('.check-all').click(
			function(){
				$(this).parent().parent().parent().parent().find("input[type='checkbox']").attr('checked', $(this).is(':checked'));   
			}
		);

    // Initialise Colorboxwindow:
		
		$('.googleSearch').colorbox({
			rel: "searchResult",
			width: "75%",
			height: "75%",
			current: "Trường số {current} trong {total} trường trên trang",
			onComplete: function(){
				var _this = $(this);
				googleSearch({
					context: _this,
					term: _this.text()
				});
			}
		});

    // Initialise jQuery WYSIWYG:
		
		//$(".wysiwyg").wysiwyg(); // Applies WYSIWYG editor to any textarea with the class "wysiwyg"

});
  
  

var config = {
	searchSite	: false,
	type		: 'images',
	append		: false,
	perPage		: 5,			// A maximum of 8 is allowed by Google
	page		: 0				// The start page
}

// Focusing the input text box:
//$('#s').focus();

/*
$('#searchForm').submit(function(){
	googleSearch();
	return false;
});
*/
function googleSearch(settings){

// If no parameters are supplied to the function,
// it takes its defaults from the config object above:

settings = $.extend({},config,settings);
settings.term = settings.term || settings.context.text();

if(settings.searchSite){
	// Using the Google site:example.com to limit the search to a
	// specific domain:
	settings.term = 'site:'+settings.siteURL+' '+settings.term;
}

// URL of Google's AJAX search API
var apiURL = 'http://ajax.googleapis.com/ajax/services/search/'+settings.type+
				'?v=1.0&callback=?';
var resultsDiv = $('.google_search_content');

	$.getJSON(apiURL,{
		q	: settings.term,
		rsz	: settings.perPage,
		start	: settings.page*settings.perPage
	},function(r){

		var results = r.responseData.results;

		$('#more').remove();

		if(results.length){
			// If results were returned, add them to a pageContainer div,
			// after which append them to the #resultsDiv:

			var pageContainer = $('<div>',{className:'pageContainer'});

			for(var i=0;i<results.length;i++){
				// Creating a new result object and firing its toString method:
				pageContainer.append(new result(results[i], settings.context) + '');
			}

			if(!settings.append){
				// This is executed when running a new search,
				// instead of clicking on the More button:
				resultsDiv.empty();
			}

			pageContainer.append('<div class="clear"></div>')
						 .hide().appendTo(resultsDiv)
						 .fadeIn('slow');
			var cursor = r.responseData.cursor;

			// Checking if there are more pages with results,
			// and deciding whether to show the More button:

			if( +cursor.estimatedResultCount > (settings.page+1)*settings.perPage){
				$('<div>',{id:'more'}).html('<span class="get_more">Get More</span>').appendTo(resultsDiv).click(function(){
					googleSearch({
						append:true,
						page:settings.page+1, 
						term: settings.term,
						context: settings.context,
					});
					$(this).fadeOut();
				});
			}
		}
		else {

			// No results were found for this search.

			resultsDiv.empty();
			$('<p>',{
				className	: 'notFound',
				html		: 'No Results Were Found!'
			}).hide().appendTo(resultsDiv).fadeIn();
		}
	});
}

function result(r, context){
	
	var _id = $(context).parent().prev().text();
	// This is class definition. Object of this class are created for
	// each result. The markup is generated by the .toString() method.

	var arr = [];

	// GsearchResultClass is passed by the google API
	switch(r.GsearchResultClass){

		case 'GwebSearch':
			arr = [
				'<div class="webResult">',
				'<h2><a href="',r.url,'">',r.title,'</a></h2>',
				'<p>',r.content,'</p>',
				'<a href="',r.url,'">',r.visibleUrl,'</a>',
				'</div>'
			];
		break;
		case 'GimageSearch':
			arr = [
				'<div class="imageResult">',
				'<a onClick="update_school_photo(', _id, ', this);" class="searchResult" href="','#','" title="',r.titleNoFormatting,
				'" class="pic" style="width:',r.tbWidth,'px;height:',r.tbHeight,'px;">',
				'<img src="',r.url,'" /></a>','<div class="clear"></div>',				
				'</div>'
			];
		break;
		case 'GvideoSearch':
			arr = [
				'<div class="imageResult">',
				'<a href="',r.url,'" title="',r.titleNoFormatting,
                                    '" class="pic" style="width:150px;height:auto;">',
				'<img src="',r.tbUrl,'" width="100%" /></a>',
				'<div class="clear"></div>','<a href="',
				r.originalContextUrl,'">',r.publisher,'</a>',
				'</div>'
			];
		break;
		case 'GnewsSearch':
			arr = [
				'<div class="webResult">',
				'<h2><a href="',r.unescapedUrl,'">',r.title,'</a></h2>',
				'<p>',r.content,'</p>',
				'<a href="',r.unescapedUrl,'">',r.publisher,'</a>',
				'</div>'
			];	
		break;
	}

	// The toString method.
	this.toString = function(){
		return arr.join('');
	}
}

function update_school_photo(school_id, _this){
	$.colorbox.close();
	image_url = $(_this).find('img').attr('src');
	$.post(tx_admin.base_url + 'admin/schools/update_photo', {
		'school_id': school_id,
		'image_url': image_url,
		'csrf': tx_admin.csrf_token_value
	}, function(result) {
		if (result.status == 'true') {
			$('tr[rel="'+school_id+'"]').find('td[field="pic_small"]').html('<img width="50" src="'+image_url+'">');
			
		}
	}, 'json');

	return false;
}