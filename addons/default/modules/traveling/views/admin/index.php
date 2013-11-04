<section class="title">
	<h4><?php echo $module_details['name']; ?></h4>
</section>

<section class="item">
<?php if ($traveling): ?>

	<?php echo form_open('admin/traveling/delete'); ?>
		<table border="0" class="table-list">
			<thead>
			<tr>
				<th width="30"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th width="20%"><?php echo lang('traveling:name_label');?></th>
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
				<?php foreach ($traveling as $travel): ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $travel->id); ?></td>
					<td><?php echo $travel->name;?></td>
					<td class="collapse"></td>
					<td class="actions">
						<?php echo anchor('admin/traveling/edit/' . $travel->id, lang('buttons.edit'), 'class="button edit"'); ?>
						<?php echo anchor('admin/traveling/delete/' . $travel->id, lang('buttons.delete'), array('class'=>'confirm button delete')); ?>
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
		<div class="no_data"><?php echo lang('traveling:no_traveling');?></div>
<?php endif; ?>
</section>
