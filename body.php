<?php
    include('pagination.class.php');
    date_default_timezone_set('Australia/Sydney');
    $files = array(); // Order by date source: http://stackoverflow.com/questions/2667065/sort-files-by-date-in-php
    $images = array(); //Dummy Array for Image list
    $texts = array(); //Dummy Array for text list
    $imgtype = array("png","jpg","jpeg"); //Image File types
    $txttype = array("txt","pdf","doc"); //Text File Types
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
            if(in_array(substr($file, -3),$imgtype)) {
                //These are images
                array_push($images, $file);
                //echo 'img found';
            }
            elseif(in_array(substr($file, -3),$txttype)) {
                //These are texts
                array_push($texts, $file);
                //echo 'txt found';
            }else{
                //Should do somthing with the not images/texts
                //echo 'else found';
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
            if( !isset($i) ) {
                $i = 1;
            }
            $filedate = date('d/m/y',filemtime($imgpage));
            $filetime = date('H:i',filemtime($imgpage));
            echo "<tr>
                <td class=\"thumbs\">
                    <a href=\"$imgpage\" data-lightbox=\"images\" data-thumbnail-src=\"$imgpage\">
                        <img src=\"thumbnail.php?file=$imgpage&maxw=50&maxh=25\" />
                    </a>
                    <input type=\"hidden\" value=\"https://ssby.me/ss/$imgpage\" id=\"but-$i\" />
                </td>
                <td>$filedate</td>
                <td>$filetime</td>
                <td><button class=\"btn\">Copy</button></td>
            </tr>"; // Thumbnail source: http://www.webgeekly.com/tutorials/php/how-to-create-an-image-thumbnail-on-the-fly-using-php/
            $i++;
        }

        echo '</table></div>';

        // Text files
        echo '<div style="float: right;">
        <textarea rows="10" cols="60" id="text"></textarea>
        <table>';
        foreach($txtpages as $txtpage) {
            $filedate = date('d/m/y',filemtime($txtpage));
            $filetime = date('H:i',filemtime($txtpage));
            echo "<tr><td><a href=\"$txtpage\" class=\"livepreview\">$txtpage</a></td><td>$filedate</td><td>
            $filetime
            </td></tr>";
        }
        echo '</table></div><div style="clear: both;">
        '.$pageNumbers.'
        </div>';
    }else{
        echo 'Error: Unable to read the directory';
    }
?>
<script src="lightbox/lightbox.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>
<script>
    new Clipboard('.btn', {
        text: function() {
            return document.querySelector('input[type=hidden]').value;
        }
    });
</script>