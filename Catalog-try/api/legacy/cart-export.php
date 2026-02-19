<?php
require_once __DIR__ . '/../../core/bootstrap.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$cart_items = $_SESSION['cart'] ?? [];
if (empty($cart_items)) {
    die('El carrito esta vacio.');
}

$format = $_GET['format'] ?? 'csv';
$allowed_formats = ['csv', 'pdf', 'excel'];
if (!in_array($format, $allowed_formats, true)) {
    die('Formato no valido.');
}

if (!isset($_POST['project_name'])) {
    ?>
    <form method="POST">
        <label for="project_name">Nombre del Proyecto:</label>
        <input type="text" name="project_name" required>
        <br><br>
        <label for="additional_info">Falto algo mas? (opcional):</label>
        <textarea name="additional_info" rows="3" cols="30"></textarea>
        <br><br>
        <input type="hidden" name="format" value="<?php echo htmlspecialchars($format); ?>">
        <button type="submit">Confirmar</button>
    </form>
    <?php
    exit;
}

$project_name = preg_replace('/[^a-zA-Z0-9_-]/', '_', $_POST['project_name']);
$additional_info = isset($_POST['additional_info']) ? trim($_POST['additional_info']) : '';

$data = [["ID", "Codigo", "Nombre", "Cantidad", "Unidad"]];

foreach ($cart_items as $product_id => $item) {
    if (is_array($item)) {
        $quantity = $item['quantity'];
        $unit     = $item['unit'];
    } else {
        $quantity = $item;
        $unit     = 'ue';
    }

    $product = PostData::getById($product_id);
    if ($product) {
        $data[] = [
            $product->id,
            $product->code,
            $product->name,
            $quantity,
            $unit,
        ];
    }
}

if (!empty($additional_info)) {
    $data[] = [];
    $data[] = ["Informacion Adicional:", $additional_info, "", "", ""];
}

if ($format == 'csv') {
    header('Content-Type: text/csv');
    header("Content-Disposition: attachment; filename={$project_name}.csv");
    $output = fopen('php://output', 'w');
    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

if ($format == 'pdf') {
    $pdf = new TCPDF();
    $pdf->SetCreator('Brigtronix');
    $pdf->SetAuthor('Brigtronix');
    $pdf->SetTitle('Carrito de Compras');
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    foreach ($data as $row) {
        if (empty($row)) {
            $pdf->Ln();
        } elseif (isset($row[0]) && $row[0] === 'Informacion Adicional:') {
            $pdf->SetFillColor(255, 255, 0);
            $pdf->Cell(0, 10, implode(' | ', $row), 0, 1, '', true);
            $pdf->SetFillColor(255, 255, 255);
        } else {
            $pdf->Cell(0, 10, implode(' | ', $row), 0, 1);
        }
    }

    $pdf->Output("{$project_name}.pdf", 'D');
    exit;
}

if ($format == 'excel') {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    foreach ($data as $index => $row) {
        $sheet->fromArray($row, null, 'A' . ($index + 1));
    }

    if (!empty($additional_info)) {
        $lastRow = count($data);
        $sheet->getStyle("A{$lastRow}:E{$lastRow}")
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FFFFFF00');
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename={$project_name}.xlsx");

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
?>
