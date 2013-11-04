<?php
	if(!$this->user_m->logged_in()){
		$this -> session -> set_flashdata('error', 'Usuário deve estar logado para acessar a página');
		redirect('');
	}
?>