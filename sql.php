<?php

    $server = 'mysql.ssby.me';
    $db = 'ssby';
    $user = '';
    $pass = '';
    $table = 'images';

    mysql_connect($server, $user, $pass) or die(mysql_error());
    mysql_select_db($db) or die(mysql_error());

    function dbinsert($file, $height, $width) {
        mysql_query("INSERT INTO images (image, height, width) VALUES('$file', '$height', '$width')");
        $new = 'uploaded/'.$file;
        rename($file, $new);
        $new = $file;
        if (is_file($file)) {
            $info = pathinfo($file);
            $extension = strtolower($info['extension']);
            if (in_array($extension, array('jpg', 'jpeg', 'png', 'gif'))) {

                switch ($extension) {
                    case 'jpg':
                        $img = imagecreatefromjpeg("{$pathToImage}");
                        break;
                    case 'jpeg':
                        $img = imagecreatefromjpeg("{$pathToImage}");
                        break;
                    case 'png':
                        $img = imagecreatefrompng("{$pathToImage}");
                        break;
                    case 'gif':
                        $img = imagecreatefromgif("{$pathToImage}");
                        break;
                    default:
                        $img = imagecreatefromjpeg("{$pathToImage}");
                }
                // load image and get image size

                $width = imagesx($img);
                $height = imagesy($img);

                // calculate thumbnail size
                $new_width = $thumbWidth;
                $new_height = floor($height * ( $thumbWidth / $width ));

                // create a new temporary image
                $tmp_img = imagecreatetruecolor($new_width, $new_height);

                // copy and resize old image into new image
                imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    $file = $file.$extension;
                // save thumbnail into a file
                imagejpeg($tmp_img, "{$pathToImage}");
                $result = $file;
            }
            else {
                $result = 'Failed | Not an accepted image type (JPG, PNG, GIF).';
            }
        } else {
            $result = 'Failed | Image file does not exist.';
        }
        return $result;
    }

?>