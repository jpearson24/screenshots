<?php
    $password = $_POST['Password'];
    $password = md5(sha1($password));

    // if( empty($_POST) ) {
    //     echo '<form action="" method="post">
    //         <input type="password" name="Password" />
    //         <input type="submit" value="Submit" />
    //     </form>';
    // }
    // elseif( !empty($_POST) && $password != 'cd8877aef9f02a65df87c06204d6ad0f' ) {
    //     echo '<p style="color: red;">
    //     Password is wrong.
    //     </p>
    //     <form action="" method="post">
    //         <input type="password" name="Password" />
    //         <input type="submit" value="Submit" />
    //     </form>';
    // }
    if( empty($_GET) ) {

    }
    elseif( $_GET['show'] == 'true' ) {
    //echo md5(sha1('FireSword$06'));
?><html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link href="lightbox/lightbox.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-live-preview.js"></script>
    <link href="css/livepreview-demo.css" rel="stylesheet" type="text/css">
    <script>
        // $(".livepreview").livePreview({
        //     // trigger: 'hover',
        //     // viewWidth: 300,
        //     // viewHeight: 200,
        //     // targetWidth: 300,
        //     // targetHeight: 200,
        //     // scale: '0.5',
        //     // offset: 50,
        //     //position: 'left'
        // });
        $(document).ready(function() {
            $(".livepreview").click(function() {
                $("textarea").empty();
                $.ajax({
                    url: $(this).attr("href"),
                    dataType: "text",
                    success: function (data) {
                        $("#text").text(data);
                    }
                });
                e.preventDefault();
            });
        });
    </script>
    <style>
        table {
            width: 45%;
        }
    </style>
</head>
<body>
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
                $filedate = date('d/m/y',filemtime($imgpage));
                $filetime = date('H:i',filemtime($imgpage));
                echo "<tr><td class=\"thumbs\"><a href=\"$imgpage\" data-lightbox=\"images\" data-thumbnail-src=\"$imgpage\"><img src=\"thumbnail.php?file=$imgpage&maxw=50&maxh=25\" /></a></td><td>$filedate</td><td>$filetime</td></tr>"; // Thumbnail source: http://www.webgeekly.com/tutorials/php/how-to-create-an-image-thumbnail-on-the-fly-using-php/
            }

            echo '</table>'.$pageNumbers.'</div>';

            // Text files
            echo '<div style="float: right;">
            <textarea rows="10" cols="60" id="text"></textarea>
            <table>';
            foreach($txtpages as $txtpage) {
                $filedate = date('d/m/y',filemtime($txtpage));
                $filetime = date('H:i',filemtime($txtpage));
                echo "<tr><td><a href=\"$file\" class=\"livepreview\">$txtpage</a></td><td>$filedate</td><td>
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
<?php } ?>
