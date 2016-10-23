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


// function generateNewUserForm(){
// 	clearOut();
// 	var addFormToThisElement = document.getElementById( "menuSelect" );
// 	var formItemsArray = new Array();
// 	var isRequired = true;

// 	var form = document.createElement("form");
// 		form.setAttribute('method',"post");
// 		form.setAttribute('action'," ");
// 		form.setAttribute('id', "newUserForm");

// 	var firstNameLabel = createLabel( "firstName", "First Name ", isRequired );
// 	addToArray( formItemsArray, firstNameLabel );

// 	var lastNameLabel = createLabel( "lastName", "Last Name ", isRequired );
// 	addToArray( formItemsArray, lastNameLabel );

// 	var emailLabel = createLabel( "email", "Email Address ", isRequired );
// 	addToArray( formItemsArray, emailLabel );

// 	var phoneNumberLabel = createLabel( "phone", "Phone Number " );
// 	addToArray( formItemsArray, phoneNumberLabel );

// 	var password1Label = createLabel( "password1", "Password ", isRequired );
// 	addToArray( formItemsArray, password1Label );

// 	var password2Label = createLabel( "password2", "Confirm Password ", isRequired );
// 	addToArray( formItemsArray, password2Label );

// 	// var userTypeRadioButtonArray = createUserTypeRadio( 
// 	// 	"Full Time Faculty",
// 	// 	"Part Time Faculty",
// 	// 	"Full Time Student",
// 	// 	"Part Time Student",
// 	// 	"Administrator",
// 	// 	"Research Office"
// 	// );
// 	// for( button in userTypeRadioButtonArray ){ 
// 	// 	addToArray(formItemsArray, userTypeRadioButtonArray[ button ]);
// 	// }



// 	var submitButton = document.createElement("input");
// 		submitButton.setAttribute('type',"submit");
// 		submitButton.setAttribute('value',"Submit");
// 		submitButton.setAttribute('id', "submitButton");
// 	addToArray( formItemsArray, submitButton );

// 	appendObjectsToForm( form, formItemsArray );

// 	addFormToThisElement.appendChild( form );
// }

// function createCourse(){
// 	clearOut();
// 	var addFormToThisElement = document.getElementById( "menuSelect" );
// 	var formItemsArray = new Array();
// 	var isRequired = true;

// 	var form = document.createElement("form");
// 		form.setAttribute('method',"post");
// 		form.setAttribute('action'," ");
// 		form.setAttribute('id', "createCourseForm");

// 	var departmentIDLabel = createLabel( "departmentID", "Department ID", isRequired );
// 	addToArray( formItemsArray, departmentIDLabel );

// 	var creditHoursLabel = createLabel( "creditHours", "Credit Hours ", isRequired );
// 	addToArray( formItemsArray, creditHoursLabel );

// 	var courseNameLabel = createLabel( "courseName", "Email Address ", isRequired );
// 	addToArray( formItemsArray, courseNameLabel );

// 	var textbookLabel = createLabel( "textbook", "Textbook " );
// 	addToArray( formItemsArray, textbookLabel );

// 	var descriptionLabel = createLabel( "description", "Description ", isRequired );
// 	addToArray( formItemsArray, descriptionLabel );

// 	var courseCodeLabel = createLabel( "courseCode", "Course Code ", isRequired );
// 	addToArray( formItemsArray, courseCodeLabel );

// 	var submitButton = document.createElement("input");
// 		submitButton.setAttribute('type',"submit");
// 		submitButton.setAttribute('value',"Submit");
// 		submitButton.setAttribute('id', "submitButton");
// 	addToArray( formItemsArray, submitButton );

// 	appendObjectsToForm( form, formItemsArray );

// 	addFormToThisElement.appendChild( form );
// }


// function createSection(){
// 	clearOut();
// 	var addFormToThisElement = document.getElementById( "menuSelect" );
// 	var formItemsArray = new Array();
// 	var isRequired = true;

// 	var form = document.createElement("form");
// 		form.setAttribute('method',"post");
// 		form.setAttribute('action'," ");
// 		form.setAttribute('id', "createSectionForm");

// 	var courseIDLabel = createLabel( "courseID", "Course ID", isRequired );
// 	addToArray( formItemsArray, courseIDLabel );

// 	var termIDLabel = createLabel( "termID", "Term ", isRequired );
// 	addToArray( formItemsArray, termIDLabel );

// 	var timeslotIDLabel = createLabel( "timeSlot", "Timeslot", isRequired );
// 	addToArray( formItemsArray, timeslotIDLabel );

