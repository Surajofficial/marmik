<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="{{ asset('js/static/face-api.min.js') }}"></script>
    <script defer src="{{ asset('js/static/script.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
            width: 100vw;
            display: flex;
            justify-content: center;
            background-color: #f4ecec;
        }

        canvas {
            position: absolute;
            text-align: center;
        }

        .video-container {
            width: clamp(400px, 30%, 430px);
            margin: 0 auto;
            height: 695px;
            border: 1px solid #ccc;
            border-radius: 0.35rem;
            height: 695px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .video{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


    </style>
</head>

<body>
    <div class="video-container">
        <video class="video" id="video"  autoplay muted>
        </video>
            <div class="pt-5" style="position: absolute; top:0">
                <span id="btn-1" class="btn btn-danger rounded-pill" style="width: 300px;">Position: Not Good</span>
                <span></span>
            </div>
            </div>
</body>

</html>
