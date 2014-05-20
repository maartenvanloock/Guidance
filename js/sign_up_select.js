$(document).ready(function(e){

	/*--large--*/

	$('#mantelzorger_optie').css("background-color", "#5db0c6");
	$('#mantelzorger').css("color", "white");
	document.getElementById("mantelzorger_profile").src="img/mantelzorger_selected.png";
	$('#user_privilege').val('false');

	$('#mantelzorger_optie').click(function(e){

	   e.preventDefault();

	   $('#geheim_wachtwoord').slideUp();

	   $('#user_privilege').val('false');

	   $('#mantelzorger_optie').css("background-color", "#5db0c6");
	   $('#mantelzorger').css("color", "white");
	   document.getElementById("mantelzorger_profile").src="img/mantelzorger_selected.png";

	   $('#zorgorganisatie_optie').css("background-color", "white");
	   $('#zorgorganisatie').css("color", "#dfdfdf");
	   document.getElementById("zorgorganisatie_profile").src="img/zorgorganisatie_unselected.png";
	});         

	$('#zorgorganisatie_optie').click(function(e){

	   e.preventDefault();

	   $('#geheim_wachtwoord').slideDown();

	   $('#user_privilege').val('true');

	   $('#zorgorganisatie_optie').css("background-color", "#5db0c6");
	   $('#zorgorganisatie').css("color", "white");
	   document.getElementById("zorgorganisatie_profile").src="img/zorgorganisatie_selected.png";

	   $('#mantelzorger_optie').css("background-color", "white");
	   $('#mantelzorger').css("color", "#dfdfdf");
	   document.getElementById("mantelzorger_profile").src="img/mantelzorger_unselected.png";
	});
}); 