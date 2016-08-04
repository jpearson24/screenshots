<?php
    $password = $_POST['Password'];
    $logout = $_POST['logout'];
    // Hash: cd8877aef9f02a65df87c06204d6ad0f
    //echo md5(sha1(''));

    if( $logout ) {
        unset($_COOKIE['login']);
        setcookie('login', 'allow', time()-3600, '/ss');
    }
    elseif( !isset($password) ) {
        header('Location: https://ssby.me/ss/?p=w');
    }
    elseif( isset($password) ) {
        $password = md5(sha1($password));
        if( $password != 'cd8877aef9f02a65df87c06204d6ad0f' ) {
            header('Location: https://ssby.me/ss/?p=w');
        }
        else {
            setcookie('login', 'allow', time()+60*60*24*365, '/ss');
            header('Location: https://ssby.me/ss/');
        }
    }
?>