<section class="title">
    <?php if ($this->controller == 'admin_movies' && $this->method === 'edit'): ?>
        <h4><?php echo sprintf(lang('mov_edit_title'), $movie->title); ?></h4>
    <?php else: ?>
        <h4><?php echo lang('mov_create_title'); ?></h4>
    <?php endif; ?>
</section>

<section class="item">
    <?php echo form_open($this->uri->uri_string(), 'class="crud" id="movies"'); ?>

    <div class="form_inputs">

        <ul>
            <li class="even">
                <label for="title"><?php echo lang('mov_title_label'); ?> <span>*</span></label>
                <div class="input"><?php echo form_input('title', $movie->title); ?></div>
            </li>
            <li >
                <label for="link"><?php echo lang('mov_link_label'); ?> <span>*</span></label>
                <div class="input"><?php echo form_input('link', $movie->link); ?></div>
            </li>
        </ul>

    </div>

    <div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?></div>

    <?php echo form_close(); ?>
</section>