<div class="orcamento">
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
                    $(".orcamento select").each(function(){$(this).removeAttr('disabled','enabled')});
                }
                ,beforeSend: function(){
                    $(".orcamento select").each(function(){$(this).attr('disabled','disabled')});
                }
            });
        }
        
        function submit_orcamento(){
            if( !($("#courses").val()) ){
                alert("Selecione um curso para prosseguir !");
            }else{
                window.location = ("<?php echo base_url() ?>index.php/schools/informations/" + $("#courses").val());

            }
            
        }
        function clear(o){
            $("#"+o).html("<option value=''> Selecionar</option>");

        }
        var change_pais = function(){
            clear("schools");
            clear("courses");
            ajax_drop("cities","get_many_by/country_id", + $("#countries").val()) ;
        }
        
        
        var change_cidade = function(){
     
            clear("courses")
            ajax_drop("schools","get_many_by/city_id/" + $("#cities").val()) ;
        }
        
        var change_lang = function(){
            clear("cities");
            clear("schools");
            clear("courses");
            ajax_drop("countries","get_by_mask_language/" + $("#languages").val()) ;

        }
        var change_school = function(){

            ajax_drop("courses","get_by_school_language/" + $("#schools").val()+ "/" + $("#languages").val()) ;
        }        
        $(document).ready(function(){
            $(".orcamento select").each(function(){clear($(this).attr('name'))});
            ajax_drop("languages","get_all",null) ;
            
        });
  
    </script>
    <img src="img/monte_intercambio.png" />
    <table >
        <tr>
            <td><label for="languages">Idioma</label></td>
            <td id="select-box"></div><select name="languages" onchange="change_lang()" id="languages">

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
            <td id="select-box"><select name="cities" onchange="change_cidade()" id="cities">

            </select></td>
        </tr>
        <tr id="justSpace"></tr>
        <tr>
            <td><label for="schools">Escola</label></td>
            <td id="select-box"><select name="schools" onchange="change_school()" id="schools">

            </select></td>
        </tr>
        <tr id="justSpace"></tr>
        <tr>
            <td><label for="courses">Curso</label></td>
            <td id="select-box"><select name="courses"  id="courses">

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
	<a href="http://www.portaldoagente.com.br/easy/easyLoad.aspx?Agencia=2045" onclick="window.open(this.href); return false;"><img src="img/passagem.png" /></a>
	<a href="#" onclick="window.open(this.href); return false;"> <img src="img/hospedagem.png" /></a>
</div>
{{ widgets:instance id="20"}}