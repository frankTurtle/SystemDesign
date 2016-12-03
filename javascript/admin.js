function unhideDepartmentList(){
	var selectionValue = document.getElementById( 'selectTypeOfUser' ).value;
	var select = document.getElementById( 'departments' );

	if( selectionValue == 0 || selectionValue == 1 ){
		select.setAttribute('style', 'display:');
	}
	else{
		select.setAttribute('style', 'display:none');
	}
}

function unhideNewHolds(){
	var holdSelectionValue = document.getElementById( 'newHoldTypes' ).value;
	var holdSelect = document.getElementById( 'newHoldCharges' );
	var holdSelect2 = document.getElementById( 'newHoldDues' );
	var holdSelect3 = document.getElementById( 'newHoldGPAs' );
	var holdSelect4 = document.getElementById( 'newHoldImmunes' );

	if( holdSelectionValue == 0 ){
		holdSelect.setAttribute('style', 'display');
                holdSelect2.setAttribute('style', 'display:none');
                holdSelect3.setAttribute('style', 'display:none');
                holdSelect4.setAttribute('style', 'display:none');
	}
	else if(holdSelectionValue == 1){
		holdSelect2.setAttribute('style', 'display');
                holdSelect3.setAttribute('style', 'display:none');
                holdSelect4.setAttribute('style', 'display:none');
                holdSelect.setAttribute('style', 'display:none');
	}
	else if(holdSelectionValue == 2){
		holdSelect3.setAttribute('style', 'display');
                holdSelect4.setAttribute('style', 'display:none');
                holdSelect.setAttribute('style', 'display:none');
                holdSelect2.setAttribute('style', 'display:none');
	}
	else if(holdSelectionValue == 3){
		holdSelect4.setAttribute('style', 'display');
                holdSelect.setAttribute('style', 'display:none');
                holdSelect2.setAttribute('style', 'display:none');
                holdSelect3.setAttribute('style', 'display:none');
	}

}

var counter = 0;

function addPrerequisite( elementToAppendTo ){
	 var limit = 3;

     if (counter == limit)  {
          alert("You have reached the limit of adding " + counter + " inputs");
     }
     else {
     		for( var i = counter; i < limit; i++ ){
     			var select = document.getElementById( 'prerequisite' + (i+1) );

     			if( select.style.display == 'none' ){
     				select.setAttribute('style', 'display:');
     				counter++;
     				break;
     			}
     		}
     }
}

function toggleElement(){
	for(var i = 0; i < arguments.length; i++) {
		if( document.getElementById( arguments[i] ) == null ){ 
			hideElement( arguments[i].id ); 
			continue;
	 	}
		if( document.getElementById( arguments[i] ).style.display == ''){
			hideElement( arguments[i] );
		}
		else{
			showElement( arguments[i] );
		}
	}
}

function hideElement( elementID ){
    document.getElementById( elementID ).style.display = 'none';   
}

function showElement( elementID ){
	document.getElementById( elementID ).style.display = '';
}

function success(){
	var success = getElementById( 'alertSuccess' );
	success.innerHTML = '<span class="closebtn">&times;</span><strong>Success!</strong> New record created successfully!';
}

function populateCourseData( courseID ){
	$.ajax({
		type: 'POST',
		url: 'AdminEdits.php',
		data: {
			  courseIDSent:courseID
 		},

 		success:
 		function (response) {
  			document.getElementById("restOfCourseEdit").innerHTML = response; 
			}
	});
}

function populateSectionData( sectionID ){
	$.ajax({
		type: 'POST',
		url: 'AdminEdits.php',
		data: {
			  sectionIDSent:sectionID
 		},

 		success:
 		function (response) {
  			document.getElementById("restOfSectionEdit").innerHTML = response; 
			}
	});
}

function populateRoomData( roomID ){
	$.ajax({
		type: 'POST',
		url: 'AdminEdits.php',
		data: {
			  roomIDSent:roomID
 		},

 		success:
 		function (response) {
  			document.getElementById("restOfRoomEdit").innerHTML = response; 
			}
	});
}