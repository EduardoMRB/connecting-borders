<section class="title">
	<h4><?php echo $module_details['name']; ?></h4>
</section>

<section class="item">

<?php if ($schools): ?>
    <table class="table-list">
		<thead>
			<tr>
				<th></th>
				<th width="22%"><?php echo lang('schools:name');?></th>
				<th width="180"><?php echo lang('schools:city');?></th>
				<th width="180"><?php echo lang('schools:courses');?></th>
				<th width="100"><?php echo lang('schools:accommodations');?></th>
				<th width="100"><?php echo lang('schools:fares');?></th>
				<th></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($schools as $school):?>
			<tr>
        		        <td><?php echo "<img src='$school->relative' width='80px' height='80px'></img>"; ?></td>
				<td><?php echo $school->name; ?></td>
				<td><?php echo @$this->cities_m->get($school->city_id)->name; ?></td>
				<td><?php echo count($this->courses_m->get_schools($school->id)); ?></td>
				<td><?php echo count($this->accommodations_m->get_schools($school->id)); ?></td>
				<td><?php echo count($this->fares_m->get_schools($school->id)); ?></td>
				<td class="actions">
				<?php echo anchor('admin/schools/edit/'.$school->id, lang('global:edit'), 'class="button edit"'); ?>
				<?php if ( ! in_array($school->name, array('user', 'admin'))): ?>
					<?php echo anchor('admin/schools/delete/'.$school->id, lang('global:delete'), 'class="confirm button delete"'); ?>
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php else: ?>
	<div class="no_data"><?php echo lang('schools:no_schools');?></div>
<?php endif;?>

</section>
