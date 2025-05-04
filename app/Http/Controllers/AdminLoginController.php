<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
{
    public function getAdminLogin()
    {
        if (Auth::user()) {
            return redirect()->route('admin.index');
        }
        return view('admin.admin_login');
    }

    public function postAdminLogin(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->push('username_minmovies', Auth::user()->username);
            return redirect()->route('admin.index');
        } else {
            return redirect()->route('admin.getLogin')->with(['thongbao_level' => 'danger', 'thongbao_admin' => "<b>Sai tài khoản hoặc mật khẩu!</b>"]);
        }
    }

    public function adminLogout()
    {
        Auth::logout();
        session()->forget('username_minmovies');
        return redirect()->route('admin.getLogin')->with(['thongbao_level' => 'success', 'thongbao_admin' => "<b>Đăng xuất thành công!</b>"]);
    }
}
