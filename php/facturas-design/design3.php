<?php
require_once('tcpdf/tcpdf.php');

class FacturaPDFModerno extends TCPDF {
    
    public function Header() {
        // Header completamente limpio
    }

    public function Footer() {
        // Footer minimalista con línea
        $this->SetY(-12);
        $this->SetDrawColor(220, 220, 220);
        $this->Line(15, $this->GetY() - 2, $this->getPageWidth() - 15, $this->GetY() - 2);
        $this->SetFont('helvetica', '', 6);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 8, 'Comprobante Fiscal Electrónico - Página ' . $this->getAliasNumPage(), 0, false, 'C');
    }
}

function generarFacturaPDFModerno($datosFactura) {
    // Crear instancia PDF
    $pdf = new FacturaPDFModerno(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Configuración del documento
    $pdf->SetCreator('Sistema de Facturación Electrónica Moderna');
    $pdf->SetAuthor('Media Soft Technology');
    $pdf->SetTitle('Factura Electrónica - Diseño Moderno');
    $pdf->SetSubject('Comprobante Fiscal Electrónico');
    
    // Márgenes reducidos para más espacio
    $pdf->SetMargins(15, 12, 15);
    $pdf->SetAutoPageBreak(TRUE, 18);
    
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
    $startY = 15;
    
    // Paleta de colores minimalista
    $colorPrincipal = [45, 55, 72]; // Gris azulado oscuro
    $colorAccento = [99, 102, 241]; // Índigo moderno
    $colorSutil = [243, 244, 246]; // Gris muy claro
    $colorTextoSecundario = [107, 114, 128]; // Gris medio
    
    // ==================== ENCABEZADO MINIMALISTA ====================
    
    // Logo y título en la misma línea - COMPACTO
    $logoSize = 22; // Reducido de 28 a 22
    $logoX = 15;
    $logoY = $startY;
    
    // Logo del emisor
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
                // Logo placeholder moderno
                $pdf->SetFillColor($colorSutil[0], $colorSutil[1], $colorSutil[2]);
                $pdf->SetDrawColor($colorAccento[0], $colorAccento[1], $colorAccento[2]);
                $pdf->SetLineWidth(0.5);
                $pdf->Rect($logoX, $logoY, $logoSize, $logoSize, 'DF');
                $pdf->SetXY($logoX + 3, $logoY + 8);
                $pdf->SetFont('helvetica', 'B', 6);
                $pdf->SetTextColor($colorAccento[0], $colorAccento[1], $colorAccento[2]);
                $pdf->Cell($logoSize - 6, 3, 'LOGO', 0, 1, 'C');
            }
        }
    } else {
        // Logo placeholder moderno
        $pdf->SetFillColor($colorSutil[0], $colorSutil[1], $colorSutil[2]);
        $pdf->SetDrawColor($colorAccento[0], $colorAccento[1], $colorAccento[2]);
        $pdf->SetLineWidth(0.5);
        $pdf->Rect($logoX, $logoY, $logoSize, $logoSize, 'DF');
        $pdf->SetXY($logoX + 2, $logoY + 6);
        $pdf->SetFont('helvetica', 'B', 5);
        $pdf->SetTextColor($colorAccento[0], $colorAccento[1], $colorAccento[2]);
        $pdf->Cell($logoSize - 4, 3, 'MEDIA SOFT', 0, 1, 'C');
        $pdf->SetX($logoX + 2);
        $pdf->Cell($logoSize - 4, 3, 'TECHNOLOGY', 0, 1, 'C');
    }
    
    // Título y número de factura en el lado derecho - REDUCIDO
    $pdf->SetXY($logoX + $logoSize + 10, $startY);
    $pdf->SetFont('helvetica', 'B', 15); // Reducido de 18 a 15
    $pdf->SetTextColor($colorPrincipal[0], $colorPrincipal[1], $colorPrincipal[2]);
    $pdf->Cell(0, 6, 'FACTURA', 0, 1, 'R');
    
    $pdf->SetXY($logoX + $logoSize + 10, $startY + 8);
    $pdf->SetFont('helvetica', '', 8); // Reducido de 10 a 8
    $pdf->SetTextColor($colorTextoSecundario[0], $colorTextoSecundario[1], $colorTextoSecundario[2]);
    $pdf->Cell(0, 4, 'Fecha de Emisión: ' . $emisor['FechaEmision'], 0, 1, 'R'); 
    
    // ==================== INFORMACIÓN DE FACTURA EN CARDS ====================
    
    $cardsY = $startY + 28; // Reducido espaciado
    $cardHeight = 35; // Reducido de 75 a 60
    $cardSpacing = 8; // Reducido de 10 a 8
    
    // === CARD 1: INFORMACIÓN DEL EMISOR ===
    $card1X = 15;
    $card1Width = ($pageWidth - $cardSpacing) / 2;
    
    // Fondo del card con sombra sutil
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetDrawColor(230, 230, 230);
    $pdf->SetLineWidth(0.2);
    $pdf->Rect($card1X, $cardsY, $card1Width, $cardHeight, 'DF');
    
    // Título del card - PADDING REDUCIDO
    $pdf->SetXY($card1X + 5, $cardsY + 5); // Reducido padding de 8 a 5
    $pdf->SetFont('helvetica', 'B', 8); // Reducido de 9 a 8
    $pdf->SetTextColor($colorPrincipal[0], $colorPrincipal[1], $colorPrincipal[2]);
    $pdf->Cell(0, 4, 'DE:', 0, 1, 'L');
    
    // Contenido del emisor
    $pdf->SetFont('helvetica', 'B', 9); // Reducido de 11 a 9
    $pdf->SetTextColor($colorPrincipal[0], $colorPrincipal[1], $colorPrincipal[2]);
    $pdf->SetX($card1X + 5);
    $pdf->MultiCell($card1Width - 10, 3, $emisor['RazonSocialEmisor'], 0, 'L');
    
    $pdf->SetFont('helvetica', '', 7); // Reducido de 8 a 7
    $pdf->SetTextColor($colorTextoSecundario[0], $colorTextoSecundario[1], $colorTextoSecundario[2]);
    $pdf->SetX($card1X + 5);
    $pdf->MultiCell($card1Width - 10, 3, $emisor['DireccionEmisor'], 0, 'L');
    
    $pdf->SetX($card1X + 5);
    $pdf->Cell(0, 3, 'RNC: ' . $emisor['RNCEmisor'], 0, 1, 'L');
    
    $pdf->SetX($card1X + 5);
    $pdf->Cell(0, 3, $emisor['CorreoEmisor'], 0, 1, 'L');
    
    // === CARD 2: INFORMACIÓN DE LA FACTURA ===
    $card2X = $card1X + $card1Width + $cardSpacing;
    $card2Width = $card1Width;
    
    // Fondo del card
    $pdf->SetFillColor($colorSutil[0], $colorSutil[1], $colorSutil[2]);
    $pdf->SetDrawColor(230, 230, 230);
    $pdf->SetLineWidth(0.2);
    $pdf->Rect($card2X, $cardsY, $card2Width, $cardHeight, 'DF');
    
    // Título del card
    $pdf->SetXY($card2X + 5, $cardsY + 5);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetTextColor($colorPrincipal[0], $colorPrincipal[1], $colorPrincipal[2]);
    $pdf->Cell(0, 4, 'DETALLES DE FACTURA:', 0, 1, 'L');
    
    // Contenido de la factura
    $pdf->SetFont('helvetica', '', 7); // Reducido de 9 a 7
    $pdf->SetTextColor($colorTextoSecundario[0], $colorTextoSecundario[1], $colorTextoSecundario[2]);
    
    $facturaInfo = [
        'e-NCF: E310000002211',
        'Fecha de Vencimiento: 31-12-2025',
        'Tipo: Crédito Fiscal'
    ];
    
    $lineY = $cardsY + 14;
    foreach ($facturaInfo as $info) {
        $pdf->SetXY($card2X + 5, $lineY);
        $pdf->Cell(0, 3, $info, 0, 1, 'L');
        $lineY += 5; // Reducido espaciado
    }
    
    // ==================== CLIENTE CON DISEÑO MODERNO ====================
    
    $clienteY = $cardsY + $cardHeight + 5; // Reducido espaciado
    
    // Título con línea decorativa
    $pdf->SetXY(15, $clienteY);
    $pdf->SetFont('helvetica', 'B', 8); // Reducido de 10 a 8
    $pdf->SetTextColor($colorPrincipal[0], $colorPrincipal[1], $colorPrincipal[2]);
    $pdf->Cell(0, 5, 'FACTURAR A:', 0, 1, 'L');
    
    // Línea decorativa debajo del título
    $pdf->SetDrawColor($colorAccento[0], $colorAccento[1], $colorAccento[2]);
    $pdf->SetLineWidth(1.5); // Reducido grosor
    $pdf->Line(15, $clienteY + 6, 50, $clienteY + 6); // Línea más corta
    
    // Información del cliente en layout limpio
    $pdf->SetXY(15, $clienteY + 12);
    $pdf->SetFont('helvetica', 'B', 10); // Reducido de 12 a 10
    $pdf->SetTextColor($colorPrincipal[0], $colorPrincipal[1], $colorPrincipal[2]);
    $pdf->Cell(0, 5, $comprador['RazonSocialComprador'], 0, 1, 'L');
    
    $pdf->SetFont('helvetica', '', 7); // Reducido de 9 a 7
    $pdf->SetTextColor($colorTextoSecundario[0], $colorTextoSecundario[1], $colorTextoSecundario[2]);
    
    // Información en líneas separadas
    $pdf->SetX(15);
    $pdf->Cell(0, 3, 'RNC: ' . $comprador['RNCComprador'], 0, 1, 'L');
    
    // Dirección si existe
    $direccion = '';
    if (!empty($comprador['MunicipioComprador']) || !empty($comprador['ProvinciaComprador'])) {
        $direccionParts = array_filter([
            trim($comprador['MunicipioComprador']),
            trim($comprador['ProvinciaComprador'])
        ]);
        $direccion = implode(', ', $direccionParts);
    }
    
    if (!empty($direccion)) {
        $pdf->SetX(15);
        $pdf->Cell(0, 3, 'Ubicación: ' . $direccion, 0, 1, 'L');
    }
    
    $pdf->SetX(15);
    $pdf->Cell(0, 3, 'Email: ' . $comprador['CorreoComprador'], 0, 1, 'L');
    
    // ==================== TABLA MODERNA Y MINIMALISTA ====================
    
    $tablaY = $pdf->GetY() + 15; // Reducido espaciado
    
    // Encabezados con diseño moderno
    $pdf->SetXY(15, $tablaY);
    $pdf->SetFont('helvetica', 'B', 7); // Reducido de 9 a 7
    $pdf->SetFillColor($colorPrincipal[0], $colorPrincipal[1], $colorPrincipal[2]);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetDrawColor($colorPrincipal[0], $colorPrincipal[1], $colorPrincipal[2]);
    $pdf->SetLineWidth(0.3);
    
    // Anchos ajustados para caber en página
    $colWidths = [70, 18, 26, 22, 22, 26]; // Total = 184 (reducido de 210)
    $headers = ['Descripción', 'Cant.', 'Precio', 'Desc.', 'ITBIS', 'Total'];
    
    foreach ($headers as $i => $header) {
        $pdf->Cell($colWidths[$i], 8, $header, 1, 0, 'C', 1);
    }
    $pdf->Ln();
    
    // Filas con diseño alternado moderno
    $pdf->SetFont('helvetica', '', 7); // Reducido de 8 a 7
    $pdf->SetTextColor($colorPrincipal[0], $colorPrincipal[1], $colorPrincipal[2]);
    $pdf->SetDrawColor(240, 240, 240);
    $pdf->SetLineWidth(0.1);
    
    foreach ($items as $index => $item) {
        // Alternar colores
        if ($index % 2 == 0) {
            $pdf->SetFillColor(255, 255, 255);
        } else {
            $pdf->SetFillColor(252, 252, 252);
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
        
        // Nombre del producto - MÁS CORTO
        $nombreProducto = strlen($item['NombreItem']) > 45 ? 
                         substr($item['NombreItem'], 0, 42) . '...' : 
                         $item['NombreItem'];
        
        $pdf->SetX(15);
        $pdf->Cell($colWidths[0], 7, $nombreProducto, 1, 0, 'L', 1);
        $pdf->Cell($colWidths[1], 7, $cantidad, 1, 0, 'C', 1);
        $pdf->Cell($colWidths[2], 7, 'RD$' . number_format($precioUnitario, 2), 1, 0, 'R', 1);
        $pdf->Cell($colWidths[3], 7, 'RD$0.00', 1, 0, 'R', 1);
        $pdf->Cell($colWidths[4], 7, 'RD$' . number_format($itbisItem, 2), 1, 0, 'R', 1);
        $pdf->Cell($colWidths[5], 7, 'RD$' . number_format($totalItem, 2), 1, 1, 'R', 1);
    }
    
    // ==================== RESUMEN FINAL MODERNO ====================
    
    $resumenY = $pdf->GetY() + 12; // Reducido espaciado
    
    // === COLUMNA IZQUIERDA: QR Y VALIDACIÓN ===
    $qrSectionWidth = $pageWidth * 0.45;
    
    // Título de validación
    $pdf->SetXY(15, $resumenY);
    $pdf->SetFont('helvetica', 'B', 8); // Reducido de 10 a 8
    $pdf->SetTextColor($colorPrincipal[0], $colorPrincipal[1], $colorPrincipal[2]);
    $pdf->Cell(0, 5, 'VALIDACIÓN DIGITAL', 0, 1, 'L');
    
    // Línea decorativa
    $pdf->SetDrawColor($colorAccento[0], $colorAccento[1], $colorAccento[2]);
    $pdf->SetLineWidth(1.5);
    $pdf->Line(15, $resumenY + 6, 65, $resumenY + 6);
    
    // QR Code - MÁS PEQUEÑO
    $qrSize = 32; // Reducido de 40 a 32
    $qrX = 25;
    $qrY = $resumenY + 12;
    
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
            $pdf->Image($tempQrFile, $qrX, $qrY, $qrSize, $qrSize, 'PNG');
            if (file_exists($tempQrFile)) {
                unlink($tempQrFile);
            }
        } else {
            throw new Exception('No se pudo generar QR');
        }
        
    } catch (Exception $e) {
        // QR fallback moderno
        $pdf->SetFillColor($colorSutil[0], $colorSutil[1], $colorSutil[2]);
        $pdf->SetDrawColor($colorAccento[0], $colorAccento[1], $colorAccento[2]);
        $pdf->SetLineWidth(0.5);
        $pdf->Rect($qrX, $qrY, $qrSize, $qrSize, 'DF');
        $pdf->SetXY($qrX + 6, $qrY + 12);
        $pdf->SetFont('helvetica', 'B', 6);
        $pdf->SetTextColor($colorAccento[0], $colorAccento[1], $colorAccento[2]);
        $pdf->Cell($qrSize - 12, 5, 'QR CODE', 0, 1, 'C');
    }
    
    // Información de validación
    $pdf->SetXY(15, $qrY + $qrSize + 5);
    $pdf->SetFont('helvetica', '', 6);
    $pdf->SetTextColor($colorTextoSecundario[0], $colorTextoSecundario[1], $colorTextoSecundario[2]);
    $pdf->Cell(0, 2, 'Código de Seguridad: ' . $codigoSeguridad, 0, 1, 'L');
    $pdf->SetX(15);
    $pdf->Cell(0, 2, 'Fecha de Firma: ' . $fechaFirma, 0, 1, 'L');
    
    // === COLUMNA DERECHA: TOTALES MODERNOS ===
    $totalesX = 15 + $qrSectionWidth + 10;
    $totalesWidth = $pageWidth - $qrSectionWidth - 10;
    
    // Título de totales
    $pdf->SetXY($totalesX, $resumenY);
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->SetTextColor($colorPrincipal[0], $colorPrincipal[1], $colorPrincipal[2]);
    $pdf->Cell(0, 5, 'RESUMEN', 0, 1, 'R');
    
    // Línea decorativa
    $pdf->SetDrawColor($colorAccento[0], $colorAccento[1], $colorAccento[2]);
    $pdf->SetLineWidth(1.5);
    $pdf->Line($totalesX + 50, $resumenY + 6, $totalesX + $totalesWidth, $resumenY + 6);
    
    // Cálculos de totales
    $subtotalBrutoTotal = $totales['MontoGravadoTotal'] + $totales['MontoExento'];
    
    $totalesData = [
        ['Subtotal:', 'RD$' . number_format($subtotalBrutoTotal, 2)],
        ['Exento:', 'RD$' . number_format($totales['MontoExento'], 2)],
        ['Base Gravable:', 'RD$' . number_format($totales['MontoGravadoTotal'], 2)],
        ['ITBIS (18%):', 'RD$' . number_format($totales['TotalITBIS'], 2)]
    ];
    
    // Mostrar totales con estilo moderno
    $lineY = $resumenY + 15;
    $pdf->SetFont('helvetica', '', 7); // Reducido de 9 a 7
    $pdf->SetTextColor($colorTextoSecundario[0], $colorTextoSecundario[1], $colorTextoSecundario[2]);
    
    foreach ($totalesData as $row) {
        $pdf->SetXY($totalesX, $lineY);
        $pdf->Cell($totalesWidth * 0.6, 4, $row[0], 0, 0, 'L');
        $pdf->Cell($totalesWidth * 0.4, 4, $row[1], 0, 1, 'R');
        $lineY += 5;
    }
    
    // Total final destacado - MÁS COMPACTO
    $pdf->SetFillColor($colorAccento[0], $colorAccento[1], $colorAccento[2]);
    $pdf->Rect($totalesX, $lineY + 3, $totalesWidth, 10, 'F'); // Reducido altura
    
    $pdf->SetXY($totalesX + 3, $lineY + 6);
    $pdf->SetFont('helvetica', 'B', 9); // Reducido de 11 a 9
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(($totalesWidth - 6) * 0.6, 4, 'TOTAL A PAGAR:', 0, 0, 'L');
    $pdf->Cell(($totalesWidth - 6) * 0.4, 4, 'RD$' . number_format($totales['MontoTotal'], 2), 0, 1, 'R');
    
    return $pdf;
}

// Función de procesamiento moderno
function procesarFacturaModerna($datosArray, $outputMode = 'I') {
    try {
        $pdf = generarFacturaPDFModerno($datosArray);
        $emisor = $datosArray['ECF']['Encabezado']['Emisor'];
        $nombreArchivo = 'factura_moderna_' . $emisor['RNCEmisor'] . '_' . date('Y-m-d_H-i-s') . '.pdf';
        
        $pdf->Output($nombreArchivo, $outputMode);
        return ['success' => true, 'filename' => $nombreArchivo];
        
    } catch (Exception $e) {
        error_log("Error generando factura moderna: " . $e->getMessage());
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

// Ejecutar factura moderna
$resultado = procesarFacturaModerna($datosFactura, 'I');

?>