function deleteClass(){
	$.ajax({
        url:"DeleteClass.php", 
        type: "POST", 
        // data: {

        // },

        success:
        function(result){
        	 alert(result);
       	}
     });
}

function getSubject( term, unhideThis ){
	document.getElementById("subject").innerHTML = "";
	document.getElementById("subject").style.display = '';
	document.getElementById("timeSlot").innerHTML = "";
	document.getElementById("timeSlot").style.display = 'none';

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

function getTimeSlot( timeslot, unhideThis ){
	document.getElementById("timeSlot").innerHTML = "";
	document.getElementById("timeSlot").style.display = '';

	$.ajax({
		type: 'POST',
		url: 'GetTimeSlot.php',
		data: {
			  subjectSelected:timeslot
 		},

 		success:
 		function (response) {
  			document.getElementById("timeSlot").innerHTML = response; 
			}
	});
}
