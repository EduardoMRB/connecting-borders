<?php
	if(!$this->user_m->logged_in()){
		$this -> session -> set_flashdata('error', 'Usuário deve estar logado para acessar a página');
		redirect('');
	}
?>
<?php
	$data['subject']			= $subject; // No translation needed as this is merely a fallback to Email Template subject
	$data['slug']				= 'viagem';
	$data['pais']				= $country->name;
	$data['cidade']				= $city->name;
	$data['tipo']				= $travel->name;
	$data['acomodacao']			= $accommodation->name;
	$data['data']				= $date;
	$data['to'] 				= 'contact@connecting-borders.com';
	$data['from'] 				= Settings::get('contact_email');
	$data['name']				= $user['name'];
	$data['reply-to']			= $user['email'];

// send the email using the template event found in system/cms/templates/
	$results = Events::trigger('email', $data, 'array');
// check for errors from the email event
	foreach ($results as $result)
	{
		if ( ! $result)
		{
			echo '<script>window.alert("Não foi possível enviar o email, tente novamente mais tarde.");</script>';
		}
	}

	$this->session->set_flashdata('success', 'Obrigado por fazer o orçamento, em breve entraremos em contato.');
	redirect('');


/*
$email_config = array('mailtype' => 'html', 'multipart' => 'related');
$this -> email -> initialize($email_config);
$this -> email -> from($user['email'], $user['name']);
$this -> email -> to($this -> settings -> item('contact_email'), $this -> settings -> item('site_name'));
$this -> email -> subject('Declaração de interesse para viagem');
$this -> email -> message($email_message);
if ($this -> email -> send()) {
	$this -> session -> set_flashdata('success', 'Obrigado por declarar interesse, em breve entraremos em contato.');
	redirect('');
} else {
	$this -> session -> set_flashdata('error', 'Ocorreu um erro ao enviar o e-mail, tente novamente.');
	redirect('cities/estimate/' . $city -> id . '/' . $travel->id . '/' . $accommodation -> id);
}
?>
