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
  if (!isset($_POST['pass'])) {
    die("pass not received");
  } else {
    $pass = $_POST['pass'];
  }
  do {
    $id = md5(microtime().$_SERVER['REMOTE_ADDR']);
  } while (isset($_SESSION[$id]));
  $_SESSION[$id]["pass"] = $pass;
} else {
  $id = $_POST["session-id"];
  if (!isset($_SESSION[$id]["pass"])) {
    die("password not read");
  } else {
    $pass = $_SESSION[$id]["pass"];
  }
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
  echo '<h2 id="header">Administrator Menu</h2>';
  echo '<h3>Upload Data File</h3>';
  echo '<form enctype = "multipart/form-data" name = "form" action ="adminUpload.php" method = "post" onsubmit="return checkFile();">';
  echo '<table border = "0" cellpadding="1">';
  echo '<input type="hidden" name="session-id" value="'.$id.'" />';
  echo '<tr><td><input type = "file" accept = ".txt" name="uploaded"/></td></tr>';
  echo '<tr><td><input type ="submit" value= "Upload" /></td></tr>';
  echo '</table>';
  echo '</form>';
  echo '<h3>Deleting Information</h3>';
  echo '<form name = "form2" action = "adminDelete.php" method = "post" onsubmit="return deleteData();">';
  echo '<input type="hidden" name="session-id" value="'.$id.'" />';
  echo '<input type ="submit" value= "Delete All" />';
  echo '</form>';
}
?>
<script>
function checkFile() {
  var path = document.forms["form"]["uploaded"].value;
  var fileName = path.replace(/^.*\\/, "");
  var ext = fileName.substring(fileName.lastIndexOf('.'));
  if (fileName == "") {
    alert("A file must be chosen to upload");
    return false;
  }
  else if (ext.toLowerCase() != ".txt") {
    alert("File must be a .txt type");
    return false;
  }
  else {
    return confirm("Uploading data file " + fileName);
  }
}

function deleteData() {
  return confirm("All data will be deleted. Proceed?");
}

</script>
</p>



<p><copyright>Roberto A. Flores &copy; 2019</copyright></p>
</div>

</body>
</html>
