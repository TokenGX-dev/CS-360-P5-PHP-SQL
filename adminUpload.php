<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN"
            "http://www.w3.org/TR/REC-html40/strict.dtd">
<html>
<head>
<title>uMovies :: Administration</title>
<style type="text/css">
@import url(uMovies.css);
</style>
</head>

<?php
if (!session_start()) {
  die("Could not start session");
}
if (!isset($_POST["session-id"])) {
  die("session-id not received");
} else {
  $id = $_POST["session-id"];
}
if (!isset($_SESSION[$id]["pass"])) {
  die("password not read");
} else {
  $pass = $_SESSION[$id]["pass"];
}
ini_set('max_execution_time', 0);
?>

<body>
<div id="links">
<a href="./">Home<span> Access the database of movies, actors and directors. Free to all!</span></a>
<a href="admin.html">Administrator<span> Administrator access. Password required.</span></a>
</div>

<div id="content">
<h1>uMovies&trade;</h1>
<p>
Welcome to <em>uMovies</em>, your destination for information on
 <a href="movies.php" title="access movies information">movies</a>,
  <a href="actors.php" title="access actors information">actors</a>
   and <a href="directors.php" title="access directors information">directors</a>.
<?php
@$moviesdb = new mysqli('localhost','uMoviesAdmin', $pass,'uMovies');
@$moviesdb->set_charset("utf8");

