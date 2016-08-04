<?php
    $password = $_POST['Password'];
    $logout = $_POST['logout'];
    // Hash: cd8877aef9f02a65df87c06204d6ad0f
    // Hash: 1619d7adc23f4f633f11014d2f22b7d8
    //echo md5(sha1(''));

    if( $logout ) {
        unset($_COOKIE['login']);
        setcookie('login', 'allow', time()-3600, '/ss');
        header('Location: https://ssby.me/ss/');
    }
    elseif( !isset($password) ) {
        header('Location: https://ssby.me/ss/?p=w');
    }
    elseif( isset($password) ) {
        echo $password = md5(sha1($password));
        if( $password != 'cd8877aef9f02a65df87c06204d6ad0f' || $password != '1619d7adc23f4f633f11014d2f22b7d8' ) {
            header('Location: https://ssby.me/ss/?p=w');
        }
        elseif( $password == '1619d7adc23f4f633f11014d2f22b7d8' || $password == 'cd8877aef9f02a65df87c06204d6ad0f' ) {
            setcookie('login', 'allow', time()+60*60*24*365, '/ss');
            header('Location: https://ssby.me/ss/');
        }
    }
?>