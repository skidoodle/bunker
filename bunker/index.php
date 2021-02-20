<?php 
    session_start();
?>

<html>
    <link rel='stylesheet' href='login.css'>
    <div id='aligned'>
        <form action='' method='post' enctype='multipart/form-data'>
            <input type='password' name='password' placeholder='password' autofocus>
            <input type='submit' name='submit'>
        </form>
</html>

<?php
    error_reporting(0);

    if(isset($_POST['submit'])) { 
        if($_POST['password'] == 'UR PASSWORD HERE') {
            $_SESSION['valid'] = true;

            header('location: files');
        } else {
            echo '<div style="color: #fff">incorrect password</div>';
        }
    }
?>
