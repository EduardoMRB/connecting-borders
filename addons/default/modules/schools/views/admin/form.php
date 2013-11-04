<?php if ($this->method == 'edit'): ?>
	<section class="title">
    	<h4><?php echo sprintf(lang('schools:edit_title'), $school->name); ?></h4>
	</section>
<?php else: ?>
	<section class="title">
    	<h4><?php echo lang('schools:add_title'); ?></h4>
	</section>
<?php endif; ?>

<section class="item">

<?php echo form_open_multipart(uri_string(), 'class="crud"'); ?>
<?php if ($this->method == 'edit') echo form_hidden('school_id', $school->id); 
?>
<div class="tabs">

	<ul class="tab-menu">
		<li><a href="#schools-content-tab"><span><?php echo lang('schools:school'); ?></span></a></li>
		<li><a href="#schools-transfers-tab"><span><?php echo lang('schools:transfers'); ?></span></a></li>
		<li><a href="#schools-fares-tab"><span><?php echo lang('schools:fares'); ?></span></a></li>
		<li><a href="#schools-courses-tab"><span><?php echo lang('schools:courses'); ?></span></a></li>
		<li><a href="#schools-accommodation-tab"><span><?php echo lang('schools:accommodations'); ?></span></a></li>
		<li><a href="#schools-school_informations-tab"><span><?php echo lang('schools:school_informations'); ?></span></a></li>

	</ul>
	<div class="form_inputs" id="schools-content-tab">
	<fieldset>
	    <ul>
			<li>
				<label for="userfile" ><?php echo lang('schools:upload'); ?>:</label>
				<input type="file" name="userfile" class="input" />
			</li>
			<li>
				<label for="name"><?php echo lang('schools:name');?> <span>*</span></label>
				<div class="input"><?php echo form_input('name', $school->name);?></div>
			</li>

			<li>
				<label for="city_id"><?php echo lang('schools:city'); ?> <span>*</span></label>
				<div class="input">
				<?php echo form_dropdown('city_id',array(lang('schools:select-option')) + $city_options, $school->city_id) ?>
				</div>
			</li>
			<li>
				<label for="street"><?php echo lang('schools:street');?></label>
				<div class="input"><?php echo form_input('street', @$school->street);?></div>
			</li>
			<li>
				<label for="number"><?php echo lang('schools:number');?></label>
				<div class="input"><?php echo form_input('number', @$school->number);?></div>
			</li>
			<li>
				<label for="cep"><?php echo lang('schools:cep');?></label>
				<div class="input"><?php echo form_input('cep', @$school->cep);?></div>
			</li>
			
			<li class="even editor">
				<label for="body"><?php echo lang('schools:content_label'); ?></label>
				
				<div class="input">
					<?php echo form_dropdown('type', array(
						'html' => 'html',
						'markdown' => 'markdown',
						'wysiwyg-simple' => 'wysiwyg-simple',
						'wysiwyg-advanced' => 'wysiwyg-advanced',
					), $school->type); ?>
				</div>
				
				<br style="clear:both"/>
				
				<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $school->body, 'rows' => 30, 'class' => $school->type)); ?>
				
			</li>
	    </ul>
	</fieldset>
	</div>
	<div class="form_inputs" id="schools-transfers-tab">
	<fieldset>
	    <ul>
			<li>
				<label for="transferc"><?php echo lang('schools:transferc');?></label>
				<div class="input"><?php echo form_input('transferc', @$school->transferc);?></div>
			</li>

			<li>
				<label for="transfercp"><?php echo lang('schools:transfercp');?></label>
				<div class="input"><?php echo form_input('transfercp', @$school->transfercp);?></div>
			</li>

	    </ul>
	</fieldset>
	</div>
	<div class="form_inputs" id="schools-fares-tab">
	<fieldset>
		<ul>
			<li>
			<?php 
				echo $this->load->view('admin/fares/indexnt');
				echo form_submit('fares', lang('schools:add_fare'));
			?>
			</li>
		</ul>
	</fieldset>
	</div>
	<div class="form_inputs" id="schools-courses-tab">
	<fieldset>
		<ul>
			<li>
			<?php 
				echo $this->load->view('admin/courses/indexnt');
				echo form_submit('courses', lang('schools:add_course'));
			?>
			</li>
		</ul>
	</fieldset>
	</div>
	<div class="form_inputs" id="schools-accommodation-tab">
	<fieldset>
		<ul>
			<li>
			<?php
				echo $this->load->view('admin/accommodations/indexnt');
				echo form_submit('accommodations', lang('accommodations:add_accommodation'));
			?>
			</li>
		</ul>
	</fieldset>
	</div>
	<div class="form_inputs" id="schools-school_informations-tab">
	<fieldset>
		<ul>
			<li>
			<?php
				echo $this->load->view('admin/school_informations/indexnt');
				echo form_submit('school_informations', lang('school_informations:add_information'));
			?>
			</li>
		</ul>
	</fieldset>
	</div>
</div>
	<div class="buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>	
	
<?php echo form_close();?>


</section>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
(function($) {
	$(function(){
		// editor switcher
		$('select[name^=type]').live('change', function() {
			chunk = $(this).closest('li.editor');
			textarea = $('textarea', chunk);
			
			// Destroy existing WYSIWYG instance
			if (textarea.hasClass('wysiwyg-simple') || textarea.hasClass('wysiwyg-advanced')) 
			{
				textarea.removeClass('wysiwyg-simple');
				textarea.removeClass('wysiwyg-advanced');
					
				var instance = CKEDITOR.instances[textarea.attr('id')];
			    instance && instance.destroy();
			}
			
			
			// Set up the new instance
			textarea.addClass(this.value);
			
			pyro.init_ckeditor();
			
		});
	});
})(jQuery);
</SCRIPT>
