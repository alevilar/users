
	var $p1 = $("#pin1");
	var $p2 = $("#pin2");
	var $p3 = $("#pin3");
	var $p4 = $("#pin4");
	var $form = $("#pinForm");

	function apretarYseguir( $current ) {
		$current.on('keyup', function(e) {
			if (e.keyCode==8) {
				// back space
		   		this.value="";
		   		var $prev = $current.prev("input");
		   		if ( $prev.length ) {
		   			$prev.focus();
		   		}
			} else {
				var $next = $current.next("input");
				if ( $next.length ) {
					apretarYseguir($next)
				} else {
					$form.submit();
				}
			}
		} ).focus();
	}

	apretarYseguir($p1);


	function ponerPin() {
		$(".pin").val("");
		$p1.focus();
	};
	ponerPin();
	$(".pin").on('click', ponerPin );