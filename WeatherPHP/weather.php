<?php
  session_start();
  if (!isset($_SESSION['cities'])) {
  $_SESSION['cities'] = array();
  }
  /* Variabler för html-koden, staden som ska sökas och länken till api */
  $city = strip_tags(ucfirst($_GET['city']));
  $apiCall = "http://api.openweathermap.org/data/2.5/weather?q=" . $city . "&units=metric&appid=426f2c819091f6ff649c54a7b1a7b3f8";
  $html = file_get_contents('weather-template.html');
  $icon = "";
  /*Arrayer för temperauters*/
  $lowest = ['0', '1', '2', '3'];
  $low = ['4', '5', '6', '7'];
  $midLow = ['8', '9', '10', '11'];
  $mid = ['12', '13', '14', '15'];
  $high = ['16', '17', '18', '19', '20'];





  if(isset($_GET)){

    if(@file_get_contents($apiCall)){ //Om man får data tillbaka, alltså har skrivit en stad
      $data = file_get_contents($apiCall);
        /*Variabler för vädret*/
      $json = json_decode($data, TRUE);
      $temperature = $json['main']['temp'];
      $weatherMain = $json['weather']['0']['main'];
      $weatherDesc = $json['weather']['0']['description'];
      $wind = $json['wind']['speed'];
      /* Lägger in staden i sessionen om den inte finns, är det redan 3 städer så tas den äldsta bort*/
      if(!in_array($city, $_SESSION['cities']) && count($_SESSION['cities']) < 3){
        $_SESSION['cities'][] = $city;
      }else if(!in_array($city, $_SESSION['cities']) && count($_SESSION['cities']) == 3){
        array_shift($_SESSION['cities']);
        $_SESSION['cities'][] = $city;
      }
      /* Tar bort punkten så att vi bara får tex 10 grader istället för 10.22 grader*/
      if(strpos($temperature, ".")){
        $parts = explode(".", $temperature);
        $temperature = $parts[0];
      }
      /* Hämtar en kommentar från databasen och byter ut olika strängar med data, detta visar vädret*/
      $comment = selectComment($temperature, $lowest, $low, $midLow, $mid, $high);
      $replace = str_replace(array('---city---', '---comment---', '---temp---', '---desc---', '---wind---', '---main---'), array(ucfirst($city), $comment, $temperature, $weatherDesc, $wind, getWeatherIcon($weatherMain, $icon)), $html);
      echo($replace);

    }else{ //Om man stavat fel eller inte sökt på en stad
        $arr = array("hide" => "show", "show" => "hide");
        $replace = strtr($html, $arr);
        echo($replace);
    }
  }

  function getWeatherIcon($weatherMain, $icon){ //Beroende på vilken data man får kommer en ikon skrivas ut för vädret, finns väldigt många olika från APIet så har bara ikoner för dom vanligaste, annars skrivs bara texten ut
    if($weatherMain == "Clouds"){
      $icon = '<i class="fas fa-cloud"></i>';
    }else if($weatherMain == "Rain"){
      $icon = '<i class="fas fa-cloud-rain"></i>';
    }else if($weatherMain == "Clear"){
      $icon = '<i class="fas fa-sun"></i>';
    }else if($weatherMain == "Snow"){
      $icon = '<i class="fas fa-snowflake"></i>';
    }else{
      $icon = $weatherMain;
    }
    return $icon;
  }
  //Databaser
  function dbConnect(){
    /* Ansluter till databasen */
    try {
      $dsn = "mysql:dbname=weathersite;host=localhost";
      $user = "root";
      $password = "";
      $options = array( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
      $db = new PDO($dsn, $user, $password, $options);
      return $db;
    } catch( PDOException $e ) {
      throw $e;
    }
  }
  /* För att stänga databasen */
  function dbDes(){
    $db = null;
  }

  function selectComment($temperature, $lowest, $low, $midLow, $mid, $high){
    /* Hämtar en random kommentar beroende på vilken temperatur det är */
    $db = dbConnect();
    $sql;
    if(in_array($temperature, $lowest)){
        $sql = "SELECT * FROM weathercomments WHERE temp = '0-3' ORDER BY RAND() LIMIT 1";
    }else if(in_array($temperature, $low)){
        $sql = "SELECT * FROM weathercomments WHERE temp = '4-7' ORDER BY RAND() LIMIT 1";
    }else if(in_array($temperature, $midLow)){
        $sql = "SELECT * FROM weathercomments WHERE temp = '8-11' ORDER BY RAND() LIMIT 1";
    }else if(in_array($temperature, $mid)){
        $sql = "SELECT * FROM weathercomments WHERE temp = '12-15' ORDER BY RAND() LIMIT 1";
    }else if(in_array($temperature, $high)){
        $sql = "SELECT * FROM weathercomments WHERE temp = '16-20' ORDER BY RAND() LIMIT 1";
    }else if(intval($temperature > '20')){
        $sql = "SELECT * FROM weathercomments WHERE temp = '20+' ORDER BY RAND() LIMIT 1";
    }else if(intval($temperature) < '0'){
      $sql = "SELECT * FROM weathercomments WHERE temp = 'minus' ORDER BY RAND() LIMIT 1";
    }else{
      $row = "We couldn't get you a comment, here's the weather at least!"; //Om något går fel
    }
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row['ComText'];
    dbDes();
  }
?>
