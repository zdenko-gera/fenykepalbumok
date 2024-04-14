<?php
$tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1500))
    )
    (CONNECT_DATA =
      (SID = xe)
    )
  )";

$conn = oci_connect('ZDENKO','palacsinta', $tns, 'UTF8');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
} else {
    echo 'Sikeresen csatlakozva az adatbázishoz!';
}

echo '<h2>Az CATEGORIES tábla adatai: </h2>';
echo '<table border="0">';


//// -- lekerdezzuk a tabla tartalmat
$stid = oci_parse($conn, 'SELECT * FROM CATEGORIES');

oci_execute($stid);

//// -- eloszor csak az oszlopneveket kerem le
$nfields = oci_num_fields($stid);
echo '<tr>';
for ($i = 1; $i<=$nfields; $i++){
    $field = oci_field_name($stid, $i);
    echo '<td>' . $field . '</td>';
}
echo '</tr>';

//// -- ujra vegrehajtom a lekerdezest, es kiiratom a sorokat
oci_execute($stid);

while ( $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<tr>';
    foreach ($row as $item) {
        echo '<td>' . $item . '</td>';
    }
    echo '</tr>';
}
echo '</table>';

oci_free_statement($stid);
oci_close($conn);