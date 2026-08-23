<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Helpers\GamePresetHelper;
use App\Models\Category;
use App\Models\GameAccount;
use App\Models\GameCategory;
use App\Models\RandomCategory;
use App\Models\RandomCategoryAccount;
use Illuminate\Http\Request;

class GameCategoryController extends Controller
{
    /** Số acc mới nhất được quét để suy ra bộ key thuộc tính động của danh mục. */
    private const DETAIL_KEY_SAMPLE_SIZE = 300;

    public function index(string $slug, Request $request)
    {
        $category = GameCategory::where("slug", $slug)->where('active', 1)->firstOrFail();

        // Get all accounts linked to this category
        $accounts = GameAccount::where('game_category_id', $category->id);
        if (!$request->filled('status')) {
            $accounts->where('status', 'available');
        }

        // Base queries
        if ($request->hasAny(['code', 'price_range', 'price_from', 'price_to', 'status'])) {
            if ($request->filled('code')) {
                $accounts->where('id', $request->code);
            }
            if ($request->filled('price_range')) {
                $range = explode('-', $request->price_range);
                if (count($range) == 2) {
                    $accounts->whereBetween('price', [(float)$range[0], (float)$range[1]]);
                } else {
                    $accounts->where('price', '>=', (float)$range[0]);
                }
            } else {
                if ($request->filled('price_from')) {
                    $accounts->where('price', '>=', (float)$request->price_from);
                }
                if ($request->filled('price_to')) {
                    $accounts->where('price', '<=', (float)$request->price_to);
                }
            }
            if ($request->filled('status')) {
                $accounts->where('status', $request->status);
            }
        }

        // Dynamic detail filters
        $hasDetailFilters = $request->has('details') && is_array($request->details) && array_filter($request->details);
        if ($hasDetailFilters) {
            foreach ($request->details as $filterKey => $filterValue) {
                if (empty($filterValue)) continue;
                // ponytail: JSON column search via whereJsonContains/whereLike. Ceiling: standard MySQL 5.7+/MariaDB.
                $accounts->where(function ($q) use ($filterKey, $filterValue) {
                    $q->whereJsonContains('details', ['key' => $filterKey, 'value' => $filterValue])
                      ->orWhere('details', 'LIKE', '%' . addcslashes($filterValue, '%_\\') . '%');
                });
            }
        }

        // DB pagination & dynamic keys extraction
        $accounts = $accounts->orderBy('id', 'DESC')->paginate(12)->withQueryString();

        $dynamicKeys = $this->dynamicDetailKeys($category->id);

        $flashSalePrice = \App\Models\FlashSale::getActivePrice('game', $category->id);
        if ($flashSalePrice !== null) {
            foreach ($accounts as $acc) {
                $acc->price = $flashSalePrice;
            }
        }

        // Match game presets to pass to view for smart filters
        $category->loadMissing('gameGroup');
        $matchedPresetKey = GamePresetHelper::resolve($category->slug)
            ?? GamePresetHelper::resolve($category->platform)
            ?? ($category->gameGroup ? GamePresetHelper::resolve($category->gameGroup->slug) : null);
        $presetConfig = $matchedPresetKey ? config("game_attributes.games.{$matchedPresetKey}") : null;

        return view('user.category.show', compact('category', 'accounts', 'dynamicKeys', 'presetConfig'));
    }

    /**
     * Danh sách key thuộc tính động để render filter.
     *
     * Trước đây hàm này pluck('details') trên toàn bộ query CHƯA phân trang, nên một
     * danh mục có vài nghìn acc sẽ kéo hết cột JSON về PHP chỉ để lấy vài cái key.
     * Giờ chỉ quét một mẫu giới hạn các acc mới nhất và cache lại kết quả.
     */
    private function dynamicDetailKeys(int $categoryId): array
    {
        return \Illuminate\Support\Facades\Cache::remember(
            'category_detail_keys_' . $categoryId,
            600,
            function () use ($categoryId) {
                $rows = GameAccount::where('game_category_id', $categoryId)
                    ->orderBy('id', 'DESC')
                    ->limit(self::DETAIL_KEY_SAMPLE_SIZE)
                    ->pluck('details');

                $keys = [];
                foreach ($rows as $accountDetails) {
                    $details = is_array($accountDetails) ? $accountDetails : json_decode((string) $accountDetails, true) ?? [];
                    if (!is_array($details)) {
                        continue;
                    }

                    foreach ($details as $detail) {
                        if (is_array($detail) && isset($detail['key']) && !isset($keys[$detail['key']])) {
                            $keys[$detail['key']] = true;
                        }
                    }
                }

                return array_keys($keys);
            }
        );
    }

    public function showAll()
    {
        $title = 'Danh mục bán nick game';
        $gameGroups = \App\Models\GameGroup::where('active', 1)->orderBy('order', 'asc')->orderBy('id', 'asc')->get();

        // Get all categories with additional statistics
        $categories = GameCategory::with('gameGroup')
            ->withCount([
                'accounts as allAccount' => fn ($query) => $query->where('status', 'available'),
                'accounts as soldCount' => fn ($query) => $query->where('status', 'sold'),
            ])
            ->withMin([
                'accounts as price' => fn ($query) => $query->where('status', 'available'),
            ], 'price')
            ->where('active', 1)
            ->get();

        foreach ($categories as $category) {
            $category->price = $category->price ?: 0;
            $category->url = route('category.index', ['slug' => $category->slug]);
        }

        $randomCategories = RandomCategory::with('gameGroup')
            ->withCount([
                'accounts as allAccount' => fn ($query) => $query->where('status', 'available'),
                'accounts as soldCount' => fn ($query) => $query->where('status', 'sold'),
            ])
            ->withMin([
                'accounts as price' => fn ($query) => $query->where('status', 'available'),
            ], 'price')
            ->where('active', 1)
            ->get();
        foreach ($randomCategories as $category) {
            $category->price = $category->price ?: 0;
            $category->url = route('random.index', ['slug' => $category->slug]);
        }

        $categories = $categories->concat($randomCategories);

        return view('user.category.show-all', compact('categories', 'title', 'gameGroups'));
    }

    public function showGroup($slug)
    {
        $gameGroup = \App\Models\GameGroup::where('slug', $slug)->firstOrFail();
        $title = $gameGroup->name;
        
        $categories = Category::withCount([
                'accounts as allAccount' => fn ($q) => $q->where('status', 'available'),
                'accounts as soldCount' => fn ($q) => $q->where('status', 'sold'),
            ])
            ->withMin(['accounts as price' => fn ($q) => $q->where('status', 'available')], 'price')
            ->where('game_group_id', $gameGroup->id)
            ->where('active', 1)
            ->get();

        foreach ($categories as $category) {
            $category->price = $category->price ?: 0;
            $category->url = route('category.index', ['slug' => $category->slug]);
        }

        $randomCategories = RandomCategory::withCount([
                'accounts as allAccount' => fn ($q) => $q->where('status', 'available'),
                'accounts as soldCount' => fn ($q) => $q->where('status', 'sold'),
            ])
            ->withMin(['accounts as price' => fn ($q) => $q->where('status', 'available')], 'price')
            ->where('game_group_id', $gameGroup->id)
            ->where('active', 1)
            ->get();

        foreach ($randomCategories as $category) {
            $category->price = $category->price ?: 0;
            $category->url = route('random.index', ['slug' => $category->slug]);
        }

        $categories = $categories->concat($randomCategories);
        $platform = $gameGroup->name;

        return view('user.category.show-group', compact('categories', 'title', 'gameGroup', 'platform'));
    }
}
