{{ theme:js file="slides.min.jquery.js" }}
<script type="text/javascript" >
    $(document).ready(function(){
        $('#<?php echo $id;?>').slides({
            preload: true,
            <?php if($auto_slide == 'no')echo 'play: 0,';else echo 'play: 9000,'; ?>
            pause: 5000,
            hoverPause: true,
			crossfade: true,
			<?php
				if($navigation == 'pagination')echo 'generatePagination: true,';else echo 'generatePagination: false,';
				if($navigation == 'next/prev')echo 'generateNextPrev: true,';else echo 'generateNextPrev: false,';
			?>
            preloadImage:'http://google-web-toolkit.googlecode.com/svn-history/r8457/trunk/user/src/com/google/gwt/cell/client/loading.gif'
        }); 
    });
</script>
<div id="<?php echo $id;?>" style="list-style: none; ">
    <div class="slides_container" style="overflow-x: hidden; overflow-y: hidden; position: relative; display: block; ">
        <?php
        foreach ($image_list as $image):
            if ($description == 'yes') {
                echo img(( $folder . $image->filename),array('alt'=>$image->description));
            }else{
                echo img(( $folder . $image->filename));
            }
        endforeach;
        ?>
    </div>
</div>
{{ widgets:instance id="15"}}