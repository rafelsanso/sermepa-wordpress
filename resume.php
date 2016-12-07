<?php
  // Prepare variables
$error = false;
if (!isset($_POST['nameInput']) || !isset($_POST['conceptInput']) || !isset($_POST['amountInput'])) {
  $error = true;
} else {
  $name = $_POST['nameInput'];
  $concept = $_POST['conceptInput'];
  $amount = $_POST['amountInput'];
  $validAmount = $amount;

  if (strpos($validAmount, ',') !== false) {
      $validAmount = str_replace(',', '', $amount);
  } else if (strpos($amount, '.') !== false) {
      $validAmount = str_replace('.', '', $amount);
  }

  if (!is_numeric($validAmount)) {
    $error = true;
  }
}

if (!$error) {
  // Se incluye la librería
  include 'lib/apiRedsys.php';
  // Se crea Objeto
  $miObj = new RedsysAPI;

  // Valores de entrada
  $fuc      = esc_attr( get_option('Ds_Merchant_MerchantCode') );
  $terminal = esc_attr( get_option('Ds_Merchant_Terminal') );
  $moneda   = esc_attr( get_option('Ds_Merchant_Currency') );
  $trans    = "0";
  $url      = esc_attr( get_option('Ds_Merchant_UrlOK') );
  $urlOKKO  = esc_attr( get_option('Ds_Merchant_UrlKO') );
  $id       = time();
  $env      = esc_attr( get_option('Which_Environment') );
  $test     = esc_attr( get_option('Demo_URI') );
  $real     = esc_attr( get_option('Production_URI') );
  $target   = ($env == 0) ? $test : $real;

  // Se Rellenan los campos
  $miObj->setParameter("DS_MERCHANT_AMOUNT",$validAmount);
  $miObj->setParameter("DS_MERCHANT_ORDER",strval($id));
  $miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$fuc);
  $miObj->setParameter("DS_MERCHANT_CURRENCY",$moneda);
  $miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$trans);
  $miObj->setParameter("DS_MERCHANT_TERMINAL",$terminal);
  $miObj->setParameter("DS_MERCHANT_MERCHANTURL",$url);
  $miObj->setParameter("DS_MERCHANT_URLOK",$urlOKKO);
  $miObj->setParameter("DS_MERCHANT_URLKO",$urlOKKO);
  $miObj->setParameter("DS_MERCHANT_PRODUCTDESCRIPTION", $name . " - " . $concept);

  //Datos de configuración
  $version="HMAC_SHA256_V1";
  $kc = esc_attr( get_option('Secret_Key') );//Clave recuperada de CANALES
  // Se generan los parámetros de la petición
  $request = "";
  $params = $miObj->createMerchantParameters();
  $signature = $miObj->createMerchantSignature($kc);
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Confirm data for transaction</title>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <h1><?php _e('Make transaction'); ?></h1>
      <hr>
      <p>
      <?php if ($error) {
        echo '<p>';
        echo 'An error found. Please, fill all inputs and send again.';
        echo '</p>';
      } else {
        echo '<p>';
        echo __("These are the inputs you entered. If they are correct, you can proceed to the payment.");
        echo '</p>';
        echo '<ul>
          <li><strong>' . __('Name') . ':</strong> ' . $name .'</li>
          <li><strong>' . __('Concept') . ':</strong> ' . $concept .'</li>
          <li><strong>' . __('Amount') . ':</strong> ' . $amount .'€</li>
        </ul>';

        echo '
          <form name="frm" action="' . $target . '" method="POST">
            <input type="hidden" name="Ds_SignatureVersion" value="' . $version . '"/>
            <input type="hidden" name="Ds_MerchantParameters" value="' . $params . '"/>
            <input type="hidden" name="Ds_Signature" value="' . $signature . '"/>
            <input type="submit" value="' . __('Send') . '" >
          </form>
        ';
      } ?>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>