

// Funcion que envia los datos de la matricula
	function enviar_matricula() {
		// almacena el nombre del estudiante
		var nombre_estudiante = document.getElementById("nombre_estudiante").value;
		var apellido_estudiante = document.getElementById("apellido_estudiante").value;
		var nacimiento = document.getElementById("nacimiento").value;
		var ciudad_nacimiento = document.getElementById("ciudad_nacimiento").value;
		var correo_estudiante = document.getElementById("correo_estudiante").value;
		var telefono = document.getElementById("telefono").value;
		var tipo_identificacion = document.getElementById("tipo_identificacion").value;
		var cedula = document.getElementById("cedula").value;
		var lugar_exp_estudiante = document.getElementById("lugar_exp_estudiante").value;
		var genero = document.getElementById("genero").value;
		var gruporh = document.getElementById("gruporh").value;
		var nivelsisben = document.getElementById("nivelsisben").value;
		var direccion_estudiante = document.getElementById("direccion_estudiante").value;
		var barrio = document.getElementById("barrio").value;
		var estrato = document.getElementById("estrato").value;
		var vivecon = document.getElementById("vivecon").value;
	
		// datos del padre
	
		var nombre_padre = document.getElementById("nombre_padre").value;
		var apellido_padre = document.getElementById("apellido_padre").value;
		var correo_padre = document.getElementById("correo_padre").value;
		var telefono_padre = document.getElementById("telefono_padre").value;
		var tipo_identificacion_padre = document.getElementById("tipo_identificacion_padre").value;
		var cedula_padre = document.getElementById("cedula_padre").value;
		var lugar_exp_padre = document.getElementById("lugar_exp_padre").value;
		var direccion_padre = document.getElementById("direccion_padre").value;
		var barrio_padre = document.getElementById("barrio_padre").value;
	
		// datos de la madre
	
		var nombre_madre = document.getElementById("nombre_madre").value;
		var apellido_madre = document.getElementById("apellido_madre").value;
		var correo_madre = document.getElementById("correo_madre").value;
		var telefono_madre = document.getElementById("telefono_madre").value;
		var tipo_identificacion_madre = document.getElementById("tipo_identificacion_madre").value;
		var cedula_madre = document.getElementById("cedula_madre").value;
		var lugar_exp_madre = document.getElementById("lugar_exp_madre").value;
		var direccion_madre = document.getElementById("direccion_madre").value;
		var barrio_madre = document.getElementById("barrio_madre").value;
	
		// llamada usando en método POST para enviar los datos al servidor
		// al archivo inscribir.php que incerta los datos en la base de datos
		// con los correspondientes atributos
	
		jQuery.post("../paginas/inscribir_colegio.php",
	
			{
				"nombre_estudiante": nombre_estudiante,
				"apellido_estudiante": apellido_estudiante,
				"nacimiento": nacimiento,
				"ciudad_nacimiento": ciudad_nacimiento,
				"correo_estudiante": correo_estudiante,
				"telefono": telefono,
				"tipo_identificacion": tipo_identificacion,
				"cedula": cedula,
				"lugar_exp_estudiante": lugar_exp_estudiante,
				"genero": genero,
				"gruporh": gruporh,
				"nivelsisben": nivelsisben,
				"direccion_estudiante": direccion_estudiante,
				"barrio" : barrio,
				"estrato": estrato,
				"vivecon": vivecon,
				"nombre_padre": nombre_padre,
				"apellido_padre": apellido_padre,
				"correo_padre": correo_padre,
				"telefono_padre": telefono_padre,
				"tipo_identificacion_padre": tipo_identificacion_padre,
				"cedula_padre": cedula_padre,
				"lugar_exp_padre": lugar_exp_padre,
				"direccion_padre": direccion_padre,
				"barrio_padre": barrio_padre,
				"nombre_madre": nombre_madre,
				"apellido_madre": apellido_madre,
				"correo_madre": correo_madre,
				"telefono_madre": telefono_madre,
				"tipo_identificacion_madre": tipo_identificacion_madre,
				"cedula_madre": cedula_madre,
				"lugar_exp_madre": lugar_exp_madre,
				"direccion_madre": direccion_madre,
				"barrio_madre": barrio_madre
	
			}
	
		);
	
		}

