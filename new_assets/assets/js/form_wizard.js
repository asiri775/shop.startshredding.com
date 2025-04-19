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
						const current = index; // index is the next tab (we are going *to* this)
						const $form = $('#wizard-form'); // your form element
						const sameBilling = $('#defaultCheck').is(':checked');
						
						let sameBillingTab1 = [
							'shipping_address_1',
							'shipping_city',
							'shipping_postal_code',
							'shipping_phone'
						];
						

						const requiredFieldsTab1 = [
							'company_name',
							'contact_name',
							'phone_number',
							'billing_address_1',
							'billing_city',
							'billing_postal_code',
							'operation_from', 
							'operation_to',
						];

						const requiredFieldsTab3 = [
							'credit_card_name',
							'credit_card_number',
							'credit_card_expire_month',
							'credit_card_expire_year',
							'credit_card_ccv',
							'signature'
						];
						
						if (current === 1) {
							const validator = $form.validate();
							if (!$form.valid()) {
								const invalidFields = validator.invalid;
								const invalidIds = Object.keys(invalidFields);
						
								let sameBillingRequiredFields = [];
								if (sameBilling) {
									sameBillingRequiredFields = sameBillingTab1.filter(field => invalidIds.includes(field));
								} else {
									// Ignore shipping fields if not sameBilling
									const shippingFieldsToClear = [
										'shipping_address_1',
										'shipping_city',
										'shipping_postal_code',
										'shipping_phone'
									];
									// Remove shipping fields from invalidIds
									for (const field of shippingFieldsToClear) {
										delete invalidFields[field];
									}
									validator.form(); // Re-run validation to update state
								}
								const missingRequiredFields = requiredFieldsTab1.filter(field => Object.keys(invalidFields).includes(field));
						
								if (missingRequiredFields.length > 0) {
									// Focus on first invalid field
									const firstInvalidField = Object.keys(invalidFields)[0];
									if (firstInvalidField) {
										$(`[name="${firstInvalidField}"]`).focus();
									}
									return false; // Block tab switch
								}
							}

						}

						if (current === 2) {
							const termsAccepted = $('#checkbox-agree').is(':checked');
							if (!termsAccepted) {
								$('#termsModal').modal('show');
								return false;
							}
							return true;
						}

						if (current === 3) {
							if (!$form.valid()) {

								const validator = $form.validate();
								const invalidFields = validator.invalid;
								const invalidIds = Object.keys(invalidFields);

								console.log(invalidIds)
								console.log(invalidFields)

								const missingRequiredFieldsTab3 = requiredFieldsTab3.filter(field => invalidIds.includes(field));

								if (missingRequiredFieldsTab3.length > 0) {
									return false; // Prevent moving to the next tab
								}
							}
							return true; // Allow tab change
							
						}
						
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