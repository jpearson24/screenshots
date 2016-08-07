<?php
    include('code.php');

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
            // Thumbnail options: maxw=100&maxh=100
            echo "<tr>
                <td class=\"thumbs\">
                    <a href=\"$imgpage\" data-lightbox=\"images\" data-thumbnail-src=\"$imgpage\">
                        <img src=\"thumbnail.php?file=$imgpage&maxw=100&maxh=100\" />
                    </a>
                    <input type=\"hidden\" value=\"https://ssby.me/ss/$imgpage\" id=\"but-$i\" />
                </td>
                <td>$filedate</td>
                <td>$filetime</td>
                <td><button class=\"btn myButton\" data-clipboard-text=\"http://ssby.me/ss/$imgpage\" >Copy</button></td>
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
            echo "<tr><td><a href=\"$txtpage\" class=\"livepreview\">$txtpage</a><input type=\"hidden\" value=\"https://ssby.me/ss/$txtpage\" id=\"but-$i\" /></td><td>$filedate</td><td>
            $filetime
            </td><td><button data-clipboard-text=\"http://ssby.me/ss/$txtpage\" class=\"btn myButton\">Copy</button></td></tr>";
        }
        echo '</table></div><div style="clear: both;">
        '.$pageNumbers.' <form action="process.php" method="post">
        <input type="submit" value="Logout" name="logout" />
        </form>
        </div>';
    }else{
        echo 'Error: Unable to read the directory';
    }
?>
<script src="lightbox/lightbox.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>
<script>
    // new Clipboard('.btn', {
    //     text: function() {
    //         return document.querySelector('input[type=hidden]').value;
    //     }
    // });
    new Clipboard('.btn');
</script>