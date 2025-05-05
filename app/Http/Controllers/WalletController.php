<?php

namespace App\Http\Controllers;

use App\Wallet;
use App\User;
use App\Nation;
use App\Cate;
use App\Year;
use App\WalletCharge;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function getWallet()
    {
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        $username=session('username_minmovies');
        $user=User::where('username',$username)->first();
        $user_id=$user->id;
        $wallet=Wallet::all();
        $walletCharge=WalletCharge::where('user_id',$user_id)->paginate(10);
        return view('user.wallet', compact('cate', 'nation', 'year','user','wallet','walletCharge'));
    }
    public function getChargeWallet()
    {
        $cate = Cate::all();
        $nation = Nation::all();
        $year = Year::all();
        return view('user.chargeWallet', compact('cate', 'nation', 'year'));
    }
    public function postChargeWallet(Request $request)
    {
        $username = session('username_minmovies');
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->with(['thongbao_level' => 'danger', 'thongbao' => 'Người dùng không tồn tại!']);
        }

        // Lưu thông tin giao dịch vào bảng WalletCharge
        $walletCharge = new WalletCharge();
        $walletCharge->user_id = $user->id;
        $walletCharge->wallet_id = Wallet::where('user_id', $user->id)->first()->id;
        $walletCharge->orderId = time(); // Mã đơn hàng (unique)
        $walletCharge->money = $request->amount;
        $walletCharge->transaction_id = $request->transaction_id; // Mã giao dịch ngân hàng
        $walletCharge->status = 'approved'; // Tự động xác nhận giao dịch
        $walletCharge->save();

        // Cập nhật số dư ví
        $wallet = Wallet::where('user_id', $user->id)->first();
        $wallet->money += $walletCharge->money;
        $wallet->save();

        return redirect()->route('user.getWallet')->with([
            'thongbao_level' => 'success',
            'thongbao' => 'Nạp tiền thành công!'
        ]);
    }

    public function saveChargeWallet($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()->route('user.getWallet')->with([
                'thongbao_level' => 'danger',
                'thongbao' => 'Người dùng không tồn tại!'
            ]);
        }

        // Lấy giao dịch đang chờ xác nhận
        $walletCharge = WalletCharge::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if (!$walletCharge) {
            return redirect()->route('user.getWallet')->with([
                'thongbao_level' => 'danger',
                'thongbao' => 'Không tìm thấy giao dịch cần xác nhận!'
            ]);
        }

        // Xác nhận giao dịch (giả sử bạn kiểm tra mã giao dịch ngân hàng thủ công)
        // Nếu giao dịch hợp lệ, cập nhật trạng thái và số dư ví
        $wallet = Wallet::where('user_id', $user->id)->first();
        $wallet->money += $walletCharge->money;
        $wallet->save();

        $walletCharge->status = 'approved'; // Đánh dấu giao dịch đã được xác nhận
        $walletCharge->save();

        return redirect()->route('user.getWallet')->with([
            'thongbao_level' => 'success',
            'thongbao' => 'Nạp tiền thành công!'
        ]);
    }
    public function walletCharge()
    {
        $walletCharge = WalletCharge::orderBy('created_at', 'desc')->get();
        return view('admin.wallet_charge.list', compact('walletCharge'));
    }
    public function rejectCharge($id)
    {
        $walletCharge = WalletCharge::find($id);

        if (!$walletCharge || $walletCharge->status != 'pending') {
            return redirect()->back()->with([
                'thongbao_level' => 'danger',
                'thongbao' => 'Giao dịch không hợp lệ!'
            ]);
        }
        // Cập nhật trạng thái giao dịch

        $walletCharge->status = 'rejected'; // Đánh dấu giao dịch bị từ chối
        $walletCharge->save();

        return redirect()->back()->with([
            'thongbao_level' => 'success',
            'thongbao' => 'Giao dịch đã bị từ chối!'
        ]);
    }

    public function approveCharge($id)
    {
        $walletCharge = WalletCharge::find($id);

        if (!$walletCharge || $walletCharge->status != 'pending') {
            return redirect()->back()->with([
                'thongbao_level' => 'danger',
                'thongbao' => 'Giao dịch không hợp lệ!'
            ]);
        }

        // Cập nhật số dư ví
        $wallet = Wallet::find($walletCharge->wallet_id);
        $wallet->money += $walletCharge->money;
        $wallet->save();

        // Cập nhật trạng thái giao dịch
        $walletCharge->status = 'approved';
        $walletCharge->save();

        return redirect()->back()->with([
            'thongbao_level' => 'success',
            'thongbao' => 'Giao dịch đã được xác nhận!'
        ]);
    }
}
