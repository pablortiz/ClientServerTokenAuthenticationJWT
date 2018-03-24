<br>
<table class="table">
<tr>
<td><strong>CLIENTE</strong></td>
<td><strong>DNI</strong></td>
<td></td>
</tr>
<?php
for ($i = 0; $i < count($datos); $i++) {
	?>
	<tr onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)" >
	<td><?php echo $datos[$i]["nombre"]; ?></td>
	<td><?php echo $datos[$i]["dni"]; ?></td>
	<td><img src="app/img/edit.png"   style="cursor: pointer;" onclick="EditCliente(<?=$datos[$i]["id"];?>)"></td>
	</tr>
	<?php
}
?>
</table>