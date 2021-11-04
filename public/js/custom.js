$(function(){
	$('[data-toggle="tooltip"]').tooltip();

	// ? SIDEBAR LINKS
	$('.btn-item-nav').on('click', function(){
		var dropdown = $('#collapse-' + $(this).attr('id'));
		var parent_nav = $(this).children();

		for (let i = 0; i < $('.btn-item-nav').length; i++) {
			var chevron = $('.btn-item-nav')[i].children[0].children[1].classList;
			chevron.remove('chevron-down');
		}

		if(dropdown.hasClass('show')){
			parent_nav[0].children[1].classList.remove('chevron-down');
		}else{
			parent_nav[0].children[1].classList.add('chevron-down');
		}

	});
	// ? ENDS HERE

	// ? USER LOGOUT
	$('.btn-logout').on('click', function(){
		$("#logout-form").on('submit');
	});
	// ? ENDS HERE

	// ? BUTTON MENU
	$('#btn-menu').on('click', function(){
		// console.log($(this));

		if($('#sidebar').width() != 0){
			hideSidebar();
		}else {
			showSidebar();
		}
	});

	$('#btn-close').on('click', function(){
		hideSidebar();
	});
	// ? ENDS HERE

	function showSidebar(){
		$('#sidebar').animate({
			width: "320px",
			opacity: 1
		}, 400, function(){
			sessionSidebar(true);
		});

		$('#btn-menu').attr('data-original-title', 'Hide sidebar');
	}

	function hideSidebar(){
		$('#sidebar').animate({
			width: 0,
			opacity: 0.4
		}, 400, function(){
			sessionSidebar(false);
		});

		$('#btn-menu').attr('data-original-title', 'Show sidebar');
	}

	function sessionSidebar(bool){
		var token = $('meta[name=csrf-token]').attr('content');
		var pathOrigin = window.location.origin;
		$.ajax({
			method: "POST",
			url: pathOrigin + "/session/display_sidebar",
			data: {
				_token: token,
				display: bool
			}
		}).done(response => {
			if(response.display === "false"){
				console.info("sidebar display: false");
			}else{
				console.info("sidebar display: true");
			}
		}).catch(error => {
			console.error(error);
		});
	}

	function kFormatter(num) {
		return Math.abs(num) > 999 ? Math.sign(num)*((Math.abs(num)/1000).toFixed(1)) + 'k' : Math.sign(num)*Math.abs(num)
	}
});