<?php require_once("conexion.php"); ?>

<html>
<head>
<meta charset="utf-8">
<title>Bitacora</title>
<link href="js/fancybox/jquery.fancybox-1.3.4.css" media="all" rel="stylesheet">
<style type="text/css">
.encabezado {
	color: #FFF;
	background-color: #09F;
}
.contenedor {
	color: #000;
	background-color: #CFF;
}
a { 
display: block;
text-align: center;
width: 15px;
border-radius: 5px;
text-decoration: none;
color: #F60;
background: #FFF;
margin: 5px;
float: left;
font-weight:bold;
}
a:hover{
	background: #058998;
	color: #fff;
}
a:visited {
	color: #F60;
}
</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.3.min.js"> </script>
<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"> </script>
<script type="text/javascript" src="js/fancybox/jquery.easing-1.3.pack.js"> </script>
<script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"> </script>
<script type="text/javascript">
	$(document).ready(function(e) {
        $('a').click(function(e) {
            e.preventDefault();
			var id=$(this).attr('href').replace('#','');
			$.ajax({url:"index.php",
					type:'GET',
					data:"cmd=buscar&id_server="+id,
					dataType:"html",
					success: function(html){
						//$('.detalle').html($(html).find('.buscar_server').html());
						$.fancybox($(html).find('.buscar_server').html());
					}
			});
        });
    });
</script>
</head>

<body>
<div align="center"> 
<p><strong>CONTROL DE MANTENIMIENTO SERVIDOR</strong></p>
<!--<form name="form"> 
    Seleccione el número de servidor:
   <select name="select">
    <option value=""></option>-->
    <?php /*
	$rows = mysql_query("SELECT * FROM registro",conectionDB()) or die(mysql_error());
	while ($row = mysql_fetch_array($rows)) {?>											   <!-- obtención del numero de servidores de la BD bitacora -->
    <option value="<?php echo $row['servidor']?>"><?php echo $row['servidor']?></option>
    <?php } */?>
   <!--</select>
    <input type="submit" name="button" id="button" value="Mostrar">
</form>-->
<?php
function search_user($valor) {
$rows = mysql_query("SELECT * FROM registro", conectionDB()) or die(mysql_error());
$s = '';
while($row = mysql_fetch_array($rows)) {
	if(/*$row['servidor'] == @$_POST['select'] &&*/ $valor%$row['periodicidad'] == 0) {	
	//$s = '<a href="#'.$row['responsable'].'">'.$row['responsable'].'</a>';
	   $s.= '<a href="#'.$row['servidor'].'">'.$row['servidor'].'</a>';
	}
}
return $s;
}
?>
<table width="500" class="encabezado">
    <tr>
    <td><div align="center"><strong>DICIEMBRE</strong></div></td>
    </tr>
</table> 
<table width="500" class="encabezado">
    <tr>
    <td width="30"><div align="center"><strong>D</strong></div></td>
    <td width="30"><div align="center"><strong>L</strong></div></td>
    <td width="30"><div align="center"><strong>M</strong></div></td>
    <td width="30"><div align="center"><strong>M</strong></div></td>
    <td width="30"><div align="center"><strong>J</strong></div></td>
    <td width="30"><div align="center"><strong>V</strong></div></td>
    <td width="30"><div align="center"><strong>S</strong></div></td>
    </tr>
</table>
<table width="500">
  <tr>
<?php
for($day=1; $day<=31; $day++) //cellpadding="0" cellspacing="0" border="0"
{
	echo '<td width="30" height="70" class="contenedor" valign="top">
	<div align="right">
	<table> 
		<tr> 
			<td width="19" class="contenedor"><div align="center">'.$day.'</div></td>
		</tr>
	</table>
	</div>
	<div align="center">'.search_user($day).'</div>
	</td>';
	if($day % 7 == 0)
	{
		echo '</tr>';
	}
}
?>
</table>
<?php if(@$_GET['cmd'] == "buscar") { ?>
<div class="buscar_server">
<?php
$rows = mysql_query("SELECT servidor as Servidor, responsable as Encargado, medio as Medio, tiempo as Tiempo, CONCAT('Cada ',periodicidad,' dias') as Periodicidad FROM registro WHERE servidor ='".$_REQUEST['id_server']."'", conectionDB()) or die(mysql_error());
$row_server = mysql_fetch_assoc($rows);
if($row_server['Servidor'] == $_REQUEST['id_server']) {
	foreach($row_server as $row=>$val) {
		echo "<div><b>".$row.":</b> <em>".$val."</em></div>";		
	}
}
?>
</div>
<?php } ?>
<div class="detalle"> </div>
</div>
</body>
</html>