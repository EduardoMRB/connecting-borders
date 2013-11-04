<section class="title">
	<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('traveling:create_title');?></h4>
	<?php else: ?>
	<h4><?php echo sprintf(lang('traveling:edit_title'), $travel->name);?></h4>
	<?php endif; ?>
</section>

<section class="item">

<?php echo form_open($this->uri->uri_string(), 'class="crud" id="traveling"'); ?>
<?php if ($this->method == 'edit') echo form_hidden('travel_id', $travel->id); ?>

<div class="form_inputs">

	<ul>
		<li class="even">
			<label for="name"><?php echo lang('traveling:name_label');?> <span>*</span></label>
			<div class="input"><?php echo  form_input('name', $travel->name); ?></div>
		</li>
		
	</ul>
		
	<div>
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>

</div>

<?php echo form_close(); ?>
</section>
