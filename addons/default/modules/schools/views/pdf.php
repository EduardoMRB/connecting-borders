<?php
ini_set("memory_limit","100M");
/* First, the head and styles for the page */
$html = "<head>
			<style>
				#title {font-size : 20px; color : #4e739f; font-weight : bold; border-top : 2px dotted #ccc; border-bottom : 2px dotted #ccc; height : 30px; }
				table#curso {border : 3px dashed #CCCCCC;}
				table#curso td {width: 20%; border-left: 3px dashed #CCCCCC; text-align : center;}
				table#curso td#first {border-left : none; heigth: 60px}
				table#tarifas {border : 3px solid #fff; width : 100%;}
				table#tarifas td {width : 50%; text-align : center; border-left : 3px solid #fff; border-bottom : 3px solid #fff; heigth : 40px; background-color : #ced1fc;}
				table#tarifas td#first {background-color : #e4e6ff;}
			</style>
		</head>";
/* Now, lets create the html body for the pdf */
$html = $html .
		'<body>
			<header>
				
			</header>
			<div id="content">
				<div style="width : 100%;" align="right" ><img style="width : 500px; height : 200px;" src="img/logo_pdf.jpg" style="float : right;"/></div>
				<p id="title"> Curso </p>
				<p id="desc">' . $course->body .'</p>
				<p><b>Cidade : </b>' . $city->name . '</p>
				<p><b>Escola : </b>' . $school->name . '</p>
				<p><b>Data de início : </b>' . $beginning . '</p>
				<p><b>Curso</b> : ' . $course->name . '</p>
				<p><b>Carga Horária</b> : ' . $course->hourly_load . '</p>
				<p><b>Período de Curso</b> : ' . $courseP->name . '</p>';
				
$html .= 			$accommodation ?
				'<p id="title"> Acomodaç&atilde;o </p>
				<p id=""> <b>' . $accommodation->name . '</b> : ' . $accommodation->body . '</p>
				<p><b>Tempo de acomoda&ccedil;&atilde;o</b> : ' . $accommodationP->name . '</p>
				<p>
Atenç&atilde;o: todas as opç&otilde;es est&atilde;o sujeitas &agrave; disponibilidade. Como o alojamento padr&atilde;o &eacute; limitado n&oacute;s
					fornecemos outras opç&otilde;es de acomodaç&atilde;o com tarifas diferentes. 
				</p>'
				 : '';

				
$text = '';
$total = $accommodation ? str_replace(',', '.', $accommodationP->price) : 0;
$total += str_replace(',', '.', $courseP->price);
$text .= '<tr>
		<td id="first"> ' . $course->name . '</td>
		<td> ' . $country->currency . ' ' . $courseP->price . '</td>
	</tr>';
$text .= $accommodation ?  '<tr>
		<td id="first"> ' . $accommodation->name . '</td>
		<td> '. $country->currency  . ' '  .$accommodationP->price . '</td>
	</tr>' : '';
if($transfer) {
	$text .= '<tr>
				<td id="first">' . $transfer['name'] . '</td>
				<td>'. $country->currency  . ' '  . $transfer['value'] . '</td>
			 </tr>';
	$total += str_replace(',', '.', $transfer['value']);
}

if($fares) {
	foreach($fares as $fare) {
		$text .= '<tr>
					<td id="first">' . $fare->name . '</td>
					<td>'. $country->currency  . ' '  . $fare->price . '</td>
				  <tr>';
		$total += str_replace(',', '.', $fare->price);
	}
}
$html .= '<p id="title">Investimento</p>			
		<table id="tarifas">'
			. $text .
		'</table>';

$total = str_replace('.', ',', $total);
$html .= '	<p><b>Valor total do or&ccedil;amento </b> : '. $country->currency  . ' '  . $total .'</p>
			<pagebreak />
				<p>Os preços informados são apenas para referência e podem variar de acordo com data de início,
				idade, tipo de acomodação, tipo de curso, duração, carga horária, tipo de visto, número de alunos por
				sala, etc.</p>				
				<p>Taxas adicionais para envio de remessas que são cobradas pelos bancos não estão inclusas no valor
				informado.</p>			
				<p>Todos os valores estão sujeitos à alteração e variação cambial sem aviso prévio. As datas de início
				possíveis de cada curso devem ser confirmadas antes da solicitação da matrícula. E o reembolso de
				valor em caso de desistência é de acordo com as normas da escola previstas no contrato.</p>
				<p>Toda a documentação de imigração e alfândega, incluindo vistos, é de responsabilidade exclusiva do
				viajante e deve ser providenciada o mais rápido possível.</p>
				<p>Para maiores informações e inscrição, entre em contato conosco. Será um prazer atendê-los em
				nossa agência!</p>
				<p>Connecting Borders</p>
				<p>Cuiabá, '  . date("d/m/Y") . '</p>
		</body>';

$footer = '<table width="100%" style="font-size: 13px;"><tr><td width="33%" style="text-align: center;">[www.connecting-borders.com]</td> <td width="33%" style="text-align: center;">[contact@connecting-borders.com]</td> <td width="33%" style="text-align: center;">[+55 65 33 21 17 38]</td></tr></table>';

$this->pdf->create($html, '', $footer, '', $footer);
$this->pdf->output_file();
exit;
?>
