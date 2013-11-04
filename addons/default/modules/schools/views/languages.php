<section class="item">

<?php if ($courses): ?>
    <table class="table-list">
		<tbody>
		<?php foreach ($courses as $course):?>
			<tr>
				<td>
					<?php echo anchor('schools/level/'.$course->id,  $course->name); ?></br>
					<?php echo $this->cities_m->get($this->schools_m->get($course->school_id)->city_id)->name; ?> -
					
					<?php echo $this->countries_m->get($this->cities_m->get($this->schools_m->get($course->school_id)->city_id)->id)->name; ?> </br>
					<?php echo $course->intro; ?></br>
					<?php echo anchor('schools/level/'.$course->id,  'Saiba Mais...'); ?></br>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php endif;?>

</section>
