<?php
//dropdown menu options for the style of the social stat(s)
$layout = array(
    'standard' => 'Padrão',
    'button_count' => 'Contador botão',
    'box_count' => 'Contador Caixa ',
);
$faces = array(
    'true' => 'Mostrar',
    'false' => 'Não Mostrar',
);
$button = array(
    'like' => 'Curtir',
    'recommend' => 'Recomendar',
);
$color = array(
    'light' => 'Claro',
    'dark' => 'Escuro',
);
$font = array(
    'arial' => 'Arial',
    'lucida grande' => 'Lucinda grande',
    'segoe ui' => 'Segoe ui',
    'tahoma' => 'Tahoma',
    'trebuchet ms' => 'Trebuchet ms',
    'verdana' => 'Verdana',
);
?>

<ol>
    <li class="even">
        <!-- there are a few different styles to choose from..enjoy-->
        <label>Página para Curtir:</label>
<?php echo form_input('link', $options['link']); ?>
    </li>
    <li class="even">
        <!-- there are a few different styles to choose from..enjoy-->
        <label>Escolha o layout do botão:</label>
<?php echo form_dropdown('layout', $layout, $options['layout']); ?>
    </li>
    <li class="even">
        <!-- there are a few different styles to choose from..enjoy-->
        <label>Largura:</label>
<?php echo form_input('width', $options['width']); ?>
    </li>
    <li class="even">
        <!-- there are a few different styles to choose from..enjoy-->
        <label>Mostrar Faces:</label>
<?php echo form_dropdown('faces', $faces, $options['faces']); ?>
    </li>
    <li class="even">
        <!-- there are a few different styles to choose from..enjoy-->
        <label>Escolha o botão que deve Mostrar:</label>
<?php echo form_dropdown('button', $button, $options['button']); ?>
    </li>
    <li class="even">
        <!-- there are a few different styles to choose from..enjoy-->
        <label>Escolha a cor do botão:</label>
<?php echo form_dropdown('color', $color, $options['color']); ?>
    </li>
    <li class="even">
        <!-- there are a few different styles to choose from..enjoy-->
        <label>Escolha a fonte do botão:</label>
<?php echo form_dropdown('font', $font, $options['font']); ?>
    </li>
</ol>
