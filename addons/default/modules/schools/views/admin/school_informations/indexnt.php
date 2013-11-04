<?php 
	if (@$informations): ?>
    <table class="table-list">
		<thead>
			<tr>
				<th width="25%"><?php echo lang('school_informations:name');?></th>
				<th width="150"><?php echo lang('school_informations:body');?></th>
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
		<?php foreach ($informations as $information):?>
			<tr>
				<td><?php echo $information->name; ?></td>
				<td><?php echo $information->body; ?></td>
				<td class="actions">
				<?php echo anchor('admin/schools/school_informations/edit/'.$information->id, lang('global:edit'), 'class="button edit"'); ?>
				<?php if ( ! in_array($information->name, array('user', 'admin'))): ?>
					<?php echo anchor('admin/schools/school_informations/delete/'.$information->id, lang('global:delete'), 'class="confirm button delete"'); ?>
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php else: ?>
	<div class="no_data"><?php echo lang('school_informations:no_informations');?></div>
<?php endif;?>
