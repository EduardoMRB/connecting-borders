<section class="item">

<?php if ($cities): ?>
    <table class="table-list">
		<thead>
			<tr>
				<th width="100%">ESCOLHA UMA CIDADE</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($cities as $city):?>
			<tr>
				<td>
					<?php echo anchor('schools/city/'.$city->id,  $city->name); ?></br>

				</td>
			</tr>
		<?php endforeach;?>
			<tr>
				<td>
					<?php echo $this->countries_m->get($country)->body ?>
				</td>
			</tr>
		</tbody>
    </table>

<?php endif;?>

</section>
