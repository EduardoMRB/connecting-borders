<?php echo form_open($this->uri->uri_string(), 'class="crud" id="traveling"'); ?>
<td><?php echo form_checkbox('action_to[]', $travel->id); ?></td>
    <td>
        <?php echo form_input('name', $travel->name, "id=\"name_{$travel->id}\""); ?>
    </td>
    <td>
        <?php echo form_hidden('travel_id', $travel->id); ?>
    </td>
    <td class="align-center buttons buttons-small actions">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
    </td>
<?php echo form_close(); ?>
