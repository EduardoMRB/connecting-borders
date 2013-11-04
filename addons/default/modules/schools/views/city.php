<section class="item">

<?php if ($schools): ?>
    <table class="table-list">
		<thead>
			<tr>
				<th width="100%">ESCOLHA UMA ESCOLA</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($schools as $school):?>
			<tr>
				<td>
					<?php echo anchor('schools/course/'.$school->id,  $school->name); ?></br>
				</td>
			</tr>
		<?php endforeach;?>
			<tr>
				<td>
					<?php echo $this->cities_m->get($city)->body ?>
				</td>
			</tr>
		</tbody>
    </table>

<?php endif;?>

</section>
