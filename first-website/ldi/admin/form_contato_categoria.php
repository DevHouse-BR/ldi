<?php
require("permissao_documento.php");
error_reporting  (E_ERROR | E_WARNING | E_PARSE);
require("funcoes.php");

if(strlen($_GET["cd"]) >0){
	$cd = trim($_GET["cd"]);
	require("../includes/conectar_mysql.php");
	$query = "SELECT categoria, ordem FROM contato_categoria WHERE cd='" . $cd . "'";
	$result = mysql_query($query) or die("Erro de conex�o ao banco de dados: " . mysql_error());
	$registro = mysql_fetch_assoc($result);
	$categoria = $registro["categoria"];
	$ordem = $registro["ordem"];
	require("../includes/desconectar_mysql.php");
}

inicio_pagina(true);
monta_formulario();
final_pagina(); 

function monta_formulario(){
	global $categoria, $cd, $ordem;
?>
	<script language="javascript">
		function valida_form(){
			var f = document.forms[0];
			if((f.categoria.value == "") || (f.ordem.value == "")){
				alert('Informe a Categoria e a Ordem!');
				return false;
			}
			else return true;
		}
	</script>
	<span class="celula"><B>Formul�rio de Categoria de Contatos</B></span><br><br>
	<table>
		<form onSubmit="return valida_form();" action="salva_contato_categoria.php" method="post">
		<tr>
			<td align="right">Categoria:</td>
			<td><input type="text" name="categoria" value="<?=$categoria?>" size="20" maxlength="255"></td>
		</tr>
		<tr>
			<td align="right">Ordem:</td>
			<td><input type="text" name="ordem" value="<?=$ordem?>" size="20" maxlength="5"></td>
		</tr>
		<tr>
			<td></td>
			<td align="right"><input type="reset" value="Cancelar"><input type="submit" value="Salvar"></td>
		</tr>
		
		<? 
			if(strlen($cd)>0){
				echo('<input type="hidden" name="modo" value="update">');
				echo('<input type="hidden" name="cd" value="' . $cd . '">');
			}
			else echo('<input type="hidden" name="modo" value="add">');
		?>
		</form>
	</table>
<?
}
?>