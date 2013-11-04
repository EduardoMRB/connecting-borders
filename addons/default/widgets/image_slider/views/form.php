<ol>
    <li class="even">
        <label>Folder</label>
        <?php echo form_dropdown('folder_id', $folder_list, $options['folder_id']); ?>
    </li>
    <li>
        <label>Auto Slide</label>
        <?php echo form_dropdown('auto_slide', array('yes' => 'Yes', 'no' => 'No'), $options['auto_slide']) ?>
    </li>
    <li class="even">
        <label>Navigation</label>
        <?php echo form_dropdown('navigation', array('pagination' => 'Pagination', 'next/prev' => 'Next and Prev'), $options['navigation']) ?>
    </li>
    <li>
        <label>Description</label>
        <?php echo form_dropdown('description', array('yes' => 'Yes', 'no' => 'No'), $options['description']) ?>
    </li>
	<li class="even">
        <label>Css Id</label>
        <?php echo form_input('id', $options['id']); ?>
    </li>
	<li>
		<b>Atention</b> - <span>slides.jquery.js</span> is required on template js jolder
	</li>
</ol>