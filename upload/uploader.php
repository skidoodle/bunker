<?php 
    class Uploader {
        private $ip;
        private $file;
        private $path;
        private $extension;
        private $new_name;
        private $new_directory;

        function setMessage($color, $message, $clickable = false) {
            if($clickable) {
                return '<a style="color: $color" href=https://example.com/' . $this->getNewName() . ' target="_blank">' . $message . '</a>';
            }
            return '<a style="color: $color">' . $message . '</a>';
        }

        function setFile($file) {
            $this->file = $file;
        }

        function setDirectory($path) {
            $this->path = $path;
        }

        function setNewName() {
            $this->new_name = $this->randomName();
        }

        function setNewDirectory() {
            $this->new_directory = $this->getDirectory() . $this->getNewName();
        }

        function getFile() {
            return $this->file['name'];
        }

        function getFileTemp() {
            return $this->file['tmp_name'];
        }

        function getDirectory() {
            return $this->path;
        }

        function getNewName() {
            return $this->new_name;
        }

        function getNewDirectory() {
            return $this->new_directory;
        }

        function getExtension() {
            $this->extension = explode('.', $this->getFile());
            $this->extension = strtolower(end($this->extension));

            return $this->extension;
        }

        function getUserIp() {
            if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
                $ip = getenv("HTTP_CLIENT_IP"); 
                else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
                    $ip = getenv("HTTP_X_FORWARDED_FOR"); 
                else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
                    $ip = getenv("REMOTE_ADDR"); 
                else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
                    $ip = $_SERVER['REMOTE_ADDR']; 
                else 
                    $ip = "unknown"; 
                return($ip);
                }

        function yoinkUserIp() {
            $ipfile = '/path/to/iplogger.txt';
            fwrite(fopen($ipfile, 'a'), $this->getNewName() . '-' . $this->getUserIp() . "\n");
            fclose();
        }

        function randomName() {
            $chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charslen = strlen($chars);

            $random = '';
            for ($i = 0; $i < 13; $i++) {
                $random .= $chars[rand(0, $charslen - 1)];
            }

            return $random . '.' . $this->getExtension();
        }

        function uploadFile() {
            $this->setNewName();
            $this->setNewDirectory();

            $message_fail = $this->setMessage('#631317', 'something went wrong');
            $message_success = $this->setMessage('#2d8734', 'upload was successful', true);

            if(move_uploaded_file($this->getFileTemp(), $this->getNewDirectory())) {
                echo $message_success;
                return;
            }
            echo $message_fail;
        }
    }
?>