<section class="title">
	<h4><?php echo $module_details['name']; ?></h4>
</section>

<section class="item">

<?php if ($countries): ?>
    <table class="table-list">
		<thead>
			<tr>
				<th></th>
				<th width="20%"><?php echo lang('countries:name');?></th>
				<th width="20%"><?php echo lang('countries:currency'); ?></th>
				<th width="200"><?php echo lang('countries:languages_label');?></th>
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
		<?php foreach ($countries as $country):?>
			<tr>
               	<td><?php echo "<img src='$country->relative' width='80px' height='80px'></img>"; ?></td>
				<td><?php echo $country->name; ?></td>
				<td><?php echo $country->currency; ?></td>
				<td><?php echo implode(', ', Languages::get_string($country->languages)); ?></td>
				<td class="actions">
				<?php echo anchor('admin/countries/edit/'.$country->id, lang('global:edit'), 'class="button edit"'); ?>
				<?php if ( ! in_array($country->name, array('user', 'admin'))): ?>
					<?php echo anchor('admin/countries/delete/'.$country->id, lang('global:delete'), 'class="confirm button delete"'); ?>
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php else: ?>
	<div class="no_data"><?php echo lang('countries:no_countries');?></div>
<?php endif;?>

</section>
