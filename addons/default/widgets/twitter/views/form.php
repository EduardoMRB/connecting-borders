<?php
//dropdown menu options for the style of the social stat(s)
$count = array(
    'vertical' => 'Vertical',
    'horizontal' => 'Horizontal',
    'none' => 'Sem contador',
);
?>

<ol>
    <li class="even">
        <!-- there are a few different styles to choose from..enjoy-->
        <label>Via:</label>
        <?php echo form_input('via', $options['via']); ?>
    </li>
    <li class="even">
        <!-- there are a few different styles to choose from..enjoy-->
        <label>Contador:</label>
        <?php echo form_dropdown('count', $count, $options['count']); ?>
    </li>
</ol>
