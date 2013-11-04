<img id="image-title" src="img/latest_post-bg.png"/>
<div class="latest_posts">
    <?php foreach ($article_widget as $post_widget): ?>    
        <div class="post"> 
            <div class="thumb"><?php echo img($post_widget->thumb); ?></div>        
            <div class="bg-title"><img src="img/latest_post_title.png"/></div>
            <div class="title"><?php echo $post_widget->title; ?></div>             
            <div class="link"><?php echo $post_widget->intro . "<br>" . anchor('article/' . date('Y/m', $post_widget->created_on) . '/' . $post_widget->slug, "Leia mais !"); ?></div>
        </div>    
    <?php endforeach; ?>
</div>