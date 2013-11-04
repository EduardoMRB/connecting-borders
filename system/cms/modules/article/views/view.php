<div class="article_post">
	<!-- Post heading -->
	<div class="post_heading">
				<h4><?php echo $post->title; ?></h4>
				<div class="post_body">
					<?php echo $post->body; ?>
				</div>
				
	</div>
	<?php if($post->keywords): ?>
	<p class="post_keywords">
		<?php echo lang('article_tagged_label');?>:
		<?php echo $post->keywords; ?>
	</p>
	<?php endif; ?>
</div>

<?php if ($post->comments_enabled): ?>
	<?php echo display_comments($post->id); ?>
<?php endif; ?>
