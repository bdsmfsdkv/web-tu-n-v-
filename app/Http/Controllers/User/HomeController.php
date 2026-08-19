<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\GameAccount;
use App\Models\GameService;
use App\Models\LuckyWheel;
use App\Models\ServiceHistory;
use App\Models\RandomCategory;
use App\Models\RandomCategoryAccount;
use App\Models\MoneyTransaction;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function index()
    {
        $gameGroups = \App\Models\GameGroup::where('active', 1)->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
        // Danh mục bán acc game
        $categories = Category::with('gameGroup')->where('active', 1)->orderBy('updated_at', 'desc')->get();
        foreach ($categories as $category) {
            $category->soldCount = GameAccount::where('game_category_id', $category->id)
                ->where('status', 'sold')
                ->count();
            $category->allAccount = GameAccount::where('game_category_id', $category->id)
                ->where('status', 'available')
                ->count();
            $category->price = GameAccount::where('game_category_id', $category->id)
                ->where('status', 'available')
                ->min('price') ?: 0;
            $category->url = route('category.index', ['slug' => $category->slug]);
        }

        // Random categories
        $services = GameService::where('active', '1')->orderBy('updated_at', 'desc')->get();
        foreach ($services as $service) {
            $service->orderCount = ServiceHistory::where('game_service_id', $service->id)->count();
        }

        $randomCategories = RandomCategory::with('gameGroup')->where('active', 1)->orderBy('updated_at', 'desc')->get();
        foreach ($randomCategories as $category) {
            $category->soldCount = RandomCategoryAccount::where('random_category_id', $category->id)
                ->where('status', 'sold')
                ->count();
            $category->allAccount = RandomCategoryAccount::where('random_category_id', $category->id)
                ->where('status', 'available')
                ->count();
            $category->price = RandomCategoryAccount::where('random_category_id', $category->id)
                ->where('status', 'available')
                ->value('price') ?: 0;
            $category->url = route('random.index', ['slug' => $category->slug]);
        }

        $categories = $categories->concat($randomCategories);

        // Vòng quay may mắn
        $LuckWheel = LuckyWheel::where('active', 1)->orderBy('updated_at', 'desc')->get();
        foreach ($LuckWheel as $wheel) {
            $wheel->soldCount = $wheel->histories->count();
        }

        // Lấy 20 giao dịch gần đây
        $recentTransactions = MoneyTransaction::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Lấy top 3 người nạp tiền nhiều nhất trong tháng hiện tại
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $topDepositors = MoneyTransaction::select('user_id', DB::raw('SUM(amount) as total_amount'))
            ->where('type', 'deposit')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('user_id')
            ->orderBy('total_amount', 'desc')
            ->limit(3)
            ->get();

        // Lấy thông tin người dùng cho top depositors
        foreach ($topDepositors as $depositor) {
            $depositor->user = \App\Models\User::find($depositor->user_id);
        }

        $notifications = Notification::orderBy('created_at', 'desc')->get();

        // Lấy danh sách khách hàng mới mua account để làm đánh giá ảo
        $recentPurchases = \App\Models\PurchaseHistory::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        $activeFlashSale = \App\Models\FlashSale::with(['items.category'])
            ->where('status', 1)
            ->where('end_time', '>', now())
            ->where('start_time', '<=', now())
            ->orderBy('end_time', 'asc')
            ->first();

        // Lấy danh sách các chiến dịch trong ngày hoặc sắp tới để làm Timeline
        $timelineCampaigns = \App\Models\FlashSale::where('status', 1)
            ->where('end_time', '>', now()->subHours(24)) // Lấy cả những cái vừa diễn ra gần đây
            ->orderBy('start_time', 'asc')
            ->limit(6)
            ->get();

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
        $purchases = \App\Models\PurchaseHistory::with('user')
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
