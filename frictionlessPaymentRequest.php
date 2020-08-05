<?php
/*This file generates the payment request and sends it to the Sips server
For more information on this use case, please refer to the following documentation:
https://documentation.sips.worldline.com/en/WLSIPS.344-UG-3-D-Secure.html */

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
   "amount" => "2000",           //Note that the amount entered in the "amount" field is in cents
   "orderChannel" => "INTERNET",
   "currencyCode" => "978",
   "keyVersion" => "1",
   "responseEncoding" => "base64",
   
   "billingAddress" => array(
      "city" => "Nantes",
      "country" => "FRA",
      "addressAdditional1" => "route de l'atlantique, 5990",
      "addressAdditional2" => "rue Pompidou, 8900",
      "addressAdditional3" => "avenue Jean Jaures, 4900",
      "zipCode" => "44000",
      "state" => "France",
   ),
   "holderContact" => array(
      "lastname" => "Doe",
      "email" => "jane.doe@example.org",
   ),
   "fraudData" => array(
      "merchantCustomerAuthentMethod" => "NOAUTHENT",
      "challengeMode3DS" => "NO_CHALLENGE",
   ),
);

$dataStr = flatten_to_sips_payload($requestData);

$dataStrEncode = base64_encode($dataStr);

$_SESSION['seal'] = compute_seal_from_string($_SESSION['sealAlgorithm'], $dataStrEncode, $_SESSION['secretKey']);

$_SESSION['data'] = $dataStrEncode;

header('Location: Common/redirectionForm.php');

?>
