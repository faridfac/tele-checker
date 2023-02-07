<?php
ulang:
$ffile = "username.txt";

if(!file_exists($ffile)){
    echo color($color = "red" , "File not found\n");
    exit();
} else if(!$ffile){
    echo color($color = "red" , "File empty\n");
    exit();
}

$aa = explode("\n", file_get_contents($ffile));
$tot = count($aa);
echo color($color = "blue" , "[*] Total username: $tot\n\n");
for ($i=0; $i < $tot; $i++) {
    $username = $aa[$i];
    echo "[*] Checking $username > ";
    echo findUs($username);
}

function findUs($username){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://t.me/$username");
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:11.0) Gecko/20100101 Firefox/11.0');
  curl_setopt($ch, CURLOPT_HEADER  ,1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  $result = curl_exec($ch);
  if (preg_match('/tgme_page_title/i', $result)) {
    return color($color = "red" , "Used\n");
  } else {
    $fopen1 = fopen("available.txt", "a");
    $fwrite1 = fwrite($fopen1, "$username\n");
    fclose($fopen1);
    return color($color = "green" , "Not Used\n");
  }
}

function color($color = "default" , $text) {
  $arrayColor = array(
    'grey' 		=> '1;30',
    'red' 		=> '1;31',
    'green' 	=> '1;32',
    'yellow' 	=> '1;33',
    'blue' 		=> '1;34',
    'purple' 	=> '1;35',
    'nevy' 		=> '1;36',
    'white' 	=> '1;0',
  );
  return "\033[".$arrayColor[$color]."m".$text."\033[0m";
}