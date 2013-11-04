
<section class="title">
	<h4><?php echo lang('article_posts_title'); ?></h4>
</section>

<section class="item">

<?php if ($article) : ?>

<?php echo $this->load->view('admin/partials/filters'); ?>

<?php echo form_open('admin/article/action'); ?>
	<div id="filter-stage">
		<?php echo $this->load->view('admin/tables/posts'); ?>
	</div>
<?php echo form_close(); ?>

<?php else : ?>
	<div class="no_data"><?php echo lang('article_currently_no_posts'); ?></div>
<?php endif; ?>

</section>
