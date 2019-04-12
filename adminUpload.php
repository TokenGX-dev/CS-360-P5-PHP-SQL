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
  if($_FILES[ 'uploaded' ][ 'error' ] > 0){
    echo 'A problem was detected:<br/>';
    switch ($_FILES[ 'uploaded' ][ 'error' ]) {
      case 1: echo '* File exceeded maximum size allowed by server.<br/>';      break;
      case 2: echo '* File exceeded maximum size allowed by application.<br/>'; break;
      case 3: echo '* File could not be fully uploaded.<br/>';                  break;
      case 4: echo '* File was not uplaoded.<br/>';
    }
    $okay = false;
  }
  if($okay && $_FILES[ 'uploaded' ][ 'type' ] != 'text/plain'){
    echo 'A problem was detected:<br/>';
    echo '* File is not a text file.<br/>';
    $okay = false;
  }
  $filename = 'file.txt';
  if($okay){
    if(is_uploaded_file($_FILES[ 'uploaded' ][ 'tmp_name' ])){
      if(!move_uploaded_file($_FILES[ 'uploaded' ][ 'tmp_name' ], $filename)){
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
      echo 'File uploaded successfully.';
      $file = fopen($filename, 'r');
      $fileContents = nl2br(fread($file, filesize($filename)));
      fclose($file);
      $

    }
  }
}
?>
</p>



<p><copyright>Roberto A. Flores &copy; 2019</copyright></p>
</div>

</body>
</html>
