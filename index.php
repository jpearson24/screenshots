<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link href="lightbox/lightbox.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-live-preview.js"></script>
    <link href="css/livepreview-demo.css" rel="stylesheet" type="text/css">
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
        table {
            width: 45%;
        }
        #inner {
            width: 50%;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div style="width: 1000px;">
        <div id="inner">
            <?php
                if( !isset($_COOKIE['login']) ) {
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
