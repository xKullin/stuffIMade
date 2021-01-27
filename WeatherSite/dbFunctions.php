<?php
  /*Arrayer för temperauters*/
  $lowest = ['0', '1', '2', '3'];
  $low = ['4', '5', '6', '7'];
  $midLow = ['8', '9', '10', '11'];
  $mid = ['12', '13', '14', '15'];
  $high = ['16', '17', '18', '19', '20'];

  $temp = $_GET['temp'];

  if(strpos($temp, ".")){
    $parts = explode(".", $temp);
    $temp = $parts[0];
  }
  $comment = selectComment($temp, $lowest, $low, $midLow, $mid, $high);
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

  function selectComment($temp, $lowest, $low, $midLow, $mid, $high){
    /* Hämtar en random kommentar beroende på vilken temperatur det är */
    $db = dbConnect();
    $sql;
    if(in_array($temp, $lowest)){
        $sql = "SELECT * FROM weathercomments WHERE temp = '0-3' ORDER BY RAND() LIMIT 1";
    }else if(in_array($temp, $low)){
        $sql = "SELECT * FROM weathercomments WHERE temp = '4-7' ORDER BY RAND() LIMIT 1";
    }else if(in_array($temp, $midLow)){
        $sql = "SELECT * FROM weathercomments WHERE temp = '8-11' ORDER BY RAND() LIMIT 1";
    }else if(in_array($temp, $mid)){
        $sql = "SELECT * FROM weathercomments WHERE temp = '12-15' ORDER BY RAND() LIMIT 1";
    }else if(in_array($temp, $high)){
        $sql = "SELECT * FROM weathercomments WHERE temp = '16-20' ORDER BY RAND() LIMIT 1";
    }else if(intval($temp > '20')){
        $sql = "SELECT * FROM weathercomments WHERE temp = '20+' ORDER BY RAND() LIMIT 1";
    }else if(intval($temp) < '0'){
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
  echo($comment);
?>
