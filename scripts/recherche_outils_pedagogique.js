/**
 * Recharge les champs recherche en ajax
 */

$(function() {
	// Charge le champ mots
	var selector = '#champ_mots'
	$(document).on('change', selector, function(event) {
			mots = [];
		$("option:selected", $(selector)).each(function() {
			mots.push($(this).val());
		});
	if (!jQuery.inArray('all', mots)) {
		$(selector + " option:selected").each(function() {
			$(this).removeAttr('selected').trigger('chosen:updated');
		});
	}
	});
});
