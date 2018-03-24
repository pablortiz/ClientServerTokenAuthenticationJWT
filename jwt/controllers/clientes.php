<?php
defined("APPPATH") OR die("Access denied");
require_once("../jwt/auth2.php");
$t = isset($_REQUEST["t"]) ? $_REQUEST["t"]  : "" ;
$ret = json_decode ( Auth2::check($t) );
$r = $ret->{'ret'};
if (!$r) {echo "Access denied"; exit;}
?>

<header class="text-center"><p class="lead">&nbsp;</p></header>
<div class="row">
	<div class="col-lg-6" style="float:left" >
		<hr/>
		<h3>Datos del cliente:</h3>
		NOMBRE: <input type="text" id="CliNombre" class="form-control" style="width:300px;margin-top:5px" required />
		DNI: <input type="text" id="CliDni" class="form-control" style="width:300px" required />
		<br/>
		<input type="text" id="CliId" class="form-control" style="width:300px;margin-top:5px;display:none" />
		<table width="50%"><tr>
		<td><input type="button" value="Crear" class="btn btn-success" id="crear" /></td>
		<td><input type="button" value="Borrar" class="btn btn-success" id="borrar" style="display:none" /></td>
		<td><input type="button" value="Cancelar" class="btn btn-success" id="cancelar" style="display:none" /></td>
		</tr></table>
	</div>
	<div class="col-lg-6 text-center" id="divr" style="float:left">
		<hr/>
		<h3>Listado de clientes</h3>
		<a href="#" onclick="return false;" id="listcli"><i class="fa fa-align-justify"></i> Acceder al listado de clientes</a>
		<hr/>
	</div>
</div>

<script>
/*
*/
$( "#crear" ).click(function() {
	var n = $("#CliNombre").val();
	var d = $("#CliDni").val();
	var i= $("#CliId").val();
	var url2 = URL +  '/index.php?p=controllers/setcliente&n='+n+'&d='+d+'&i='+i+'&t=<?=$t?>';
	$.ajax({url: url2,beforeSend: function( xhr ) { xhr.overrideMimeType( "text/plain; charset=x-user-defined" ); }
	}).done(function( data ) {
		if (!data.length){
			alert("Client NOT save !!");
		}else{
			clearForm();
			ver_clientes();
		}
	}); 
});
/*
*/
$( "#cancelar" ).click(function() {
	clearForm();
});
/*
*/
$( "#listcli" ).click(function() {
	$("#divr").html("");
	ver_clientes();
});
/*
*/
$("#borrar").click(function(){
	var nombre  = $("#CliNombre").val();	
	var ret = confirm("Delete Client  ["+nombre+"] ?");
	if(ret===true)
	{
		var id  = $("#CliId").val();
		var url = URL +  '/index.php?i='+id+'&p=controllers/delcliente&t=<?=$t?>';
		$.ajax({url: url,beforeSend: function( xhr ) { xhr.overrideMimeType( "text/plain; charset=x-user-defined" ); }
		}).done(function( data ) {
			clearForm();
			ver_clientes();
		});
	}
});
/*
*/
function ver_clientes(){
	var url = URL +  '/index.php?p=controllers/clienteslist&t=<?=$t?>';
	$.ajax({url: url,beforeSend: function( xhr ) { xhr.overrideMimeType( "text/plain; charset=x-user-defined" ); }
	}).done(function( data ) {
		$("#divr").html(data);
	});
}
/*
*/
var TableBackgroundNormalColor = "#ffffff";
var TableBackgroundMouseoverColor = "#9999ff";
function ChangeBackgroundColor(row) {
	row.style.backgroundColor = TableBackgroundMouseoverColor;
}
/*
*/
function RestoreBackgroundColor(row) {
	row.style.backgroundColor = TableBackgroundNormalColor;
}
/*
*/
function EditCliente(id) {
	var url = URL +  '/index.php?i='+id+'&p=controllers/getcliente&t=<?=$t?>';
	$.ajax({url: url,beforeSend: function( xhr ) { xhr.overrideMimeType( "text/plain; charset=x-user-defined" ); }
	}).done(function( data ) {
		var d = JSON.parse(data);
		$("#CliNombre").val(d["nombre"]);
		$("#CliDni").val(d["dni"]);
		$("#CliId").val(d["id"]);
		$("#crear").val("Actualizar");
		$("#cancelar").attr("style", "display:block");
		$("#borrar").attr("style", "display:block");
	});
}
/*
*/
function clearForm(){
	$("#CliNombre").val("");
	$("#CliDni").val("");
	$("#CliId").val("");
	$("#crear").val("Grabar");
	$("#cancelar").attr("style", "display:none");
	$("#borrar").attr("style", "display:none");
}	
</script>