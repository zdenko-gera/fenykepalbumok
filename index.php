<html lang="hu">
<head>
    <title>Fényképalbumok</title>
</head>
<body>
<?php

$tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = orania2.inf.u-szeged.hu)(PORT = 1521))
    )
    (CONNECT_DATA =
      (SID = orania2)
    )
  )";

$conn = oci_pconnect('C##HZLNA1', 'Palacsinta1', $tns,'UTF8');
?>
</body>
</html>
