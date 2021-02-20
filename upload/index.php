<html>
    <link rel='stylesheet' href='upload.css'>
    <body>        
        <div id='aligned'>
            <form id='form' action='' method='post' enctype='multipart/form-data'>
                <input id='file' type='file' name='file'>
            </form>
        </div>
        <script>
            document.getElementById('file').onchange = function() {
                document.getElementById('form').submit();
            };
        </script>
    </body>
</html>

<?php
    error_reporting(0);
    include('uploader.php');

    $file = $_FILES['file'];
    if(isset($file)) {
        $uploader = new Uploader();

        $uploader->setFile($file);
        $uploader->setDirectory('../files/');

        $message_fail = $uploader->setMessage('#911c28', 'something went wrong');
        $message_success = $uploader->setMessage('#a7bcd1', 'upload was successful', true);

        
        $uploader->uploadFile($file);
        $uploader->yoinkUserIp();

        header('refresh: 5');
    }
?>