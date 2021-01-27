<?php
  //session_start();
  /* Lägger in all html-kod i en variabel */
  $html = file_get_contents('index-template.html');
  /* Om sessions-kakan finns körs denna kod, else skrivs HTML ut som vanligt */

  if(isset($_COOKIE['cities'])){

    $cities = explode(',', $_COOKIE['cities']);
    array_pop($cities); //Empty element at the last spot, easier to remove here
    $pieces = explode("<!-- suggest  -->", $html); //Delar upp i delar
    $pieces[0] = str_replace('hide', 'suggest', $pieces[0]); //Byter hide till suggest så att klassen synns om det finns tidigare söknigar
    echo($pieces[0]); //Skriver ut första delen
    foreach ($cities as $key => $value) {
      /* För varje stad skriver man ut en länk där man visar staden så att man kan söka igen*/
      $temp = str_replace(array('---city---', 'hide'), array($value, 'suggest'), $pieces[1]);
      echo($temp);
    }
    echo($pieces[2]); //skriver ut nedre delen av koden
  }else{
    echo($html);
  }

?>
