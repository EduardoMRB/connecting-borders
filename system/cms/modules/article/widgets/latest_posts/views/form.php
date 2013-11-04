<ol>
        <li class="even">
		<label>Category</label>
		<?php echo form_dropdown('category', $categories_options, $options['category']); ?>
	</li>
	<li class="even">
		<label>Number to display</label>
		<?php echo form_input('limit', $options['limit']); ?>
	</li>
</ol>