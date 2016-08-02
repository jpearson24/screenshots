<html>
<head>
    <link href="lightbox/lightbox.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <style>
        body {
            font-family: 'Ubuntu', sans-serif;
        }
    </style>
    <script>
        $(document).ready(function(){

        $("h2").append('') // to add caption
        $(".text a").hover(function(){ // hover link

            var largePath = $(this).attr("name");   // grab name of link

                    /** add the file extension to the name that was grabbed perviously **/
            $("#largeImg").attr({ src: largePath + ".txt" };
            $("h2 em").html(" (" + largePath + ")"); return false;  // add the caption.
        });
        });
    </script>
</head>
<body>
    <?php
        include('pagination.class.php');
        date_default_timezone_set('Australia/Sydney');
        $files = array(); // Order by date source: http://stackoverflow.com/questions/2667065/sort-files-by-date-in-php
        if ($handle = opendir('.')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                   $files[filemtime($file)] = $file;
                }
            }
            closedir($handle);

            // sort
            ksort($files);
            // find the last modification
            $reallyLastModified = end($files);

            $files = array_reverse($files);

            echo '<div style="float: left;"><table>';
            foreach($files as $file) {
                $filedate = date('d/m/y',filemtime($file));
                $filetime = date('H:i',filemtime($file));
                if(strlen($file)-strpos($file,".png")== 4){
                   if ($file == $reallyLastModified) {
                     // do stuff for the real last modified file
                   }
                   echo "<tr><td class=\"thumbs\"><a href=\"$file\" data-lightbox=\"images\"><img src=\"thumbnail.php?file=$file&maxw=50&maxh=25\" /></a></td><td>$filedate</td><td>
                   $filetime
                   </td></tr>"; // Thumbnail source: http://www.webgeekly.com/tutorials/php/how-to-create-an-image-thumbnail-on-the-fly-using-php/
                }
            }
            echo '</table>'.$pageNumbers.'</div>';

            echo '<div style="float: right;"><p><img id="largeImg"  alt="Hover Over Link" src="grave_preview/phil.JPG" style="border: solid 1px #ccc; width: 400px; height: 300px; padding: 5px;"></p><table>';
            foreach($files as $file) {
                $filedate = date('d/m/y',filemtime($file));
                $filetime = date('H:i',filemtime($file));
                if(strlen($file)-strpos($file,".txt")== 4){
                   if ($file == $reallyLastModified) {
                     // do stuff for the real last modified file
                   }
                   echo "<tr><td class=\"text\"><a href=\"$file\" name=\"$file\">$file</a></td><td>$filedate</td><td>
                   $filetime
                   </td></tr>";
                }
            }
            echo '</table></div>';
        }
    ?>
    <script src="lightbox/lightbox.js"></script>
</body>
</html>

