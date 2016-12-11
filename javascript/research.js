function getSubject( term, unhideThis ){
	document.getElementById("subject").innerHTML = "";
	document.getElementById("subject").style.display = '';

	$.ajax({
		type: 'POST',
		url: 'GetSubject.php',
		data: {
			  termSelected:term
 		},

 		success:
 		function (response) {
  			document.getElementById("subject").innerHTML = response; 
			}
	});
}

function getSchedule( term ){
	document.getElementById("currentClasses").innerHTML = ""; 

	$.ajax({
		type: 'POST',
		url: 'GetSchedule.php',
		data: {
			  termSelected:term
 		},

 		success:
 		function (response) {
  			document.getElementById("currentClasses").innerHTML = response; 
		}
	});
}