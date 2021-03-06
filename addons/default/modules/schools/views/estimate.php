<section class="item" id="secEstimate">
	<head>
		<script>
	function ajax_drop (select, model,filter,attr){
            $.ajax({
                type: "GET",
                url:  ("<?php echo base_url() ?>index.php/ajax/get/" + model + "/"+ filter +"/" + attr),
                success: function(data) {
                    var opt="<option value='0'> Selecionar</option>";
                    $.each(data, function(key,val){
                        opt += '<option value="' + key + '">' + val + '</option>';
                    });
                    $("#"+select).html(opt);
                   	$("select").each(function(){$(this).removeAttr('disabled','enabled')});
                }
                ,beforeSend: function(){
                    $("select").each(function(){$(this).attr('disabled','disabled')});
                }
            });
        }
        
        function makePrice(price) {
        	var i;
        	for(i=0; i < price.length; i++) {
        		if(price.charAt(i) == ',') {
        			var dif = price.length - i;
        			if(dif < 3) {
						return price.substring(0, i+2) + "0";
        			} else {
        				return price.substring(0, i+3);
        			}
        		} 
        	}
        	return price + ",00";
        }
        
        function ajax_price (parent, model,filter,attr){
            $.ajax({
                type: "GET",
                url:  ("<?php echo base_url() ?>index.php/ajax/price/" + model + "/"+ filter +"/" + attr),
                success: function(data) {
                	var price = "00,00";
                    $.each(data, function(key,val){
                        price = val;
                    });
                    var week;                    
                    if(parent != undefined){
                    	if(parent == 'c') {
                    		//Ajuste para arrumar a formatação de moeda
                    		price = makePrice(price);
                    		$("#price").attr('value', "<?php echo $country -> currency; ?> " + price.toString());
                    	} else {
                    		//Ajuste para arrumar a formatação de moeda
                    		price = makePrice(price);
                    		$("#priceA").attr('value', "<?php echo $country -> currency; ?>  " + price.toString());
                    	} 
                    }
                    $("select").each(function(){$(this).removeAttr('disabled','enabled')});
                }
                ,beforeSend: function(){
                    $("select").each(function(){$(this).attr('disabled','disabled')});
                }
            });
        }
        
        function clear(o){
            $("#"+o).html("<option value=''> Selecionar</option>");
        }
        
        function clear_input(o) {
        	$("#"+o).attr('value', "<?php echo $country -> currency; ?>  00,00");
        }
                
        function change_date(){
        	clear('periods');
        	clear_input("price");
        	var period = $('select#beginning option:selected').text().split('-');
			ajax_drop('periods', 'periods', 'get_courses_year/'+<?php echo $course -> id; ?> +'/' +  period[2]);

        }
        
        function change_period() {
       		clear_input("price");
       		ajax_price('c', 'periods', 'get/'+$("select#periods option:selected").val());
        }
        
        function change_periodA() {
        	var accommodation = $('input:radio[name=accommodation]:checked').val();
        	ajax_price('a', 'periods', 'get/'+$("select#periodA option:selected").val())
        }
        
        function before_send(event) {
        	var formAction = $('#formCalculate').attr('action');
        	var accommodation = $('input:radio[name=accommodation]:checked').val();			
			var period = $("select#periods option:selected").val();
			if(period == undefined || period == 0) {
				window.alert('Escolha um período para o curso	!');
				event.preventDefault();
			}
			accommodation -= 1;
			var date = $('select#beginning option:selected').val();
			var periodA = $('select#periodA option:selected').val();
			$('#formCalculate').attr('action', formAction + '/'+date+'/'+periodA+'/');
        }
        
			$(document).ready(function(){
				clear("periods");
				clear("periodA");
				clear_input("price");
				$('input:radio[name=accommodation]').each(function(){clear_input('priceA'+$(this).val());});
				var period = $('select#beginning option:selected').text().split('-');
				ajax_drop('periods', 'periods', 'get_courses_year/'+<?php echo $course -> id; ?> +'/' +  period[2]);
				
				$('input:radio[name=accommodation]').change(function(){
					var accommodation = $('input:radio[name=accommodation]:checked').val();
					clear('periodA');
					clear_input('priceA');
					ajax_drop('periodA', 'periods', "get_parent/"+accommodation+'/accommodations');
				});
//				$('select[name=periodA]').live('change', function (){
// 					tam = '//sizeof($accommodations) ?>';
//					for (b = 0; b < tam; b++){
//					var value = $('.periodA'+b).val();
//					var price;
//					var id;
//					var flag = 0;
//					for (i=0; i < value.length; i++)
//					  {
//						if (value.charAt(i)==':'){
//							price = value.substring(i+1);
//							if (flag == 0){
//								id = value.substring(1, i-1);
//								flag = 1;
//							}else
//								break;
//						}
//					  }
//
//						$('#p'+id).text('R$ ' + price);
//					}
//				});
//				$('#period').live('change', function (){
//					var value = $('select[name=period]').val();
//					var price;
//					for (i=0; i < value.length; i++)
//					  {
//						if (value.charAt(i)==':'){
//							price = value.substring(i+1);
//							break;
//						}
//					  } 
//					$('#ptotal').text('R$ ' + price);
//				});
				$('#pdf-link, #email-link').click(function (){
					var accommodation = $('input:radio[name=accommodation]:checked').val();
					var coursePeriod = $('select#periods option:selected').val();
					if(coursePeriod == 0) {
						window.alert("Selecione um período para o curso!");
						return false;
					}
					var accommodationPeriod = $('select#periodA option:selected').val();
					var transfer = $('input:radio[name=transfer]:checked').val();
					var inicio = $('select#beginning option:selected').attr('value');	
					switch (transfer) {
						case 'chegada' :
							transfer = 1;
							break;
						case 'partida' :
							transfer = 2;
							break;
						default : 
							transfer = 0;
							break;
					}					
					window.open(this.href+'/'+<?php echo $course->id ?>
						+'/' + coursePeriod + '/' + accommodation + '/' + accommodationPeriod + '/' + transfer + '/' + inicio, 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');
						return false;
						});
						});

		</script>
	</head>
	<div style="border-bottom: 1px solid #ccc; margin-bottom: 30px; height: 48px">
    <div style="font-size: 32px; font-weight: bold;">Or&ccedil;amento</div>
    <div style="margin-top: -20px">
    <div style="width:100px; float:right; "><?php echo anchor('schools/email', '<img src="img/email.jpg" />', 'id="email-link"'); ?></div>
    <div style="width:100px; float:right; "><?php echo anchor('schools/pdf', '<img src="img/pdf.jpg" />', 'id="pdf-link"'); ?></div>
    <div style="width:100px; float:right;"><?php echo anchor('schools/pdf', '<img src="img/imprimir.jpg" />', 'id="pdf-link"'); ?></div>
    </div>
    </div>
    <div style="clear:both"></div>
    <?php echo form_open('schools/calculate/' . $course -> id, 'id="formCalculate"'); ?>
    <table class="table-list estimate" id="general_informations">
		<tbody>
			<tr>
				<td>
					<?php echo 'Pa&iacute;s:' ?></br>
				</td>
				<td style="color: #4f5251; font-weight: bold;">
					<?php echo $country->name; ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo 'Cidade:' ?>
				</td>
				<td style="color: #4f5251; font-weight: bold;">
					<?php echo $this -> cities_m -> get($school -> city_id) -> name; ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo 'Escola:' ?>
				</td>
				<td style="color: #4f5251; font-weight: bold;">
					<?php echo $school -> name; ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo 'Curso:' ?>
				</td>
				<td style="color: #4f5251; font-weight: bold;">
					<?php echo $course -> name; ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo 'Idioma:' ?>
				</td>
				<td style="color: #4f5251; font-weight: bold;">
					<?php echo $this -> languages_m -> get($course -> language_id) -> name; ?>
				</td>
			</tr>
			<tr style="height: 25px">
				<td>
					<?php echo 'Carga hor&aacute;ria:' ?>
				</td>
				<td style="color: #4f5251; font-weight: bold;">
					<?php echo $course -> hourly_load; ?>
				</td>
			</tr>
		</tbody>
	</table>
	<div id="estimateHead">
		<?php echo 'Escolha o per&iacute;odo do seu curso:'; ?>
	</div>
	<table class="table-list estimate" id="periods_informations">
		<tbody>
			<tr style="height: 25px">
				<td class="first">
					<?php echo 'Data in&iacute;cio:' ?>
				</td>
				<td>
					<?php echo form_dropdown('beginning', $beginning, '', 'id="beginning" onchange="change_date()"'); ?>
				</td>
			</tr>
			<tr>
				<td class="first">
					<?php echo 'Per&iacute;odos:' ?>
				</td>
				<td>
					<select name="periods" onchange="change_period()" id="periods"></select>
				</td>
			</tr>
			<tr>
				<td class="first" >
					<?php echo 'Pre&ccedil;o:' ?>
				</td>
				<td id="ptotal">
					<input type="text" id="price" name="price" readonly="true" />
				</td>
			</tr>
		</tbody>
	</table>
	<div id="estimateHead">
		<?php echo 'Acomoda&ccedil;&atilde;o' ?>
	</div>
	<table class="table-list estimate" id="accommodations_informations">
		<tbody>		
			<?php $i = 0; foreach ($accommodations as $accommodation):?>
			<tr>
				<td class="first">
					<div class="input">
						<?php echo form_radio('accommodation', $accommodation -> id, FALSE) . ' ' . $accommodation -> name; ?>
					</div>
				</td>
				<td class="second">
					<?php echo $accommodation -> body; ?>
				</td>
			</tr>
			<?php $i++;
				endforeach;
			?>
			<tr>
				<td class="first">
					<?php echo 'Dura&ccedil;&atilde;o' ?>     
				</td>
				<td class="second">
					<select name="periodA" id="periodA" onchange="change_periodA()"></select>
				</td>
				<td class="third">
					<input type="text" id="priceA" />
				</td>
			</tr>
		</tbody>
	</table>
	<div id="estimateHead">
		<?php echo 'Transfer (opcional)' ?>
	</div>
	<table class="table-list estimate" id="transfers_informations">
		<tbody>
			<tr>
				<td>
					<div class="input">
					<?php echo form_radio('transfer', 'chegada', FALSE) . ' Transfer de Chegada'; ?>
					</div>
				</td>
				<td>
					<?php echo $country->currency . ' ' . $school -> transferc; ?>
				</td>
			</tr>
			<tr>
				<td id="radio">
					<div class="input">
					<?php echo form_radio('transfer', 'partida', FALSE) . ' Transfer de Chegada e Partida'; ?>
					</div>
				</td>
				<td>
					<?php echo $country->currency . ' ' . $school -> transfercp; ?>
				</td>
			</tr>
		</tbody>
    </table></br>
    <div>{{ widgets:instance id="11"}}</div>
    <div style="width:160px; float:left;"><?php echo anchor('schools/informations/' . $course -> id, 'Voltar', 'class="button"'); ?></div>    
    <div style="width:160px; float:right;"><?php echo form_submit('calculate', 'Calcular Valores', 'class="button" onclick="before_send(event)"'); ?></div>
    <?php form_close(); ?>
</section>
