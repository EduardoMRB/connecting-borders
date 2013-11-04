<?php
	if(!$this->user_m->logged_in()){
		$this -> session -> set_flashdata('error', 'Usuário deve estar logado para acessar a página');
		redirect('');
	}
?>
<?php

?>
<script>
	function validate() {
		if(!$('input:text[name=namef]').val() || !$('input:text[name=friend]').val()) {
			window.alert('Informe o e-mail e o nome do seu amigo.');
			return false;
		}
		return true;
	}
</script>
<form action="schools/email/" method="post">
{{ user:profile }}

</form>
