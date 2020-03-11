<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <style>

        .container_img {
            border: 1px solid grey;
            padding-left: 20px;
            padding-right: 20px;
            margin: 0 auto;
            margin-bottom: 20px;
            width: 642px;
            position: relative;
        }

        .loading {
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            position: absolute;
            display: block;
            opacity: 0.7;
            background-color: #fff;
            z-index: 99;
            text-align: center;
            display: none;
        }

        .loader {
            color: black;
            font-size: 20px;
            margin: 100px auto;
            width: 1em;
            height: 1em;
            border-radius: 50%;
            position: relative;
            text-indent: -9999em;
            -webkit-animation: load4 1.3s infinite linear;
            animation: load4 1.3s infinite linear;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
        }
        @-webkit-keyframes load4 {
            0%,
            100% {box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;}
            12.5% {box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;}
            25% {box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;}
            37.5% {box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;}
            50% {box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;}
            62.5% {box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;}
            75% {box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;}
            87.5% {box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;}
        }
        @keyframes load4 {
            0%,
            100% {box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;}
            12.5% {box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;}
            25% {box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;}
            37.5% {box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;}
            50% {box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;}
            62.5% {box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;}
            75% {box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;}
            87.5% {box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;}
        }

        img {
            max-height: 600px;
            margin: 0 auto;
        }

        .imagefor {
            text-align: center;
        }
    </style>
    <title>Новомет - Распознование</title>
</head>
<body>

<div id="content">

    <div class="container_img">
        <div class="loading">
            <div class="loader"></div>
        </div>
        <h3>Image test_vision.png </h3>
        <div class="imagefor">
            <img src="resources/test_vision.png" width="600px">
        </div>
        <div class="bound"></div>
    </div>


    <div class="container_img">
        <div class="loading"><div class="loader"></div></div>
        <h3>Image test_vision1.png </h3>
        <div class="imagefor">
            <img src="resources/test_vision1.png" width="600px">
        </div>
        <div class="bound"></div>
    </div>

    <div class="container_img">
        <div class="loading"><div class="loader"></div></div>
        <h3>Image hi.jpg </h3>
        <div class="imagefor">
            <img src="resources/hi.jpg" width="600px">
        </div>
        <div class="bound"></div>
    </div>

    <div class="container_img">
        <div class="loading"><div class="loader"></div></div>
        <h3>Image 1.jpg </h3>
        <div class="imagefor">
            <img src="resources/1.jpg" width="600px">
        </div>
        <div class="bound"></div>
    </div>

    <div class="container_img">
        <div class="loading"><div class="loader"></div></div>
        <h3>Image 2.jpg </h3>
        <div class="imagefor">
            <img src="resources/2.jpg" width="600px">
        </div>
        <div class="bound"></div>
    </div>

    <div class="container_img">
        <div class="loading"><div class="loader"></div></div>
        <h3>Image 3</h3>
        <div class="imagefor">
            <img src="resources/3.jpg" width="600px">
        </div>
        <div class="bound"></div>
    </div>

    <div class="container_img">
        <div class="loading"><div class="loader"></div></div>
        <h3>Image 4</h3>
        <div class="imagefor">
            <img src="resources/4.jpg" width="600px">
        </div>
        <div class="bound"></div>
    </div>

</div>

    <script>

        var url = 'detect_script.php';
        var data = { img_path: "resources/test_vision.png"};

        var images = [];
        var bounds = [];
        var loaders = [];

        async function getAnswer(i)
        {
            loaders[i].style.display='block';
            var data_img = { img_path: images[i].getAttribute("src")};
            const response = await fetch(url, {
                method: 'POST',
                body: JSON.stringify(data_img),
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();
            console.log(data);
                // console.log(response);
            bounds[i].innerHTML =  'texts found:' + data.length + '<br>';
            var j = 0;
            data.forEach(function(item){
                j++;
                bounds[i].innerHTML =  bounds[i].innerHTML + j + ') ' + item + '<br>'
            });
            loaders[i].style.display='none';
        }

        window.onload = async function () {
            images = document.getElementsByTagName('img');
            bounds = document.getElementsByClassName('bound');
            loaders = document.getElementsByClassName('loading');

            for (var i = 0 ; i < images.length; i++) {
                await getAnswer(i);
            }

        };

    </script>

</body>
</html>
