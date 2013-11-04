<?php

		$this->load->model('languages/languages_m');
		$this->load->model('countries/countries_m');
		$this->load->model('cities/cities_m');

		if ($this->input->get_post('submit') == 'Buscar'){
			$language = $this->input->post('language');
			$city = $this->input->post('city');
			$country = $this->input->post('country');
			if (($language > 0)&&($city == 0)&&($country == 0)){
				redirect('schools/languages/'.$language);
			}

			if (($city == 0)&&($country > 0)){
				redirect('schools/country/'.$country);
			}

			if ($city > 0){
				redirect('schools/city/'.$city);
			}
		}

		$languages = $this->languages_m->order_by('name')->get_all();
		foreach ($languages as $language)
		{
			$language_options[$language->id] = $language->name;
		}

		$countries = $this->countries_m->order_by('name')->get_all();
		foreach ($countries as $country)
		{
			$country_options[$country->id] = $country->name;
		}

		$cities = $this->cities_m->order_by('name')->get_all();
		foreach ($cities as $city)
		{
			$city_options[$city->id] = $city->name;
		}
	
?>
<?php echo form_open('');?>
<table>
	<thead>
		<tr>
			<th colspan="2" align="left"><?php echo 'Monte seu pacote:';?></th>
		</tr>
	</thead>
	<tbody>		
		<tr>
			<td id="select-box"><?php echo form_dropdown('language',array('Idioma') + $language_options) ?></td>
		</tr>
		<tr>
			<td id="select-box"><?php echo form_dropdown('country',array('País') + $country_options) ?></td>
		</tr>
		<tr>
			<td id="select-box"><?php echo form_dropdown('city',array('Cidade') + $city_options) ?></td>
		</tr>
		<tr>
			<td><?php echo form_submit('submit', 'Buscar'); ?></td>
		</tr>
	</tbody>
</table>
<?php echo form_close();?>
