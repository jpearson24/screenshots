<?php
    $password = $_POST['Password'];
    $password = md5(sha1($password));
    //echo md5(sha1(''));
    print_r($_COOKIE).'<br />';

    if( !isset($_COOKIE['login']) ) {
        echo 'false';
        
    }
    elseif( $password == 'cd8877aef9f02a65df87c06204d6ad0f' || isset($_COOKIE['login']) ) {
        setcookie('login');
        echo 'true';
        echo 'foo';
?>