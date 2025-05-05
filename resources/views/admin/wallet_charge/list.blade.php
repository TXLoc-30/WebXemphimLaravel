@extends('admin.master')
@section('title','Danh Sách Nạp Tiền - MinMovie')
@section('content')
<div id="content">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800 text-center">QUẢN LÝ NẠP TIỀN</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="m-0 font-weight-bold text-primary">
                    DANH SÁCH NẠP TIỀN
                </div>
            </div>
            @if (session('thongbao'))
            <div class="alert alert-{{ session('thongbao_level') }}" style="border-radius:0px;">
                - {!! session('thongbao') !!}
            </div>
            @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:3em;">STT</th>
                                <th>Số hoá đơn</th>
                                <th>Người dùng</th>
                                <th>Số tiền</th>
                                <th>Thời gian</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($walletCharge as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->orderId }}</td>
                                    <td>
                                        <a class="text-decoration-none" href="{{ route('admin.user.edit', $item->user_id) }}" title="Mở người dùng trong tab mới" target="_blank">
                                            <b>{{ $item->user->name }}</b>
                                        </a>
                                    </td>
                                    <td>{{ number_format(round($item->money)) . 'đ' }}</td>
                                    <td>
                                        @php
                                            \Carbon\Carbon::setLocale('vi');
                                            $commentTime = $item->created_at;
                                            $commentTime = \Carbon\Carbon::parse($commentTime);
                                            $currentTime = \Carbon\Carbon::now('Asia/Ho_Chi_Minh');
                                            echo $commentTime->diffForHumans($currentTime);
                                        @endphp
                                    </td>
                                    <td>
                                        @if ($item->status == 'pending')
                                            <span class="badge badge-warning">Đang chờ</span>
                                        @elseif ($item->status == 'approved')
                                            <span class="badge badge-success">Đã duyệt</span>
                                        @elseif ($item->status == 'rejected')
                                            <span class="badge badge-danger">Đã từ chối</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 'pending')
                                            <a href="{{ route('wallet.approveCharge', $item->id) }}" class="btn btn-success btn-sm">Xác nhận</a>
                                            <a href="{{ route('wallet.rejectCharge', $item->id) }}" class="btn btn-danger btn-sm">Từ chối</a>
                                        @else
                                            <span class="text-muted">Không khả dụng</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
