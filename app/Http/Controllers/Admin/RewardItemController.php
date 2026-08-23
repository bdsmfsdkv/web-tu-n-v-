<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LuckyWheel;
use App\Models\RewardItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RewardItemController extends Controller
{
    public function index(Request $request)
    {
        $query = RewardItem::with('luckyWheel');

        if ($request->filled('lucky_wheel_id')) {
            $query->where('lucky_wheel_id', $request->lucky_wheel_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('game_name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 20);
        $items = $query->orderBy('priority', 'asc')->orderBy('id', 'desc')->paginate($perPage);
        
        $luckyWheels = LuckyWheel::orderBy('name')->get();

        return view('admin.reward-items.index', compact('items', 'luckyWheels'));
    }

    public function create()
    {
        $luckyWheels = LuckyWheel::orderBy('name')->get();

        return view('admin.reward-items.create', compact('luckyWheels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lucky_wheel_id' => 'required|exists:lucky_wheels,id',
            'game_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('reward_items')->where('lucky_wheel_id', $request->lucky_wheel_id),
            ],
            'min_withdraw' => 'required|integer|min:0',
            'max_withdraw' => 'required|integer|min:0|gte:min_withdraw',
            'priority' => 'required|integer|min:0',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->except('icon');
        $data['active'] = $request->has('active');

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('reward-items', 'public');
            $data['icon'] = '/storage/' . $path;
        }

        RewardItem::create($data);

        return redirect()->route('admin.reward-items.index')->with('success', 'Thêm vật phẩm thưởng thành công!');
    }

    public function edit(RewardItem $rewardItem)
    {
        $luckyWheels = LuckyWheel::orderBy('name')->get();

        return view('admin.reward-items.edit', compact('rewardItem', 'luckyWheels'));
    }

    public function update(Request $request, RewardItem $rewardItem)
    {
        $request->validate([
            'lucky_wheel_id' => 'required|exists:lucky_wheels,id',
            'game_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('reward_items')
                    ->where('lucky_wheel_id', $request->lucky_wheel_id)
                    ->ignore($rewardItem->id),
            ],
            'min_withdraw' => 'required|integer|min:0',
            'max_withdraw' => 'required|integer|min:0|gte:min_withdraw',
            'priority' => 'required|integer|min:0',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'remove_icon' => 'nullable|boolean',
        ]);

        $data = $request->except(['icon', 'remove_icon']);
        $data['active'] = $request->has('active');

        if ($request->hasFile('icon')) {
            if ($rewardItem->icon && file_exists(public_path($rewardItem->icon))) {
                @unlink(public_path($rewardItem->icon));
            }
            $path = $request->file('icon')->store('reward-items', 'public');
            $data['icon'] = '/storage/' . $path;
        } elseif ($request->boolean('remove_icon')) {
            if ($rewardItem->icon && file_exists(public_path($rewardItem->icon))) {
                @unlink(public_path($rewardItem->icon));
            }
            $data['icon'] = null;
        }

        $rewardItem->update($data);

        return redirect()->route('admin.reward-items.index')->with('success', 'Cập nhật vật phẩm thưởng thành công!');
    }

    public function destroy(RewardItem $rewardItem)
    {
        if ($rewardItem->icon && file_exists(public_path($rewardItem->icon))) {
            @unlink(public_path($rewardItem->icon));
        }
        $rewardItem->delete();
        
        return response()->json(['status' => true, 'message' => 'Xóa vật phẩm thưởng thành công!']);
    }
}
