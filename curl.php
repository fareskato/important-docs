<?php
$key = "ALARME_FR";
$publickey = '1CF958FF1EE83BE24D4C9D812FCDF';
//$timestamp = time();
$timeselected = 1;
$iphone = '0123456788';
$sex = 'M';
$fname = 'test';
$lname = 'altima';
$email = 'oleg.angelov@altima-agency.com';
$checksum =  md5($sex . "/" .$key . "/" .$email ."/" . $timeselected . "/" .$fname . "/" .$lname . "/" .$iphone . "/" .$publickey);
$url = 'https://www.eps-wap.fr/coregistration/certification/?/coregistration/rest/prospect';
//$header = "Accept:text/html\r\nUser-Agent:" . $_SERVER['HTTP_USER_AGENT'] . "\r\nContent-type:form-data\r\n";

/*
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$header = array(
    "Accept-Encoding: text/html",
    "Content-Type: text/html",
    "User-Agent: $user_agent "
);
*/


$data = array(
    'civilite' => $sex,
    'cle' => $key,
    'email' => $email,
    'heureRappel' => $timeselected,
    'identifiantExterne' => $publickey,
    'nom' => $fname,
    'prenom' => $lname,
    'telephone' => $iphone,
    'checksum' => $checksum,
);
/*
$options = array(
    'http' => array(
        'header' => $header,
        'method' => 'POST',
        'content' => http_build_query($data)
    ),
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    )
);
*/
//$context = stream_context_create($options);
//$result = file_get_contents($url, false, $context);


var_dump(http_build_query($data));
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, true);  //  Enable Post request
//curl_setopt($curl, CURLOPT_ENCODING ,"");
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // disable ssl
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  // disable ssl
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   // return data as string
$curl_response = curl_exec($curl);
if ($curl_response === false) {
    die(curl_error($curl));
}
$info = curl_getinfo($curl);
curl_close($curl);
echo "<h1> $curl_response </h1>" ;


















echo "<br /><br />";
echo "Private key: ". $key . "<br /><br />";
echo "Publickey: ". $publickey . "<br /><br />";
echo "Selected time slot: ". $timeselected . "<br /><br />";
echo "Phone number: ". $iphone . "<br /><br />";
echo "First name: ". $fname . "<br /><br />";
echo "Last name: ". $lname . "<br /><br />";
echo "Email: ". $email . "<br /><br />";
echo "checksum: " . $sex . "/" .$key . "/" .$email ."/" . $timeselected  . "/" .$fname . "/" .$lname . "/" .$iphone . "/" .$publickey . "<br /><br />";
echo "url request: ". $url . "<br /><br />";
echo "Data: <br />";


echo "<hr />";

echo "<pre>";
//  print_r($curl_response);
  print_r($info);
echo "</pre>";








?>