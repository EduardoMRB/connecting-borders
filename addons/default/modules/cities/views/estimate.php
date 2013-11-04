<section class="item" id="secEstimate">
	<head>
		<script>
			$(document).ready(function(){
				$('#pdf-link, #email-link').click(function (){
					window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');
					return false;
				});
				$('#data').datepicker({
					dateFormat : "d-m-y",
				});
			});

		</script>
		<style>
			table#estimate {width: 100%;}
			table#estimate td {width: 33%;}
		</style>
	</head>
	<div style="border-bottom: 2px dotted black; margin-bottom: 30px; height: 48px">
    <div style="font-size: 32px; font-weight: bold;">Or&ccedil;amento</div>
    <div style="margin-top: -20px">
   <!-- <div style="width:130px; float:right; "><?php echo anchor('tourisms/email', '<img src="img/email.jpg" />', 'id="email-link"'); ?></div>
    <div style="width:130px; float:right; "><?php echo anchor('tourisms/pdf', '<img src="img/pdf.jpg" />', 'id="pdf-link"'); ?></div>
    <div style="width:130px; float:right;"><?php echo anchor('tourisms/pdf', '<img src="img/imprimir.jpg" />', 'id="pdf-link"'); ?></div> -->
    </div>
    </div>
    <div style="clear:both"></div>
    <?php echo form_open('cities/submit/'.$city->id.'/'.$travel->id . '/' . $accommodation -> id, 'id="formEstimate"');?>
    <table class="table-list estimate">
		<tbody>
			<tr>
				<td>
					<?php echo 'Pa&iacute;s:' ?></br>
				</td>				
				<td style="color: #4f5251; font-weight: bold;">
					<?php echo $this->countries_m->get($city->country_id)->name; ?>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>
					<?php echo 'Cidade:' ?>
				</td>				
				<td style="color: #4f5251; font-weight: bold;">
					<?php echo $city->name; ?>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>
					<?php echo 'Tipo de viagem:' ?>
				</td>
				<td style="color: #4f5251; font-weight: bold;">
					<?php echo $travel->name; ?>
				</td>
				<td></td>
			</tr>
			<tr style="height: 25px">
				<td>
					<?php echo 'Data:' ?>
				</td>				
				<td>
					<input type="text" id="data" name="data" value="<?php echo date('d-m-Y'); ?>" />
				</td>
				<td></td>
			</tr>
			<tr>
				<td>
					<?php echo 'Acomodações:' ?>
				</td>
			</tr>
			<tr>
				<td><?php echo $accommodation->name; ?></td>
				<td style="color: #4f5251; ">
					<?php echo $accommodation->body; ?>
				</td>
			</tr>
			<tr>
				{{ user:profile }}
				<td>
					<input type="hidden" value="{{ email }}" name="email" />
				</td>
				<td>
    				<input type="hidden" value="{{ first_name }}" name="name" />
				</td>
				 {{ /user:profile }}
			</tr>
	</tbody>
    </table></br>
    <div style="width:160px; float:left;"><?php echo anchor('cities/informations/'.$city->id.'/'. $travel->id . '/' .$accommodation->id, 'Voltar', 'class="button"'); ?></div>
    <div style="width:160px; float:right;"><?php echo form_submit('submit', 'Declarar Interesse', 'class="button" id="submit"'); ?></div>
    <?php form_close();?>  
</section>
