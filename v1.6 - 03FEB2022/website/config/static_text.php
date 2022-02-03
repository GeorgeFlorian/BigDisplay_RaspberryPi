<?php
/*
 Change URL to point to http://localhost/config/static_text.php
 Write static display text to /config/static_text.txt from interface
 Get text from url by calling /code/get_text_from_url.sh
 Write text to /code/url_response.txt
 Display text from /code/url_response.txt
*/

function getFileContent () {
    $text_file_path = __DIR__."/static_text.txt";
    $text_lock_path = __DIR__."/static_text.lock";
    $text_lock_file = fopen($text_lock_path, 'a');

    $arrayInputs = new SplFixedArray(3);

    if(flock($text_lock_file, LOCK_SH)) {
        $text_file = fopen($text_file_path, "r");
        $arrayInputs = explode(PHP_EOL, fread($text_file, filesize($text_file_path)));
        fclose($text_file);
        flock($text_lock_file, LOCK_UN);    
    } else {
        echo "Could not open file to read".PHP_EOL;
    }
    fclose($text_lock_file);
    echo $arrayInputs[0];
}

getFileContent();

?>