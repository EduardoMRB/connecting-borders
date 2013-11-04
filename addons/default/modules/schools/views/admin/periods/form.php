<section class="title">
	<?php if ($this->controller == 'admin_periods' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('periods:edit_title'), $period->name);?></h4>
	<?php else: ?>
	<h4><?php echo lang('periods:create_title');?></h4>
	<?php endif; ?>
</section>

<section class="item">
<?php echo form_open($this->uri->uri_string(), 'class="crud" id="periods"'); ?>

<div class="form_inputs">

	<ul>
		<li>
			<label for="name"><?php echo lang('periods:period');?> <span>*</span></label>
			<div class="input"><?php echo  form_input('name', $period->name); ?></div>
		</li>
		<li>
			<label for="price"><?php echo lang('periods:price');?></label>
			<div class="input"><?php echo  form_input('price', @$period->price); ?></div>
		</li>
<?php if($parent != 'accommodations'): ?>
		<li>
			<label for="year"><?php echo lang('periods:year'); ?></label>
			<div class="input"><?php echo form_input('year', $period->year); ?></div>
		</li>
<?php endif; ?>
	</ul>
	
</div>

	<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?></div>

<?php echo form_close(); ?>
</section>
	