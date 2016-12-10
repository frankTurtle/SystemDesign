function deleteClass( section ){
	$.ajax({
        url:"DeleteClass.php", 
        type: "POST", 
        data: {
    		sectionID:section
        },

        success:
        function(result){
        	 alert(result);
        	 getSchedule( 3 );
       	}
     });
}

function getSubject( term, unhideThis ){
	document.getElementById("subject").innerHTML = "";
	document.getElementById("subject").style.display = '';
	document.getElementById("timeSlot").innerHTML = "";
	document.getElementById("timeSlot").style.display = 'none';
	document.getElementById("answer").innerHTML = "";

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

function showDeleteClassButton( element ){
	// var id = element.getAttribute( 'data-row-id' );
	$('.cat'+$(element).attr('data-row-id')).toggle();
}