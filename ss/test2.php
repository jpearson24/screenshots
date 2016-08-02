<html>
<head>
    <link href="lightbox/lightbox.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-live-preview.js"></script>
    <link href="css/livepreview-demo.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".livepreview").livePreview();
        });
    </script>
</head>
<body>
    <?php
        include('pagination.class.php');
        date_default_timezone_set('Australia/Sydney');
        $files = array(); // Order by date source: http://stackoverflow.com/questions/2667065/sort-files-by-date-in-php
        $imgtype = array("png","jpg","jpeg"); //Image File types
        $txttype = array("txt","pdf","doc","html","php"); //Text File Types
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

            foreach($files as $file) {
                //Split Array $Files into images and texts
                //Is [strlen($file)-strpos($file,".png")== 4] the best way to check the file's extension?
                if(in_array($file,$imgtype)) {
                    //These are images
                    array_push($images, $file);
                }
                elseif(in_array($file,$txttype)) {
                    //These are texts
                    array_push($texts, $file);

                }else{
                    //Should do somthing with the not images/texts

                }
            }

            //Default pagein to 1 if no page is given.
            //I'm sure there is a better way to do this,
            // maybe $pagein = $_GET["page"] ?: 1;
            if(isset($_GET["page"])){
                $pagein = $_GET["page"];
            }else{
                $pagein = 1;
            }
            $imagepages = new pagination($images,$pagein,10);
            $textpages = new pagination($texts,$pagein,10);
            $imgpages = $imagepages->getResults();
            $txtpages = $textpages->getResults();

            //Get longer Page Links
            if(count($images)>count($texts)){
                $pageNumbers = $imagepages->getLinks();
            }else{
                $pageNumbers = $textpages->getLinks();
            }

            //Splitting the results makes things painful. You may want to make an Iframe
            //page and load this script twice, once for images and once for txts and
            //split them in the iframe

            echo '<div style="float: left;"><table>';
            foreach($imgpages as $imgpage) {
                $filedate = date('d/m/y',filemtime($imgpage));
                $filetime = date('H:i',filemtime($imgpage));
                echo "<tr><td class=\"thumbs\"><a href=\"$imgpage\" data-lightbox=\"images\" data-thumbnail-src=\"$imgpage\"><img src=\"thumbnail.php?file=$imgpage&maxw=50&maxh=25\" /></a></td><td>$filedate</td><td>
                $filetime
                </td></tr>"; // Thumbnail source: http://www.webgeekly.com/tutorials/php/how-to-create-an-image-thumbnail-on-the-fly-using-php/
            }
            echo '</table>'.$pageNumbers.'</div>';

            // Text files
            echo '<div style="float: right;"><table>';
            foreach($txtpages as $txtpage) {
                $filedate = date('d/m/y',filemtime($txtpage));
                $filetime = date('H:i',filemtime($txtpage));
                echo "<tr><td><a href=\"$txtpage\" class=\"livepreview\">$txtpage</a></td><td>$filedate</td><td>
                $filetime
                </td></tr>";
            }
            echo '</table></div>';
        }else{
            echo 'Error: Unable to read the directory';
        }
    ?>
    <script src="lightbox/lightbox.js"></script>
</body>
</html>

