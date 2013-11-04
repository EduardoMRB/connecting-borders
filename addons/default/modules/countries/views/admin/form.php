<?php if ($this->method == 'edit'): ?>
	<section class="title">
    	<h4><?php echo sprintf(lang('countries:edit_title'), $country -> name); ?></h4>
	</section>
<?php else: ?>
	<section class="title">
    	<h4><?php echo lang('countries:add_title'); ?></h4>
	</section>
<?php endif; ?>

<section class="item">

<script type="text/javascript">
var cur=new Array();
var sym=new Array();
cur[0]='Leke ';sym[0]='&#76;&#101;&#107';cur[1]='America(UnitedStatesofAmerica),Dollars ';sym[1]='&#36';cur[2]='Afghanis ';sym[2]='&#1547';cur[3]='Pesos ';sym[3]='&#36';cur[4]='Guilders ';sym[4]='&#402';cur[5]='Australia,Dollars ';sym[5]='&#36';cur[6]='NewManats ';sym[6]='&#1084;&#1072;&#1085';cur[7]='Bahamas,Dollars ';sym[7]='&#36';cur[8]='Barbados,Dollars ';sym[8]='&#36';cur[9]='Rubles ';sym[9]='&#112;&#46';cur[10]='Francs ';sym[10]='&#8355';cur[11]='Belize,Dollars ';sym[11]='&#66;&#90;&#36';cur[12]='Bermuda,Dollars ';sym[12]='&#36';cur[13]='Bolivianos ';sym[13]='&#36;&#98';cur[14]='ConvertibleMarka';sym[14]='&#75;&#77';cur[15]='Pulas ';sym[15]='&#80';cur[16]='Leva ';sym[16]='&#1083;&#1074';cur[17]='Reais  ';sym[17]='&#82;&#36';cur[18]='Cruzeiros';sym[18]='&#8354';cur[19]='Pounds ';sym[19]='&#163';cur[20]='BruneiDarussalam,Dollars ';sym[20]='&#36';cur[21]='Riels ';sym[21]='&#6107';cur[22]='Canada,Dollars ';sym[22]='&#36';cur[23]='CaymanIslands,Dollars ';sym[23]='&#36';cur[25]='YuanRenminbi ';sym[25]='&#20803';;cur[27]='Colón ';sym[27]='&#8353';cur[28]='Kuna ';sym[28]='&#107;&#110';cur[29]='Pesos ';sym[29]='&#8369';cur[31]='Koruny ';sym[31]='&#75;&#269';cur[32]='Kroner ';sym[32]='&#107;&#114';cur[33]='Pesos ';sym[33]='&#82;&#68;&#36';cur[34]='EastCaribbean,Dollars ';sym[34]='&#36';cur[36]='Colones ';sym[36]='&#36';cur[38]='Krooni ';sym[38]='&#107;&#114';cur[39]='EUR';sym[39]='&#8364';cur[40]='EuropeanCurrencyUnit';sym[40]='&#8352';cur[42]='Fiji,Dollars';sym[42]='&#36';cur[43]='Francs';sym[43]='&#8355';cur[44]='Cedis ';sym[44]='&#162';cur[46]='Drachmae ';sym[46]='&#8367';cur[47]='Quetzales ';sym[47]='&#81';cur[49]='Guyana,Dollars ';sym[49]='&#36';cur[50]='Guilders ';sym[50]='&#402';cur[51]='Lempiras ';sym[51]='&#76';cur[52]='HongKong,Dollars ';sym[52]='&#72;&#75;&#36';cur[53]='HongKong,Dollars(BOC notes) ';sym[53]='&#22291';cur[54]='HongKong,Dollars(SCB notes) ';sym[54]='&#22291';cur[55]='HongKong,Dollars(HSBC notes) ';sym[55]='&#20803';cur[56]='Forint ';sym[56]='&#70;&#116';cur[57]='Kronur ';sym[57]='&#107;&#114';cur[58]='Rupees';sym[58]='&#8360';cur[59]='Rupiahs ';sym[59]='&#82;&#112';cur[60]='Rials ';sym[60]='&#65020';cur[61]='Punt';sym[61]='&#163';cur[63]='NewShekels ';sym[63]='&#8362';cur[64]='Lire';sym[64]='&#8356';cur[65]='Jamaica,Dollars ';sym[65]='&#74;&#36';cur[66]='Yen ';sym[66]='&#165';cur[68]='Tenge ';sym[68]='&#1083;&#1074';cur[69]='Won ';sym[69]='&#8361';cur[70]='Won ';sym[70]='&#8361';cur[71]='Soms ';sym[71]='&#1083;&#1074';cur[72]='Kips ';sym[72]='&#8365';cur[73]='Lati ';sym[73]='&#76;&#115';cur[75]='Liberia,Dollars ';sym[75]='&#36';cur[76]='SwitzerlandFrancs ';sym[76]='&#67;&#72;&#70';cur[77]='Litai ';sym[77]='&#76;&#116';cur[78]='Francs';sym[78]='&#8355';cur[79]='Denars ';sym[79]='&#1076;&#1077;&#1085';cur[80]='Ringgits ';sym[80]='&#82;&#77';cur[81]='Liri ';sym[81]='&#76;&#109';cur[82]='Rupees ';sym[82]='&#8360';cur[84]='Tugriks ';sym[84]='&#8366';cur[85]='Meticais ';sym[85]='&#77;&#84';cur[86]='Namibia,Dollars ';sym[86]='&#36';cur[87]='Rupees ';sym[87]='&#8360';cur[88]='Guilders';sym[88]='&#402';cur[89]='Guilders ';sym[89]='&#402';cur[90]='New Zealand,Dollars ';sym[90]='&#36';cur[91]='Cordobas ';sym[91]='&#67;&#36';cur[92]='Nairas ';sym[92]='&#8358';cur[93]='Won ';sym[93]='&#8361';cur[94]='Krone ';sym[94]='&#107;&#114';cur[95]='Rials ';sym[95]='&#65020';cur[96]='Rupees ';sym[96]='&#8360';cur[97]='Balboa ';sym[97]='&#66;&# 47;&#46';cur[98]='Guarani ';sym[98]='&#71;&#115';cur[99]='NuevosSoles ';sym[99]='&#83;&#47;&#46';cur[101]='Zlotych ';sym[101]='&#122;&#322';cur[102]='Rials ';sym[102]='&#65020';cur[103]='NewLei ';sym[103]='&#108;&#101;&#105';cur[104]='Rubles ';sym[104]='&#1088;&#1091;&#1073';cur[106]='Riyals ';sym[106]='&#65020';cur[107]='Dinars ';sym[107]='&#1044;&#1080;&#1085;&#46';cur[108]='Rupees ';sym[108]='&#8360';cur[109]='Singapore,Dollars ';sym[109]='&#36';cur[110]='Koruny ';sym[110]='&#83;&#73;&#84';cur[111]='Euro ';sym[111]='&#8364';cur[112]='SolomonIslands,Dollars ';sym[112]='&#36';cur[113]='Shillings ';sym[113]='&#83';cur[114]='Rand ';sym[114]='&#82';cur[115]='Won ';sym[115]='&#8361';cur[116]='Pesetas';sym[116]='&#8359';cur[117]='Rupees ';sym[117]='&#8360';cur[118]='Kronor ';sym[118]='&#107;&#114';cur[119]='Francs ';sym[119]='&#67;&#72;&#70';cur[120]='Suriname,Dollars ';sym[120]='&#36';cur[122]='Taiwan,NewDollars ';sym[122]='&#78;&#84;&#36';cur[123]='Baht ';sym[123]='&#3647';cur[124]='TrinidadandTobago,Dollars ';sym[124]='&#84;&#84;&#36';cur[125]='NewLira ';sym[125]='&#89;&#84;&#76';cur[126]='Liras ';sym[126]='&#8356';cur[127]='Tuvalu,Dollars ';sym[127]='&#36';cur[128]='Hryvnia ';sym[128]='&#8372';cur[130]='UnitedStatesOfAmerica, Dollars ';sym[130]='&#36';cur[131]='Pesos ';sym[131]='&#36;&#85';cur[132]='Sums ';sym[132]='&#1083;&#1074';cur[133]='Lire';sym[133]='&#8356';cur[134]='Bolivares ';sym[134]='&#66;&#115';cur[135]='Dong ';sym[135]='&#8363';cur[136]='Rials ';sym[136]='&#65020';cur[137]='Zimbabwe,ZimbabweDollars ';sym[137]='&#90;&#3';
function list(index) {
    var con=document.getElementById('sym');
    if(index==-1) {
     con.innerHTML="";
     return;
    }
    con.innerHTML=$('select#cur option:selected').val();
}
$(document).ready(function(){
	var opt = '<option value="-1">Select Currency</option>';
	count=cur.length;
	var i;
	for(i=0;i<count;i++){
		if(cur[i] != undefined)
 			opt += '<option value="'+sym[i]+'">'+cur[i]+'</option>';
 	}
 	$("#cur").html(opt);
});
</script>

