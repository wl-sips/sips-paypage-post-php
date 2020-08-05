<?php
/*This file generates the payment request and sends it to the Sips server
For more information on this use case, please refer to the following documentation:
https://documentation.sips.worldline.com/en/WLSIPS.004-GD-Functionality-set-up-guide.html */

session_start();

include('Common/sealCalculationPaypagePost.php');
include('Common/flatten.php');

//PAYMENT REQUEST

//You can change the values in session according to your needs and architecture
$_SESSION['secretKey'] = "002001000000002_KEY1";
$_SESSION['sealAlgorithm'] = "HMAC-SHA-256";
$_SESSION['normalReturnUrl'] = "http://localhost/sips-paypage-post-php/Common/paymentResponse.php";

$requestData = array(
   "normalReturnUrl" => $_SESSION['normalReturnUrl'],
   "merchantId" => "002001000000002",
   "amount" => "9000",           //Note that the amount entered in the "amount" field is in cents
   "orderChannel" => "INTERNET",
   "currencyCode" => "978",
   "keyVersion" => "1",
   "responseEncoding" => "base64",
   
   "transactionReference" => "m136",
   "paymentPattern" => "INSTALMENT",
   "instalmentData" => array(
      "number" => "3",
      "amountsList" => array('1000','1000','7000'),   //The sum of these amounts must be equal to the content of the amount field
      "datesList" => array('20200805','20200806','20200807'),  //Change the dates according to the time of the test of this use case
      "transactionReferencesList" => array('m136','m236','m336'),   //The first reference must be equal to the one contained in the transactionReference field
   ),
);

$dataStr = flatten_to_sips_payload($requestData);

$dataStrEncode = base64_encode($dataStr);

$_SESSION['seal'] = compute_seal_from_string($_SESSION['sealAlgorithm'], $dataStrEncode, $_SESSION['secretKey']);

$_SESSION['data'] = $dataStrEncode;

header('Location: Common/redirectionForm.php');

?>
