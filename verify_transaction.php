<?php
  $ref = $_GET['reference'];

  // check if reference is empty
  if ($ref == "") {
    header("Location: javascript://history.go(-1)");
  }
  ?>

  <?php

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/".rawurlencode($ref),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer sk_test_080e8e96a8a1992a9b65e2fac136748ab85cf69b",
      "Cache-Control: no-cache",
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    // access all responses
    $result = json_decode($response);
  }

  // check if payment was successful
  if ($result->data->status == 'success') {
    // successful payment (fetch result)
    $status = $result->data->status;
    $reference = $result->data->reference;
    $lname = $result->data->customer->last_name;
    $fname = $result->data->customer->first_name;
    $fullname = $lname.' '.$fname;
    $customer_email = $result->data->customer->email;
    $data_time = date('Y-m-d H:i:s');

    // insert values to database
    include('database/connection.php');

    $stmt = $connection->prepare("INSERT INTO paystack_payments(status, reference, fullname, date_purchased, email) VALUES(?, ?, ?, ?, ?)");
    $stmt->bindParam('1', $status);
    $stmt->bindParam('2', $reference);
    $stmt->bindParam('3', $fname);
    $stmt->bindParam('4', $data_time);
    $stmt->bindParam('5', $customer_email);

    $stmt->execute();

    if(!$stmt) {
      // query did not run
      echo 'There was a problem on your code';
    } else {
      // sucess
      header("Location: success.php?status=success");
      exit();
    }

    // close all db connections
    $stmt->close();

  } else {
    // payment not successful
    header("Location: error.html");
    exit();
  }
?>