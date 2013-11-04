<!-- Page layout: <?php echo $page->layout->title; ?> -->
<?php 
$this->session->set_userdata(array("page_id" => $page->id));
echo $page->layout->body ; 
?>

<?php if($page->comments_enabled): ?>
	<?php echo display_comments($page->id); ?>
<?php endif; ?>