if ($moviesdb->connect_errno) {
    echo '<h2 id="header">Administrator Access</h2>';
    echo '<h3>Incorrect Password</h3>';
}
else {
  echo '<h2 id="header">Administrator Access</h2>';
  echo '<h3>Uploading Data File</h3>';
  $okay = true;
  if($_FILES[ "uploaded" ][ 'error' ] > 0){
    echo 'A problem was detected:<br/>';
    switch ($_FILES[ "uploaded" ][ 'error' ]) {
      case 1: echo '* File exceeded maximum size allowed by server.<br/>';      break;
      case 2: echo '* File exceeded maximum size allowed by application.<br/>'; break;
      case 3: echo '* File could not be fully uploaded.<br/>';                  break;
      case 4: echo '* File was not uplaoded.<br/>';
    }
    $okay = false;
  }
  if($okay && $_FILES[ "uploaded" ][ 'type' ] != 'text/plain'){
    echo 'A problem was detected:<br/>';
    echo '* File is not a text file.<br/>';
    $okay = false;
  }
  $filename = 'file.txt';
  if($okay){
    if(is_uploaded_file($_FILES[ "uploaded" ][ 'tmp_name' ])){
      if(!move_uploaded_file($_FILES[ "uploaded" ][ 'tmp_name' ], $filename)){
        echo 'A problem was detected:</br>';
        echo '* Could not copy file to final destination.<br/>';
        $okay = false;
      }
    }
    else {
      echo 'A problem was detected:<br/>';
      echo '* File to copy is not an uploaded file.<br/>';
      $okay = false;
    }
    if($okay){
      $file = fopen($filename, 'r');
      $fileContents = nl2br(fread($file, filesize($filename)));
      unlink($filename);
      fclose($file);

      $movieTotal = 0;
      $movieAdded = 0;
      $movieLast = "";
      $actorTotal = 0;
      $actorAdded = 0;
      $actorLast = "";
      $directorTotal = 0;
      $directorAdded = 0;
      $directorLast = "";
      $directionTotal = 0;
      $directionsAdded = 0;
      $directionsLast = "";
      $performanceTotal = 0;
      $performanceAdded = 0;
      $performanceLast = "";

      $rows = explode("\n", $fileContents);
      foreach($rows as $row => $data) {
        $row_data = explode("\t", $data);
        $row_data[1] = utf8_encode($row_data[1]);
        switch ($row_data[0]) {
          case 'movie':
            $name = $row_data[1];
            $year = $row_data[2];

            if (strpos($name, "'") != false) {
              $name = str_replace("'", "''", $name);
            }

            $moviesquery = "INSERT INTO `movies` VALUES ('$name', '$year')";
            $moviesqueryresult = $moviesdb->query($moviesquery);
            $movieTotal++;
            if ($moviesqueryresult) {
              $movieAdded++;
              $movieLast = $row_data[1];
            }

            break;
          case 'director':
            $row_data[2] = utf8_encode($row_data[2]);
            $name = $row_data[1];
            $movie = $row_data[2];
            $year = $row_data[3];

            if (strpos($name, "'") != false) {
              $name = str_replace("'", "''", $name);
            }
            if (strpos($movie, "'") != false) {
              $movie = str_replace("'", "''", $movie);
            }

            $directorsquery = "INSERT INTO `directors` VALUES('$name')";
            $directorsqueryresult = $moviesdb->query($directorsquery);
            $directedbyquery = "INSERT INTO `directed_by` VALUES('$movie', '$year', '$name')";
            $directedbyqueryresult = $moviesdb->query($directedbyquery);
            $directorTotal++;
            $directionTotal++;
            if ($directorsqueryresult) {
              $directorAdded++;
              $directorLast = $row_data[1];
            }
            if ($directedbyqueryresult) {
              $directionsAdded++;
              $directionsLast = $row_data[2].'/'.$row_data[1];
            }
            break;
          case 'actor':
            $row_data[2] = utf8_encode($row_data[2]);
            $row_data[4] = utf8_encode($row_data[4]);
            $name = $row_data[1];
            $movie = $row_data[2];
            $year = $row_data[3];
            $role = $row_data[4];

            if (strpos($name, "'") != false) {
              $name = str_replace("'", "''", $name);
            }
            if (strpos($movie, "'") != false) {
              $movie = str_replace("'", "''", $movie);
            }
            if (strpos($role, "'") != false) {
              $role = str_replace("'", "''", $role);
            }

            $actorquery = "INSERT INTO `actors` VALUES('$name', 'Male')";
            $actorqueryresult = $moviesdb->query($actorquery);
            $performedinquery = "INSERT INTO `performed_in` VALUES('$name', '$movie', '$year', '$role')";
            $performedinqueryresult = $moviesdb->query($performedinquery);
            $actorTotal++;
            $performanceTotal++;
            if ($actorqueryresult) {
              $actorAdded++;
              $actorLast = $row_data[1];
            }
            if ($performedinqueryresult) {
              $performanceAdded++;
              $performanceLast = $row_data[1].'/'.$movie = $row_data[2].'/'.$row_data[4];
            }
            break;
          case 'actress':
            $row_data[2] = utf8_encode($row_data[2]);
            $row_data[4] = utf8_encode($row_data[4]);
            $name = $row_data[1];
            $movie = $row_data[2];
            $year = $row_data[3];
            $role = $row_data[4];

            if (strpos($name, "'") != false) {
              $name = str_replace("'", "''", $name);
            }
            if (strpos($movie, "'") != false) {
              $movie = str_replace("'", "''", $movie);
            }
            if (strpos($role, "'") != false) {
              $role = str_replace("'", "''", $role);
            }

            $actorquery = "INSERT INTO `actors` VALUES('$name', 'Female')";
            $actorqueryresult = $moviesdb->query($actorquery);
            $performedinquery = "INSERT INTO `performed_in` VALUES('$name', '$movie', '$year', '$role')";
            $performedinqueryresult = $moviesdb->query($performedinquery);
            $actorTotal++;
            $performanceTotal++;
            if ($actorqueryresult) {
              $actorAdded++;
              $actorLast = $row_data[1];
            }
            if ($performedinqueryresult) {
              $performanceAdded++;
              $performanceLast = $row_data[1].'/'.$movie = $row_data[2].'/'.$row_data[4];
            }
            break;
          default:
            break;
        }
      }
      $movieFail = $movieTotal - $movieAdded;
      $actorFail = $actorTotal - $actorAdded;
      $directorFail = $directorTotal - $directorAdded;
      $directionsFail = $directionTotal - $directionsAdded;
      $performanceFail = $performanceTotal - $performanceAdded;
      echo '<ul>';
      echo '<li>Added <b>'.$movieAdded.'</b> movies out of '.$movieTotal.' movie records ('.$movieFail.' failures) [Last added: <i>'.$movieLast.'</i>]</li>';
      echo '<li>Added <b>'.$actorAdded.'</b> actors out of '.$actorTotal.' actor records ('.$actorFail.' failures) [Last added: <i>'.$actorLast.'</i>]</li>';
      echo '<li>Added <b>'.$directorAdded.'</b> directors out of '.$directorTotal.' director records ('.$directorFail.' failures) [Last added: <i>'.$directorLast.'</i>]</li>';
      echo '<li>Added <b>'.$directionsAdded.'</b> directions out of '.$directionTotal.' movie/director records ('.$directionsFail.' failures) [Last added: <i>'.$directionsLast.'</i>]</li>';
      echo '<li>Added <b>'.$performanceAdded.'</b> performances out of '.$performanceTotal.' actor/movie/role records ('.$performanceFail.' failures) [Last added: <i>'.$performanceLast.'</i>]</li>';
      echo '</ul>';

      echo '<form name = "form" action = "adminMenu.php" method = "post">';
      echo '<input type="hidden" name="session-id" value="'.$id.'" />';
      echo '<input type ="submit" value= "Back to Administration Menu" />';
      echo '</form>';

    }
  }
}
?>
</p>



<p><copyright>Roberto A. Flores &copy; 2019</copyright></p>
</div>

</body>
</html>
