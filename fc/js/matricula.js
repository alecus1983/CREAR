// funcion que consulta una matricula realizada

function consultar_matricula(id_matricula){
  // variable que almacena
  // el resultado
  let res = 0;
  
    // envio los dato por ajax
    // mediante el metodo post
    // en el archivo consulta_matricula.php

    $.ajax({
    type: "POST",
    async: false,
    url: "consultar_matricula.php",
    data: {
	id_matricula : id_matricula
    },

    success: function (respuesta) {
      // salida por consola
      // console.log(respuesta);
      // paso los atributos a la variable matricula
      // a un objeto json y lo retorno
     res = JSON.parse(respuesta);
     
      }
    ,
    error: function (xhr, status) {
      swal('Disculpe, existió un problema' + status);
      console.log(xhr);
    }} );
  // restorna la respuesta
   return res;
}
