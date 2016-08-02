<!DOCTYPE html>
<html>
<head>
  <title>Logic is Awesome</title>
</head>
<body>
<?php


//Config is here
//$lines = file('https://ssby.me/ss/'); // This is the URL, if it changes, put it here.
//$dir = dirname($_SERVER['PHP_SELF']);
$dir = getcwd();
$txttypes = array("txt","pdf","doc","html","php"); //Text File Types
$imgtypes = array("png","jpg","jpeg"); //Image File types

//echo $dir;

$lines = scandir($dir); // This is the URL, if it changes, put it here. ( should make this self scan)

// Functions Go Here
function date_compare($a, $b)
{
    $t1 = strtotime($a[1]);
    $t2 = strtotime($b[1]);
    return $t1 - $t2;
}


// Arrarry Primeing.
$textfiles[0][0] = "<h1> Text Files: </h1><br>\n";
$textfiles[0][1] = "";
$textfiles[0][2] = "";
$curtxt = 1;
$imagefiles[0][0] = "<h1> Image Files: </h1><br>\n";
$imagefiles[0][1] = "";
$imagefiles[0][2] = "";
$curimg = 1;
// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {

    /*
	if (strpos(substr($line,0,18),'<a href="')) {
        //echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
        $sublines = preg_split('/\s+/', $line);
        $filetype = substr($sublines[2], -7, 3);
        $filelink = $sublines[1] . " " . $sublines[2];
        $filedate = $sublines[3] . " " . $sublines[4];
        $filesize = $sublines[5];
		*/

		$file = new SplFileInfo($line);
		
		$filepath = $file->getRealPath();
		$filename = $file->getBasename();
        $filedate = date('d, M, Y - H:m:s', $file->getMTime()) . " - ";
        //$filesize = $file->getSize(); Make Bytes to human readable sizes later. 
		$filesize = '';
		$filetype = $file->getExtension();
		
		$filelink = '<a href="' . $filepath . $filename . '">' . $filename . '</a>';


        if (in_array($filetype, $txttypes)){
            // Is Txt File
            $textfiles[$curtxt][0] = $filedate;
            $textfiles[$curtxt][1] = $filelink;
            $textfiles[$curtxt][2] = $filesize;
            $curtxt++;
        }
        elseif (in_array($filetype, $imgtypes)){
            // Is img File
            $imagefiles[$curimg][0] = $filedate;
            $imagefiles[$curimg][1] = $filelink;
            $imagefiles[$curimg][2] = $filesize;
            $curimg++;
        }
        /* Debug Info
        foreach ($sublines as $sub_num => $subline) {
            echo "Line #<b>{$sub_num}</b> : " . htmlspecialchars($subline) . "<br />\n";
        }
        echo "<br />\n";
        echo "Data Subset:<br />\n";

        echo "File Type: $filetype";
        echo "<br />\n";
        echo "File Link: " . htmlspecialchars($filelink) . " => $filelink";
        echo "<br />\n";
        echo "File Date: $filedate";
        echo "<br />\n";
        echo "File Size: $filesize";
        echo "<br />\n";

        echo "<br />\n";
        echo "<br />\n";

        
    } */
}

?>

        <div style="float:left; width:50%;">
        <?
            usort($imagefiles, 'date_compare');
            foreach ($imagefiles as $lrow => $image) {
                if ($lrow = 0){
                    echo $image[0];
                }
                else{
                    echo $image[0] . "\t" . $image[1] . "\t" . $image[2] . "<br>\n";
                }

            }
        ?>
        </div>
        <div style="float:left; width:50%;">
        <?
            usort($textfiles, 'date_compare');
            foreach ($textfiles as $rrow => $text) {
                if ($rrow = 0){
                    echo $text[0];
                }
                else{
                    echo $text[0] . "\t" . $text[1] . "\t" . $text[2] . "<br>\n";
                }
            }
        ?>
        </div>
        <div style="clear:both;"></div> <!-- Yes, I know, I'm bad, and i'm lazy -->
        <br><br>
        Generated :
        <?
            date_default_timezone_set('Australia/Melbourne');
            $date = date('m/d/Y h:i:s a', time());
            echo $date;
        ?>
</body>
</html>