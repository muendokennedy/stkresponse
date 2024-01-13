<?php 
// Get the authorization token

date_default_timezone_set('Africa/Nairobi');

$consumerKey = 'MKN5NxF3O4wUreGKswJQ1idNaLMAe2Qr';

$consumerSecret = 'FOiASR4OAztwdxza';

$authorizationtokenUrl = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$ch = curl_init($authorizationtokenUrl);

$password = $consumerKey . ':' . $consumerSecret;

curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json; charset=utf8']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERPWD, $password);

$response = curl_exec($ch);
curl_close($ch);

$responseToken = json_decode($response);

$accessToken = $responseToken->access_token;

// echo '<h2>'. $accessToken .'</h2>';

// The stk token api code

$stkpushUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

$curl = curl_init($stkpushUrl);

$stkShortCode = 174379;

$phoneNumber = 254745079253;

$amount = 1;

$timestamp = date('YmdHis');

$passKey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';

$securityCredential = base64_encode($stkShortCode . $passKey . $timestamp);

$callbackUrl = 'https://e948-41-209-10-84.ngrok-free.app/darajaapi/callback.php';

curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken,
    'Content-Type: application/json'
]);
curl_setopt($curl, CURLOPT_POST, 1);

$curl_post_data  = [
  'BusinessShortCode' => $stkShortCode,
  'Password' => $securityCredential,
  'Timestamp' => $timestamp,
  'TransactionType' => 'CustomerPayBillOnline',
  'Amount' => $amount,
  'PartyA' => $phoneNumber,
  'PartyB' => $stkShortCode,
  'PhoneNumber'=> $phoneNumber,
  'CallBackURL' => $callbackUrl,
  'AccountReference' => 'Motech Technologies',
  'TransactionDesc' => 'Payment of some electronic goods' 
];

curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curl_post_data));

curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($curl);
curl_close($curl);
echo $response;