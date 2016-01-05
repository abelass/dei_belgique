/**
 * Recharge les champs recherche en ajax
 */

// Charge le champ rubriques
$(function() {
	$(document).on('change','#champ_rubriques',function(event) {
		variables('#champ_rubriques');
		ajaxReload('recherche_mots', {
			args : {
				_rubriques : rubriques,
				rubriques : rubriques,
				id_mot : mots,
				mots : mots,
			},
			cache:false
		});
	});
	
// Charge le champ mots

	$(document).on('change','#champ_mots',function(event) {
		variables('#champ_mots');
		ajaxReload('recherche_rubriques', {
			args : {
				_rubriques : rubriques,
				rubriques : rubriques,
				id_mot : mots,
				mots : mots,
			},
			cache:false
		});
	});
});

// Compose les variables
function variables(selector){
	rubriques = [];
	mots = [];
	$("option:selected", $('#champ_rubriques')).each(function() {
		rubriques.push($(this).val());
	});
	$("option:selected", $('#champ_mots')).each(function() {
		mots.push($(this).val());
	});	
	console.log(rubriques );
	if (!jQuery.inArray('all', rubriques )) {
console.log('ok');
    $(selector +" option:selected" ).each(function() {
      $(this).removeAttr('selected').trigger('chosen:updated');
    });
		rubriques = [];
	}
	if (!jQuery.inArray('all', mots )) {
    $(selector +" option:selected" ).each(function() {
    	//console.log(this);
      $(this).removeAttr('selected').trigger('chosen:updated');
    });
		mots = [];
	}
}
