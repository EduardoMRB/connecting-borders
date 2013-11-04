<section class="title">
    <?php if ($this->method == 'create'): ?>
        <h4><?php echo lang('article_create_title'); ?></h4>
    <?php else: ?>
        <h4><?php echo sprintf(lang('article_edit_title'), $post->title); ?></h4>
    <?php endif; ?>
</section>

<section class="item">

    <?php echo form_open_multipart(uri_string(), 'class="crud"'); ?>

    <div class="tabs">

        <ul class="tab-menu">
            <li><a href="#article-content-tab"><span><?php echo lang('article_content_label'); ?></span></a></li>
            <li><a href="#article-options-tab"><span><?php echo lang('article_options_label'); ?></span></a></li>
        </ul>

        <!-- Content tab -->
        <div class="form_inputs" id="article-content-tab">

            <fieldset>

                <ul>
                    <li>
                        <label for="thumb"><?php echo lang('article_thumb_label'); ?> <span>*</span></label>
                        <div class="input"><?php echo form_upload('thumb', $post->thumb, 'id="thumb"'); ?></div>				
                    </li>
                    <li class="even">
                        <label for="title"><?php echo lang('article_title_label'); ?> <span>*</span></label>
                        <div class="input"><?php echo form_input('title', htmlspecialchars_decode($post->title), 'maxlength="100" id="title"'); ?></div>				
                    </li>

                    <li>
                        <label for="slug"><?php echo lang('article_slug_label'); ?> <span>*</span></label>
                        <div class="input"><?php echo form_input('slug', $post->slug, 'maxlength="100" class="width-20"'); ?></div>
                    </li>

                    <li class="even">
                        <label for="status"><?php echo lang('article_status_label'); ?></label>
                        <div class="input"><?php echo form_dropdown('status', array('draft' => lang('article_draft_label'), 'live' => lang('article_live_label')), $post->status) ?></div>
                    </li>

                    <li>
                        <label for="intro"><?php echo lang('article_intro_label'); ?></label>
                        <br style="clear: both;" />
                        <?php echo form_textarea(array('id' => 'intro', 'name' => 'intro', 'value' => $post->intro, 'rows' => 5, 'class' => 'article wysiwyg-simple')); ?>
                    </li>

                    <li class="even editor">
                        <label for="body"><?php echo lang('article_content_label'); ?></label>

                        <div class="input">
                            <?php
                            echo form_dropdown('type', array(
                                'html' => 'html',
                                'markdown' => 'markdown',
                                'wysiwyg-simple' => 'wysiwyg-simple',
                                'wysiwyg-advanced' => 'wysiwyg-advanced',
                                    ), $post->type);
                            ?>
                        </div>

                        <br style="clear:both"/>

                        <?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $post->body, 'rows' => 30, 'class' => $post->type)); ?>

                    </li>
                </ul>

            </fieldset>

        </div>

        <!-- Options tab -->
        <div class="form_inputs" id="article-options-tab">

            <fieldset>

                <ul>
                    <li>
                        <label for="category_id"><?php echo lang('article_category_label'); ?></label>
                        <div class="input">
                            <?php echo form_dropdown('category_id', array(lang('article_no_category_select_label')) + $categories, $post->category_id) ?>
                            [ <?php echo anchor('admin/article/categories/create', lang('article_new_category_label'), 'target="_blank"'); ?> ]
                        </div>
                    </li>

                    <li class="even">
                        <label for="keywords"><?php echo lang('global:keywords'); ?></label>
                        <div class="input"><?php echo form_input('keywords', $post->keywords, 'id="keywords"') ?></div>
                    </li>

                    <li class="date-meta">
                        <label><?php echo lang('article_date_label'); ?></label>

                        <div class="input datetime_input">
                            <?php echo form_input('created_on', date('Y-m-d', $post->created_on), 'maxlength="10" id="datepicker" class="text width-20"'); ?> &nbsp;
                            <?php echo form_dropdown('created_on_hour', $hours, date('H', $post->created_on)) ?> : 
                            <?php echo form_dropdown('created_on_minute', $minutes, date('i', ltrim($post->created_on, '0'))) ?>

                        </div>
                    </li>

                 
                      
                        
        
                </ul>

            </fieldset>

        </div>

    </div>
<?php echo form_hidden('comments_enabled', 0, 'id="comments_enabled"'); ?>
    <div class="buttons">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
    </div>

    <?php echo form_close(); ?>

</section>

<style type="text/css">
    form.crudli.date-meta div.selector {
        float: left;
        width: 30px;
    }
    form.crud li.date-meta div input#datepicker { width: 8em; }
    form.crud li.date-meta div.selector { width: 5em; }
    form.crud li.date-meta div.selector span { width: 1em; }
    form.crud li.date-meta label.time-meta { min-width: 4em; width:4em; }
</style>