<?php

  //To be done:
  //1) Store failed requests on DBO  

  $input=validateInput(); //defines the data that was recieved, might be used for future datatypes implementation like PH or Chlorine
  if ($input!=0){
    $input=validateMac($mac, $token, $input);
    if ($input==1 && validateTemperature($temperature, $input)){
      if (!inputWrite($temperature, $mac, $token)){
        //return error from writing on db
      }
    }
  }

  function validateInput(){
    //checks if the args temperature, mac and token are written
    //should return error if temp, mac or token are missing
    //should return error if SQL Injection is detected ' char
    //passes the args to the vars
    $dataArray; //all the data is put into the array
    global $temperature, $mac, $token;
    
    if (file_get_contents('php://input')){
      $data=json_decode(file_get_contents('php://input'), false);
      if ($data->type=="1"){
        $temperature=$data->temperature;
        $mac=$data->mac;
        $token=$data->token;
        $dataArray=Array($temperature, $mac, $token);
      }
      else{
        //data type not recognized or not inserted
        echo json_encode("ERROR - Invalid or missing datatype.", JSON_PRETTY_PRINT);
        return 0;
      }
      foreach ($dataArray as $data){
        if (!isset($data) || strpos($data, "'")){
          //error missing args or SQL Injection
          echo json_encode("ERROR - Missing arguments or SQL invalid chars detected.", JSON_PRETTY_PRINT);
          return 0;
        }
      }
      return 1;
    }
    echo json_encode("ERROR - No Request found.", JSON_PRETTY_PRINT);
    return 0;
  }
  
  function validateTemperature($valTemp, $valInput){
    //checks if value temperature is within accepted parameters
    //should return error if temp has unexpected value or format
    $MINTEMP=-2500;
    $MAXTEMP=5000;
    if (!preg_match("/^[0-9\-]+$/", $valTemp) || $valTemp<$MINTEMP || $valTemp>$MAXTEMP){
      //error invalid temperature
      echo json_encode("ERROR - Unexpected temperature format or out of bounds.", JSON_PRETTY_PRINT);
      return 0;
    }
    return $valInput;
  }

  function validateMac($valMac, $valToken, $valInput){
    //checks if MAC is possible and if exists and if token is correct
    //should return error if MAC is not within expected format
    //should return error if token is incorrect
    if (!preg_match("/^[a-fA-F0-9]+$/", $valMac) || strlen($valMac)!=12){
      //error invalid format MAC
      echo json_encode("ERROR - Invalid MAC address.", JSON_PRETTY_PRINT);
      return 0;
    }
    elseif (false){
      //error MAC does not exist or wrong token
      echo json_encode("ERROR - MAC Address not found.", JSON_PRETTY_PRINT);
      return 0;
    }
    return $valInput;
  }
  
  function inputWrite($insertData, $onMac, $withToken){
    //writes to db according to input type
    //should send error status if fail
  }
?>