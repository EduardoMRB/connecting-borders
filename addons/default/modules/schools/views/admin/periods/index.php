<?php if (@$periods): ?>
    <table class="table-list">
		<thead>
			<tr>
				<th width="25%"><?php echo lang('schools:period');?></th>
				<th width="100"><?php echo lang('schools:price');?></th>
				<?php if($parent != 'accommodations'): ?><th width="100"><?php echo lang('schools:year'); ?></th> <?php endif;?>
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
		<?php foreach ($periods as $period):?>
			<tr>
				<td><?php echo $period->name; ?></td>
				<td><?php echo $period->price; ?></td>
				<?php if($parent != 'accommodations'): ?><td><?php echo $period->year; ?></td> <?php endif;?>
				<td class="actions">
				<?php echo anchor('admin/schools/periods/edit/'.$period->id, lang('global:edit'), 'class="button edit"'); ?>
				<?php if ( ! in_array($period->name, array('user', 'admin'))): ?>
					<?php echo anchor('admin/schools/periods/delete/'.$period->id.'/courses/'.$period->parent_id, lang('global:delete'), 'class="confirm button delete"'); ?>
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php else: ?>
	<div class="no_data"><?php echo lang('schools:no_periods');?></div>
<?php endif;?>
