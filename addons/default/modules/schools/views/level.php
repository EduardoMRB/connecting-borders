<section class="item">
<?php if ($course): ?>
    <table class="table-list">
		<thead>
			<tr>
				<th width="100%">Escolha, abaixo, o seu nível de idioma e clique no botão GERAR ORÇAMENTO</th>
			</tr>
			<?php echo form_open('schools/estimate/');?>
			<tr>
				<th><?php echo form_dropdown('level', explode(',',$course->levels))  ?></th>
				<th><?php echo form_submit('submit', 'Gerar Orçamento'); ?></th>
				<?php echo form_hidden('course_id', $course->id);?> 
			</tr>
			<?php echo form_close();?>
		</thead>
		<tbody>
			<tr>
				<td>
					<?php echo $course->name; ?></br>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $course->body ?>
				</td>
			</tr>
		</tbody>
    </table>
<?php endif;?>
</section>
