<?php
    //initialize curl
    $ch = curl_init();
    //set headers
    $headers = array(
    'X-Operator: mog003',
    'X-Key: 4k706tpYPT',
    );
    //set url
    curl_setopt($ch, CURLOPT_URL, 'http://api01.oriental-game.com:8085/token');
    //set header to curl
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //Timeout in seconds
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    //curl exercute
    $authToken = curl_exec($ch);
    //json decode
    $obj = json_decode($authToken, true);
    //get token
    $token = $obj['data']['token'];
    // echo $token;
    var_dump($obj);