<?php if ($this->method == 'edit'): ?>
	<section class="title">
    	<h4><?php echo sprintf(lang('cities:edit_title'), $city->name); ?></h4>
	</section>
<?php else: ?>
	<section class="title">
    	<h4><?php echo lang('cities:add_title'); ?></h4>
	</section>
<?php endif; ?>

<section class="item">


<?php echo form_open_multipart(uri_string(), 'class="crud"'); ?>
<?php if ($this->method == 'edit') echo form_hidden('city_id', $city->id); ?>
<div class="tabs">

	<ul class="tab-menu">
		<li><a href="#cities-content-tab"><span><?php echo lang('cities:city'); ?></span></a></li>
		<li><a href="#cities-accommodation-tab"><span><?php echo lang('cities:accommodations'); ?></span></a></li>

	</ul>

	<div class="form_inputs" id="cities-content-tab">
	<fieldset>
    <ul>
		<li>
			<label for="userfile" ><?php echo lang('cities:upload'); ?>:</label>
			<input type="file" name="userfile" class="input" />
		</li>
		<li>
			<label for="name"><?php echo lang('cities:name');?> <span>*</span></label>
			<div class="input"><?php echo form_input('name', $city->name);?></div>
		</li>

		<li>
			<label for="country_id"><?php echo lang('cities:country'); ?> <span>*</span></label>
			<div class="input">
			<?php echo form_dropdown('country_id',array(lang('cities:select-option')) + $country_options, $city->country_id) ?>
			</div>
		</li>
		<li class="<?php echo alternator('even', ''); ?>">
			<label for="travelings[]"><?php echo lang('cities:travel_label'); ?> <span>*</span></label>
			<div class="input">
				<?php echo form_multiselect('travelings[]', $travel_options, $city -> travelings); ?>
			</div>
		</li>
		<li class="even editor">
			<label for="body"><?php echo lang('cities:content_label'); ?></label>
				
			<div class="input">
				<?php echo form_dropdown('type', array(
					'html' => 'html',
					'markdown' => 'markdown',
					'wysiwyg-simple' => 'wysiwyg-simple',
					'wysiwyg-advanced' => 'wysiwyg-advanced',
				), $city->type); ?>
			</div>
				
			<br style="clear:both"/>
				
			<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $city->body, 'rows' => 30, 'class' => $city->type)); ?>
				
		</li>
    </ul>
    </fieldset>
	</div>
	<div class="form_inputs" id="cities-accommodation-tab">
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
