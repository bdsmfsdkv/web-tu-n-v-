<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\RandomCategory;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use Carbon\Carbon;

class FlashSaleController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $title = 'Quản lý Flash Sale';
        
        $flashSales = FlashSale::with('items')->orderBy('created_at', 'desc')->adminFilter(request())->paginate(request("per_page", 25))->withQueryString();
        
        // For the "Add New" dropdowns
        $allGameCategories = Category::where('active', 1)->adminFilter(request())->paginate(request("per_page", 25))->withQueryString();
        $allRandomCategories = RandomCategory::where('active', 1)->get();

        return view('admin.flash-sales.index', compact('title', 'flashSales', 'allGameCategories', 'allRandomCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'campaign_name' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|in:0,1',
            'products' => 'required|array',
            'products.*.id' => 'required|string',
            'products.*.old_price' => 'required|integer|min:0',
            'products.*.new_price' => 'required|integer|min:0',
        ]);

        $flashSale = FlashSale::create([
            'campaign_name' => $request->campaign_name,
            'start_time' => Carbon::parse($request->start_time),
            'end_time' => Carbon::parse($request->end_time),
            'status' => $request->status,
        ]);

        foreach ($request->products as $product) {
            $parts = explode('_', $product['id']);
            $type = $parts[0];
            $id = $parts[1];

            FlashSaleItem::create([
                'flash_sale_id' => $flashSale->id,
                'item_type' => $type,
                'item_id' => $id,
                'old_price' => $product['old_price'],
                'new_price' => $product['new_price'],
            ]);
        }

        return back()->with('success', 'Đã lưu chiến dịch Flash Sale thành công!');
    }

    public function destroy($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $flashSale->delete();

        return back()->with('success', 'Đã xóa chiến dịch Flash Sale!');
    }
}
