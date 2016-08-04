<?php
    $password = $_POST['Password'];
    $password = md5(sha1($password));
    //echo md5(sha1(''));
    print_r($_COOKIE).'<br />';

    if( !isset($_COOKIE['login']) ) {
        echo 'false';
        if( empty($_POST) ) {
            echo '<form action="" method="post">
                <input type="password" name="Password" />
                <input type="submit" value="Submit" />
            </form>';
        }
        elseif( !empty($_POST) && $password != 'cd8877aef9f02a65df87c06204d6ad0f' ) {
            echo '<p style="color: red;">
            Password is wrong.
            </p>
            <form action="" method="post">
                <input type="password" name="Password" />
                <input type="submit" value="Submit" />
            </form>';
        }
    }
    elseif( $password == 'cd8877aef9f02a65df87c06204d6ad0f' || isset($_COOKIE['login']) ) {
        setcookie('login');
        echo 'true';
        echo 'foo';
?>