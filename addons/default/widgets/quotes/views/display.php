<?php if($quote) { ?>
<div id="quote">
	<div id="frase">
		<?php echo '<b id="doble">"</b>' . $quote->body . '<b id="doble">"</b>'; ?>
	</div>
	<div id="autor">  
		<?php echo $quote->author; ?>
	</div>
</div>	
<?php } ?>
