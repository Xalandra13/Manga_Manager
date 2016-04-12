$(document).ready(function(){
	
	// jQuery UI Tabs
	$('#tabs').tabs();
	
	// Search function: Get data from db
	$('#searchBtn').on('click', search);
	
	function search(){
		$.post(
			'search.php',
			{
				title: $('#title').val()
			},
			function(data){
				$('#results').html(data);
			}
		);
	}
	
	// Adding New Manga: Title is required!
	$('#addForm').submit(function(){
		// Get title value and trim it
		var title = $.trim($('#addTitle').val());
		// Check if empty
		if(title == ''){
			alert('Please enter a title!');
			$('#addTitle').focus();
			return false;
		}
	});
	
	// Delete Manga: Confirm first!
	$('.confirm').on('click', function(){
		return confirm('Delete this manga?');
	});
	
});

// Tooltips for icons
var tooltip = {

	init: function(){
	
		var $obj = $('.tooltip');
		
		if(!$obj.length) return;
		$('body').append('<div id="tooltip">');
		var tooltip = $('#tooltip');
		var title;
		$obj.hover(function(e){
			title = $(this).attr('title') ?
					$(this).attr('title') :
					'No title';
			$(this).attr('title', '');
			tooltip.html(title);
			tooltip.css({
				top: e.pageY + 10,
				left: e.pageX + 10
			});
			tooltip.stop(true, true).delay(50).fadeIn('slow');
		}, function(){
			$(this).attr('title', title);
			tooltip.stop(true, true).fadeOut('slow');
		});
	}
}

$(document).ready(tooltip.init);
