<img src="img/suporte.png" />
<p style="text-align: center; font-size: 16px; margin: 20px 0 0 0; padding: 0;">Assista nossos <b style="color : #5e4f96; font-size: 20px;">videos!</b></p>
<ul class="navigation">
    <?php foreach ($movie_widget as $post_widget): ?>
       <li class="thumb"> <object width="90%" data="http://www.youtube.com/v/<?php echo $post_widget->link ?>" type="application/x-shockwave-flash"><param name="src" value="http://www.youtube.com/v/<?php echo $post_widget->link ?>" /></object>
        </li>
        <li class="link"><?php echo "<a target='_blank' href='http://www.youtube.com/watch?v=$post_widget->link'>" . lang('mov_watch_title') . "</a>" ?></li>
    <?php endforeach; ?>
</ul>