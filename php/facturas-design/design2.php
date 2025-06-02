<?php
require_once('tcpdf/tcpdf.php');

class FacturaPDFAlternativo extends TCPDF {
    
    public function Header() {
        // Header limpio para control total
    }

    public function Footer() {
        // Footer con número de página elegante
        $this->SetY(-15);
        $this->SetFont('helvetica', '', 8);
        $this->SetTextColor(120, 120, 120);
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'C');
    }
}

function generarFacturaPDFAlternativo($datosFactura) {
    // Crear instancia PDF
    $pdf = new FacturaPDFAlternativo(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Configuración del documento
    $pdf->SetCreator('Sistema de Facturación Electrónica Premium');
    $pdf->SetAuthor('Media Soft Technology');
    $pdf->SetTitle('Factura Electrónica - Diseño Alternativo');
    $pdf->SetSubject('Comprobante Fiscal Electrónico');
    
    // Márgenes optimizados para más espacio
    $pdf->SetMargins(15, 12, 15);
    $pdf->SetAutoPageBreak(TRUE, 20);
    
    // Agregar página
    $pdf->AddPage();
    
    // Extraer datos dinámicamente
    $encabezado = $datosFactura['ECF']['Encabezado'];
    $emisor = $encabezado['Emisor'];
    $comprador = $encabezado['Comprador'];
    $totales = $encabezado['Totales'];
    $items = $datosFactura['ECF']['DetallesItems'];
    
    // Variables de layout compacto
    $pageWidth = $pdf->getPageWidth() - 30; // Márgenes de 15 a cada lado
    $startY = 18;
    
    // Colores del tema alternativo
    $colorPrimario = [41, 128, 185]; // Azul profesional
    $colorSecundario = [52, 73, 94]; // Gris azulado
    $colorAccento = [230, 240, 250]; // Azul muy claro
    
    // ==================== ENCABEZADO SUPERIOR CON BANDA DE COLOR ====================
    
    // Banda superior de color
    $pdf->SetFillColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    $pdf->Rect(0, 0, $pdf->getPageWidth(), 8, 'F');
    
    // Título principal centrado
    $pdf->SetXY(15, $startY);
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->SetTextColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    $pdf->Cell($pageWidth, 6, 'COMPROBANTE FISCAL ELECTRÓNICO', 0, 1, 'C');
    
    // Línea decorativa
    $pdf->SetDrawColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    $pdf->SetLineWidth(0.5);
    $pdf->Line(15, $startY + 8, 15 + $pageWidth, $startY + 8);
    
    // ==================== INFORMACIÓN PRINCIPAL EN LAYOUT HORIZONTAL ====================
    
    $infoY = $startY + 15;
    
    // === SECCIÓN IZQUIERDA: EMISOR ===
    $emisorWidth = $pageWidth * 0.45;
    
    // Cuadro del emisor
    $pdf->SetFillColor(250, 250, 250);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.2);
    $pdf->Rect(15, $infoY, $emisorWidth, 35, 'DF');
    
    // Logo del emisor
    $logoX = 18;
    $logoY = $infoY + 3;
    $logoSize = 20;
    
    if (isset($emisor['logoURL']) && !empty($emisor['logoURL'])) {
        if (strpos($emisor['logoURL'], 'data:image') === 0) {
            $imageData = explode(',', $emisor['logoURL']);
            if (count($imageData) == 2) {
                $imageContent = base64_decode($imageData[1]);
                $tempFile = tempnam(sys_get_temp_dir(), 'logo') . '.png';
                file_put_contents($tempFile, $imageContent);
                $pdf->Image($tempFile, $logoX, $logoY, $logoSize, 0, '', '', '', false, 300);
                unlink($tempFile);
            }
        } else {
            try {
                $pdf->Image($emisor['logoURL'], $logoX, $logoY, $logoSize, 0, '', '', '', false, 300);
            } catch (Exception $e) {
                $pdf->SetFillColor($colorAccento[0], $colorAccento[1], $colorAccento[2]);
                $pdf->Rect($logoX, $logoY, $logoSize, $logoSize, 'F');
                $pdf->SetXY($logoX + 3, $logoY + 8);
                $pdf->SetFont('helvetica', 'B', 6);
                $pdf->SetTextColor(100, 100, 100);
                $pdf->Cell($logoSize - 6, 4, 'LOGO', 0, 1, 'C');
            }
        }
    } else {
        $pdf->SetFillColor($colorAccento[0], $colorAccento[1], $colorAccento[2]);
        $pdf->Rect($logoX, $logoY, $logoSize, $logoSize, 'F');
        $pdf->SetXY($logoX + 2, $logoY + 6);
        $pdf->SetFont('helvetica', 'B', 5);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($logoSize - 4, 3, 'MEDIA SOFT', 0, 1, 'C');
        $pdf->SetX($logoX + 2);
        $pdf->Cell($logoSize - 4, 3, 'TECHNOLOGY', 0, 1, 'C');
    }
    
    // Información del emisor al lado del logo
    $textX = $logoX + $logoSize + 6;
    $textWidth = $emisorWidth - $logoSize - 12;
    
    $pdf->SetXY($textX, $logoY);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);
    $pdf->MultiCell($textWidth, 3, $emisor['RazonSocialEmisor'], 0, 'L');
    
    $pdf->SetFont('helvetica', '', 8);
    $pdf->SetTextColor(80, 80, 80);
    $pdf->SetX($textX);
    $pdf->MultiCell($textWidth, 3, $emisor['DireccionEmisor'], 0, 'L');
    
    $pdf->SetX($textX);
    $pdf->MultiCell($textWidth, 3, 'RNC: ' . $emisor['RNCEmisor'], 0, 'L');
    
    $pdf->SetX($textX);
    $pdf->MultiCell($textWidth, 3, 'Email: ' . $emisor['CorreoEmisor'], 0, 'L');
    
    // === SECCIÓN DERECHA: DATOS DEL COMPROBANTE ===
    $comprobanteX = 15 + $emisorWidth + 8;
    $comprobanteWidth = $pageWidth - $emisorWidth - 8;
    
    // Cuadro del comprobante con color de acento
    $pdf->SetFillColor($colorAccento[0], $colorAccento[1], $colorAccento[2]);
    $pdf->SetDrawColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    $pdf->SetLineWidth(0.3);
    $pdf->Rect($comprobanteX, $infoY, $comprobanteWidth, 35, 'DF');
    
    $pdf->SetXY($comprobanteX + 6, $infoY + 5);
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->SetTextColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    $pdf->Cell($comprobanteWidth - 12, 4, 'INFORMACIÓN FISCAL', 0, 1, 'C');
    
    // Línea separadora
    $pdf->SetDrawColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    $pdf->Line($comprobanteX + 6, $infoY + 12, $comprobanteX + $comprobanteWidth - 6, $infoY + 12);
    
    $pdf->SetFont('helvetica', '', 8);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->SetXY($comprobanteX + 6, $infoY + 15);
    $pdf->Cell($comprobanteWidth - 12, 3, 'e-NCF: E310000002211', 0, 1, 'L');
    
    $pdf->SetX($comprobanteX + 6);
    $pdf->Cell($comprobanteWidth - 12, 3, 'Fecha Emisión: ' . $emisor['FechaEmision'], 0, 1, 'L');
    
    $pdf->SetX($comprobanteX + 6);
    $pdf->Cell($comprobanteWidth - 12, 3, 'Fecha Vencimiento: 31-12-2025', 0, 1, 'L');
    
    $pdf->SetX($comprobanteX + 6);
    $pdf->Cell($comprobanteWidth - 12, 3, 'Tipo: Crédito Fiscal', 0, 1, 'L');
    
