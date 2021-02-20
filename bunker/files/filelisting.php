<?php
    class Listing {
        public $files;
        private $file;
        private $name;
        private $path;
        private $ippath;
        private $extension;

        function setColor($color, $string, $clickable = false) {
            if($clickable) {
                return '<a style="color: ' . $color . '" href=https://example.com/' . $this->getFile() . ' target="_blank">' . $string . '</a>';
            }
            return '<a style="color: ' . $color . '" target="_blank">' . $string . '</a>';
        }

        function setFile($file) {
            $this->file = $file;
        }

        function setDirectory($path) {
            $this->path = $path;
        }

        function setIpDirectory($ippath) {
            $this->ippath = $ippath;
        }

        function getFile() {
            return $this->file;
        }

        function getFileName() {
            $this->name = explode('.', $this->getFile());
            $this->name = strtolower(current($this->name));
            
            return $this->name;
        }

        function getFileSize() {
            return filesize($this->getDirectory() . $this->getFile());
        }

        function getDirectory() {
            return $this->path;
        }

        function getIpDirectory() {
            return $this->ippath;
        }

        function getExtension() {
            $this->extension = explode('.', $this->getFile());
            $this->extension = strtolower(end($this->extension));
            
            return $this->extension;
        }

        function getCreationDate() {
            $date[0] = date('Y.m.d', filemtime($this->getDirectory() . $this->getFile()));
            $date[1] = date('H:i', filemtime($this->getDirectory() . $this->getFile()));

            return $date;
        }

        function getDirSize() {
            $size = 0;

            foreach(glob($this->getDirectory() . '/*') as $file) {
                $size += filesize($file);
            }
            return $size;
        }

        function transformSize($bytes) {
            $array = ['B', 'KB', 'MB', 'GB', 'TB'];
            $index = 0;

            while($bytes > 1024) {
                $bytes /= 1024;
                $index++;
            }
            return round($bytes, 2) . ' ' . $array[$index];
        }

        function displayUserIp() {
            $ip = 'unknown';
            $handle = file($this->getIpDirectory());

            foreach($handle as $line) {
                if (strpos($line, $this->getFile()) === 0) {
                    $ip = explode('-', $line);
                    $ip = end($ip);
                }
            }
            return $ip;
        }

        function sortFilesByDate() {
            $scan = scandir($this->getDirectory());

            foreach ($scan as $file) {
                $this->files[$file] = filemtime($this->getDirectory() . $file);
            }
            arsort($this->files);
        
            $this->files = array_keys($this->files);
            $this->files = array_reverse($this->files);

            return $this->files;
        }
    }

    // file type coloring
    class Categorize {
        function getFileInfo($extension) {
            switch($extension) {
                case 'doc':
                case 'pdf':
                case 'rtf':
                case 'txt':
                case 'docx':
                    $category[0] = 'text';
                    $category[1] = '#fff';
                    break;
                case 'png':
                case 'jpg':
                case 'jpeg':
                case 'webp':
                case 'bmp':
                case 'gif':
                case 'ico':
                    $category[0] = 'image';
                    $category[1] = '#fff';
                    break;
                case 'mp4':
                case 'mov':
                case 'mkv':
                case 'wmv':
                case 'avi':
                case 'webm':
                    $category[0] = 'video';
                    $category[1] = '#fff';
                    break;
                case 'js':
                case 'asp':
                case 'css':
                case 'jsp':
                case 'php':
                case 'htm':
                case 'html':
                case 'aspx':
                    $category[0] = 'web';
                    $category[1] = '#fff';
                    break;
                case 'db':
                case 'log':
                case 'mdb':
                case 'sql':
                case 'tar':
                case 'xlsx':
                case 'csv':
                case 'xml':
                    $category[0] = 'database';
                    $category[1] = '#fff';
                    break;
                case '7z':
                case 'rar':
                case 'zip':
                case 'deb':
                case 'pkg':
                case 'tar.gz':
                    $category[0] = 'compressed';
                    $category[1] = '#fff';
                    break;
                case 'py':
                case 'exe':
                case 'apk':
                case 'jar':
                case 'msi':
                case 'bat':
                    $category[0] = 'executable';
                    $category[1] = '#fff';
                    break;
                case 'c':
                case 'h':
                case 'cs':
                case 'py':
                case 'vb':
                case 'sh':
                case 'cpp':
                case 'java':
                case 'class':
                case 'swift':
                    $category[0] = 'programming';
                    $category[1] = '#fff';
                    break;
                default:
                    $category[0] = 'unknown';
                    $category[1] = '#fff';
                    break;
            }
            return $category;
        }
    }
?>