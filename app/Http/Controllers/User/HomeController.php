<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\GameAccount;
use App\Models\GameGroup;
use App\Models\GameService;
use App\Models\LuckyWheel;
use App\Models\ServiceHistory;
use App\Models\RandomCategory;
use App\Models\RandomCategoryAccount;
use App\Models\MoneyTransaction;
use App\Models\Notification;
use App\Models\PurchaseHistory;
use App\Models\FlashSale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Cache dữ liệu danh mục & dịch vụ & vòng quay 120s
        $catalogData = Cache::remember('home_catalog_data', 120, function () {
            $gameGroups = GameGroup::where('active', 1)->orderBy('order', 'asc')->orderBy('id', 'asc')->get();

            // Danh mục bán acc game
            $accountStats = GameAccount::selectRaw("game_category_id, SUM(status = 'sold') AS sold_count, SUM(status = 'available') AS available_count, MIN(CASE WHEN status = 'available' THEN price END) AS min_price")
                ->groupBy('game_category_id');
            $categories = Category::with('gameGroup')
                ->leftJoinSub($accountStats, 'account_stats', fn ($join) => $join->on('game_categories.id', '=', 'account_stats.game_category_id'))
                ->select('game_categories.*', DB::raw('COALESCE(account_stats.sold_count, 0) AS soldCount'), DB::raw('COALESCE(account_stats.available_count, 0) AS allAccount'), DB::raw('COALESCE(account_stats.min_price, 0) AS price'))
                ->where('game_categories.active', 1)
                ->orderBy('game_categories.updated_at', 'desc')
                ->get();
            $categories->each(fn ($category) => $category->url = route('category.index', ['slug' => $category->slug]));

            // Dịch vụ cày thuê
            $serviceStats = ServiceHistory::selectRaw('game_service_id, COUNT(*) AS order_count')->groupBy('game_service_id');
            $services = GameService::leftJoinSub($serviceStats, 'service_stats', fn ($join) => $join->on('game_services.id', '=', 'service_stats.game_service_id'))
                ->select('game_services.*', DB::raw('COALESCE(service_stats.order_count, 0) AS orderCount'))
                ->where('game_services.active', '1')
                ->orderBy('game_services.updated_at', 'desc')
                ->get();

            // Random categories
            $randomAccountStats = RandomCategoryAccount::selectRaw("random_category_id, SUM(status = 'sold') AS sold_count, SUM(status = 'available') AS available_count, MIN(CASE WHEN status = 'available' THEN price END) AS min_price")
                ->groupBy('random_category_id');
            $randomCategories = RandomCategory::with('gameGroup')
                ->leftJoinSub($randomAccountStats, 'random_account_stats', fn ($join) => $join->on('random_categories.id', '=', 'random_account_stats.random_category_id'))
                ->select('random_categories.*', DB::raw('COALESCE(random_account_stats.sold_count, 0) AS soldCount'), DB::raw('COALESCE(random_account_stats.available_count, 0) AS allAccount'), DB::raw('COALESCE(random_account_stats.min_price, 0) AS price'))
                ->where('random_categories.active', 1)
                ->orderBy('random_categories.updated_at', 'desc')
                ->get();
            $randomCategories->each(fn ($category) => $category->url = route('random.index', ['slug' => $category->slug]));

            $categories = $categories->concat($randomCategories);

            // Vòng quay may mắn
            $LuckWheel = LuckyWheel::withCount('histories')->where('active', 1)->orderBy('updated_at', 'desc')->get();
            foreach ($LuckWheel as $wheel) {
                $wheel->soldCount = $wheel->histories_count;
            }

            return compact('gameGroups', 'categories', 'services', 'LuckWheel');
        });

        $gameGroups = $catalogData['gameGroups'];
        $categories = $catalogData['categories'];
        $services = $catalogData['services'];
        $LuckWheel = $catalogData['LuckWheel'];

        // Lấy 20 giao dịch gần đây (Cache 30s)
        $recentTransactions = Cache::remember('home_recent_transactions', 30, function () {
            return MoneyTransaction::with('user')
                ->whereHas('user', fn ($query) => $query->where('role', '!=', 'admin'))
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();
        });

        // Lấy top 3 người nạp tiền nhiều nhất trong tháng hiện tại (dùng index created_at qua whereBetween)
        $topDepositors = Cache::remember('home_top_depositors', 120, function () {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            return MoneyTransaction::with('user')
                ->select('user_id', DB::raw('SUM(amount) as total_amount'))
                ->whereHas('user', fn ($query) => $query->where('role', '!=', 'admin'))
                ->where('type', 'deposit')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->groupBy('user_id')
                ->orderBy('total_amount', 'desc')
                ->limit(3)
                ->get();
        });

        $notifications = Cache::remember('home_notifications', 300, function () {
            // Sắp theo id giảm dần: khớp với thứ tự marquee trên trang chủ trước đây.
            return Notification::orderBy('id', 'desc')->get();
        });

        // Lấy danh sách khách hàng mới mua account để làm đánh giá ảo (Cache 60s)
        $recentPurchases = Cache::remember('home_recent_purchases', 60, function () {
            return PurchaseHistory::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();
        });

        // Hai query flash sale này trước đây chạy ở mọi lần vào trang chủ. Cache 60s là
        // đủ chính xác vì countdown được tính lại bằng JS từ end_time.
        $flashSaleData = Cache::remember('home_flash_sales', 60, function () {
            return [
                'active' => FlashSale::with(['items.category'])
                    ->where('status', 1)
                    ->where('end_time', '>', now())
                    ->where('start_time', '<=', now())
                    ->orderBy('end_time', 'asc')
                    ->first(),
                'timeline' => FlashSale::where('status', 1)
                    ->where('end_time', '>', now()->subHours(24))
                    ->orderBy('start_time', 'asc')
                    ->limit(6)
                    ->get(),
            ];
        });

        $activeFlashSale = $flashSaleData['active'];
        $timelineCampaigns = $flashSaleData['timeline'];

        $flashSales = collect();
        if ($activeFlashSale) {
            foreach ($activeFlashSale->items as $item) {
                if ($item->category && $item->category->active == 1) {
                    $cat = $item->category;
                    $cat->is_random = ($item->item_type == 'random');
                    $cat->flash_sale_old_price = $item->old_price;
                    $cat->flash_sale_new_price = $item->new_price;
                    $cat->flash_sale_end_time = $activeFlashSale->end_time;
                    $flashSales->push($cat);
                }
            }
        }

        return view('user.home', compact(
            'gameGroups',
            'categories',
            'services',
            'LuckWheel',
            'recentTransactions',
            'topDepositors',
            'notifications',
            'recentPurchases',
            'flashSales',
            'activeFlashSale',
            'timelineCampaigns'
        ));
    }

    public function reviews()
    {
        $purchases = PurchaseHistory::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(24);
            
        return view('user.reviews', compact('purchases'));
    }

    public function faq()
    {
        return view('user.faq');
    }

    public function terms()
    {
        $title = "Điều Khoản Sử Dụng";
        $content = config_get('terms_of_use', '<p>Nội dung đang được cập nhật...</p>');
        return view('user.page', compact('title', 'content'));
    }

    public function privacy()
    {
        $title = "Chính Sách Bảo Mật";
        $content = config_get('privacy_policy', '<p>Nội dung đang được cập nhật...</p>');
        return view('user.page', compact('title', 'content'));
    }
}

