@extends("layouts")

@section("content")
    <form action="{{route("home.xem_tkb")}}">
        <div class="input-group">
            <input type="text" class="form-control" id="msv" name="msv" placeholder="Nhập mã sinh viên" value="@if(\Illuminate\Support\Facades\Session::has("msv")){{\Illuminate\Support\Facades\Session::get("msv")}}@endif">
            <div class="input-group-append">
                <button type="submit" class="btn btn-success">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <div>
        @if(!$tkb)
            <p>Nhập mã sinh viên vào ô tìm kiếm để xem lịch học.</p>
            <p>Nếu chưa upload thời khoá biểu lên website, hãy vào trang cá nhân download file excel lịch học theo "ngày" và upload lên website để xem thời khoá biểu.</p>
        @endif
    </div>
    @if(\Illuminate\Support\Facades\Session::has("error"))
        <div class="alert alert-danger">{{\Illuminate\Support\Facades\Session::get("error")}}</div>
    @endif

    @if($tkb)
        <div class="text-center"><strong>{{$tkb->ho_ten}} - {{$tkb->lop}}</strong></div>
    @endif
    <div id="calendar"></div>
@endsection
