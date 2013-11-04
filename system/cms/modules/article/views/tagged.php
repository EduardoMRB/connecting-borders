<h2 id="page_title"><?php echo lang('article_tagged_label').': '.str_replace('-', ' ', $tag); ?></h2>
<?php if (!empty($article)): ?>
<?php foreach ($article as $post): ?>
	<div class="article_post">
		<!-- Post heading -->
		<div class="post_heading">
			<h2><?php echo  anchor('article/' .date('Y/m', $post->created_on) .'/'. $post->slug, $post->title); ?></h2>
			<p class="post_date"><?php echo lang('article_posted_label');?>: <?php echo format_date($post->created_on); ?></p>
			<?php if($post->category_slug): ?>
			<p class="post_category">
				<?php echo lang('article_category_label');?>: <?php echo anchor('article/category/'.$post->category_slug, $post->category_title);?>
			</p>
			<?php endif; ?>
			<?php if($post->keywords): ?>
			<p class="post_keywords">
				<?php echo lang('article_tagged_label');?>:
				<?php echo $post->keywords; ?>
			</p>
			<?php endif; ?>
		</div>
		<div class="post_body">
			<?php echo $post->intro; ?>
		</div>
	</div>
<?php endforeach; ?>

<?php echo $pagination['links']; ?>

<?php else: ?>
	<p><?php echo lang('article_currently_no_posts');?></p>
<?php endif; ?>