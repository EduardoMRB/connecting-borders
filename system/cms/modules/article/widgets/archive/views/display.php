<?php if($archive_months): ?>
	<ul class="list-unstyled">
		<?php foreach($archive_months as $month): ?>
			<li>
				<a href="<?php echo site_url('article/archive/'.date('Y/m', $month->date));?>">
					<?php echo format_date($month->date, lang('article_archive_date_format')) ?> (<?php echo $month->post_count; ?>)
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>