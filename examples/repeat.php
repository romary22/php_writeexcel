<?php

set_time_limit(10);

require_once __DIR__ . '/../vendor/autoload.php';

$fname = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'repeat-' . bin2hex(random_bytes(16)) . '.xls';
$workbook = new writeexcel_workbook($fname);
$worksheet = &$workbook->addworksheet();

$worksheet->repeat_rows(0, 1);

$worksheet->write(0, 0, "Header line (will be repeated when printed)");
$worksheet->write(1, 0, "Header line number 2");

for ($i=1;$i<=100;$i++) {
    $worksheet->write($i+1, 0, "Line $i");
}

$workbook->close();

if (PHP_SAPI !== 'cli') {
    header("Content-Type: application/x-msexcel; name=\"example-repeat.xls\"");
    header("Content-Disposition: inline; filename=\"example-repeat.xls\"");
    $fh=fopen($fname, "rb");
    fpassthru($fh);
}
#unlink($fname);
