@extends('user.master')
@section('title','Giới Thiệu Về Chúng Tôi - MinMovies')
@section('content')
<div class="faq">
    <h4 class="latest-text w3_faq_latest_text w3_latest_text">Giới Thiệu</h4>
    <div class="container">
        <div class="agileits-news-top">
            <ol class="breadcrumb">
                <li><a href="{{ route('user.index') }}">Trang Chủ</a></li>
                <li class="active">Giới Thiệu</li>
            </ol>
            <div>
                <h4>Mục tiêu của đề tài là phát triển một website xem phim trực tuyến sử dụng Laravel và PHP, cung cấp các chức năng quản lý danh sách phim, xem phim trực tuyến và các gợi ý phim tự động. Hệ thống được tối ưu hóa giao diện người dùng, bảo mật cao và dễ dàng mở rộng..<br><br></h4>
            </div>
        </div>
    </div>
    <h4 class="latest-text w3_faq_latest_text w3_latest_text">Liên Hệ</h4>
    <div class="container">
        <h4 class="pt-1"><b>Nhóm Thực hiện</b>Nhóm 9</h4>

    </div>
</div>
@endsection
