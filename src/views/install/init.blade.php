<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>NCCMS - Installation</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <style>
        body {
            background: #cccccc;
        }
        .container {
            display: block;
            position: absolute;
            top: 25%;
            left: 20%
        }
        h1 {
            text-transform: uppercase;
            font-size: 46px;
            transform: 			translateY(-50%);
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container">
        <h1>Initiate NCCMS Installation <span id="wait"></span></h1>
        <div id="respHolder"></div>
    </div>

    <script>
        var xmlhttp;
        function initNccmsFolder(){
            if (window.XMLHttpRequest)
            {
                xmlhttp = new XMLHttpRequest();
            }
            else
            {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200))
                {
                    top.location.href="{{ URL::to('installation') }}";
                }
            }
            xmlhttp.open("GET", "{{ URL::to('installation/init/folder') }}", true);
            xmlhttp.send();
        }

        var dots = window.setInterval( function() {
            var wait = document.getElementById("wait");
            if ( wait.innerHTML.length > 2 )
                wait.innerHTML = "";
            else
                wait.innerHTML += ".";
        }, 600);

        document.addEventListener("DOMContentLoaded", function(event) {
            initNccmsFolder();
        });
    </script>
</body>
</html>