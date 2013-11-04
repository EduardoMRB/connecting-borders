<section class="title">
	<?php if ($this->controller == 'admin_accommodations' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('accommodations:edit_title'), $accommodation->name);?></h4>
	<?php else: ?>
	<h4><?php echo lang('accommodations:add_title');?></h4>
	<?php endif; ?>
</section>

<section class="item">
<?php echo form_open($this->uri->uri_string(), 'class="crud" id="accommodations"'); ?>


	<div class="form_inputs" id="accommodations-content-tab">
	<fieldset>
	<ul>
		<li>
			<label for="name"><?php echo lang('accommodations:name');?> <span>*</span></label>
			<div class="input"><?php echo  form_input('name', $accommodation->name); ?></div>
		</li>

		<li class="even editor">
			<label for="body"><?php echo lang('accommodations:content'); ?></label>
				
			<br style="clear:both"/>
				
			<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => @$accommodation->body, 'rows' => 30, 'class' => 'wysiwyg-simple')); ?>
				
		</li>
	</ul>
	</fieldset>
	</div>
	

	<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?></div>

<?php echo form_close(); ?>
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
