$(function(){
	'use strict';


	$('.navbar-menu .dropdown-toggle').attr('data-display', 'static');

	function hideMain(complete) {
		$('.navbar-menu-backdrop').remove();


		$('.navbar-menu-left').animate({width: 'hide'}, 300, function() {

			$('.navbar-icon-left').removeClass('open');

			if (complete)
				complete();
		});
	}


	function hideContext(complete) {
		$('.navbar-menu-backdrop').remove();

		$('.navbar-menu-right').slideUp(300, function() {

			$('.navbar-icon-right').removeClass('open');

			if (complete)
				complete();
		});
	}

	function hideMenu() {
		hideMain();
		hideContext();
	}


	function showMain() {

		hideContext(function() {
			var objMenu = $('.navbar-menu-left');

			objMenu.animate({width: 'show'}, 300);

			$('.navbar-icon-left').addClass('open');

			$(document.createElement('div'))
				.addClass('navbar-menu-backdrop')
				.insertAfter(objMenu)
				.on('click', hideMenu);
		});


	}


	function showContext() {
		hideMain(function() {
			var objMenuContext = $('.navbar-menu-right');

			objMenuContext.slideDown(300);

			$('.navbar-icon-right').addClass('open');

			$(document.createElement('div'))
				.addClass('navbar-menu-backdrop')
				.insertAfter(objMenuContext)
				.on('click', hideMenu);
		});
	}

	$('.navbar-icon-left').click(function(){

		if ($(this).hasClass('open')) hideMain();
		else showMain();

		return false;
	});

	$('.navbar-icon-right').click(function(){
		if ($(this).hasClass('open')) hideContext();
		else showContext();

		return false;
	});



});