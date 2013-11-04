<section class="title">
	<h4><?php echo $module_details['name']; ?></h4>
</section>

<section class="item">
<?php if ($languages): ?>

	<?php echo form_open('admin/languages/delete'); ?>
		<table border="0" class="table-list">
			<thead>
			<tr>
				<th width="30"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th width="20%"><?php echo lang('languages:name_label');?></th>
				<th width="140"></th>
				<th width="140"></th>
			</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="5">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($languages as $language): ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $language->id); ?></td>
					<td><?php echo $language->name;?></td>
					<td class="collapse"></td>
					<td class="actions">
						<?php echo anchor('admin/languages/edit/' . $language->id, lang('buttons.edit'), 'class="button edit"'); ?>
						<?php echo anchor('admin/languages/delete/' . $language->id, lang('buttons.delete'), array('class'=>'confirm button delete')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="table_action_buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		</div>
	<?php echo form_close(); ?>

<?php else: ?>
		<div class="no_data"><?php echo lang('languages:no_languages');?></div>
<?php endif; ?>
</section>
