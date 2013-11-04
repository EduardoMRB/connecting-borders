<section class="title">
	<?php if ($this->controller == 'admin_courses' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('school_informations:edit_title'), $course->name);?></h4>
	<?php else: ?>
	<h4><?php echo lang('school_informations:create_title');?></h4>
	<?php endif; ?>
</section>

<section class="item">
<?php echo form_open($this->uri->uri_string(), 'class="crud" id="fares"'); ?>

<div class="form_inputs">

	<ul>
		<li>
			<label for="name"><?php echo lang('school_informations:name');?> <span>*</span></label>
			<div class="input"><?php echo  form_input('name', $information->name); ?></div>
		</li>
		<li>
			<label for="body"><?php echo lang('school_informations:body');?></label>
			<div class="input"><?php echo  form_input('body', @$information->body); ?></div>
		</li>
	</ul>
	
</div>

	<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?></div>

<?php echo form_close(); ?>
</section>
