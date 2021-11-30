// este fichero contiene las funciones de javascrip ( jquery
// que permiten mostrar un contenido dinámico en la hoja del formulario
// esta funcion filtra el contenido  cuando cambia el selct de consultar
// esta funcion oculta el contenido de la página cuando
// se selecciona una funcion del combo adiccionar
$(document).ready(function(){
    // cada vez que se cambia el valor del combo   de ediccion
    $("#edi").change(function() {

      edit_display(); // funcion que muestra los campos especificos
	    carga("#cursos","materias.php",{ id : $("#id").val()});
	    $('#resultado').html("");

    });
});



$(document).ready(function () {

    $("#grados").change(function () {
		 var year = $("#years").val().toString();
	   var grado = $("#grados").val();
		 if ( grado > 0 ) {
	    //console.log ("grado %s",grado);
	    carga("#estudiantes","estudiantes.php", {'grados': grado, 'year': year  , id : $("#id").val()});
		}
    });
});
/////////////////////////////////////////////////////////////////////////////


$(document).ready(function () {
    $("#estudiantes").change(function () {


	var year = $("#years").val().toString();
	var grado = $("#grados").val();


	//console.log ("cambio grado");

	if ( grado > 0 ) {

	    carga("#id_ms","materias_grado.php", {'grados': grado, id : $("#id").val()});

	}
    });
});



/////////////////////////////////////////////////////////////////////

// esta funcion espera que  el documento este listo
// y adiere al evento cambio al selector #id_gs
// es decir cada vez que se cambia el grado  y se esta en
// algunos de los items a mensionar  se ejecuta la funcion
// consultar

$(document).ready(function () {
    $("#id_gs").change ( function () {

	// si la opcion para el selector
	// #opcion es:
	// 7 - Matricula alumnos
	// 8 - Matricula docente
	// 9 - Requisitos de materia

	// si la opcion para el selector
	// #add es:
	// 7 - Matricula alumnos
	// 8 - Matricula docente
	// 9 - Requisitos de materia

	if ($("#opcion").val() == 7 ||
	    $("#opcion").val() == 8 ||
	    $("#opcion").val() == 9 ||
	    $("#add").val() == 9 ||
	    $("#add").val() == 8 ||
	    $("#add").val() == 7 )
	{
	    consultar(); // se ejecuta la funcion consultar
	}

    });
});

//////////////////////////////////////////////////////////////////////

$(document).ready(function () {
    $("#cursos").change(function () {

	console.log("Cambio de curso");

	if ($("#edi").val() == 5  ) {
	    cursos = $("#cursos").val();

	    $("#calificador").load("modificar.php", {"cursos": cursos });
			}

		});
		});

	////////////////////////////////////////////////////////////////////////


	$(document).ready(function()
	{
		$("input[name=grupo]").click(function () {
			alert("cambio");
			console.log("cambio el radio buton");
			});
        });

  ////////////////////////////////////////////////////////////////////////

  $(document).ready(function () {

		$("#docentes").change(function () {

			console.log("Cambio de el docente");

			if ($("#add").val() == 8  ) {

				carga("#cursos","materias.php", { id : $("#id").val()});
			}

		});
		});


    /////////////////////////////////////////////////////////////////////

$(document).ready(function () {
	$("#cursos").change(function () {

	console.log("Cambio de la materia");

        if ($("#add").val() == 8 || $("#add").val() == 9) {

	  carga("#id_gs","grados.php",{ id : $("#id").val()});
	}

	});
});

    /////////////////////////////////////////////////////////////////////

$(document).ready(function () {
	$("#periodos").change(function () {

	console.log("Cambio de la periodo");

	if ($("#edi").val() == 12 || $("#opcion").val() == 11 || $("#add").val() == 11 ) {

		periodo = $("#periodos").val();

		$("#calificador").load("limite.php", {"periodos": periodo });

		}

        });
});
