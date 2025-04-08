/* ============================================================
 * Form Wizard
 * Multistep form wizard using Bootstrap Wizard Plugin
 * For DEMO purposes only. Extract what you need.
 * ============================================================ */
(function($) {

	'use strict';

	$(document).ready(function() {

			$('#rootwizard').bootstrapWizard({
					onTabShow: function(tab, navigation, index) {
							var $total = navigation.find('li').length;
							var $current = index + 1;

							// If it's the last tab then hide the last button and show the finish instead
							// if ($current >= $total) {
							// 		$('#rootwizard').find('.pager .next').hide();
							// 		$('#rootwizard').find('.pager .finish').show().removeClass('disabled hidden');
							// }

							if($current==1)
							{
                                     $('#rootwizard').find('.pager .next').show().removeClass('disabled hidden');
                                     $('#rootwizard').find('.pager .previous').hide();
                                     $('#rootwizard').find('.pager .finish').hide();
							} 
							else if($current==2)
							{
                                  $('#rootwizard').find('.pager .previous').show().removeClass('disabled hidden');
                                  $('#rootwizard').find('.pager .finish').hide();
                                  $('#rootwizard').find('.pager .next').show();
							}
							else if($current==3)
							{
                                   $('#rootwizard').find('.pager .finish').show();
                                   $('#rootwizard').find('.pager .next').hide();
							}
							else {
								    $('#rootwizard').find('.pager .finish').show();
									$('#rootwizard').find('.pager .next').hide();
							}

							var li = navigation.find('li a.active').parent();

							var btnNext = $('#rootwizard').find('.pager .next').find('button');
							var btnPrev = $('#rootwizard').find('.pager .previous').find('button');	
							var btnSubmit = $('#rootwizard').find('.pager .submit').find('button');	

							if ($current < $total) {

									var nextIcon = li.next().find('.material-icons');
									var nextIconClass = nextIcon.text();

									btnNext.find('.material-icons').html(nextIconClass)

									var prevIcon = li.prev().find('.material-icons');
									var prevIconClass = prevIcon.html()
									btnPrev.addClass('');
									btnPrev.find('.hidden-block').show();
									btnSubmit.find('.hidden-block').show();
									btnPrev.find('.material-icons').html(prevIconClass);
									btnSubmit.find('.hidden-block').hide();
									
							}
							if($current == 1){
								btnPrev.find('.hidden-block').hide();
								btnPrev.removeClass('');
								btnSubmit.find('.hidden-block').hide();
								btnSubmit.removeClass('');
							} 
							if($current == 2){
								btnSubmit.find('.hidden-block').show();
								btnSubmit.removeClass('');
							} 
					},
					onNext: function(tab, navigation, index) {
							console.log("Showing next tab");
					},
					onPrevious: function(tab, navigation, index) {
							console.log("Showing previous tab");
					},
					onInit: function() {
							$('#rootwizard ul').removeClass('nav-pills');
					}

			});

			$('.remove-item').click(function() {
					$(this).parents('tr').fadeOut(function() {
							$(this).remove();
					});
			});

	});

})(window.jQuery);