<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link href="lightbox/lightbox.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-live-preview.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <script>
        $(document).ready(function() {
            $(".livepreview").click(function() {
                $("textarea").empty();
                //e.preventDefault();
                $.ajax({
                    url: $(this).attr("href"),
                    dataType: "text",
                    success: function (data) {
                        $("#text").text(data);
                    }
                });
                return false;
            });
        });
    </script>
    <style>
        body {
            text-align: center;
            font-family: 'Ubuntu', sans-serif;
        }
        .myButton {
        	-moz-box-shadow:inset 0px 1px 0px 0px #54a3f7;
        	-webkit-box-shadow:inset 0px 1px 0px 0px #54a3f7;
        	box-shadow:inset 0px 1px 0px 0px #54a3f7;
        	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #007dc1), color-stop(1, #0061a7));
        	background:-moz-linear-gradient(top, #007dc1 5%, #0061a7 100%);
        	background:-webkit-linear-gradient(top, #007dc1 5%, #0061a7 100%);
        	background:-o-linear-gradient(top, #007dc1 5%, #0061a7 100%);
        	background:-ms-linear-gradient(top, #007dc1 5%, #0061a7 100%);
        	background:linear-gradient(to bottom, #007dc1 5%, #0061a7 100%);
        	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#007dc1', endColorstr='#0061a7',GradientType=0);
        	background-color:#007dc1;
        	-moz-border-radius:3px;
        	-webkit-border-radius:3px;
        	border-radius:3px;
        	border:1px solid #124d77;
        	display:inline-block;
        	cursor:pointer;
        	color:#ffffff;
        	font-family:Arial;
        	font-size:13px;
        	padding:6px 24px;
        	text-decoration:none;
        	text-shadow:0px 1px 0px #154682;
        }
        .myButton:hover {
        	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #0061a7), color-stop(1, #007dc1));
        	background:-moz-linear-gradient(top, #0061a7 5%, #007dc1 100%);
        	background:-webkit-linear-gradient(top, #0061a7 5%, #007dc1 100%);
        	background:-o-linear-gradient(top, #0061a7 5%, #007dc1 100%);
        	background:-ms-linear-gradient(top, #0061a7 5%, #007dc1 100%);
        	background:linear-gradient(to bottom, #0061a7 5%, #007dc1 100%);
        	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#0061a7', endColorstr='#007dc1',GradientType=0);
        	background-color:#0061a7;
        }
        .myButton:active {
        	position:relative;
        	top:1px;
        }

        table {
            width: 45%;
        }
        #outer {
            width: 100%;
            text-align: center;
            /*border: 1px solid blue;*/
        }
        #inner {
            width: 80%;
            margin: 0 auto;
            /*border: 1px solid red;*/
        }
        p {
            /*text-align: center;*/
        }
        form {
            display: inline-block;
            text-align: center;
        }
    </style>
    <title>Screenshots</title>
</head>
<body>
    <div id="outer">
        <div id="inner">
            <?php
                if( !isset($_COOKIE['login']) ) {
                    echo '<h1>Login</h1>';
                    if( $_GET['p'] == 'w' ) {
                        echo '<p style="color: red;">
                        Password is wrong.
                        </p>
                        <form action="process.php" method="post">
                            <input type="password" name="Password" />
                            <input type="submit" value="Submit" />
                        </form>';
                    }
                    elseif( empty($_POST) ) {
                        echo '<form action="process.php" method="post">
                            <input type="password" name="Password" />
                            <input type="submit" value="Submit" />
                        </form>';
                    }
                }
                else {
                    include('body.php');
                }
            ?>
        </div>
    </div>
</body>
</html>
