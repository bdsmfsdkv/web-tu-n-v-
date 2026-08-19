<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UsdtAccount;
use Illuminate\Http\Request;

class UsdtAccountController extends Controller
{
    public function index()
    {
        $title = 'Tài khoản USDT';
        $accounts = UsdtAccount::orderBy('id', 'desc')->paginate(20);
        return view('admin.usdt-accounts.index', compact('title', 'accounts'));
    }

    public function create()
    {
        $title = 'Thêm tài khoản USDT';
        return view('admin.usdt-accounts.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:binance,trc20',
            'name' => 'required|string|max:255',
            'wallet_address' => 'required|string|max:255',
            'qr_image' => 'nullable|url|max:500',
            'api_token' => 'required|string|max:255',
        ]);

        UsdtAccount::create([
            'type' => $request->type,
            'name' => $request->name,
            'wallet_address' => $request->wallet_address,
            'qr_image' => $request->qr_image,
            'api_token' => $request->api_token,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.usdt-accounts.index')->with('success', 'Thêm tài khoản thành công!');
    }

    public function edit(UsdtAccount $usdtAccount)
    {
        $title = 'Sửa tài khoản USDT';
        return view('admin.usdt-accounts.edit', compact('title', 'usdtAccount'));
    }

    public function update(Request $request, UsdtAccount $usdtAccount)
    {
        $request->validate([
            'type' => 'required|in:binance,trc20',
            'name' => 'required|string|max:255',
            'wallet_address' => 'required|string|max:255',
            'qr_image' => 'nullable|url|max:500',
            'api_token' => 'required|string|max:255',
        ]);

        $usdtAccount->update([
            'type' => $request->type,
            'name' => $request->name,
            'wallet_address' => $request->wallet_address,
            'qr_image' => $request->qr_image,
            'api_token' => $request->api_token,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.usdt-accounts.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(UsdtAccount $usdtAccount)
    {
        $usdtAccount->delete();
        return redirect()->route('admin.usdt-accounts.index')->with('success', 'Xóa thành công!');
    }
}
