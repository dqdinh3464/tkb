@extends("layouts")

@section("content")
    <h2>Tải lên thời khoá biểu giảng viên</h2>

    <form enctype="multipart/form-data" action="{{route("home.upload.giang_vien")}}" method="POST">
        @csrf
        <label class="form-label span3" for="file">Chọn file: </label>
        <input type="file" name="file" id="file" required><br>
        <input class="btn btn-success mt-2" type="submit" value="Tải lên">
    </form>

    @if(\Illuminate\Support\Facades\Session::has("success"))
        <div class="alert alert-success">{{\Illuminate\Support\Facades\Session::get("success")}}</div>
    @endif
@endsection
