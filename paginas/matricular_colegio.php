<?php
// requiere la clase datos
require ('datos.php');
// atributos enviados
$codigo = $_POST["codigo"];
$inscripcion = $_POST["inscripcion"];
$antiguedad = $_POST["antiguedad"];

echo "<br>codigo : <b>".$codigo."</b>";
echo "<br>inscripcion : <b>".$inscripcion."</b>";
echo "<br>antiguedad : <b>".$antiguedad."</b>";


// creamos una nueva inscripcion
$ficha = new inscripcion($inscripcion);
// creamos una nueva matricula
$matricula = new matricula(0);


// array para almacenar la inscriccion
$f = $ficha->get_all($inscripcion);


// si se ingreso la antiguedad
if (isset($antiguedad)){
  // cuando la antiguedad es igual a cero
  // el estudiante es nuevo
  if($antiguedad == 0){
    // creamos una nueva persona vacia
    $persona = new alumnos(0);
    // le asignamos atributos
    $persona->cedula = $ficha->documento_estudiante;
    $persona->fecha = $ficha->nacimiento;
    $persona->nombres = $ficha->nombre_estudiante;
    $persona->apellidos =$ficha->apellido_estudiante;
    $persona->inscripcion = $ficha->id;
    $persona->telefono =$ficha->celular;
    $persona->correo = $ficha->correo_estudiante;
    // grabo el alumno
    $persona->set_alumno();

    // busco el ultimo alumno ingresado
    $id_alumno = $persona->maximo();

    // asigno parametros a la matricula
    $matricula->id_alumno =$id_alumno;
    $matricula->id_grado = $ficha->id_grado;
    $matricula->id_jornada = $ficha->id_jornada;
    $matricula->year = date("Y");
    $matricula->mes = date("m");
    $matricula->retiro = 11;
    // ejecuto la matricula
    $matricula->set_matricula();

    // actualizo el campo de inscripcion
    $ficha->estado = "m";
    $ficha->update_estado();

  }
  // para estudiante antiguos
  elseif ($antiguedad == 1){

    // actualizo el estudiante
    $persona = new alumnos($codigo);
    // le asignamos atributos
    $persona->cedula = $ficha->documento_estudiante;
    $persona->fecha = $ficha->nacimiento;
    $persona->nombres = $ficha->nombre_estudiante;
    $persona->apellidos =$ficha->apellido_estudiante;
    $persona->inscripcion = $ficha->id;
    $persona->telefono =$ficha->celular;
    $persona->correo = $ficha->correo_estudiante;
    

    // asigno parametros a la matricula
    $matricula->id_alumno =$codigo;
    $matricula->id_grado = $ficha->id_grado;
    $matricula->id_jornada = $ficha->id_jornada;
    $matricula->year = date("Y");
    $matricula->mes = date("m");
    $matricula->retiro = 11;
    // ejecuto la matricula
    $matricula->set_matricula();

    // actualizo el campo de inscripcion
    $ficha->estado = "m";
    $ficha->update_estado();

  }
}







?>
