<section class="item">

<?php if ($courses): ?>
    <table class="table-list">
		<thead>
			<tr>
				<th width="100%">ESCOLHA UM CURSO</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($courses as $course):?>
			<tr>
				<td>
					<?php echo anchor('schools/level/'.$course->id,  $course->name); ?></br>
				</td>
			</tr>
		<?php endforeach;?>
			<tr>
				<td>
					<?php echo $this->schools_m->get($school)->body ?>
				</td>
			</tr>
		</tbody>
    </table>

<?php endif;?>

</section>