// ==================== DATOS DEL CLIENTE CON DISEÑO MODERNO ====================

$clienteY = $infoY + 40;

// Título de sección con fondo
$pdf->SetFillColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);
$pdf->Rect(15, $clienteY, $pageWidth, 6, 'F');

$pdf->SetXY(15, $clienteY + 1);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell($pageWidth, 4, '   INFORMACIÓN DEL CLIENTE', 0, 1, 'L');

// Contenido del cliente - ALTURA AUMENTADA PARA ACOMODAR MÁS LÍNEAS
$pdf->SetFillColor(255, 255, 255);
$pdf->SetDrawColor(220, 220, 220);
$pdf->SetLineWidth(0.2);
$pdf->Rect(15, $clienteY + 6, $pageWidth, 25, 'DF'); // Aumentado de 25 a 30

// Nombre del cliente
$pdf->SetXY(18, $clienteY + 9);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);
$pdf->Cell($pageWidth - 6, 4, $comprador['RazonSocialComprador'], 0, 1, 'L');

// LAYOUT EN UNA SOLA COLUMNA - SIN COLISIONES
$pdf->SetFont('helvetica', '', 8);
$pdf->SetTextColor(80, 80, 80);

// RNC en primera línea
$pdf->SetXY(18, $clienteY + 15);
$pdf->Cell($pageWidth - 6, 3, 'RNC: ' . $comprador['RNCComprador'], 0, 1, 'L');