<?php echo form_open_multipart(uri_string(), 'class="crud"'); ?>
<?php
	if ($this -> method == 'edit')
		echo form_hidden('country_id', $country -> id);
 ?>
<div class="form_inputs">
    <ul>
		<li>
			<label for="userfile" ><?php echo lang('countries:upload'); ?>:</label>
			<input type="file" name="userfile" class="input" />
		</li>
		<li>
			<label for="currency"></label>
			<div class="input">
				<select name="cur" id="cur" onChange="list(this.value)"></select>
				<div id="sym"></div>
			</div>
		</li>
		<li>
			<label for="name"><?php echo lang('countries:name'); ?> <span>*</span></label>
			<div class="input"><?php echo form_input('name', $country -> name); ?></div>
		</li>

		<li class="<?php echo alternator('even', ''); ?>">
			<label for="languages[]"><?php echo lang('countries:languages_label'); ?> <span>*</span></label>
			<div class="input">
				<?php echo form_multiselect('languages[]', $language_options, $country -> languages); ?>
			</div>
		</li>
		</li>
			
		<li class="even editor">
			<label for="body"><?php echo lang('countries:countries_content_label'); ?></label>
				
			<div class="input">
				<?php echo form_dropdown('type', array('html' => 'html', 'markdown' => 'markdown', 'wysiwyg-simple' => 'wysiwyg-simple', 'wysiwyg-advanced' => 'wysiwyg-advanced', ), $country -> type); ?>
			</div>
				
			<br style="clear:both"/>
				
			<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $country -> body, 'rows' => 30, 'class' => $country -> type)); ?>
				
		</li>
    </ul>
    
</div>
    
	<div class="buttons">
		<?php $this -> load -> view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
	</div>	
	
<?php echo form_close(); ?>



</section>
