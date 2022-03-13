/**
 * Custom scripts for PACE Theme
 *
 * @package Digital\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

(function($) {

	$( document ).ready(function() {

		// Make sure JS class is added.
		document.documentElement.className = "js";

		// Run on page scroll.
		$(window).scroll( function() {

			// Toggle header class after threshold point.
			if ( $(document).scrollTop() > 50 ) {
				$(".site-header").addClass("shrink");
			} else {
				$(".site-header").removeClass("shrink");
			}

		});

		// Responsive pricing table (mobile buttons)
		if ($(window).width() < 769){
			$( ".comparison-table ul" ).on( "click", "li", function() {
				var pos = $(this).index()+2;
				$("tr").find('td:not(:eq(0))').hide();
				$('td:nth-child('+pos+')').css('display','table-cell');
				$("tr").find('th:not(:eq(0))').hide();
				$('li').removeClass('active');
				$(this).addClass('active');
			});
		}

		// List Search - Filter
		// $("#filter").focus();
		const listItems = $(".search-content li");
		$("#filter").on("input", function() {
			let filter = $(this).val();
			if (filter) {
				listItems.removeClass("active").hide();
				$(`li:contains('${filter}')`).addClass("active").fadeIn(500).show();
				if ($(".search-content li.active")[0]){
					$(".list-search .no-results").hide();
					$(".list-search .wp-block-buttons").show();
				} else {
					$(".list-search .wp-block-buttons").hide();
					$(".list-search .no-results").show();
				}
			} else {
				$(".list-search .no-results").hide();
				$(".list-search .wp-block-buttons").show();
				listItems.fadeIn(1000).show();
			}
		});
		jQuery.expr[':'].contains = function(a, i, m) {
			return jQuery(a).text().toUpperCase()
				.indexOf(m[3].toUpperCase()) >= 0;
		};

		/** Testimonial - Adjust bottom margin based on testimonial content height**/
		if ($(window).width() < 801){
			$('.testimonial .wp-block-cover__inner-container').each(function() {
				var $this = $(this);
				var sectionInnerHeight = $this.innerHeight();
				$('.testimonial').css({
					'margin-bottom': (sectionInnerHeight)
				});
			});
		}

		// Auto add vp-a lightbox listener to video buttons
		$(".wp-block-button.video").find('a').addClass('vp-a');

		/** Add Fancybox data attribute **/
		$("a.vp-a").each(function () {
			$(this).attr('data-fancybox', '');
		});

		/** Chat **/
		var options = {
			"rootUrl": "https://app.five9.com/consoles/",
			"type": "chat",
			"ga":"UA-87637906-1",
			"title": "Home Run Financing",
			"tenant": "PACEFunding",
			"profiles": "PACEFunding Team Email",
			"showProfiles": true,
			"autostart": false,
			"theme": "https://www.homerunfinancing.com/wp-content/themes/homerunfinancing/chat.css?ver=1.1",
			"logo": "https://www.homerunfinancing.com/wp-content/uploads/2021/06/homerun-logo-header-white-v2.png",
			"surveyOptions": {
				"showComment": true,
				"requireComment": false
			},
			"fields": {
				"name": {
					"value": "",
					"show": true,
					"label": "Name"
				},
				"email": {
					"value": "",
					"show": true,
					"label": "Email"
				}
			},
			"playSoundOnMessage": true,
			"allowCustomerToControlSoundPlay": false,
			"showEmailButton": true,
			"hideDuringAfterHours": false,
			"useBusinessHours": true,
			"showPrintButton": false,
			"allowUsabilityMenu": false,
			"enableCallback": false,
			"callbackList": "",
			"allowRequestLiveAgent": false
		};
		Five9SocialWidget.addWidget(options);

		/** FAQ **/
		var coll = $(".homerunfinancing .schema-faq-question");
		var i;
		for (i = 0; i < coll.length; i++) {
			coll[i].addEventListener("click", function() {
				this.classList.toggle("active");
				var content = this.nextElementSibling;
				if (content.style.maxHeight){
					content.style.maxHeight = null;
				} else {
					content.style.maxHeight = content.scrollHeight + "px";
				}
			});
		}

	});

})(jQuery);