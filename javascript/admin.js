function generateNewUserForm(){
	var addFormToThisElement = document.getElementById( "menuSelect" );
	var formItemsArray = new Array();

	var form = document.createElement("form");
		form.setAttribute('method',"post");
		form.setAttribute('action'," ");

	var firstNameLabel = createLabel( "firstName", "First Name " );
	addToArray( formItemsArray, firstNameLabel );

	var lastNameLabel = createLabel( "lastName", "Last Name " );
	addToArray( formItemsArray, lastNameLabel );

	var emailLabel = createLabel( "email", "Email Address " );
	addToArray( formItemsArray, emailLabel );

	var phoneNumberLabel = createLabel( "phone", "Phone Number " );
	addToArray( formItemsArray, phoneNumberLabel );

	var password1Label = createLabel( "password1", "Password " );
	addToArray( formItemsArray, password1Label );

	var password2Label = createLabel( "password2", "Confirm Password " );
	addToArray( formItemsArray, password2Label );

	var userTypeRadioButtonArray = createUserTypeRadio( 
		"Full Time Faculty",
		"Part Time Faculty",
		"Full Time Student",
		"Part Time Student",
		"Administrator",
		"Research Office"
	);
	for( button in userTypeRadioButtonArray ){ 
		addToArray(formItemsArray, userTypeRadioButtonArray[ button ]);
	}

	var submitButton = document.createElement("input");
		submitButton.setAttribute('type',"submit");
		submitButton.setAttribute('value',"Submit");
	addToArray( formItemsArray, submitButton );

	appendObjectsToForm( form, formItemsArray );

	addFormToThisElement.appendChild( form );
}

function createLabel( idAttribute, innerText ){	
	var returnLabel = document.createElement( "label" );
		returnLabel.setAttribute( 'id', (idAttribute + "Label") );
		returnLabel.setAttribute( 'class', "formLabel" );
		returnLabel.innerText = innerText;

	var input = createInput( idAttribute + "Input" );
	var br = document.createElement( "br" ); 

	returnLabel.appendChild( input );
	returnLabel.appendChild( br );

	return returnLabel;
}

function createUserTypeRadio(){
	var returnRadioArray = new Array();

	for(var i = 0; i < arguments.length; i++) {
		var returnLabel = document.createElement( "label" );
			returnLabel.setAttribute( 'id', camelize(arguments[i] + "Label") );
			returnLabel.setAttribute( 'class', "radioLabel" );
			returnLabel.innerText = arguments[ i ];

		var radioButton = document.createElement( "Input" );
			radioButton.setAttribute( 'type', "radio" );
			radioButton.setAttribute( 'name', "userType" );
			radioButton.setAttribute( 'value', i );
			radioButton.setAttribute( 'class', "radioButton");

		var br = document.createElement( "br" );

		returnLabel.appendChild( radioButton );
		returnLabel.appendChild( br );

    	returnRadioArray.push( returnLabel );
  	}

	return returnRadioArray;
}

function createInput( nameAttribute ){
	var returnInput = document.createElement( "input" );
		returnInput.setAttribute( 'type', "text" );
		returnInput.setAttribute( 'name', nameAttribute );
	return returnInput;
}

function appendObjectsToForm( form, elementsArray ){
	elementsArray.forEach( 
		function( item ){
			form.appendChild( item );
		}
	);
}

function addToArray( array ){
	for(var i = 1; i < arguments.length; i++) {
    	array.push( arguments[i] );
  	}
}

function camelize(str) {
  return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function(letter, index) {
    return index == 0 ? letter.toLowerCase() : letter.toUpperCase();
  }).replace(/\s+/g, '');
}