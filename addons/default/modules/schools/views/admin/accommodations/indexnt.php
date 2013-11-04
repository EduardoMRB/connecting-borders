<?php if (@$accommodations): ?>
    <table class="table-list">
		<thead>
			<tr>
				<th width="27%"><?php echo lang('accommodations:name');?></th>
				<th width="500"><?php echo lang('accommodations:content');?></th>
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
		<?php foreach ($accommodations as $accommodation):?>
			<tr>
				<td><?php echo $accommodation->name; ?></td>
				<td><?php echo $accommodation->body; ?></td>
				<td class="actions">
				<?php echo anchor('admin/schools/accommodations/edit/'.$accommodation->id, lang('global:edit'), 'class="button edit"'); ?>
				<?php if ( ! in_array($accommodation->name, array('user', 'admin'))): ?>
					<?php echo anchor('admin/schools/accommodations/delete/'.$accommodation->id, lang('global:delete'), 'class="confirm button delete"'); ?>
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php else: ?>
	<div class="no_data"><?php echo lang('accommodations:no_accommodations');?></div>
<?php endif;?>
