<?php if (@$courses): ?>
    <table class="table-list">
		<thead>
			<tr>
				<th width="25%"><?php echo lang('courses:name');?></th>
				<th width="150"><?php echo lang('courses:language');?></th>
				<th width="150"><?php echo lang('courses:beginning');?></th>
				<th width="150"><?php echo lang('courses:hourly_load');?></th>
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
		<?php foreach ($courses as $course):?>
			<tr>
				<?php $dates = explode(',',$course->beginning);?>
				<td><?php echo $course->name; ?></td>
				<td><?php echo $this->languages_m->get($course->language_id)->name; ?></td>
				<td><?php echo  $dates[0] . ' à ' . $dates[sizeof($dates)-1]; ?></td>
				<td><?php echo $course->hourly_load; ?></td>
				<td class="actions">
				<?php echo anchor('admin/schools/courses/edit/'.$course->id, lang('global:edit'), 'class="button edit"'); ?>
				<?php if ( ! in_array($course->name, array('user', 'admin'))): ?>
					<?php echo anchor('admin/schools/courses/delete/'.$course->id, lang('global:delete'), 'class="confirm button delete"'); ?>
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php else: ?>
	<div class="no_data"><?php echo lang('courses:no_courses');?></div>
<?php endif;?>
