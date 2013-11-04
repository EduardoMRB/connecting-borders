<section class="title">
    <h4><?php echo lang('mov_list_title'); ?></h4>
</section>

<section class="item">

    <?php if ($movies): ?>

        <?php echo form_open('admin/article/movies/delete'); ?>

        <table border="0" class="table-list">
            <thead>
                <tr>
                    <th width="110"></th>
                    <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                    <th><?php echo lang('mov_movie_label'); ?></th>
                    <th width="310"></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="4">
                        <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($movies as $movie): ?>
                    <tr>
                        <td><?php echo "<img width='100px' height='76px' src='http://i4.ytimg.com/vi/" . $movie->link . "/default.jpg' class='nav-thumb'/>"; ?></td>
                        <td><?php echo form_checkbox('action_to[]', $movie->id); ?></td>
                        <td><?php echo $movie->title; ?></td>
                        <td class="align-center buttons buttons-small">
                            <?php echo anchor('admin/article/movies/edit/' . $movie->id, lang('global:edit'), 'class="button edit"'); ?>
                            <?php echo anchor('admin/article/movies/delete/' . $movie->id, lang('global:delete'), 'class="confirm button delete"'); ?>
                            <?php echo "<a target='_blank' href='http://www.youtube.com/watch?v=$movie->link' class ='button'>" . lang('mov_watch_title') . "</a>"?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="table_action_buttons">
            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
        </div>

        <?php echo form_close(); ?>

    <?php else: ?>
        <div class="no_data"><?php echo lang('mov_no_movies'); ?></div>
    <?php endif; ?>
</section>