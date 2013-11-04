<section class="title">
	<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('languages:create_title');?></h4>
	<?php else: ?>
	<h4><?php echo sprintf(lang('languages:edit_title'), $language->name);?></h4>
	<?php endif; ?>
</section>

<section class="item">

<?php echo form_open($this->uri->uri_string(), 'class="crud" id="languages"'); ?>
<?php if ($this->method == 'edit') echo form_hidden('language_id', $language->id); ?>

<div class="form_inputs">

	<ul>
		<li class="even">
			<label for="name"><?php echo lang('languages:name_label');?> <span>*</span></label>
			<div class="input"><?php echo  form_input('name', $language->name); ?></div>
		</li>
		
	</ul>
		
	<div>
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>

</div>

<?php echo form_close(); ?>
</section>
