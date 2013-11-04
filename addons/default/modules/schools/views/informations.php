<section class="item" id="secInformation">
    <div class="information">				
		<div id="content" style=" text-align: left; float: left;">
		<div id="image" style="float: left;"><?php echo "<img src='$school->relative'></img>"; ?></div>
			<p id="title"><?php echo $school -> name; ?></p>
			<div><?php echo $school -> body; ?></br></div>
		</div>		
    </div>
  	<div class="information">
		<div id="content" style="text-align: left; float: left;">
			<div id="image" style="float: right;"><?php echo "<img src='$city->relative'></img>"; ?></div>
			<p id="title" style="width: 96%;"><?php echo $city->name ; ?></p>
			<div ><?php echo $city -> body; ?><br /></div>			
		</div>				
	</div>
	<div class="information">    			
		<div id="content" style="width: 100%; padding : 0 25px 0 12px;">
			<div style="text-align: left; width: 100%; padding : 0 40px 0 30px;"><p id="title" style="width: 94%;" ><?php echo $course -> name; ?></p></div>
			<div style="text-align: left; padding : 0 0 0 30px;">
				<?php echo $course -> body; ?></br>
			</div>
		</div>
	</div>
    <div id="monte_orcamento_button">
		<?php echo anchor('schools/estimate/' . $course -> id, '<img src="img/monte_orcamento.png" />'); ?>
	</div>
</section>
