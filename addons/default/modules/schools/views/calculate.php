<?php
	if(!$this->user_m->logged_in()){
		$this -> session -> set_flashdata('error', 'Usuário deve estar logado para acessar a página');
		redirect('');
	}
?>
<section class="item" id="secCalculate">
	<head>
		<script>
		$(document).ready(function(){
			$('#pdf-link, #email-link').click(function (){
					window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');
					return false;
			});
		});
		</script>
	</head>
    <?php echo form_open('schools/submit/'.$course->id .'/' . $period->id.'/'. ($accommodation ? $accommodation->id.'/'.$periodA->id : '0/0').'/'.$trans.'/'.$beginning['id'], 'id="formCalculate"');?>
    <table class="table-list estimate">
		<tbody>
			<tr>
				<td>
					<?php echo 'País:' ?></br>
				</td>
				<td style="color: #4f5251; font-weight: bold;">
					<?php $country = $this->countries_m->get($this->cities_m->get($school->city_id)->country_id); echo $country->name; ?></br>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo 'Cidade:' ?>
				</td>
				<td style="color: #4f5251; font-weight: bold;">
					<?php echo $this->cities_m->get($school->city_id)->name; ?></br>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo 'Escola:' ?>
				</td>
				<td style="color: #4f5251; font-weight: bold;">
					<?php echo $school->name; ?></br>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo 'Curso:' ?>
				</td>
				<td style="color: #4f5251; font-weight: bold;">
					<?php echo $course->name; ?></br>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo 'Idioma:' ?>
				</td>
				<td style="color: #4f5251; font-weight: bold;">
					<?php echo $this->languages_m->get($course->language_id)->name; ?></br>
				</td>
			</tr>
			<tr style="height: 25px">
				<td>
					<?php echo 'Carga horária:' ?>
				</td>
				<td style="color: #4f5251; font-weight: bold;">
					<?php echo $course->hourly_load; ?></br>
				</td>
			</tr>
		</tbody>
	</table>
	<div id="estimateHead">
		<?php echo 'Período do seu curso:' ?>
	</div>
	<table class="table-list estimate">
		<tbody>
			<tr>
				<td>
					<?php echo 'Data início:' ?>
				</td>
				<td>
					<?php echo $beginning['value']; ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo 'Período:' ?>
				</td>
				<td>
					<?php echo $period->name; ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo 'Preço:' ?>
				</td>
				<td>
					<?php echo $country->currency . ' ' . $period->price; ?></br>
				</td>
			</tr>
		</tbody>
	</table>
<?php if ($accommodation) : ?>
	<div id="estimateHead">
		<?php echo 'Acomodação' ?>
	</div>
	<table class="table-list estimate" id="accommodations_informations" >
		<tbody>
			
			<tr>
				<td>
					<?php echo 'Duração' ?>
				</td>
				<td>
					<?php echo $periodA->name; ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $accommodation->name; ?>
				</td>
				<td>
					<?php echo $accommodation->body; ?></br>
				</td>
				<td>
					<?php echo $country->currency . ' ' . $periodA->price; ?></br>
				</td>
			</tr>
<? endif; ?>
				<?php $total = ( $accommodation ? str_replace(",", ".",$periodA->price) : 0 )+str_replace(",", ".",$period->price) ;?>
		</tbody>
	</table>
	<div id="estimateHead">
		<?php echo 'Outras Taxas'; ?><br/>
	</div>
	<?php if($fares || ($transfer != 0)): ?>
	<table class="table-list estimate">
		<tbody>
			<?php if ($transfer != '0'): ?>
			<tr>
				<td>
					<?php echo 'Transfer'; ?>
				</td>
				<td>
					<?php echo $country->currency . ' ' .  $transfer; ?></br>
				</td>
			</tr>
			<?php $total += str_replace(",", ".",$transfer); ?>
			<?php endif; ?>
			<?php if($fares): ?>
				<?php foreach ($fares as $fare):?>
			<tr>
				<td>
				<?php echo $fare->name; ?>
				</td>
				<td>
					<?php echo $country->currency . ' ' . $fare->price; ?></br>
				</td>
					<?php $total = $total + str_replace(",", ".",$fare->price);?>
			</tr>
				<?php endforeach;?>
				<?php endif; ?>
		</tbody>
	</table>
	<br />
	<?php endif; ?>
    <div style="background-color: #574594; color : #FFFFFF; height: 30px; font-size: 16px; padding: 15px 0 0 20px;">Preço total: 
    <div style="font-size: 20px; font-weight: bold ;margin: 0 12px 0 0; float: right;"><?php echo $country->currency . ' ' .  str_replace('.',',',$total);?></div><br />
	</div>
    {{ user:profile }}
    <input type="hidden" value="{{ email }}" name="email" />
    <input type="hidden" value="{{ first_name }}" name="name" />
    {{ /user:profile }}
    <br />
    <div style="border-top: 1px solid #ccc; margin-bottom: 30px; height: 48px, margin-top : 40px;">
    <div style="width:100px; float: left;"><?php echo form_submit('submit', 'Enviar', 'class="button"'); ?></div>
    <div style="height: 25px;"></div>
    <div style="margin-top: -20px">
    <div style="width:90px; float:right; "><?php echo anchor('schools/email/'.$course->id .'/' .  $period->id.'/' . ( $accommodation ? $accommodation->id.'/'.$periodA->id : '0/0' ) .'/'.$trans.'/'.$beginning['id'] , '<img src="img/email.jpg" />', 'id="email-link"'); ?></div>
    <div style="width:100px; float:right; "><?php echo anchor('schools/pdf/'.$course->id .'/' . $period->id.'/'. ( $accommodation ? $accommodation->id.'/'.$periodA->id : '0/0' ) . '/'.$trans.'/'.$beginning['id'], '<img src="img/pdf.jpg" />', 'id="pdf-link"'); ?></div>
    <div style="width:100px; float:right;"><?php echo anchor('schools/pdf/'.$course->id .'/' . $period->id.'/'. ( $accommodation ? $accommodation->id.'/'.$periodA->id : '0/0' ). '/' .$trans.'/'.$beginning['id'], '<img src="img/imprimir.jpg" />', 'id="pdf-link"'); ?></div>
    </div>
    </div>
    <?php form_close();?>
</section>
