<?php

require_once('modelo.php');

class inscripcion extends modelo{

    protected $nombre_estudiante;
// apellidos del iscrito
protected $apellido_estudiante;
// apellidos del iscrito
protected $nacimiento;
// ciudad de nacimiento del estudiante
protected $ciudad_nacimiento;
// codigo de escolaridad
protected $escolaridad;
// grado
protected $id_grado;
// nombre del grado
protected $id_jornada;
// Telefono del inscrito
protected $telefono;
// Telefono del inscrito
protected $celular;
//tipo de indentificaion
protected $tipo_identificacion;
// documento de estudiante
protected $documento_estudiante;
// lugar de expecidicion del documento del estudiante
protected $lugar_exp_estudiante;
// genero del estudiante ( femenino, masculino )
protected $genero;
// grupo sanguineo del estudiante
protected $gruporh;
// EPS del estudiante
protected $EPS;
// sisben al que pertenece el estudiante
protected $nivelsisben;
// direccion de residencia del estudiante
protected $direccion_estudiante;
// barrio donde vive el estudiante
protected $barrio;
// estrato del estudiante
protected $estrato;
// personas con las que vive el estudiante
protected $vivecon;
// nombre del padre
protected $nombre_padre;
// apellodo del padre
protected $apellido_padre;
// correo electronico del padre
protected $correo_padre;
// telefono del padre
protected $telefono_padre;
// tipo de documento del padre
protected $tipo_identificacion_padre;
// numero de documento del padre
protected $documento_padre;
// lugrar de expedicion
protected $lugar_exp_padre;
// direccion del padre
protected $direccion_padre;
// barrio del padre
protected $barrio_padre;

// nombre de la madre
protected $nombre_madre;
// apellido del padre
protected $apellido_madre;
// correo de la madre debe llevar @
protected $correo_madre;
// telefono de la madre máximo diez dijitos
protected $telefono_madre;
// tipo de documnto CC, CE, RC
protected $tipo_identificacion_madre;
// documento de la madre
protected $documento_madre;
// lugar de expedicin del documento de la madre
protected $lugar_exp_madre;
// direccion de recidencia de la madre
protected $direccion_madre;
// barrio de la madre
protected $barrio_madre;

public function __construct(){

    parent::__construct();
}





}
?>