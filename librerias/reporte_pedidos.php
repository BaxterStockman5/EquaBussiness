<?php
ob_start(); // Iniciar el búfer de salida
require('./fpdf/fpdf.php');
require_once('../conexion.php');

// Verificar conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Crear clase personalizada para el PDF
class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image('../ebisnes.jpg', 10, 10, 25); // Asegúrate de que el logo sea PNG o JPG
        
        // Título
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(102, 0, 204); // Violeta corporativo
        $this->Cell(190, 10, utf8_decode(' Reporte de Pedidos'), 0, 1, 'C');
        
        // Subtítulo con la fecha
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(190, 7, utf8_decode('Empresa EquaBusiness | Fecha: ' . date('d/m/Y')), 0, 1, 'C');

        // Línea separadora
        $this->SetDrawColor(102, 0, 204);
        $this->SetLineWidth(1);
        $this->Line(10, 35, 200, 35);
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(102, 0, 204);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }
}

// Crear documento PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(5);

// Encabezados de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(0, 123, 255); // Azul corporativo
$pdf->SetTextColor(255, 255, 255); // Texto en blanco
$pdf->Cell(95, 10, 'Estado', 1, 0, 'C', true);
$pdf->Cell(95, 10, 'Cantidad', 1, 1, 'C', true);
$pdf->SetTextColor(0, 0, 0); // Texto negro

// Obtener datos de la base de datos
$query = "SELECT estado, COUNT(*) as cantidad FROM pedidos GROUP BY estado";
$result = mysqli_query($conexion, $query);

$pdf->SetFont('Arial', '', 12);
$fill = false; // Alternancia de colores en filas

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->SetFillColor(230, 204, 255); // Violeta claro para filas alternas
        $pdf->Cell(95, 10, utf8_decode(ucfirst($row['estado'])), 1, 0, 'C', $fill);
        $pdf->Cell(95, 10, $row['cantidad'], 1, 1, 'C', $fill);
        $fill = !$fill; // Alternar color de fila
    }
} else {
    $pdf->Cell(190, 10, 'No hay pedidos registrados', 1, 1, 'C');
}

// Pie de firma
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 10);
$pdf->SetFillColor(102, 0, 204);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(190, 10, utf8_decode('Firma del Responsable ______________________'), 0, 1, 'C', true);

mysqli_close($conexion);
ob_end_clean();

// Descargar PDF
$pdf->Output('D', 'reporte_pedidos.pdf');
exit;
?>