// Dirección en segunda línea (si existe)
$direccion = '';
if (!empty($comprador['MunicipioComprador']) || !empty($comprador['ProvinciaComprador'])) {
    $direccionParts = array_filter([
        trim($comprador['MunicipioComprador']),
        trim($comprador['ProvinciaComprador'])
    ]);
    $direccion = implode(', ', $direccionParts);
}

if (!empty($direccion)) {
    $pdf->SetXY(18, $clienteY + 19);
    $pdf->Cell($pageWidth - 6, 3, 'Ubicación: ' . $direccion, 0, 1, 'L');
    
    // Email en tercera línea
    $pdf->SetXY(18, $clienteY + 23);
    $pdf->Cell($pageWidth - 6, 3, 'Email: ' . $comprador['CorreoComprador'], 0, 1, 'L');
} else {
    // Si no hay dirección, email en segunda línea
    $pdf->SetXY(18, $clienteY + 19);
    $pdf->Cell($pageWidth - 6, 3, 'Email: ' . $comprador['CorreoComprador'], 0, 1, 'L');
}
    
    // ==================== TABLA DE PRODUCTOS CON DISEÑO MODERNO ====================
    
    $tablaY = $clienteY + 35;
    
    // Título de sección
    $pdf->SetFillColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);
    $pdf->Rect(15, $tablaY, $pageWidth, 6, 'F');
    
    $pdf->SetXY(15, $tablaY + 1);
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell($pageWidth, 4, '   DETALLE DE PRODUCTOS Y SERVICIOS', 0, 1, 'L');
    
    // Encabezados de tabla
    $pdf->SetXY(15, $tablaY + 8);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetFillColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.2);
    
    // Anchos ajustados para caber en la página
    $colWidths = [75, 15, 25, 20, 20, 25]; // Total = 170
    $headers = ['Descripción', 'Cant.', 'Precio', 'Desc.', 'ITBIS', 'Total'];
    
    foreach ($headers as $i => $header) {
        $pdf->Cell($colWidths[$i], 7, $header, 1, 0, 'C', 1);
    }
    $pdf->Ln();
    
    // Filas de productos con alternancia de colores
    $pdf->SetFont('helvetica', '', 7);
    $pdf->SetTextColor(60, 60, 60);
    
    foreach ($items as $index => $item) {
        // Alternar color de fila
        if ($index % 2 == 0) {
            $pdf->SetFillColor(250, 250, 250);
        } else {
            $pdf->SetFillColor(255, 255, 255);
        }
        
        $montoItem = $item['MontoItem'];
        $cantidad = $item['CantidadItem'];
        $precioUnitario = $item['PrecioUnitarioItem'];
        
        // Cálculo de ITBIS
        $itbisItem = 0;
        if ($item['IndicadorFacturacion'] == 1) {
            $itbisItem = $montoItem * ($totales['ITBIS1'] / 100);
        }
        
        $totalItem = $montoItem + $itbisItem;
        
        // Nombre del producto truncado para caber
        $nombreProducto = strlen($item['NombreItem']) > 60 ? 
                         substr($item['NombreItem'], 0, 60) . '...' : 
                         $item['NombreItem'];
        
        $pdf->SetX(15);
        $pdf->Cell($colWidths[0], 6, $nombreProducto, 1, 0, 'L', 1);
        $pdf->Cell($colWidths[1], 6, $cantidad, 1, 0, 'C', 1);
        $pdf->Cell($colWidths[2], 6, 'RD$' . number_format($precioUnitario, 2), 1, 0, 'R', 1);
        $pdf->Cell($colWidths[3], 6, 'RD$0.00', 1, 0, 'R', 1);
        $pdf->Cell($colWidths[4], 6, 'RD$' . number_format($itbisItem, 2), 1, 0, 'R', 1);
        $pdf->Cell($colWidths[5], 6, 'RD$' . number_format($totalItem, 2), 1, 1, 'R', 1);
    }
    
    // ==================== SECCIÓN INFERIOR CON RESUMEN Y QR ====================
    
    $resumenY = $pdf->GetY() + 10;
    
    // === LADO IZQUIERDO: QR Y CÓDIGOS ===
    $qrX = 15;
    $qrWidth = $pageWidth * 0.4;
    
    // Cuadro para QR
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetDrawColor(220, 220, 220);
    $pdf->SetLineWidth(0.2);
    $pdf->Rect($qrX, $resumenY, $qrWidth, 55, 'DF');
    
    // Título del QR
    $pdf->SetXY($qrX + 3, $resumenY + 3);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);
    $pdf->Cell($qrWidth - 6, 4, 'VALIDACIÓN DIGITAL', 0, 1, 'C');
    
    // QR centrado
    $qrSize = 30;
    $qrCenterX = $qrX + ($qrWidth - $qrSize) / 2;
    $qrCenterY = $resumenY + 10;
    
    // Generar QR real
    $codigoSeguridad = 'Rg7zr1';
    $fechaFirma = '26-05-2025 02:08:06';
    $qrData = "Código: {$codigoSeguridad}\nFecha: {$fechaFirma}\nRNC: {$emisor['RNCEmisor']}\ne-NCF: E310000002211";
    
    try {
        $qrDataEncoded = urlencode($qrData);
        $qrSize_px = $qrSize * 10;
        $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size={$qrSize_px}x{$qrSize_px}&data={$qrDataEncoded}";
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'Mozilla/5.0 (compatible; PDF Generator)'
            ]
        ]);
        
        $qrImageData = file_get_contents($qrApiUrl, false, $context);
        
        if ($qrImageData !== false) {
            $tempQrFile = tempnam(sys_get_temp_dir(), 'qr') . '.png';
            file_put_contents($tempQrFile, $qrImageData);
            $pdf->Image($tempQrFile, $qrCenterX, $qrCenterY, $qrSize, $qrSize, 'PNG');
            if (file_exists($tempQrFile)) {
                unlink($tempQrFile);
            }
        } else {
            throw new Exception('No se pudo generar QR');
        }
        
    } catch (Exception $e) {
        // QR simulado de fallback
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Rect($qrCenterX, $qrCenterY, $qrSize, $qrSize, 'F');
        $pdf->SetXY($qrCenterX + 8, $qrCenterY + 12);
        $pdf->SetFont('helvetica', '', 7);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($qrSize - 16, 3, 'QR CODE', 0, 1, 'C');
    }
    
    // Información de validación
    $pdf->SetXY($qrX + 3, $qrCenterY + $qrSize + 3);
    $pdf->SetFont('helvetica', '', 6);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->Cell($qrWidth - 6, 2, 'Código: ' . $codigoSeguridad, 0, 1, 'C');
    $pdf->SetX($qrX + 3);
    $pdf->Cell($qrWidth - 6, 2, 'Firma: ' . $fechaFirma, 0, 1, 'C');
    
    // === LADO DERECHO: RESUMEN DE TOTALES ===
    $totalesX = $qrX + $qrWidth + 8;
    $totalesWidth = $pageWidth - $qrWidth - 8;
    
    // Cuadro de totales con estilo premium
    $pdf->SetFillColor($colorAccento[0], $colorAccento[1], $colorAccento[2]);
    $pdf->SetDrawColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    $pdf->SetLineWidth(0.3);
    $pdf->Rect($totalesX, $resumenY, $totalesWidth, 55, 'DF');
    
    // Título de totales
    $pdf->SetXY($totalesX + 4, $resumenY + 3);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetTextColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    $pdf->Cell($totalesWidth - 8, 4, 'RESUMEN FINANCIERO', 0, 1, 'C');
    
    // Línea decorativa
    $pdf->SetDrawColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    $pdf->Line($totalesX + 8, $resumenY + 10, $totalesX + $totalesWidth - 8, $resumenY + 10);
    
    // Totales con mejor presentación
    $pdf->SetXY($totalesX + 6, $resumenY + 14);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->SetTextColor(70, 70, 70);
    
    $subtotalBrutoTotal = $totales['MontoGravadoTotal'] + $totales['MontoExento'];
    
    $totalesData = [
        ['Subtotal Bruto:', 'RD$' . number_format($subtotalBrutoTotal, 2)],
        ['Monto Exento:', 'RD$' . number_format($totales['MontoExento'], 2)],
        ['Base Gravable:', 'RD$' . number_format($totales['MontoGravadoTotal'], 2)],
        ['ITBIS (18%):', 'RD$' . number_format($totales['TotalITBIS'], 2)]
    ];
    
    foreach ($totalesData as $row) {
        $pdf->Cell(($totalesWidth - 12) * 0.6, 4, $row[0], 0, 0, 'L');
        $pdf->Cell(($totalesWidth - 12) * 0.4, 4, $row[1], 0, 1, 'R');
        $pdf->SetX($totalesX + 6);
    }
    
    // Total final destacado
    $currentY = $pdf->GetY() + 3;
    $pdf->SetFillColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    $pdf->Rect($totalesX + 6, $currentY, $totalesWidth - 12, 8, 'F');
    
    $pdf->SetXY($totalesX + 6, $currentY + 1);
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(($totalesWidth - 12) * 0.6, 6, 'TOTAL A PAGAR:', 0, 0, 'L');
    $pdf->Cell(($totalesWidth - 12) * 0.4, 6, 'RD$' . number_format($totales['MontoTotal'], 2), 0, 1, 'R');
    
    return $pdf;
}

