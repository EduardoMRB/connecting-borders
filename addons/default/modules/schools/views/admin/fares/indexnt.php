<?php if (@$fares): ?>
    <table class="table-list">
		<thead>
			<tr>
				<th width="25%"><?php echo lang('fares:name');?></th>
				<th width="150"><?php echo lang('fares:price');?></th>
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
		<?php foreach ($fares as $fare):?>
			<tr>
				<td><?php echo $fare->name; ?></td>
				<td><?php echo $fare->price; ?></td>
				<td class="actions">
				<?php echo anchor('admin/schools/fares/edit/'.$fare->id, lang('global:edit'), 'class="button edit"'); ?>
				<?php if ( ! in_array($fare->name, array('user', 'admin'))): ?>
					<?php echo anchor('admin/schools/fares/delete/'.$fare->id, lang('global:delete'), 'class="confirm button delete"'); ?>
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php else: ?>
	<div class="no_data"><?php echo lang('fares:no_fares');?></div>
<?php endif;?>
