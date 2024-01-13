<?php

header('Content-Type: application/json');

$stkCallbackResponse = file_get_contents('php://input');

$logFile = 'mpesaresponse.json';

$log = fopen($logFile, 'a');

fwrite($log, $stkCallbackResponse);

fclose($log);

$data = json_decode($stkCallbackResponse);

$MerchantRequestID = $data->Body->stkCallback->MerchantRequestID;
$CheckoutRequestID = $data->Body->stkCallback->CheckoutRequestID;
$ResultCode = $data->Body->stkCallback->ResultCode;
$ResultDesc = $data->Body->stkCallback->ResultDesc;
$Amount = $data->Body->stkCallback->CallbackMetadata->Item[0]->Value;
$transactionId = $data->Body->stkCallback->CallbackMetadata->Item[1]->Value;
$userPhonenumber = $data->Body->stkCallback->CallbackMetadata->Item[4]->Value;

// Check if the transaction is successfull

if($ResultCode == 0){
  // store the data to the database
}