<?
require('../fpdf/fpdf.php');


class PDF extends FPDF

{
   //Cabecera de página
   function Header()
   {

       $this->Image('../imagenes/Logo_fimc2.png',10,8,180,30);

      $this->SetFont('Arial','B',12);

      //$this->Cell(30,10,'Title',1,0,'C');

   }
   
   //Pie de página
   function Footer()
   {
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','',8);
    //Número de página
    $txt = "Otros servicios: Programas técnicos – cursos cortos y Programas tecnológicos (Tecnológica Autónoma del Pacifico)
    \n Info: 	Cel.3166288374    Whatsaap. 3164469532    Email:imcreativo@hotmail.com          www.imcreativo.edu.co ";
    $this->MultiCell(0,5,$txt,0,'C',false);
    	//$this->Cell(400,6,"Otros servicios: Programas técnicos – Cursos cortos y Programas tecnológicos ",0,0,'L',FALSE);
    	//$this->Cell(400,6,"Otros servicios: Programas técnicos – Cursos cortos y Programas tecnológicos ",0,0,'L',FALSE);
    	$this->Ln(1);
		//$this->Cell(180,6,"(Tecnológica Autónoma del Pacifico)	Info: 	Cel.3166288374    ",0,0,'L',false);
		//$this->Ln(1);
		//$this->Cell(180,6,"(Whatsaap. 3164469532    Email:imcreativo@hotmail.com          www.imcreativo.edu.co ",0,0,'L',false);
		$this->Ln(1);	    
    	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    
   }
   
   
	//Tabla simple
   function TablaSimple($header)
   {
    //Cabecera
    foreach($header as $col)
		$this->SetFont('Arial','',8);    
    	
    	$this->Cell(40,7,$col,1);
    	$this->Ln();
   	
      $this->Cell(40,5,"hola",1);
      $this->Cell(40,5,"hola2",1);
      $this->Cell(40,5,"hola3",1);
      $this->Cell(40,5,"hola4",1);
      $this->Ln();
      $this->Cell(40,5,"linea ",1);
      $this->Cell(80,5,"linea 2",1);
      $this->Cell(40,5,"linea 3",1);
      $this->Cell(80,5,"linea 4",1);
   }   
   
}



$pdf=new PDF();
//Títulos de las columnas
$header=array('Columna 1','Columna 2','Columna 3','Columna 4');
$pdf->AliasNbPages();
//Primera página
$pdf->AddPage();
$pdf->SetY(65);
//$pdf->AddPage();
$pdf->TablaSimple($header);
$pdf->SetFont('Times','',8);
$pdf->Output();





/*

//Creación del objeto de la clase heredada
$pdf=new PDF();
//Títulos de las columnas
$header=array('Columna 1','Columna 2','Columna 3','Columna 4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
//Aquí escribimos lo que deseamos mostrar...
$pdf->Output();
*/
?> 