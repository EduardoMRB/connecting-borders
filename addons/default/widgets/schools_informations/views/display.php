<img src="img/informacoes.png" style="float: left; margin-left: -4px;" />
<?php if($school->informations):?>
	<table class="informations">
		<tr>
			<td id="name_information"><?php echo "Cidade: "; ?> </td>
			<td id="information"><?php echo $school->city->name; ?></td>
		</tr>
		<?php foreach ($school->informations as $information) : ?>
			<tr>
				<td id="name_information"><?php echo $information->name . ':'; ?></td>
				<td id="information"><?php echo $information->body; ?></td>
			</tr>
		<?php endforeach;?>
	</table>
<?php else:?>
	<table class="informations">
		<tr>
			<td id="name_information"><?php echo "Cidade"; ?> </td>
			<td id="information"><?php echo $school->city->name; ?></td>
		</tr>
	</table>
<?php endif; ?>