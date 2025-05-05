@extends('user.master')
@section('title','Ví Của Tôi - MinMovies')
@section('content')
<br>
<div class="tittle-head">
    <h4 class="latest-text">Nạp tiền vào ví</h4>
    <div class="container">
        <div class="agileits-single-top">
            <ol class="breadcrumb">
                <li><a href="">Trang Chủ</a></li>
                <li><a href="{{ route('user.getProfile') }}">{{ session('username_minmovies') }}</a></li>
                <li><a href="{{ route('user.getWallet') }}">Ví</a></li>
                <li class="active">Nạp tiền vào ví</li>
            </ol>
        </div>
    </div>
</div>
<div class="video-modal" tabindex="-1" role="dialog" aria-labelledby="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                NẠP TIỀN VÀO VÍ
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <section>
                <div class="modal-body">
                    <div class="w3_login_module">
                        <div class="module form-module">
                            <div class="toggle"><i class="fa fa-times fa-pencil"></i>
                            </div>
                            <div class="form">
                                <h3>NẠP TIỀN</h3>
                                <form action="{{ route('user.postChargeWallet') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="amount">Số tiền cần nạp:</label>
                                        <input type="number" name="amount" value="" placeholder="Nhập số tiền bạn muốn nạp" required="" 
                                               oninvalid="this.setCustomValidity('Vui lòng nhập số tiền cần nạp!')" 
                                               oninput="this.setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="bank_account">Thông tin tài khoản ngân hàng:</label>
                                        <p><b>Ngân hàng:</b> TPBank</p>
                                        <p><b>Số tài khoản:</b>0942192764</p>
                                        <p><b>Chủ tài khoản:</b>Trần Đạt Huy </p>
                                        <p><b>Nội dung chuyển khoản:</b> Nạp tiền {{ session('username_minmovies') }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="transaction_id">Mã giao dịch ngân hàng:</label>
                                        <input type="text" name="transaction_id" placeholder="Nhập mã giao dịch ngân hàng" required="" 
                                               oninvalid="this.setCustomValidity('Vui lòng nhập mã giao dịch!')" 
                                               oninput="this.setCustomValidity('')">
                                    </div>
                                    <p><b>Hướng dẫn lấy mã giao dịch:</b></p>
                                    <ul>
                                        <li>Sau khi chuyển khoản, kiểm tra biên lai hoặc lịch sử giao dịch trong ứng dụng ngân hàng.</li>
                                        <li>Tìm mã giao dịch (Transaction ID) và nhập vào ô "Mã giao dịch ngân hàng".</li>
                                        <li>Nếu không tìm thấy, liên hệ ngân hàng để được hỗ trợ.</li>
                                    </ul>
                                    <input type="submit" value="Xác nhận nạp tiền">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script>
    $('.toggle').click(function(){
      // Switches the Icon
      $(this).children('i').toggleClass('fa-pencil');
      // Switches the forms
      $('.form').animate({
        height: "toggle",
        'padding-top': 'toggle',
        'padding-bottom': 'toggle',
        opacity: "toggle"
      }, "slow");
    });
</script>
@endsection
