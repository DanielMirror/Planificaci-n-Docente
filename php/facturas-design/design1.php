<?php
require_once('tcpdf/tcpdf.php');

class FacturaPDFGenerator extends TCPDF {
    
    public function Header() {
        // Header completamente limpio
    }

    public function Footer() {
        // Footer limpio
    }
}

function generarFacturaPDF($datosFactura) {
    // Crear instancia PDF
    $pdf = new FacturaPDFGenerator(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Configuración del documento
    $pdf->SetCreator('Sistema de Facturación Electrónica');
    $pdf->SetAuthor('Media Soft Technology');
    $pdf->SetTitle('Comprobante Fiscal Electrónico');
    $pdf->SetSubject('Factura Electrónica');
    
    // Márgenes reducidos según especificaciones
    $pdf->SetMargins(12, 10, 12); // Margen superior menor a 20px
    $pdf->SetAutoPageBreak(false);
    
    // Agregar página
    $pdf->AddPage();
    
    // Extraer datos dinámicamente
    $encabezado = $datosFactura['ECF']['Encabezado'];
    $emisor = $encabezado['Emisor'];
    $comprador = $encabezado['Comprador'];
    $totales = $encabezado['Totales'];
    $items = $datosFactura['ECF']['DetallesItems'];
    
    // Variables de layout compacto
    $pageWidth = $pdf->getPageWidth() - 24; // Márgenes izquierdo y derecho
    $leftColumnWidth = $pageWidth * 0.6;
    $rightColumnWidth = $pageWidth * 0.35;
    $spacing = 8;
    
    // Configuración de bordes y colores neutros
    $pdf->SetDrawColor(180, 180, 180); // Gris claro para bordes
    $pdf->SetLineWidth(0.3);
    
    // ==================== ENCABEZADO - MUY CERCA DEL BORDE SUPERIOR ====================
    
    $startY = 12; // Muy cerca del borde superior
    
    // === COLUMNA IZQUIERDA: DATOS DEL EMISOR (alineado al borde izquierdo) ===
    
    $logoX = 12;
    $logoY = $startY;
    $logoWidth = 35;
    $logoHeight = 30;
    
    // Logo del emisor
    if (isset($emisor['logoURL']) && !empty($emisor['logoURL'])) {
        if (strpos($emisor['logoURL'], 'data:image') === 0) {
            // Procesar base64
            $imageData = explode(',', $emisor['logoURL']);
            if (count($imageData) == 2) {
                $imageContent = base64_decode($imageData[1]);
                $tempFile = tempnam(sys_get_temp_dir(), 'logo') . '.png';
                file_put_contents($tempFile, $imageContent);
                $pdf->Image($tempFile, $logoX, $logoY, $logoWidth, $logoHeight, '', '', '', false, 300);
                unlink($tempFile);
            }
        } else {
            // URL directa
            try {
                $pdf->Image($emisor['logoURL'], $logoX, $logoY, $logoWidth, $logoHeight, '', '', '', false, 300);
            } catch (Exception $e) {
                // Placeholder si falla
                $pdf->SetFillColor(245, 245, 245);
                $pdf->Rect($logoX, $logoY, $logoWidth, $logoHeight, 'F');
                $pdf->SetXY($logoX + 5, $logoY + 12);
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->SetTextColor(100, 100, 100);
                $pdf->Cell($logoWidth - 10, 6, 'LOGO', 0, 1, 'C');
            }
        }
    } else {
        // Placeholder por defecto
        $pdf->SetFillColor(245, 245, 245);
        $pdf->Rect($logoX, $logoY, $logoWidth, $logoHeight, 'F');
        $pdf->SetXY($logoX + 2, $logoY + 10);
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($logoWidth - 4, 4, 'MEDIA SOFT', 0, 1, 'C');
        $pdf->SetX($logoX + 2);
        $pdf->Cell($logoWidth - 4, 4, 'TECHNOLOGY', 0, 1, 'C');
    }
    
    // Información del emisor con espaciado mínimo (2px entre líneas) - MULTICELL PARA DIVIDIR TEXTO
    $textX = $logoX + $logoWidth + 8;
    $textY = $startY + 2;
    $textWidth = $leftColumnWidth - $logoWidth - 12;
    
    $pdf->SetXY($textX, $textY);
    $pdf->SetFont('helvetica', 'B', 11); // Roboto simulado con Helvetica
    $pdf->SetTextColor(30, 30, 30); // Gris oscuro
    $pdf->MultiCell($textWidth, 4, $emisor['RazonSocialEmisor'], 0, 'L');
    
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->SetX($textX);
    $pdf->MultiCell($textWidth, 3, $emisor['DireccionEmisor'], 0, 'L');
    
    $pdf->SetX($textX);
    $pdf->MultiCell($textWidth, 3, 'RNC: ' . $emisor['RNCEmisor'], 0, 'L');
    
    $pdf->SetX($textX);
    $pdf->MultiCell($textWidth, 3, 'Email: ' . $emisor['CorreoEmisor'], 0, 'L');
    
    // === COLUMNA DERECHA: COMPROBANTE FISCAL (cuadro discreto, centrado verticalmente) ===
    
    $rightX = 12 + $leftColumnWidth + $spacing;
    $rightY = $startY + 5; // Centrado verticalmente respecto al logo
    $rightHeight = 35;
    
    // Cuadro discreto con borde gris claro y padding compacto
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.5);
    $pdf->Rect($rightX, $rightY, $rightColumnWidth, $rightHeight, 'DF');
    
    $pdf->SetXY($rightX + 6, $rightY + 4);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetTextColor(30, 30, 30);
    $pdf->Cell($rightColumnWidth - 12, 5, 'Comprobante Fiscal Electrónico', 0, 1, 'C');
    
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->SetX($rightX + 6);
    $pdf->Cell($rightColumnWidth - 12, 4, 'e-NCF: E310000002211', 0, 1, 'L');
    
    $pdf->SetX($rightX + 6);
    $pdf->Cell($rightColumnWidth - 12, 4, 'Fecha Emisión: ' . $emisor['FechaEmision'], 0, 1, 'L');
    
    $pdf->SetX($rightX + 6);
    $pdf->Cell($rightColumnWidth - 12, 4, 'Fecha Vencimiento: 31-12-2025', 0, 1, 'L');
    
    // ==================== SECCIÓN DE CLIENTE (debajo del encabezado) ====================
    
    $clienteY = $startY + $logoHeight + 15;
    $clienteHeight = 28;
    
    // Cuadro sutil con borde gris claro y padding pequeño (5-8px)
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.5);
    $pdf->Rect(12, $clienteY, $pageWidth, $clienteHeight, 'DF');
    
    // Contenido con líneas compactas
    $pdf->SetXY(12 + 6, $clienteY + 4);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetTextColor(30, 30, 30);
    $pdf->Cell($pageWidth - 12, 4, 'DATOS DEL CLIENTE', 0, 1, 'L');
    
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetX(12 + 6);
    $pdf->Cell($pageWidth - 12, 4, $comprador['RazonSocialComprador'], 0, 1, 'L');
    
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->SetX(12 + 6);
    $pdf->Cell(($pageWidth - 12) / 2, 4, 'RNC/Cédula: ' . $comprador['RNCComprador'], 0, 0, 'L');
    
    // Dirección (si existe)
    $direccion = '';
    if (!empty($comprador['MunicipioComprador']) || !empty($comprador['ProvinciaComprador'])) {
        $direccionParts = array_filter([
            trim($comprador['MunicipioComprador']),
            trim($comprador['ProvinciaComprador'])
        ]);
        $direccion = implode(', ', $direccionParts);
    }
    
    if (!empty($direccion)) {
        $pdf->Cell(($pageWidth - 12) / 2, 4, 'Dirección: ' . $direccion, 0, 1, 'L');
    } else {
        $pdf->Ln(4);
    }
    
    $pdf->SetX(12 + 6);
    $pdf->Cell($pageWidth - 12, 4, 'Email: ' . $comprador['CorreoComprador'], 0, 1, 'L');
    
    // ==================== TABLA DE PRODUCTOS (ancho completo) ====================
    
    $tablaY = $clienteY + $clienteHeight + 10;
    $pdf->SetXY(12, $tablaY);
    
    // Configuración de tabla
    $pdf->SetDrawColor(180, 180, 180);
    $pdf->SetLineWidth(0.3);
    
    // Encabezados claros y en negrita
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetFillColor(245, 245, 245);
    $pdf->SetTextColor(30, 30, 30);
    
    // Anchos de columnas para ocupar todo el ancho
    $colWidths = [72, 20, 28, 22, 22, 26]; // Total = 190 (ajustado al ancho)
    $headers = ['Producto', 'Cant.', 'Precio', 'Desc.', 'ITBIS', 'Total'];
    
    foreach ($headers as $i => $header) {
        $pdf->Cell($colWidths[$i], 8, $header, 1, 0, 'C', 1);
    }
    $pdf->Ln();
    
    // Contenido de la tabla con espaciado reducido pero legible
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(60, 60, 60);
    
    foreach ($items as $item) {
        $montoItem = $item['MontoItem'];
        $cantidad = $item['CantidadItem'];
        $precioUnitario = $item['PrecioUnitarioItem'];
        
        // Cálculo de ITBIS
        $itbisItem = 0;
        if ($item['IndicadorFacturacion'] == 1) {
            $itbisItem = $montoItem * ($totales['ITBIS1'] / 100);
        }
        
        $totalItem = $montoItem + $itbisItem;
        
        // Producto con truncado
        $nombreProducto = strlen($item['NombreItem']) > 48 ? 
                         substr($item['NombreItem'], 0, 45) . '...' : 
                         $item['NombreItem'];
        
        // Líneas sutiles entre filas
        $pdf->Cell($colWidths[0], 7, $nombreProducto, 1, 0, 'L', 1);
        $pdf->Cell($colWidths[1], 7, $cantidad, 1, 0, 'C', 1);
        $pdf->Cell($colWidths[2], 7, 'RD$' . number_format($precioUnitario, 2), 1, 0, 'R', 1);
        $pdf->Cell($colWidths[3], 7, 'RD$0.00', 1, 0, 'R', 1);
        $pdf->Cell($colWidths[4], 7, 'RD$' . number_format($itbisItem, 2), 1, 0, 'R', 1);
        $pdf->Cell($colWidths[5], 7, 'RD$' . number_format($totalItem, 2), 1, 1, 'R', 1);
    }
    
    // ==================== FILA INFERIOR DIVIDIDA EN DOS COLUMNAS ====================
    
    $bottomY = $pdf->GetY() + 15;
    
    // === COLUMNA IZQUIERDA: QR CENTRADO ===
    
    $qrX = 12;
    $qrY = $bottomY;
    $qrSize = 50;
    $qrSectionWidth = $pageWidth * 0.5;
    
    // QR centrado dentro de su sección
    $qrCenterX = $qrX + ($qrSectionWidth - $qrSize) / 2;
    
    // GENERAR QR CODE REAL CON CÓDIGO DE SEGURIDAD
    $codigoSeguridad = 'Rg7zr1';
    $fechaFirma = '26-05-2025 02:08:06';
    
    // Datos para el QR (puedes incluir más información)
    $qrData = "Código: {$codigoSeguridad}\nFecha: {$fechaFirma}\nRNC: {$emisor['RNCEmisor']}\ne-NCF: E310000002211";
    
    // Usar API externa para generar QR (no requiere librerías locales)
    try {
        // Codificar datos para URL
        $qrDataEncoded = urlencode($qrData);
        $qrSize_px = $qrSize * 10; // Convertir a píxeles para la API
        
        // API de qr-server.com (más confiable que Google Charts)
        $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size={$qrSize_px}x{$qrSize_px}&data={$qrDataEncoded}";
        
        // Descargar la imagen QR
        $context = stream_context_create([
            'http' => [
                'timeout' => 10, // 10 segundos timeout
                'user_agent' => 'Mozilla/5.0 (compatible; PDF Generator)'
            ]
        ]);
        
        $qrImageData = file_get_contents($qrApiUrl, false, $context);
        
        if ($qrImageData !== false) {
            // Crear archivo temporal
            $tempQrFile = tempnam(sys_get_temp_dir(), 'qr') . '.png';
            file_put_contents($tempQrFile, $qrImageData);
            
            // Insertar en PDF
            $pdf->Image($tempQrFile, $qrCenterX, $qrY, $qrSize, $qrSize, 'PNG');
            
            // Limpiar archivo temporal
            if (file_exists($tempQrFile)) {
                unlink($tempQrFile);
            }
        } else {
            throw new Exception('No se pudo generar QR');
        }
        
    } catch (Exception $e) {
        // Fallback: QR simulado si falla la API
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetDrawColor(180, 180, 180);
        $pdf->SetLineWidth(0.3);
        $pdf->Rect($qrCenterX, $qrY, $qrSize, $qrSize, 'DF');
        
        // Patrón QR simulado mejorado
        $pdf->SetFillColor(20, 20, 20);
        for ($i = 0; $i < 17; $i++) {
            for ($j = 0; $j < 17; $j++) {
                // Patrón más realista
                if (($i == 0 || $i == 16 || $j == 0 || $j == 16) || // Bordes
                    (($i < 7 && $j < 7) || ($i < 7 && $j > 9) || ($i > 9 && $j < 7)) || // Esquinas
                    (($i + $j) % 3 == 0 && $i > 7 && $i < 10 && $j > 7 && $j < 10)) { // Centro
                    $cellSize = $qrSize / 17;
                    $pdf->Rect($qrCenterX + ($i * $cellSize), $qrY + ($j * $cellSize), $cellSize, $cellSize, 'F');
                }
            }
        }
        
        // Agregar texto de error pequeño
        $pdf->SetXY($qrCenterX, $qrY + $qrSize + 2);
        $pdf->SetFont('helvetica', '', 6);
        $pdf->SetTextColor(150, 150, 150);
        $pdf->Cell($qrSize, 3, '(QR simulado)', 0, 1, 'C');
    }
    
    // Texto debajo del QR, alineado al centro
    $pdf->SetXY($qrX, $qrY + $qrSize + 8);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->Cell($qrSectionWidth, 4, 'Código de Seguridad: ' . $codigoSeguridad, 0, 1, 'C');
    $pdf->SetX($qrX);
    $pdf->Cell($qrSectionWidth, 4, 'Fecha Firma: ' . $fechaFirma, 0, 1, 'C');
    
    // === COLUMNA DERECHA: TOTALES (cuadro discreto con borde suave) ===
    
    $totalesX = 12 + $qrSectionWidth + 5;
    $totalesWidth = $pageWidth * 0.45;
    $totalesHeight = 65;
    
    // Cuadro discreto centrado verticalmente respecto al QR
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->SetLineWidth(0.5);
    $pdf->Rect($totalesX, $qrY, $totalesWidth, $totalesHeight, 'DF');
    
    // Totales bien alineados sin espacio extra
    $pdf->SetXY($totalesX + 8, $qrY + 8);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetTextColor(60, 60, 60);
    
    $subtotalBrutoTotal = $totales['MontoGravadoTotal'] + $totales['MontoExento'];
    
    $totalesData = [
        ['Subtotal Bruto:', 'RD$' . number_format($subtotalBrutoTotal, 2)],
        ['Exento:', 'RD$' . number_format($totales['MontoExento'], 2)],
        ['Subtotal Neto:', 'RD$' . number_format($totales['MontoGravadoTotal'], 2)],
        ['ITBIS:', 'RD$' . number_format($totales['TotalITBIS'], 2)]
    ];
    
    foreach ($totalesData as $row) {
        $pdf->Cell(($totalesWidth - 16) * 0.6, 5, $row[0], 0, 0, 'L');
        $pdf->Cell(($totalesWidth - 16) * 0.4, 5, $row[1], 0, 1, 'R');
        $pdf->SetX($totalesX + 8);
    }
    
    // Línea separadora sutil
    $currentY = $pdf->GetY() + 2;
    $pdf->SetDrawColor(220, 220, 220);
    $pdf->SetLineWidth(0.3);
    $pdf->Line($totalesX + 8, $currentY, $totalesX + $totalesWidth - 8, $currentY);
    
    // Total final
    $pdf->SetXY($totalesX + 8, $currentY + 4);
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->SetTextColor(30, 30, 30);
    $pdf->SetFillColor(250, 250, 250);
    $pdf->SetDrawColor(180, 180, 180);
    $pdf->SetLineWidth(0.5);
    $pdf->Cell(($totalesWidth - 16) * 0.6, 8, 'Total:', 1, 0, 'L', 1);
    $pdf->Cell(($totalesWidth - 16) * 0.4, 8, 'RD$' . number_format($totales['MontoTotal'], 2), 1, 1, 'R', 1);
    
    return $pdf;
}

// Función de procesamiento
function procesarFactura($datosArray, $outputMode = 'I') {
    try {
        $pdf = generarFacturaPDF($datosArray);
        $emisor = $datosArray['ECF']['Encabezado']['Emisor'];
        $nombreArchivo = 'factura_compacta_' . $emisor['RNCEmisor'] . '_' . date('Y-m-d_H-i-s') . '.pdf';
        
        $pdf->Output($nombreArchivo, $outputMode);
        return ['success' => true, 'filename' => $nombreArchivo];
        
    } catch (Exception $e) {
        error_log("Error generando factura: " . $e->getMessage());
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
                'MunicipioComprador' => '',
                'ProvinciaComprador' => '',
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

// Ejecutar factura
$resultado = procesarFactura($datosFactura, 'I');

?>