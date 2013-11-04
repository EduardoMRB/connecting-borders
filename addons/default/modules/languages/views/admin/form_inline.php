<?php echo form_open($this->uri->uri_string(), 'class="crud" id="languages"'); ?>
<td><?php echo form_checkbox('action_to[]', $language->id); ?></td>
    <td>
        <?php echo form_input('name', $language->name, "id=\"name_{$language->id}\""); ?>
    </td>
    <td>
        <?php echo form_hidden('language_id', $language->id); ?>
    </td>
    <td class="align-center buttons buttons-small actions">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
    </td>
<?php echo form_close(); ?>
