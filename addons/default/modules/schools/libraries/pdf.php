<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf {
	
	private $ci;
	private $mpdf;
	private $name;
	
	function __contruct() {
		$this->ci = & get_instance();
	}
	
	/* Create the file
	 * 
	 * @param html The html of document
	 * @param header the html header of document
	 * @param footer the html footer of document
	 * @param headerEven The header of even pages of the document
	 * @param footerEven The footer of even pages of the document
	 */
	function create($html, $header = '', $footer = '', $headerEven =  '', $footerEven = '') {
		include 'mpdf/mpdf.php';
		$this->mpdf = new mPDF();
		if($header) {
			$this->mpdf->SetHTMLHeader($header);
		}
		if($headerEven) {
			$this->mpdf->SetHTMLHeader($headerEven, 'E');
		}
		if($footer) {
			$this->mpdf->SetHTMLFooter($footer);
		}
		if($footerEven) {
			$this->mpdf->SetHTMLFooter($footerEven, 'E');
		}
		$this->mpdf->WriteHTML($html);
	}
	
	/* Output the file */
	function output_file($filename = NULL) {
		if(!$filename){
			$this->mpdf->Output("OrçamentoConnectingBorders.pdf", "I");			
		} else {
			$this->name = $filename;
			$this->mpdf->Output('pdf/'.$filename, 'F');
		}
	}
	
	function get_file_name() {
		return $this -> name;
	}
	
	function setFooter($footer) {
		$this->mpdf->SetHTMLFooter($footer);
	}
}
