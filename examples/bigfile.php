<?php

set_time_limit(300);

require_once __DIR__ . '/../vendor/autoload.php';

$fname = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'bigfile-' . bin2hex(random_bytes(16)) . '.xls';
$workbook = new writeexcel_workbookbig($fname);
$worksheet = $workbook->addworksheet();

$worksheet->set_column(0, 50, 18);

for ($col=0;$col<50;$col++) {
    for ($row=0;$row<6000;$row++) {
        $worksheet->write($row, $col, "ROW:$row COL:$col");
    }
}

$workbook->close();

if (PHP_SAPI !== 'cli') {
    header("Content-Type: application/x-msexcel; name=\"example-bigfile.xls\"");
    header("Content-Disposition: inline; filename=\"example-bigfile.xls\"");
    $fh=fopen($fname, "rb");
    fpassthru($fh);
}
#unlink($fname);
