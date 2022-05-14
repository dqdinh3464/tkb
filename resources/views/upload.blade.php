@extends("layouts")

@section("content")
    <h2>Tải lên thời khoá biểu sinh viên</h2>
    <ul>
        <li>B1: Vào trang cá nhân -> đăng ký học -> kết quả đăng ký học -> download file excel thời khóa biểu "Hiển theo ngày học"</li>
        <li>B2: Tải file thời khóa biểu đó lên website này</li>
        <li>B3: Sau khi tải xong, nhập mã sinh viên vào ô tìm kiếm để xem lịch học</li>
    </ul>

    <img class="mb-2 border" src="{{asset("images/hd.png")}}" alt="">

    <span style="color: red">*</span>Note:
    <ul>
        <li>Thời khóa biểu sau khi download sẽ có dạng như trên</li>
        <li>Các bạn muốn hiển thị link meet thì phải thêm bằng tay vào cột G trong file excel</li>
    </ul>

    <form enctype="multipart/form-data" action="{{route("home.upload_tkb")}}" method="POST">
        @csrf
        <label class="form-label span3" for="file">Chọn file: </label>
        <input type="file" name="file" id="file" required><br>
        <input class="btn btn-success mt-2" type="submit" value="Tải lên">
    </form>

    @if(\Illuminate\Support\Facades\Session::has("success"))
        <div class="alert alert-success">{{\Illuminate\Support\Facades\Session::get("success")}}</div>
    @endif
@endsection
