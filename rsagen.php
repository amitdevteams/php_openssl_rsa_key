<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $res = openssl_pkey_new();
  openssl_pkey_export($res, $privkey, "PassPhrase number 1"); {
    // Get details of public key
    $pubkey = openssl_pkey_get_details($res);
    $pubkey = $pubkey["key"];
    $rsaKey = openssl_pkey_new(array( 
      'private_key_bits' => 4096,
      'private_key_type' => OPENSSL_KEYTYPE_RSA,
    ));
    $privKey = openssl_pkey_get_private($rsaKey); 
    openssl_pkey_export($privKey, $pem);


    //download in privatekey.pem file
    file_put_contents('publickey.pem', $pubkey);
    file_put_contents('privatekey.pem', $pem);
    // download function start here
    ob_clean();
    header('Content-Description: File Transfer');
    header('Content-Type: application/x-pem-file');
    header("Content-Disposition: attachment; filename=privatekey.pem");
    exit(readfile('privatekey.pem'));
    // var_export($pubkey, $return)
    // var_dump($privkey);
    // var_dump($pubkey);
  }
}
?>