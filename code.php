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
?>