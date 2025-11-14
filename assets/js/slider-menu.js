$(document).ready(function(){
	$('a.menu-a').on('click', function(e){
		$('a.menu-a').siblings('ul').slideUp();
		// $('a.menu-a').closest('li').removeClass('active');
		// $(this).closest('li').addClass('active');
		 if ($(this).siblings('ul').attr( 'aria-expanded') === 'true'){
			// $(this).closest('li').removeClass('active');
			$(this).siblings('ul').removeClass('in');
			$(this).siblings('ul').attr('aria-expanded','false');
		}else{
			$(this).siblings('ul').slideDown();
			$(this).siblings('ul').addClass('in');
			$('a.menu-a').siblings('ul').attr('aria-expanded','false');
			$(this).siblings('ul').attr('aria-expanded','true');
		}
	});
	  $('li a.sub-menu-a').on('click', function(e){
		$('a.menu-a').closest('li').addClass('active');
		$(this).addClass('active');
		if($(this).addClass('active')){
			$('a.menu-a').closest('li').addClass('active');
			$('ul.sub-has-menu').addClass('in');
			$('a.menu-a').closest('li').addClass('active');
			$('ul.sub-has-menu').addClass('in');
			if ($('ul.sub-has-menu').attr( 'aria-expanded') === 'true') {
				$('a.menu-a').closest('li').removeClass('active');
				$('ul.sub-has-menu').removeClass('in');
				$('ul.sub-has-menu').attr('aria-expanded','false');
			} else {
				$('ul.sub-has-menu').addClass('in');
				$('ul.sub-has-menu').attr('aria-expanded','true');
			}
			
		}
		else{
			$('a.menu-a').closest('li').removeClass('active');
			$('ul.sub-has-menu').removeClass('in');
			$('ul.sub-has-menu').attr('aria-expanded','false');

		}
		
	}); 
	if ($("a.menu-a").hasClass("active")) {
		$('a.active').closest('li').addClass('active');
		$('a.active').siblings('ul.sub-has-menu').addClass('in');
		$('a.menu-a>active').siblings('ul.sub-has-menu').attr('aria-expanded','true');
	}
	 
	
});