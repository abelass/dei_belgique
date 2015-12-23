/**
 * Recharge les champs recherche en ajax
 */

// Charge le champ rubriques
$(function() {
	$(document).on('change','#champ_rubriques',function(event) {
		variables();
		ajaxReload('recherche_mots', {
			args : {
				_rubriques : rubriques,
				rubriques : rubriques,
				id_mot : mots,
				mots : mots,
			}
		});
	});
	
// Charge le champ mots
$(document).on('change','#champ_mots',function(event) {
		variables();
		ajaxReload('recherche_rubriques', {
			args : {
				_rubriques : rubriques,
				rubriques : rubriques,
				id_mot : mots,
				mots : mots,
			}
		});
	});
});

// Compose les variables
function variables(){
	rubriques = [];
	mots = [];
	$("option:selected", $('#champ_rubriques')).each(function() {
		rubriques.push($(this).val());
	});
	$("option:selected", $('#champ_mots')).each(function() {
		mots.push($(this).val());
	});	
	if (!jQuery.inArray('all', rubriques )) {
		ajaxReload('recherche_rubriques', {
			args : {
				_rubriques : '',
				rubriques : '',
				id_mot : mots,
				mots :mots,
				parent : parent,
			}
		});
		rubriques = [];
	}
	if (!jQuery.inArray('all', mots )) {
		ajaxReload('recherche_mots', {
			args : {
				_rubriques : rubriques,
				rubriques : rubriques,
				id_mot : mots,
				mots :'',
			}
		});
		mots = [];
	}
}
