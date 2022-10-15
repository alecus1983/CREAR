<?php require_once('../Connections/creativo.php'); ?>
<?php
mysql_select_db($database_creativo, $creativo);
$query_docentes_1 = "SELECT * FROM docentes";
$docentes_1 = mysql_query($query_docentes_1, $creativo) or die(mysql_error());
$row_docentes_1 = mysql_fetch_assoc($docentes_1);
$totalRows_docentes_1 = mysql_num_rows($docentes_1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


<title>Consultar_docentes</title>


<style type="text/css"></style>


<link href="estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	color: #006600;
}
a:visited {
	color: #006600;
}
-->
</style></head>

<body>
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">

<tr>
    <td height="150" colspan="2" valign="top">
	
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
      		<tr>
	  
	  			<td width="900" height="150" valign="top"><img src= "../imagenes/logo.png" alt="logo" width="900" height="150" border="0" usemap="#Map" title="Secundaria (10&nbsp;a&ntilde;os en adelante)" target="_self" /></td>
      		</tr>
      	</table>
 	</td>
  </tr>
 <tr>
    <td height="150" colspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
     
      <tr>
        <td width="900" height="150" valign="top"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="900" height="150">
            <param name="movie" value="../videos/Crecimiento 900 x 150.swf" />
            <param name="quality" value="high" />
            <embed src="../videos/Crecimiento 900 x 150.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="900" height="150"></embed>
        </object></td>
      </tr>
   
    </table></td>
  </tr>
  <tr>
    <td width="144" height="879" valign="top">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolordark="#006633">
        <!--DWLayoutTable-->
      
        <tr bordercolor="#006600" bordercolorlight="#006666" bordercolordark="#006600">
          <td width="98" height="40" align="center" valign="middle" nowrap="nowrap" bordercolor="#006633" bordercolordark="#FFFFFF" background=""><span class="enlaces"><img src="../imagenes/Quienes somos.png" width="65" height="60" /></span></td>
        </tr>
        <tr bordercolor="#006600" bordercolorlight="#006666" bordercolordark="#006600">
          <td height="40" valign="top"><div align="center" class="enlaces"><a href="Quienes_somos.php">Quienes Somos</a> </div></td>
        </tr>
        <tr bordercolor="#006600" bordercolorlight="#006666" bordercolordark="#006600">
          <td height="61" valign="top"><div align="center"><img src="../imagenes/legal.png" alt="Marco legal" width="86" height="60" /></div></td>
        </tr>
        <tr bordercolor="#006600" bordercolorlight="#006666" bordercolordark="#006600">
          <td height="40" valign="top"><div align="center"><span class="enlaces"><a href="Marco_legal.php">Marco Legal </a></span></div></td>
        </tr>
        <tr bordercolor="#006600" bordercolorlight="#006666" bordercolordark="#006600">
          <td height="60" valign="top"><div align="center">
              <p><img src="../imagenes/talleres.png" alt="tareas" width="60" height="60" /></p>
          </div></td>
        </tr>
        <tr bordercolor="#006600" bordercolorlight="#006666" bordercolordark="#006600">
          <td height="40" valign="top"><div align="center"><a href="../moodle/index.php" target="_blank" class="enlaces">Moodle</a></div></td>
        </tr>
        <tr bordercolor="#006600" bordercolorlight="#006666" bordercolordark="#006600">
          <td height="60" valign="top"><div align="center">
              <p><img src="../imagenes/Eventos.png" alt="eventos" width="68" height="60" /></p>
          </div></td>
        </tr>
        <tr bordercolor="#006600" bordercolorlight="#006666" bordercolordark="#006600">
          <td height="40" valign="top"><div align="center"><a href="../Eventos.php" class="enlaces">Eventos</a></div></td>
        </tr>
        <tr bordercolor="#006600" bordercolorlight="#006666" bordercolordark="#006600">
          <td height="60" valign="top"><div align="center"><img src="../imagenes/fotos.png" alt="fotos" width="60" height="60" /></div></td>
        </tr>
        <tr bordercolor="#006600" bordercolorlight="#006666" bordercolordark="#006600">
          <td height="40" valign="top"><div align="center"><span class="enlaces"><a href="../paginas/fotos.php">Galer&iacute;a de Fotos</a></span></div></td>
        </tr>
        <tr bordercolor="#006600" bordercolorlight="#006666" bordercolordark="#006600">
          <td height="354">&nbsp;</td>
        </tr>
      </table>
    </td>
   
    <td width="756" valign="top">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <!--DWLayoutTable-->
     
      	  <tr>    <td width="183" height="601">
   	        
            <td width="448" valign="top">                                    <p class="Titulo_1"><strong>Formato de docentes </strong></p>
              
			  <p class="Parrafo">&nbsp;</p>
			  <table border="1">
  <tr class="Titulo_tabla">
    <td>Codigo</td>
    <td class="Titulo_tabla">Contrase&ntilde;a</td>
    <td>Nombre</td>
    <td>Apellido</td>
    <td>Direccion</td>
    <td>Telefono</td>
    <td>Celular</td>
    <td>Fecha</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_docentes_1['Codigo']; ?></td>
      <td class="formato_tabla"><?php echo $row_docentes_1['Contraseña']; ?></td>
      <td><?php echo $row_docentes_1['Nombre']; ?></td>
      <td><?php echo $row_docentes_1['Apellido']; ?></td>
      <td><?php echo $row_docentes_1['Direccion']; ?></td>
      <td><?php echo $row_docentes_1['Telefono']; ?></td>
      <td><?php echo $row_docentes_1['Celular']; ?></td>
      <td><?php echo $row_docentes_1['Fecha']; ?></td>
    </tr>
    <?php } while ($row_docentes_1 = mysql_fetch_assoc($docentes_1)); ?>
</table>
              <p></p>
              <!--aqui termina el contenido HTML-->
            <td width="125">            
      </table>
	
	</td>
  </tr>
  
  
  
  <tr>
    <td height="60" colspan="2" valign="top">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <!--DWLayoutTable-->
     
      <tr>
        <td width="145" height="59">&nbsp;</td>
        <td width="755" valign="top"><p align="center" class="Subtitulo">Direccion: Carrera 16 N calle 13 esquina - Telefono: (032) 829 40 44 </p>          <p align="center"><span class="Subtitulo">Celular: 316 6288374 </span></p></td>
        </tr>
    </table>
	
	
	</td>
  </tr>
</table>

  
<map name="Map" id="Map">

  <area shape="rect" coords="301,97,396,118"  href="primera_infancia.php" target="_parent" alt="3- 5 a&ntilde;os" title="Primera infancia (1.5 a 4 a&ntilde;os)" />
  
<area shape="rect" coords="423,97,512,117" href="primaria.php" target="_parent" title="Primaria (5 a 12 a&ntilde;os)" />

<area shape="rect" coords="535,98,626,117" href="secundaria.php" target="_parent" title="Secundaria (10&nbsp;a&ntilde;os en adelante)" />

<area shape="rect" coords="655,98,744,117" href="media.php" target="_parent" title="Media" />

<area shape="rect" coords="765,96,876,118" href="tecnica.php" target="_parent" title="Tecnica " />

<area shape="circle" coords="61,71,61" href="../index.php" target="_parent" title="Inicio" />
</map>

</body>
</html>
<?php
mysql_free_result($docentes_1);

/* mysql_free_result($Grados); */
?>
