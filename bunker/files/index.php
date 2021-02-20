<?php 
    session_start();
    if($_SESSION['valid'] == false) {
        header('location: .');
    }
?>
<html>
	<head>
	<title>bunker</title>
	</head>
    <link rel='stylesheet' href='files.css'>
</html>

<?php
    include('filelisting.php');

    $listing = new Listing();
    $category = new Categorize();

    $listing->setDirectory('../../files/');
    $listing->setIpDirectory('/path/to/iplogger.txt');
    $listing->sortFilesByDate();

    $badfiles = array('.htaccess', 'index.php', 'files to ignore');
    $count = 0;

    echo 'used space: ' . $listing->transformSize($listing->getDirSize()) . '<br><br>';
    echo '<table>';

    foreach($listing->files as $file) {
        if(!(is_dir($listing->getDirectory() . $file))) {
            $listing->setFile($file);
            
            if(!(in_array($listing->getFile(), $badfiles))) {
                $count++;
                echo '<tr>';
                    echo '<td style="font-size: 12px">' . $count . '<td>';
                    echo '<td>' . $listing->setColor($category->getFileInfo($listing->getExtension())[1], $listing->getFileName(), true) . '<td>';
                    echo '<td>' . $listing->getCreationDate()[0] . '</td>';
                    echo '<td>' . $listing->getCreationDate()[1] . '</td>';
                    echo '<td>' . $listing->setColor($category->getFileInfo($listing->getExtension())[1], $category->getFileInfo($listing->getExtension())[0] . ' - (' . strtoupper($listing->getExtension()) . ')' , false) . '</td>';
                    echo '<td>' . $listing->displayUserIp() . '</td>';
                    echo '<td>' . $listing->transformSize($listing->getFileSize()) . '</td>';
                echo '</tr>';
            }
        }
    }
    echo '</table>';
?>