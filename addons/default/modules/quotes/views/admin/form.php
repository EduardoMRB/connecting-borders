<section class="title">
	<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('quotes:create_title');?></h4>
	<?php else: ?>
	<h4><?php echo sprintf(lang('quotes:edit_title'), $quote->author);?></h4>
	<?php endif; ?>
</section>

<section class="item">

<?php echo form_open($this->uri->uri_string(), 'class="crud" id="periods"'); ?>
<?php if ($this->method == 'edit') echo form_hidden('period_id', $quote->id); ?>

<div class="form_inputs">

	<ul>
		<li class="even">
			<label for="pages"><?php echo lang('quotes:page_label'); ?></label>
			<div class="input"><?php echo form_dropdown('page', $pages_options, $quote->page_id); ?></div>
		</li>
		<li class="even">
			<label for="authors"><?php echo lang('quotes:author_label');?> <span>*</span></label>
			<div class="input"><?php echo  form_input('author', $quote->author); ?></div>
		</li>
		<li class="even editor">
			<label for="body"><?php echo lang('countries:countries_content_label'); ?></label>
				
			<div class="input">
				<?php echo form_dropdown('type', array(
					'html' => 'html',
					'markdown' => 'markdown',
					'wysiwyg-simple' => 'wysiwyg-simple',
					'wysiwyg-advanced' => 'wysiwyg-advanced',
				), $quote->type); ?>
			</div>
				
			<br style="clear:both"/>
				
			<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $quote->body, 'rows' => 30, 'class' => $quote->type)); ?>
				
		</li>
		<li>
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</li>
	</ul>
</div>
<?php echo form_close(); ?>
</section>
