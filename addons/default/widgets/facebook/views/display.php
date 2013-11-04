<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<ul class="fb">
    <div class="fb-like" href="<?php echo $options['link']; ?>" data-layout="<?php echo $options['layout']; ?>" data-width="<?php echo $options['width']; ?>" data-show-faces="<?php echo $options['faces']; ?>" data-action="<?php echo $options['button']; ?>" data-colorscheme="<?php echo $options['color']; ?>" data-font="<?php echo $options['font']; ?>"></div>
</ul>
