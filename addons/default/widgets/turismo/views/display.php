<div class="orcamento_turismo">
    <script type="text/javascript" > 
        function ajax_drop (model,filter,attr){
            $.ajax({
                type: "GET",
                url:  ("<?php echo base_url() ?>index.php/ajax/get/" + model + "/"+ filter +"/" + attr),
                success: function(data) {
                    var opt="<option value=''> Selecionar</option>";
                    $.each(data, function(key,val){
                        opt += '<option value="' + key + '">' + val + '</option>';
                    });
                    $("#"+model).html(opt);
                    $(".orcamento_turismo select").each(function(){$(this).removeAttr('disabled','enabled')});
                }
                ,beforeSend: function(){
                    $(".orcamento_turismo select").each(function(){$(this).attr('disabled','disabled')});
                }
            });
        }
        
        function submit_orcamento(){
            if( !($("#cities").val()) ){
                alert("Selecione uma cidade para prosseguir !");
            }else{
                window.location = ("<?php echo base_url() ?>index.php/cities/informations/" + $("#cities").val()+"/"+$('#traveling').val()+"/"+$("#accommodations").val());

            }
            
        }
        
        function clear(o){
            $("#"+o).html("<option value=''> Selecionar</option>");

        }
        
        var change_cidade = function() {
        	ajax_drop("accommodations", "get_accommodations_by_city/" + $('#cities').val());
        }
        
        var change_pais = function(){
        	clear('accommodations');
            ajax_drop("cities","get_travel_cities/"+$("#countries").val());
        }
        
        var change_travel = function(){
        	clear('accommodations');
            clear("cities");
            ajax_drop("countries","get_countries_by_traveling/" + $("#traveling").val()) ;

        }
        
        $(document).ready(function(){
            $(".orcamento_turismo select").each(function(){clear($(this).attr('name'))});
            ajax_drop("traveling","get_all",null) ;
            
        });
  
    </script>
    <img src="img/monte_viagem.png" />
    <table >
        <tr>
            <td><label for="traveling">Tipo de viagem</label></td>
            <td id="select-box"></div><select name="traveling" onchange="change_travel()" id="traveling">

            </select></td>
        </tr>
        <tr id="justSpace"></tr>
        <tr>
            <td><label for="countries">Pa&iacute;s</label></td>
            <td id="select-box"><select name="countries" onchange="change_pais()" id="countries">

            </select></td>
        </tr>
        <tr id="justSpace"></tr>
        <tr>
            <td><label for="cities">Cidade</label></td>
            <td id="select-box"><select name="cities" onchange="change_cidade()"id="cities">

            </select></td>
        </tr>
        <tr id="justSpace"></tr>
        <tr>
            <td><label for="accommodations">Acomoda&ccedil;&otilde;es</label></td>
            <td id="select-box"><select name="accommodations" onchange="" id="accommodations">

            </select></td>
        </tr>
        <tr id="justSpace"></tr>
        <tr>
        	<td></td>
            <td><div class="buttons">
                <a id="pesquisar" onclick="submit_orcamento()"><img src="img/pesquisa.png" /></a>
            </div></td>
        </tr>
    </table>
</div>
<div id="pass-hosp" >
	<a href="http://www.portaldoagente.com.br/easy/easyLoad.aspx?Agencia=2045"><img style="margin-bottom : 14px;" src="img/passagem.png" /></a>
	<a href="#"> <img src="img/hospedagem.png" /></a>
</div>
{{ widgets:instance id="20"}}
