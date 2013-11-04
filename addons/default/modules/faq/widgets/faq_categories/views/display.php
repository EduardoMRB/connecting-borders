<div style="background-color: #574594; color : #FFFFFF; height: 30px; font-size: 16px; padding: 15px 0 0 20px; margin-top: -15px; margin-bottom: 7px"> D&ugrave;vidas Frequentes</div>

<?php if (is_array($faq_widget)): ?>
<table id="faq-display">    
        <?php foreach ($faq_widget as $f): ?>
        <tr>
            <td class="question">
                <?php echo $f->question; ?>
            </td>
            <td class="answer">
                <?php echo $f->answer; ?>
            </td>
        </tr>
        <?php endforeach; ?>
</table>
<div>
	<?php echo anchor('faq/' . $category->slug, "Mais"); ?>
</div>
<?php endif; ?>