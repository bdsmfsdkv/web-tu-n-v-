<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AffiliateHistory;

class AffiliateController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $title = "Quản lý Hoa hồng";
        $histories = AffiliateHistory::with(['referrer', 'referred'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        $totalCommissionPaid = AffiliateHistory::sum('commission_amount');

        return view('admin.affiliates.index', compact('title', 'histories', 'totalCommissionPaid'));
    }
}
