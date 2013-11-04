<section class="title">
	<h4><?php echo lang('school_informations:school_informations'); ?></h4>
</section>

	<section class="item">
	<?php if (@$informations): ?>
	    <table class="table-list">
			<thead>
				<tr>
					<th width="18%"><?php echo lang('school_information:name');?></th>
					<th width="200"><?php echo lang('school_information:school');?></th>
					<th width="100"><?php echo lang('school_information:body');?></th>
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
					<td><?php echo $this->schools_m->get($information->school_id)->name; ?></td>
					<td><?php echo $information->body; ?></td>
					<td class="actions">
					<?php echo anchor('admin/schools/school_informations/edit/'. $information->id, lang('global:edit'), 'class="button edit"'); ?>
					<?php if ( ! in_array($information->name, array('user', 'admin'))): ?>
						<?php echo anchor('admin/schools/school_informations/delete/'.$information->id, lang('global:delete'), 'class="confirm button delete"'); ?>
					<?php endif; ?>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
	    </table>

	<?php else: ?>
		<div class="no_data"><?php echo lang('school_information:no_information');?></div>
	<?php endif;?>
</section>
