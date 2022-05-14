<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thời khoá biểu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset("css/style.css")}}">
    <link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}">
    <script src="{{asset("js/jquery.min.js")}}"></script>
    <script src="{{asset("js/popper.min.js")}}"></script>
    <script src="{{asset("js/bootstrap.min.js")}}"></script>
</head>

<body>
    <div class="container">
        <div class="row align-items-center justify-content-center" style="margin-top: 5px; margin-bottom: 5px">
            <a class="btn btn-success" href="{{route("home.index")}}" style="margin-right: 5px">Xem TKB</a>
            <a class="btn btn-success" href="{{route("home.upload")}}" style="margin-right: 5px">Tải lên TKB Sinh viên</a>
            <a class="btn btn-success" href="{{route("home.upload.giang_vien")}}" style="margin-right: 5px">Tải lên TKB Giảng viên</a>
        </div>

        @yield("content")
    </div>

    <script src="{{asset("js/moment.min.js")}}"></script>
    <script src="{{asset("js/index.js")}}"></script>
</body>

</html>