// Función de procesamiento alternativa
function procesarFacturaAlternativa($datosArray, $outputMode = 'I') {
    try {
        $pdf = generarFacturaPDFAlternativo($datosArray);
        $emisor = $datosArray['ECF']['Encabezado']['Emisor'];
        $nombreArchivo = 'factura_alternativa_' . $emisor['RNCEmisor'] . '_' . date('Y-m-d_H-i-s') . '.pdf';
        
        $pdf->Output($nombreArchivo, $outputMode);
        return ['success' => true, 'filename' => $nombreArchivo];
        
    } catch (Exception $e) {
        error_log("Error generando factura alternativa: " . $e->getMessage());
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

// Datos de prueba
$datosFactura = [
    'ECF' => [
        'Encabezado' => [
            'IdDoc' => [
                'TipoeCF' => 31,
                'IndicadorMontoGravado' => 0,
                'TipoIngresos' => '01',
                'TipoPago' => 1
            ],
            'Emisor' => [
                'logoURL' => 'https://media.licdn.com/dms/image/v2/C560BAQG_98SK1P7y2Q/company-logo_200_200/company-logo_200_200/0/1630627553683?e=2147483647&v=beta&t=IVKZ4Bn8wOgoP-ygF7a9_ESBnh7Jsa2mpr_5y3If1hc',
                'RNCEmisor' => '132596161',
                'RazonSocialEmisor' => 'Prueba Facturación Electrónica',
                'NombreComercial' => 'Prueba Facturación Electrónica',
                'DireccionEmisor' => 'Av. San Vicente de Paul, Esq. Puerto Rico, Baro Plaza 3er nivel #14',
                'Municipio' => '010101',
                'Provincia' => '010000',
                'CorreoEmisor' => 'info@mediasoft.do',
                'FechaEmision' => '26-05-2025'
            ],
            'Comprador' => [
                'RNCComprador' => '101601175',
                'RazonSocialComprador' => 'FRITO-LAY DOMINICANA SA',
                'MunicipioComprador' => 'Santo Domingo Este',
                'ProvinciaComprador' => 'Santo Domingo',
                'CorreoComprador' => 'comercial@mediasoft.do'
            ],
            'Totales' => [
                'MontoGravadoTotal' => 2000,
                'MontoGravadoI1' => 2000,
                'MontoExento' => 3500,
                'ITBIS1' => 18,
                'TotalITBIS' => 305.08,
                'TotalITBIS1' => 305.08,
                'MontoTotal' => 5805.08
            ]
        ],
        'DetallesItems' => [
            [
                'NumeroLinea' => 1,
                'IndicadorFacturacion' => 1,
                'NombreItem' => 'Soporte Técnico | Licencia de software',
                'IndicadorBienoServicio' => 2,
                'CantidadItem' => 1,
                'UnidadMedida' => 43,
                'PrecioUnitarioItem' => 1000,
                'MontoItem' => 1000
            ],
            [
                'NumeroLinea' => 2,
                'IndicadorFacturacion' => 1,
                'NombreItem' => 'Soporte Técnico | Licencia de software',
                'IndicadorBienoServicio' => 2,
                'CantidadItem' => 1,
                'UnidadMedida' => 43,
                'PrecioUnitarioItem' => 1000,
                'MontoItem' => 1000
            ],
            [
                'NumeroLinea' => 3,
                'IndicadorFacturacion' => 4,
                'NombreItem' => 'Licencia de software prestan2 1-100 plan emprendedor | Licencia de software',
                'IndicadorBienoServicio' => 2,
                'CantidadItem' => 1,
                'UnidadMedida' => 43,
                'PrecioUnitarioItem' => 1500,
                'MontoItem' => 1500
            ],
            [
                'NumeroLinea' => 4,
                'IndicadorFacturacion' => 4,
                'NombreItem' => 'Servicio de seguridad privada Nocturno / Hora | Licencia de software',
                'IndicadorBienoServicio' => 2,
                'CantidadItem' => 1,
                'UnidadMedida' => 43,
                'PrecioUnitarioItem' => 2000,
                'MontoItem' => 2000
            ]
        ]
    ]
];

// Ejecutar factura alternativa
$resultado = procesarFacturaAlternativa($datosFactura, 'I');

?>