// 	var roomIDLabel = createLabel( "roomID", "Room ID" , isRequired);
// 	addToArray( formItemsArray, roomIDLabel );

// 	var facultyIDLabel = createLabel( "facultyID", "Faculty ID", isRequired );
// 	addToArray( formItemsArray, facultyIDLabel );


// 	var submitButton = document.createElement("input");
// 		submitButton.setAttribute('type',"submit");
// 		submitButton.setAttribute('value',"Submit");
// 		submitButton.setAttribute('id', "submitButton");
// 	addToArray( formItemsArray, submitButton );

// 	appendObjectsToForm( form, formItemsArray );

// 	addFormToThisElement.appendChild( form );
// }

// function createLabel( idAttribute, innerText, isRequired ){	
// 	var returnLabel = document.createElement( "label" );
// 		returnLabel.setAttribute( 'id', (idAttribute + "Label") );
// 		returnLabel.setAttribute( 'class', "formLabel" );
// 		returnLabel.innerText = innerText;

// 	var input = createInput( idAttribute + "Input", isRequired );
// 	var br = document.createElement( "br" ); 

// 	returnLabel.appendChild( input );
// 	returnLabel.appendChild( br );

// 	return returnLabel;
// }

// function createUserTypeRadio(){
// 	var returnRadioArray = new Array();

// 	for(var i = 0; i < arguments.length; i++) {
// 		var returnLabel = document.createElement( "label" );
// 			returnLabel.setAttribute( 'id', camelize(arguments[i] + "Label") );
// 			returnLabel.setAttribute( 'class', "radioLabel" );
// 			returnLabel.innerText = arguments[ i ];

// 		var radioButton = document.createElement( "Input" );
// 			radioButton.setAttribute( 'type', "radio" );
// 			radioButton.setAttribute( 'name', "userType" );
// 			radioButton.setAttribute( 'value', i );
// 			radioButton.setAttribute( 'class', "radioButton");

// 		if( arguments[i].includes("Faculty") ){
// 			radioButton.setAttribute( 'onclick', "additionalFacultyOptions()" );
// 		}

// 		var br = document.createElement( "br" );

// 		returnLabel.appendChild( radioButton );
// 		returnLabel.appendChild( br );

//     	returnRadioArray.push( returnLabel );
//   	}

// 	return returnRadioArray;
// }

// function radioButtons(){
// 	document.write("
// 		<select name='departmentID'>
// 			<?php 
// 				$sql = mysqli_query($dataBase, 'SELECT deptName FROM Department');

// 				while ($row = $sql->fetch_assoc()){
// 					echo '<option value=\'owner1\'>' . $row['username'] . '</option>';
// 				}
// 			?>
// 		</select>"
// 	);	
// }

// function additionalFacultyOptions(){
// 	var form = document.getElementById( "newUserForm" );
// 	var studentRadioButton = document.getElementById( "fullTimeStudentLabel" );

// 	if( document.getElementById("deptID") ) return;

// 	var departments = document.createElement( "select" );
// 		departments.setAttribute('name', "departmentID");
// 		departments.setAttribute('id', "deptID");

// 	var dept1 = document.createElement( "option" );
// 		dept1.setAttribute('value', "44412345");
// 		dept1.setAttribute('id', "mathDept")
// 		dept1.innerText = "Mathematics";

// 	var dept2 = document.createElement( "option" );
// 		dept2.setAttribute('value', "44412347");
// 		dept2.innerText = "Art & Art History";

// 	departments.appendChild( dept1 );
// 	departments.appendChild( dept2 );

// 	form.insertBefore( departments, studentRadioButton );
// }

// function createInput( nameAttribute, isRequired ){
// 	var returnInput = document.createElement( "input" );
// 		returnInput.setAttribute( 'type', "text" );
// 		returnInput.setAttribute( 'name', nameAttribute );

// 	if( isRequired ){ returnInput.setAttribute( 'required', "true" ); }

// 	return returnInput;
// }

// function appendObjectsToForm( form, elementsArray ){
// 	elementsArray.forEach( 
// 		function( item ){
// 			form.appendChild( item );
// 		}
// 	);
// }

// function addToArray( array ){
// 	for(var i = 1; i < arguments.length; i++) {
//     	array.push( arguments[i] );
//   	}
// }

// function camelize(str) {
//   return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function(letter, index) {
//     return index == 0 ? letter.toLowerCase() : letter.toUpperCase();
//   }).replace(/\s+/g, '');
// }

// function clearOut(){
// 	document.getElementById( "menuSelect" ).innerHTML = "";
// }