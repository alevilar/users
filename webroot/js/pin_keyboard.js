let Keyboard = window.SimpleKeyboard.default;

let myKeyboard = new Keyboard({
	onChange: input => onChange(input),
	'layout': {
		'default': [
		    '1 2 3 4', 
		    '5 6 7 8', 
		    '9 0 {bksp}', 
		    //'0 {bksp}'
			],
		/*'default': [
		    '` 1 2 3 4 5 6 7 8 9 0 - = {bksp}',
		    '{tab} q w e r t y u i o p [ ] \\',
		    '{lock} a s d f g h j k l ; \' {enter}',
		    '{shift} z x c v b n m , . / {shift}',
		    '.com @ {space}'
		],*/
	},
	'maxlength': {
		'pin': 1,
	}
});

function onChange(input) {
	var cantInputsPin = 4;
	for(var key = 1; cantInputsPin >= key; key++) {
		if($("#pin"+key).val().length === 0) {
			//si el length del value del pin es 0, le agregamos el input que clickeamos en el keyboard on-screen.
			$("#pin"+key).val(input);
			if(key === 4) {
				//si estamos en el pin 4, enviamos el formulario despues de ingresar el ultimo número.
				$("#pinForm").submit();
			}
			break;
		}
	}
	myKeyboard.clearInput();
}