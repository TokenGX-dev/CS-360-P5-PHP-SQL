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
}
?>
</p>



<p><copyright>Roberto A. Flores &copy; 2019</copyright></p>
</div>

</body>
</html>
