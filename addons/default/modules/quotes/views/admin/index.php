<section class="title">
	<h4><?php echo $module_details['name']; ?></h4>
</section>

<section class="item">
<?php if ($quotes): ?>

	<?php echo form_open('admin/quotes/delete'); ?>
		<table border="0" class="table-list">
			<thead>
			<tr>
				<th width="30"><?php echo form_checkbox(array('authors' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th width="20%"><?php echo lang('quotes:author_label');?></th>
				<th width="20%"><?php echo lang('quotes:page_label'); ?></th>
				<th width="58%"></th>
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
				<?php foreach ($quotes as $quote):
				$page = $this->page_m->get($quote->page_id);
				 ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $quote->id); ?></td>
					<td><?php echo $quote->author;?></td>
					<td><?php echo (($quote->page_id == 0) ? 'Sidebar' : $page['title']); ?></td>
					
					<td class="actions">
						<?php echo anchor('admin/quotes/edit/' . $quote->id, lang('buttons.edit'), 'class="button edit"'); ?>
						<?php echo anchor('admin/quotes/delete/' . $quote->id, lang('buttons.delete'), array('class'=>'confirm button delete')); ?>
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
		<div class="no_data"><?php echo lang('quotes:no_quotes');?></div>
<?php endif; ?>
</section>
