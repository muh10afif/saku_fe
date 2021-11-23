<?php 

$a = "FormatExcel";

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename= $a.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

<?= $konten ?>

</body>
</html>