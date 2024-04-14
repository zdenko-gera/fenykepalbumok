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
