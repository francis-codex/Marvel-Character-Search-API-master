<?php
if (isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) ) {
  if (isset($_GET['comic-id'])) {

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  
    $comic_id = htmlentities(strtolower($_GET['comic-id']));
  
    $ts = time();
    $public_key = 'aeb01546905f570d88845f9b377a0d2c';
  $private_key = '1fd59abf347c5be1ee004115d65d8510b6503ac2';
    $hash = md5($ts . $private_key . $public_key);
  
    $query = array(
      'apikey' => $public_key,
      'ts' => $ts,
      'hash' => $hash
    );
  
    curl_setopt($curl, CURLOPT_URL,
      "https://gateway.marvel.com:443/v1/public/comics/" . $comic_id . "?" . http_build_query($query)
    );
    
    $result = json_decode(curl_exec($curl), true);
    
    curl_close($curl);
  
    echo json_encode($result);

  } else {
    echo "Error invalid comic id";
  }
} else {
  echo "Error: wrong server.";
}

?>