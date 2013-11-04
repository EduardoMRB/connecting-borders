<section class="title">
	<h4><?php echo $module_details['name']; ?></h4>
</section>

<section class="item">

<?php if ($cities): ?>
    <table class="table-list">
		<thead>
			<tr>
				<th></th>
				<th width="20%"><?php echo lang('cities:name');?></th>
				<th width="200"><?php echo lang('cities:country');?></th>
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
		<?php foreach ($cities as $city):?>
			<tr>
				<td><?php echo "<img src='$city->relative' width='80px' height='80px'></img>"; ?></td>
				<td><?php echo $city->name; ?></td>
				<td><?php echo $this->countries_m->get($city->country_id)->name; ?></td>
				<td class="actions">
				<?php echo anchor('admin/cities/edit/'.$city->id, lang('global:edit'), 'class="button edit"'); ?>
				<?php if ( ! in_array($city->name, array('user', 'admin'))): ?>
					<?php echo anchor('admin/cities/delete/'.$city->id, lang('global:delete'), 'class="confirm button delete"'); ?>
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php else: ?>
	<div class="no_data"><?php echo lang('cities:no_cities');?></div>
<?php endif;?>

</section>
