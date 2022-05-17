/***************************************************
==================== JS INDEX ======================
****************************************************
01. PreLoader Js
02. Mobile Menu Js
03. Sidebar Js
04. Cart Toggle Js
05. Search Js
06. Sticky Header Js
07. Data Background Js
08. Testimonial Slider Js
09. Slider Js (Home 3)
10. Brand Js
11. Tesimonial Js
12. Course Slider Js
13. Masonary Js
14. Wow Js
15. Data width Js
16. Cart Quantity Js
17. Show Login Toggle Js
18. Show Coupon Toggle Js
19. Create An Account Toggle Js
20. Shipping Box Toggle Js
21. Counter Js
22. Parallax Js
23. InHover Active Js

****************************************************/

(function ($) {
	"use strict";

	var windowOn = $(window);
	////////////////////////////////////////////////////
	//01. PreLoader Js
	windowOn.on('load',function() {
		$("#loading").fadeOut(500);
	});

	////////////////////////////////////////////////////
	// 02. Mobile Menu Js
	$('#mobile-menu').meanmenu({
		meanMenuContainer: '.mobile-menu',
		meanScreenWidth: "991",
		meanExpand: ['<i class="fal fa-plus"></i>'],
	});

	////////////////////////////////////////////////////
    // 03. Mobile Menu 2 Js
    $('#mobile-menu-2').meanmenu({
        meanMenuContainer: '.mobile-menu-2',
        meanScreenWidth: "30000",
        meanExpand: ['<i class="fal fa-plus"></i>'],
    });

	////////////////////////////////////////////////////
	// 03. Sidebar Js
	$(".offcanvas-toggle-btn").on("click", function () {
		$(".offcanvas__area").addClass("opened");
		$(".body-overlay").addClass("opened");
	});
	$(".offcanvas__close-btn").on("click", function () {
		$(".offcanvas__area").removeClass("opened");
		$(".body-overlay").removeClass("opened");
	});

	////////////////////////////////////////////////////
	// 04. Body overlay Js
	$(".body-overlay").on("click", function () {
		$(".offcanvas__area").removeClass("opened");
		$(".body-overlay").removeClass("opened");
	});

	////////////////////////////////////////////////////
	// 05. Search Js
	$(".search-toggle").on("click", function () {
		$(".search__area").addClass("opened");
	});
	$(".search-close-btn").on("click", function () {
		$(".search__area").removeClass("opened");
	});

	////////////////////////////////////////////////////
	// 06. Sticky Header Js
	windowOn.on('scroll', function () {
		var scroll = $(window).scrollTop();
		if (scroll < 100) {
			$("#header-sticky").removeClass("header-sticky");
		} else {
			$("#header-sticky").addClass("header-sticky");
		}
	});

	////////////////////////////////////////////////////
	// 07. Data CSS Js
	$("[data-background").each(function () {
		$(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
	});
	$("[data-width]").each(function () {
		$(this).css("width", $(this).attr("data-width"));
	});
	$("[data-bg-color]").each(function () {
        $(this).css("background-color", $(this).attr("data-bg-color"));
    });

	////////////////////////////////////////////////////
	// 07. Nice Select Js
	$('select').niceSelect();

	////////////////////////////////////////////////////
	// 08. slider__active Slider Js
	if (jQuery(".slider__active").length > 0) {
		let sliderActive1 = ".slider__active";
		let sliderInit1 = new Swiper(sliderActive1, {
			// Optional parameters
			slidesPerView: 1,
			slidesPerColumn: 1,
			paginationClickable: true,
			loop: true,
			effect: 'fade',

			autoplay: {
				delay: 5000,
			},

			// If we need pagination
			pagination: {
				el: ".main-slider-paginations",
				// dynamicBullets: true,
				clickable: true,
			},

			// Navigation arrows
			navigation: {
				nextEl: ".swiper-button-next",
				prevEl: ".swiper-button-prev",
			},

			a11y: false,
		});

		function animated_swiper(selector, init) {
			let animated = function animated() {
				$(selector + " [data-animation]").each(function () {
					let anim = $(this).data("animation");
					let delay = $(this).data("delay");
					let duration = $(this).data("duration");

					$(this)
						.removeClass("anim" + anim)
						.addClass(anim + " animated")
						.css({
							webkitAnimationDelay: delay,
							animationDelay: delay,
							webkitAnimationDuration: duration,
							animationDuration: duration,
						})
						.one(
							"webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",
							function () {
								$(this).removeClass(anim + " animated");
							}
						);
				});
			};
			animated();
			// Make animated when slide change
			init.on("slideChange", function () {
				$(sliderActive1 + " [data-animation]").removeClass("animated");
			});
			init.on("slideChange", animated);
		}

		animated_swiper(sliderActive1, sliderInit1);
	}

	var sliderr = new Swiper('.active-class', {
		slidesPerView: 1,
		spaceBetween: 30,
		loop: true,
		pagination: {
			el: ".testimonial-pagination-6",
			clickable: true,
			renderBullet: function (index, className) {
			  return '<span class="' + className + '">' + '<button>'+(index + 1)+'</button>' + "</span>";
			},
		},
		breakpoints: {
			'1200': {
				slidesPerView: 3,
			},
			'992': {
				slidesPerView: 2,
			},
			'768': {
				slidesPerView: 2,
			},
			'576': {
				slidesPerView: 1,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	///////////////////////////////////////////////////
	// 13. Masonary Js
	$(".package__slider").owlCarousel({
		//add owl carousel in activation class
		loop: true,
		margin: 30,
		items: 4,
		navText: ['<button class="nav-left"><i class="far fa-angle-left"></i></button>', '<button class="nav-right"><i class="far fa-angle-right"></i></button>'],
		nav: false,
		dots: true,
		responsive: {
			0: {
				items: 1
			},
			767: {
				items: 2
			},
			992: {
				items: 3
			},
			1200: {
				items: 4
			}
		}
	});

	////////////////////////////////////////////////////
	// 13. Masonary Js
	$('.grid').imagesLoaded(function () {
		// init Isotope
		var $grid = $('.grid').isotope({
			itemSelector: '.grid-item',
			percentPosition: true,
			masonry: {
				// use outer width of grid-sizer for columnWidth
				columnWidth: '.grid-item',
			}
		});


		// filter items on button click
		$('.masonary-menu').on('click', 'button', function () {
			var filterValue = $(this).attr('data-filter');
			$grid.isotope({ filter: filterValue });
		});

		//for menu active class
		$('.masonary-menu button').on('click', function (event) {
			$(this).siblings('.active').removeClass('active');
			$(this).addClass('active');
			event.preventDefault();
		});

	});

	/* magnificPopup img view */
	$('.popup-image').magnificPopup({
		type: 'image',
		gallery: {
			enabled: true
		}
	});

	/* magnificPopup video view */
	$(".popup-video").magnificPopup({
		type: "iframe",
	});

	////////////////////////////////////////////////////
	// 14. Wow Js
	new WOW().init();

	////////////////////////////////////////////////////
	// 21. Cart Plus Minus Js
	// $(".cart-plus-minus").append('<div class="dec qtybutton">-</div><div class="inc qtybutton">+</div>');
	$(document).on('click', '.qtybutton', function(){
		var $button = $(this);
		var oldValue = $button.parent().find("input").val();
		if ($button.text() == "+") {
		var newVal = parseFloat(oldValue) + 1;
		} else {
		// Don't allow decrementing below zero
		if (oldValue > 1) {
			var newVal = parseFloat(oldValue) - 1;
		} else {
			newVal = 1;
		}
		}
		$button.parent().find("input").val(newVal);
	});
	/* $(".qtybutton").on("click", function () {
		var $button = $(this);
		var oldValue = $button.parent().find("input").val();
		if ($button.text() == "+") {
			var newVal = parseFloat(oldValue) + 1;
		} else {
			// Don't allow decrementing below zero
			if (oldValue > 1) {
				var newVal = parseFloat(oldValue) - 1;
			} else {
				newVal = 1;
			}
		}
		$button.parent().find("input").val(newVal);
	}); */

	////////////////////////////////////////////////////
	// 17. Show Login Toggle Js
	$('#showlogin').on('click', function () {
		$('#checkout-login').slideToggle(900);
	});

	////////////////////////////////////////////////////
	// 18. Show Coupon Toggle Js
	$('#showcoupon').on('click', function () {
		$('#checkout_coupon').slideToggle(900);
	});
	$("#showcoupon").trigger('click');

	////////////////////////////////////////////////////
	// 19. Create An Account Toggle Js
	$('#cbox').on('click', function () {
		$('#cbox_info').slideToggle(900);
	});

	////////////////////////////////////////////////////
	// 20. Shipping Box Toggle Js
	$('#ship-box').on('click', function () {
		$('#ship-box-info').slideToggle(1000);
	});

	////////////////////////////////////////////////////
	// 21. Counter Js
	$('.counter').counterUp({
		delay: 10,
		time: 1000
	});

	////////////////////////////////////////////////////
	// 22. Parallax Js
	if ($('.scene').length > 0) {
		$('.scene').parallax({
			scalarX: 10.0,
			scalarY: 15.0,
		});
	};

	////////////////////////////////////////////////////
	// 23. InHover Active Js
	$('.hover__active').on('mouseenter', function () {
		$(this).addClass('active').parent().siblings().find('.hover__active').removeClass('active');
	});

	////////////////////////////////////////////////////
	// 00. Toggle MEnu Js
	$('.cat-toggle-btn').on('click', function () {
		$('.cat__menu').slideToggle(500);
	});
	$('.cat-toggle-btn-2').on('click', function () {
		$('.side-menu').slideToggle(500);
	});

	 ////////////////////////////////////////////////////
    // 63. Data Countdown Js
    if (jQuery(".data-countdown").length > 0) {
		$('[data-countdown]').each(function() {
	
		  var $this = $(this),
			  finalDate = $(this).data('countdown');
	
		  $this.countdown(finalDate, function(event) {
	
			  $this.html(event.strftime('<span class="cdown days"><span class="time-count">%-D</span> <p>Days</p><span class="colon">:</span></span> <span class="cdown hour"><span class="time-count">%-H</span> <p>Hours</p><span class="colon">:</span></span> <span class="cdown minutes"><span class="time-count">%M</span> <p>Mins</p><span class="colon">:</span></span> <span class="cdown second"> <span><span class="time-count">%S</span> <p>Secs</p></span>'));
	
		  });
	
	  });
	  }

	////////////////////////////////////////////////////
	// 11. Product Slider Activation Js
	if (jQuery(".product-slider").length > 0) {
		let testimonialTwo = new Swiper('.product-slider', {
			slidesPerView: 1,
			spaceBetween: 0,
			// direction: 'vertical',
			loop: true,
			observer: true,
			observeParents: true,
			autoplay: {
					delay: 6000,
				},
			
			// If we need pagination
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			// Navigation arrows
			navigation: {
				nextEl: '.bs-button-next',
				prevEl: '.bs-button-prev',
			},
			
			// And if we need scrollbar
			scrollbar: {
				el: '.swiper-scrollbar',
			},
			breakpoints: {
				550: {
					slidesPerView: 2,
				},
				768: {
					slidesPerView: 3,
				},
				1200: {
					slidesPerView: 4,
				},
				1400: {
					slidesPerView: 5,
					}
				}
			});
	}

	////////////////////////////////////////////////////
	// 11. Product Slider Activation Js
	if (jQuery(".product-slider-2").length > 0) {
		let testimonialTwo = new Swiper('.product-slider-2', {
			slidesPerView: 1,
			spaceBetween: 0,
			// direction: 'vertical',
			loop: true,
			observer: true,
			observeParents: true,
			autoplay: {
					delay: 6000,
				},
			
			// If we need pagination
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			// Navigation arrows
			navigation: {
				nextEl: '.bs2-button-next',
				prevEl: '.bs2-button-prev',
			},
			
			// And if we need scrollbar
			scrollbar: {
				el: '.swiper-scrollbar',
			},
			breakpoints: {
				550: {
					slidesPerView: 2,
				},
				768: {
					slidesPerView: 3,
				},
				1200: {
					slidesPerView: 4,
				},
				1400: {
					slidesPerView: 5,
					}
				}
			});
	}

	////////////////////////////////////////////////////
	// 11. Product Slider Activation Js
	if (jQuery(".product-slider-3").length > 0) {
		let testimonialTwo = new Swiper('.product-slider-3', {
			slidesPerView: 1,
			spaceBetween: 0,
			// direction: 'vertical',
			loop: true,
			autoplay: {
					delay: 6000,
				},
			
			// If we need pagination
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			// Navigation arrows
			navigation: {
				nextEl: '.bs2-button-next',
				prevEl: '.bs2-button-prev',
			},
			
			// And if we need scrollbar
			scrollbar: {
				el: '.swiper-scrollbar',
			},
			breakpoints: {
				550: {
					slidesPerView: 2,
				},
				768: {
					slidesPerView: 3,
				},
				1200: {
					slidesPerView: 4,
				},
				1400: {
					slidesPerView: 5,
					}
				}
			});
	}

	////////////////////////////////////////////////////
	// 11. Product Slider Activation Js
	if (jQuery(".brand-slider").length > 0) {
		let testimonialTwo = new Swiper('.brand-slider', {
			slidesPerView: 1,
			spaceBetween: 30,
			// direction: 'vertical',
			loop: true,
			autoplay: {
					delay: 6000,
				},
			
			// If we need pagination
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			// Navigation arrows
			navigation: {
				nextEl: '.bs-button-next',
				prevEl: '.bs-button-prev',
			},
			
			// And if we need scrollbar
			scrollbar: {
				el: '.swiper-scrollbar',
			},
			breakpoints: {
				550: {
					slidesPerView: 3,
				},
				768: {
					slidesPerView: 4,
				},
				1200: {
					slidesPerView: 5,
				},
				1400: {
					slidesPerView: 6,
					}
				}
			});
	}

	////////////////////////////////////////////////////
	// 14. Range Slider Js
	if (jQuery("#slider-range").length > 0) {
		$("#slider-range").slider({
			range: true,
			min: 20,
			max: 280,
			values: [75, 300],
			slide: function (event, ui) {
				$("#amount").val("$" + ui.values[0] + " To $" + ui.values[1]);
			}
		});
		$("#amount").val("$" + $("#slider-range").slider("values", 0) +
			" To $" + $("#slider-range").slider("values", 1));
	}

	////////////////////////////////////////////////////
	//loading item
	if (jQuery("#loading").length > 0){
		let cart = $('#cart'),
		soda = $('#soda'),
		meat = $('#meat'),
		image = $('#image'),
		mustard = $('#mustard'),
		path = [{x:-250, y:0}, {x:-100, y:-90}, {x:0, y:0}],
		path2 = [{x:250, y:0}, {x:150, y:-80}, {x:60, y:0}],
		path3 = [{x:-170, y:0}, {x:-80, y:-70}, {x:70, y:0}];
	  
	   
		
		var setupSequence = function() {
		  let tl = new TimelineMax({repeat: -1, timeScale: 1.8});
		  
		  tl.set(mustard, {x:-250})
		  .set(meat, {x:250})
		  .set(soda, {x:-170})
		  .to(cart, 2.1, { 
			x:750, 
			ease: SlowMo.ease.config(0.5, 0.5, false),
		  })
		  .to(mustard, 1, {
			bezier: {curviness: 0.3, values:path},
			opacity: 1,
			scale:1,
			ease: Back.easeOut.config(1.4)
		  }, 0.5)
		  .to(mustard, .2, {
			scale: 0,
		  }, 0.8)
		  .to(meat, 1, {
			bezier: {curviness: 0.3, values:path2},
			opacity: 1,
			scale:1,
			ease: Back.easeOut.config(1.4)
		  }, 0.8)
		  .to(meat, .2, {
			scale: 0
		  }, 1.2)
		  .to(soda, .7, {
			bezier: {curviness: 0.3, values:path3},
			opacity: 1,
			scale:1,
			ease: Back.easeOut.config(1.4)
		  }, 1.2)
		  .to(soda, .1, {
			scale: 0,
		  },1.5);
		}
		
		setupSequence();
	}
	
})(jQuery);
// my custom code start
"use strict";
const base_url = $("input[name=base_url]").val();
const isLoggedIn = $("input[name=isLoggedIn]").val();

const getProd = (id) => {
	$.ajax({
		type: "GET",
		url: `${base_url}getProduct`,
		data: {prod: id},
		beforeSend: function (xhr, opts) {
			$("#loading").fadeIn(500);
		},
	}).done((res) => {
		$("#loading").fadeOut(500);
		const myModal = new bootstrap.Modal(document.getElementById("productModalId"), {});
		$("#prod-details").html(res);
		myModal.show();
	});
}

const swalShow = (icon, title, redirect=null) => {
  Swal.fire({
    title: title,
    icon: icon,
    timer: 2000,
    timerProgressBar: true,
    showConfirmButton: false,
  }).then((result) => {
    if (redirect) {
      window.location.href = `${base_url + redirect}.html`;
    }
  });
};

if ($('input[name=error]').val())
	swalShow("error", $("input[name=error]").val());

if ($('input[name=success]').val())
	swalShow("success", $("input[name=success]").val());

toastr.options = {
  closeButton: false,
  debug: false,
  newestOnTop: false,
  progressBar: false,
  positionClass: "toast-top-right",
  preventDuplicates: false,
  onclick: null,
  showDuration: "300",
  hideDuration: "1000",
  timeOut: "5000",
  extendedTimeOut: "1000",
  showEasing: "swing",
  hideEasing: "linear",
  showMethod: "fadeIn",
  hideMethod: "fadeOut",
};

let cartReq = wishReq = "ToCancelPrevReq";
let discount = $("input[name=discount]").val() ? $("input[name=discount]").val() : 0;
let delivery = 0;

const addAddress = (button) => {
	let data = {address: $("input[name=address]").val(), pincode: $("input[name=pincode]").val()};
	$.ajax({
		type: "POST",
		url: `${base_url}add-address`,
		data: data,
		dataType: "JSON",
		beforeSend: function (xhr, opts) {
			$(button).attr("disabled", true);
		},
	}).done((res) => {
		toastr[res.status](res.message);
		setTimeout(() => {
			if (res.status === 'success') location.reload();
		}, 1500);
		$(button).attr("disabled", false);
	});
};

const checkAddress = (select) => {
	$.ajax({
		type: "GET",
		url: `${base_url}check-address`,
		data: {add_id:  $(select).val()},
		dataType: "JSON",
		beforeSend: function (xhr, opts) {
			$("#loading").fadeIn(500);
		},
	}).done((res) => {
		$("#loading").fadeOut(500);
		if (res.status === 'success') {
			discount = parseInt(res.discount);
			delivery = parseInt(res.charge);
			checkOut();
    	}
		toastr[res.status](res.message);
	});
};

const updateAddress = (form) => {
	$.ajax({
		type: "POST",
		url: `${base_url}user/update-address/${$(form).data('id')}`,
		data: $(form).serialize(),
		dataType: "JSON",
		beforeSend: function (xhr, opts) {
			$("#loading").fadeIn(500);
		},
	}).done((res) => {
		$("#loading").fadeOut(500);
		toastr[res.status](res.message);
	});
};

const checkOut = () => {
	let myCart = JSON.parse(localStorage.getItem("cart"));
	
	if (! myCart || myCart.length < 1) {
		$("#coupon-section").html(``);
		$("#checkout-section").html(`<div class="container">
			<div class="row">
				<div class="col-lg-3"></div>
				<div class="col-lg-6">
					<h4>Your cart is empty!</h4><br />
					<a class="tp-btn-h1" href="${base_url}"><i class="fa fa-shopping-cart"></i> Start shopping Now!</a>
				</div>
			</div>
		</div>`);
  	}else{
		let total = 0;
		let details = `<div class="your-order mb-30 ">
							<h3>Your order</h3>
							<div class="your-order-table table-responsive" id="checkout-order">
							<table>
								<thead>
									<tr>
										<th class="product-name">Product</th>
										<th class="product-total">Total</th>
									</tr>
								</thead>
								<tbody>`;
		myCart.forEach((ele) => {
			total += ele.p_price * ele.quantity;
			details += `<tr class="cart_item">
							<td class="product-name">
								${ele.p_title} <strong class="product-quantity"> × ${ele.quantity}</strong>
							</td>
							<td class="product-total">
								<span class="amount">₹ ${ele.p_price * ele.quantity}</span>
							</td>
						</tr>`;
		});
		disAmount = (total * discount) / 100;
		details += `</tbody><tfoot>
						${disAmount > 0 ? `<tr class="cart-subtotal">
						<th>Discount</th>
						<td><span class="amount">₹ ${disAmount.toFixed(2)}</span></td>
						</tr>` : ""}
						<tr class="shipping">
							<th>Shipping</th>
							<td><span class="amount">₹ ${delivery.toFixed(2)}</span></td>
						</tr>
						<tr class="order-total">
							<th>Order Total</th>
							<td><strong><span class="amount">₹ ${(total + delivery - disAmount).toFixed(2)}</span></strong>
							</td>
						</tr>
						</tfoot></table></div>
						<div class="payment-method">
							<div class="order-button-payment mt-20">
								<button type="submit" class="tp-btn-h1">Place order</button>
							</div>
						</div>
					</div>`;

		$("#order-details").html(details);
	}
};

const wish = {
	add: (id) => {
		let myWish = JSON.parse(localStorage.getItem("wish"));
		let add = JSON.parse($(`input[name=cart-${id}]`).val());
		if (!myWish) {
		localStorage.setItem("wish", JSON.stringify([add]));
		} else {
			let check = true;
			myWish.forEach((element) => {
				if (element.prod == id) check = false;
			});
			if (check === true) {
				myWish.push(add);
				localStorage.setItem("wish", JSON.stringify(myWish));
			}
		}
		toastr["success"]("Product added to wishlist.");
		wish.count();
	},
	count: () => {
		let myWish = JSON.parse(localStorage.getItem("wish"));
		let count = !myWish ? 0 : myWish.length;
		$("#wishlist-count").html(count);
		wish.show();
		if (isLoggedIn) wish.save();
	},
	delete: (id) => {
		let myWish = JSON.parse(localStorage.getItem("wish")).filter(function(ele){
			if (ele.prod !== id) return ele;
		});
		localStorage.setItem("wish", JSON.stringify(myWish));
		/* toastr["success"]("Product removed from wishlist."); */
		wish.show();
		wish.count();
	},
	show: () => {
		if (window.location.pathname.includes("wishlist") === true) {
			let myWish = JSON.parse(localStorage.getItem("wish"));
			let html = "";
			if (!myWish || myWish.length <= 0) {
				html +='<tr><td colspan="5"><strong>Wish list is empty.</strong></td></tr>';
			}else{
				myWish.forEach((ele) => {
					html += `<tr>
						<input type="hidden" name="cart-${ele.prod}" value='${JSON.stringify(ele)}' />
						<td class="product-thumbnail"><a href="${base_url + ele.slug}.html"><img src="${base_url + ele.image}" alt=""></a></td>
						<td class="product-name"><a href="${base_url + ele.slug}.html">${ele.p_title}</a></td>
						<td class="product-price"><span class="amount">₹ ${ele.p_price}</span></td>
						<td class="product-quantity">
							<button class="tp-btn-h1" type="button" onclick="cart.add(${ele.prod})">Add To Cart</button>
						</td>
						<td class="product-remove"><a href="javascript:;" onclick="wish.delete(${ele.prod})"><i class="fa fa-times"></i></a></td>
					</tr>`;
				});
			}

			$("#show-wishlist").html(html);
		}
	},
	save: () => {
		let myWish=[];

		if (localStorage.getItem("wish") && localStorage.getItem("wish").length > 0) {
			JSON.parse(localStorage.getItem("wish")).forEach((ele) => {
				myWish.push({ prod: ele.prod });
			});
	
			wishReq = $.ajax({
						type: "POST",
						url: `${base_url}addWish`,
						data: {
							wish: myWish,
						},
						dataType: "JSON",
						beforeSend: function (xhr, opts) {
							if (wishReq != 'ToCancelPrevReq' && wishReq.readyState < 4) {
								wishReq.abort();
							}
						},
					});
    	}
	}
};

const cart = {
	add: (id) => {
		let myCart = JSON.parse(localStorage.getItem("cart"));
		let add = JSON.parse($(`input[name=cart-${id}]`).val());
		add.quantity = $("#input-quantity").val() != undefined ? $("#input-quantity").val() : 1;
		if (!myCart || myCart.length <= 0) {
			localStorage.setItem("cart", JSON.stringify([add]));
		} else {
			let check = true;
			myCart.forEach((element, index) => {
				if (element.prod == id) {
					check = false;
					myCart[index].quantity = add.quantity;
				}
			});
			if (check === true) {
				myCart.push(add);
			}
			localStorage.setItem("cart", JSON.stringify(myCart));
		}

		toastr["success"]("Product added to cart.");
		cart.view();
	},
	delete: (id) => {
		let myCart = JSON.parse(localStorage.getItem("cart")).filter(function(ele){
			if ($("input[name=prodPage]").val() && parseInt($("input[name=prodPage]").val()) === id)
        		$("#input-quantity").val(1);
			if (ele.prod !== id) return ele;
		});
		localStorage.setItem("cart", JSON.stringify(myCart));
		/* toastr["success"]("Product removed from cart."); */
		cart.view();
	},
	update: (id, qty) => {
		let myCart = JSON.parse(localStorage.getItem("cart")).filter(function(ele){
			if (ele.prod === id) ele.quantity = qty;
			return ele;
		});
		localStorage.setItem("cart", JSON.stringify(myCart));
		/* toastr["success"]("Product quantity updated."); */
		cart.view();
	},
	show: () => {
		if (window.location.pathname.includes("cart") === true) {
			let cartBody = "";
			let cartFoot = "";
			let checkOut = `<div class="col-md-9">
								<div class="coupon-all">
									<div class="coupon">
										<a class="tp-btn-h1" href="${base_url}"><i class="fa fa-shopping-cart"></i> add products</a>
									</div>
								</div>
							</div>`;
			let total = 0;
			let myCart = JSON.parse(localStorage.getItem("cart"));
			if (!myCart || myCart.length <= 0) {
				cartBody += `<tr><td colspan="6"><strong>Your cart is empty! Start shopping Now!</strong></td></tr>`;
			}else{
				myCart.forEach((ele) => {
					cartBody += `<tr>
						<td class="product-thumbnail"><a href="${base_url+ele.slug}.html"><img src="${base_url+ele.image}" alt=""></a></td>
						<td class="product-name"><a href="${base_url+ele.slug}.html">${ele.p_title}</a></td>
						<td class="product-price"><span class="amount">₹ ${ele.p_price}</span></td>
						<td class="product-quantity">
							<div class="cart-plus-minus"><input type="text" value="${ele.quantity}" readonly="" />
							<div class="dec qtybutton" onclick="${ele.quantity > 1 ? `cart.update(${ele.prod}, ${ele.quantity - 1})` : ''}">-</div><div class="inc qtybutton" onclick="cart.update(${ele.prod}, ${parseInt(ele.quantity)+1})">+</div></div>
						</td>
						<td class="product-subtotal"><span class="amount">₹ ${ele.p_price * ele.quantity}</span></td>
						<td class="product-remove"><a href="javascript:;" onclick="cart.delete(${ele.prod})"><i class="fa fa-times"></i></a></td>
					</tr>`;
					total += ele.p_price * ele.quantity;
				});
				cartFoot += `<tr>
								<th colspan="4"></th>
								<th class="product-remove">₹ ${total}</th>
								<th></th>
							</tr>`;
				checkOut += `
							<div class="col-md-3">
								<div class="cart-page-total">
									<a class="tp-btn-h1" href="${base_url}checkout.html">Proceed to checkout</a>
								</div>
							</div>`;
			}
			$("#cart-body").html(cartBody);
			$("#cart-foot").html(cartFoot);
			$("#check-out").html(checkOut);
		}
	},
	view: () => {
		let headerCart = '';
		let total = 0;
		let counts = 0;
		let myCart = JSON.parse(localStorage.getItem("cart"));
		
		if (!myCart || myCart.length <= 0) {
		headerCart +=
			'<div class="cart__mini"><ul><li><div class="cart__title"></div></li>';
		headerCart +=
			'<li><div class="cart__item d-flex justify-content-center align-items-center"><h6>Your cart is empty! Start shopping Now!</h6></div></li>';
		} else {
			counts = myCart.length;
			headerCart += `<div class="cart__mini"><ul><li>
											<div class="cart__title"><h4>Your Cart</h4>
											<span>(${counts} Item(s) in Cart)</span>
											</div></li>`;
			myCart.forEach((element) => {
				if ($("input[name=prodPage]").val() && parseInt($("input[name=prodPage]").val()) === element.prod)
        			$("#input-quantity").val(element.quantity);

				total += element.quantity * element.p_price;
				headerCart += `
							<li>
								<div class="cart__item d-flex justify-content-between align-items-center">
								<div class="cart__inner d-flex">
									<div class="cart__thumb">
									<a href="${base_url + element.slug}">
										<img src="${base_url + element.image}" alt="">
									</a>
									</div>
									<div class="cart__details">
									<h6><a href="${base_url + element.slug}"> ${element.p_title}  </a></h6>
									<div class="cart__price">
										<span>₹ ${element.p_price} X ${element.quantity} = ${element.quantity * element.p_price}</span>
									</div>
									</div>
								</div>
								<div class="cart__del">
									<a href="javascript:;" onclick="cart.delete(${element.prod})"><i class="fal fa-times"></i></a>
								</div>
								</div>
							</li>
						`;
			});
			headerCart += `<li>
								<div class="cart__sub d-flex justify-content-between align-items-center">
								<h6>Total</h6>
								<span class="cart__sub-total">₹ ${total}</span>
								</div>
							</li>
							<li>
								<a href="${base_url}cart.html" class="wc-cart mb-10">View cart</a>
								<a href="${base_url}checkout.html" class="wc-checkout">Checkout</a>
							</li>`;
		}

		if (isLoggedIn) cart.save();

		headerCart += "</ul></div>";
		$(".cart-total").html(`₹ ${total}`);
		$(".cart-counts").html(counts);
		$("#show-cart").html(headerCart);
		cart.show();
	},
	save: () => {
		let myCart=[];
		if (localStorage.getItem("wish") && localStorage.getItem("wish").length > 0) {
			JSON.parse(localStorage.getItem("cart")).forEach((ele) => {
				myCart.push({ prod: ele.prod, qty: ele.quantity });
			});

			cartReq = $.ajax({
						type: "POST",
						url: `${base_url}addCart`,
						data: {
							cart: myCart,
						},
						dataType: "JSON",
						beforeSend: function (xhr, opts) {
							if (cartReq != 'ToCancelPrevReq' && cartReq.readyState < 4) {
								cartReq.abort();
							}
						},
					});

			if (window.location.pathname.includes("checkout") === true) {
				checkOut();
			}
		}
	}
};

wish.count();
cart.view();

if ($("#login-form").length > 0) {
	$("#login-form").validate({
	  rules: {
		mobile: {
		  required: true,
		  minlength: 10,
		  maxlength: 10,
		  digits: true,
		},
		pass: {
		  required: true,
		  minlength: 3,
		  maxlength: 100,
		}
	  },
	  errorPlacement: function (error, element) {},
	  submitHandler: function (form) {
		form.submit();
	  },
	});
}

if ($("#register-form").length > 0) {
	$("#register-form").validate({
    rules: {
      reg_mobile: {
        required: true,
        minlength: 10,
        maxlength: 10,
        digits: true,
      },
      otp: {
        required: true,
        minlength: 4,
        maxlength: 4,
        digits: true,
      },
      fullname: {
        required: true,
        minlength: 3,
        maxlength: 100,
      },
      state: {
        required: true,
        minlength: 3,
        maxlength: 50,
      },
      city: {
        required: true,
        minlength: 3,
        maxlength: 50,
      },
      message: {
        required: true,
        maxlength: 255,
      },
      pincode: {
        required: true,
        minlength: 6,
        maxlength: 6,
        digits: true,
      },
      password: {
        required: true,
        minlength: 3,
        maxlength: 100,
      },
      c_password: {
        required: true,
        minlength: 3,
        maxlength: 100,
        equalTo: "#password",
      },
      address: {
        required: true,
        minlength: 15,
        maxlength: 255,
      },
      coupon_code: {
        required: true,
        minlength: 5,
        maxlength: 20,
      },
    },
    errorPlacement: function (error, element) {},
    submitHandler: function (form) {
      form.submit();
    },
  });
}

if ($("#checkout-form").length > 0) {
	$("#checkout-form").validate({
		rules: {
		mobile: {
			required: true,
			minlength: 10,
			maxlength: 10,
			digits: true,
		},
		fullname: {
			required: true,
			minlength: 3,
			maxlength: 100,
		},
		add_id: {
			required: true,
		},
		},
		errorPlacement: function (error, element) {},
		submitHandler: function (form) {
			$.ajax({
				type: "POST",
				url: $(form).attr('action'),
				data: $(form).serialize(),
				dataType: "JSON",
				beforeSend: function (xhr, opts) {
					$("#loading").fadeIn(500);
				},
			}).done((res) => {
				$("#loading").fadeOut(500);
				if(res.status === 'success'){
					localStorage.setItem("cart", JSON.stringify([]));
					setTimeout(() => {
						window.location.href = `${base_url}user/order?order=${res.id}`;
					}, 1500);
				}
				toastr[res.status](res.message);
			});
			return;
		},
	});
}

cancelOrder = (id) => {
	Swal.fire({
		title: "Are you sure?",
		text: "You won't be able to revert this!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, cancel it!",
	}).then((result) => {
		if (result.isConfirmed) {
			$(`#${id}`).submit();
		}
	});
};

shareProd = async (id) => {
	let prod = JSON.parse($(`input[name=cart-${id}]`).val());
	const shareData = {
	  title: document.getElementsByTagName('title')[0].innerHTML,
	  text: prod.p_title,
	  url: window.location.href
	};
	
	try {
		await navigator.share(shareData);
		toastr["success"]("shared successfully");
	} catch (err) {
		toastr["error"](err);
	}
}

// my custom code end