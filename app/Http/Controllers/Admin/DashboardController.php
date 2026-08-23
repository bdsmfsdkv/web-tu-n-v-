<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankDeposit;
use App\Models\CardDeposit;
use App\Models\Category;
use App\Models\DiscountCode;
use App\Models\GameAccount;
use App\Models\GameService;
use App\Models\LuckyWheel;
use App\Models\LuckyWheelHistory;
use App\Models\MoneyTransaction;
use App\Models\MoneyWithdrawalHistory;
use App\Models\Notification;
use App\Models\RandomCategory;
use App\Models\RandomCategoryAccount;
use App\Models\ServiceHistory;
use App\Models\ServicePackage;
use App\Models\User;
use App\Models\WithdrawalHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index(\Illuminate\Http\Request $request): View
    {
        try {
            // Lấy thông tin người dùng
            $statistics['users'] = [
                'total' => User::count(),
                'admin' => User::where('role', 'admin')->count(),
                'user' => User::where('role', 'user')->count(),
                'new_today' => User::whereDate('created_at', Carbon::today())->count(),
                'new_this_week' => User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
                'new_this_month' => User::whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)->count(),
            ];

            // Lấy thông tin tài khoản game
            $statistics['accounts'] = [
                'total' => GameAccount::count(),
                'available' => GameAccount::where('status', 'available')->count(),
                'sold' => GameAccount::where('status', 'sold')->count(),
                'locked' => GameAccount::where('status', 'locked')->count(),
                'pending' => GameAccount::where('status', 'pending')->count(),
            ];

            // Lấy thông tin tài khoản random
            $statistics['random_accounts'] = [
                'total' => RandomCategoryAccount::count(),
                'available' => RandomCategoryAccount::where('status', 'available')->count(),
                'sold' => RandomCategoryAccount::where('status', 'sold')->count(),
            ];

            // Lấy thông tin dịch vụ
            $statistics['services'] = [
                'total' => GameService::count(),
                'active' => GameService::where('active', true)->count(),
                'inactive' => GameService::where('active', false)->count(),
            ];

            // Lấy thông tin gói dịch vụ
            $statistics['packages'] = [
                'total' => ServicePackage::count(),
            ];

            // Lấy thông tin danh mục
            $statistics['categories'] = [
                'total' => Category::count(),
                'active' => Category::where('active', true)->count(),
                'inactive' => Category::where('active', false)->count(),
            ];

            // Lấy thông tin danh mục random
            $statistics['random_categories'] = [
                'total' => RandomCategory::count(),
                'active' => RandomCategory::where('active', true)->count(),
                'inactive' => RandomCategory::where('active', false)->count(),
            ];

            // Lấy thông tin vòng quay may mắn
            $statistics['lucky_wheels'] = [
                'total' => LuckyWheel::count(),
                'active' => LuckyWheel::where('active', true)->count(),
                'inactive' => LuckyWheel::where('active', false)->count(),
            ];

            // Lấy thông tin các loại dịch vụ
            $servicesByType = GameService::select('type', DB::raw('count(*) as total'))
                ->groupBy('type')
                ->get();

            // Lấy thông tin các giao dịch gần đây
            $recentTransactions = MoneyTransaction::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            // Tổng hợp các giao dịch theo loại
            // Tiền vé quay vòng quay đã được ghi thành giao dịch 'purchase' (reference_id LW-*),
            // nên không trừ thêm LuckyWheelHistory::sum('total_cost') nữa để tránh tính hai lần.
            $transactionSummary = [
                'total_deposit' => MoneyTransaction::where('type', 'deposit')->sum('amount'),
                'total_withdraw' => MoneyTransaction::where('type', 'withdraw')->sum('amount'),
                'total_purchase' => MoneyTransaction::where('type', 'purchase')->sum('amount'),
                'total_refund' => MoneyTransaction::where('type', 'refund')->sum('amount'),
            ];

            // Thống kê giao dịch trong 7 ngày gần nhất
            $last7Days = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $last7Days[] = [
                    'date' => $date->format('d/m'),
                    'deposits' => MoneyTransaction::whereDate('created_at', $date->format('Y-m-d'))
                        ->where('type', 'deposit')
                        ->sum('amount'),
                    'purchases' => MoneyTransaction::whereDate('created_at', $date->format('Y-m-d'))
                        ->where('type', 'purchase')
                        ->sum('amount'),
                ];
            }

            // Lấy thông tin các đơn dịch vụ chờ xử lý
            $pendingServices = ServiceHistory::with('user', 'gameService', 'servicePackage')
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Lấy thông tin rút tiền đang chờ xử lý
            $pendingWithdrawals = MoneyWithdrawalHistory::with('user')
                ->where('status', 'processing')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Lấy thông tin rút tài nguyên (gold/gem) đang chờ xử lý
            $pendingResourceWithdrawals = WithdrawalHistory::with('user')
                ->where('status', 'processing')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Lấy thông tin giao dịch nạp thẻ gần đây
            $recentCardDeposits = CardDeposit::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Lấy thông tin giao dịch nạp bank gần đây
            $recentBankDeposits = BankDeposit::with('user', 'bankAccount')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Lấy thông tin các mã giảm giá đang hoạt động
            $activeDiscountCodes = DiscountCode::where('is_active', 1)
                ->where(function ($query) {
                    $query->where('expire_date', '>=', Carbon::now())
                        ->orWhereNull('expire_date');
                })
                ->limit(5)
                ->get();

            // Lấy thống kê doanh thu theo tháng trong năm hiện tại
            $currentYear = Carbon::now()->year;
            $monthlyRevenue = [];
            for ($month = 1; $month <= 12; $month++) {
                $purchases = MoneyTransaction::where('type', 'purchase')
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->sum('amount');

                $deposits = MoneyTransaction::where('type', 'deposit')
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->sum('amount');

                $monthlyRevenue[] = [
                    'month' => Carbon::createFromDate($currentYear, $month, 1)->format('m/Y'),
                    'purchases' => $purchases,
                    'deposits' => $deposits,
                ];
            }

            // Lấy thông tin những tài khoản được mua gần đây
            $recentPurchases = GameAccount::with(['buyer', 'category'])
                ->where('status', 'sold')
                ->whereNotNull('buyer_id')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

            // Lấy thông tin những tài khoản random được mua gần đây
            $recentRandomPurchases = RandomCategoryAccount::with(['buyer', 'randomCategory'])
                ->where('status', 'sold')
                ->whereNotNull('buyer_id')
                ->orderBy('created_at', 'desc')
                ->limit(2)
                ->get();

            // Kết hợp hai collection
            $recentPurchases = $recentPurchases->merge($recentRandomPurchases)->sortByDesc('created_at')->take(5);

            // Lấy danh sách thông báo để hiển thị trong modal
            $notifications = Notification::orderBy('created_at', 'desc')->get();

            // --- COMPARISON LOGIC ---
            $period_a = $request->input('period_a', 'today');
            $period_b = $request->input('period_b', 'yesterday');

            $getPeriodDates = function($period) {
                switch ($period) {
                    case 'today': return [Carbon::today(), Carbon::tomorrow()];
                    case 'yesterday': return [Carbon::yesterday(), Carbon::today()];
                    case 'this_week': return [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
                    case 'last_week': return [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()];
                    case 'this_month': return [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()];
                    case 'last_month': return [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()];
                    default: return [Carbon::today(), Carbon::tomorrow()];
                }
            };

            $dates_a = $getPeriodDates($period_a);
            $dates_b = $getPeriodDates($period_b);

            $getStatsForPeriod = function($start, $end) {
                $accRevenue = GameAccount::where('status', 'sold')->whereBetween('updated_at', [$start, $end])->sum('price') 
                              + RandomCategoryAccount::where('status', 'sold')->whereBetween('updated_at', [$start, $end])->sum('price');
                $serviceRevenue = ServiceHistory::whereBetween('created_at', [$start, $end])->sum('price') ?? 0;
                $revenue = $accRevenue + $serviceRevenue;
                $profit = $revenue * 0.4;
                $ordersCount = GameAccount::where('status', 'sold')->whereBetween('updated_at', [$start, $end])->count()
                               + RandomCategoryAccount::where('status', 'sold')->whereBetween('updated_at', [$start, $end])->count()
                               + ServiceHistory::whereBetween('created_at', [$start, $end])->count();
                $avgOrderValue = $ordersCount > 0 ? ($revenue / $ordersCount) : 0;
                $deposits = BankDeposit::whereBetween('created_at', [$start, $end])->sum('amount')
                            + CardDeposit::where('status', 'success')->whereBetween('updated_at', [$start, $end])->sum('amount');
                $newMembers = User::whereBetween('created_at', [$start, $end])->count();

                $accSold = GameAccount::where('status', 'sold')->whereBetween('updated_at', [$start, $end])->count()
                           + RandomCategoryAccount::where('status', 'sold')->whereBetween('updated_at', [$start, $end])->count();
                $accStock = GameAccount::where('status', 'available')->count()
                            + RandomCategoryAccount::where('status', 'available')->count();
                
                // Lượt quay và doanh thu vòng quay lấy từ chính giao dịch trừ tiền vé quay (reference_id LW-*).
                // Trước đây filter theo type 'subtract' vốn không tồn tại trong enum nên luôn ra 0.
                $wheelSpins = LuckyWheelHistory::whereBetween('created_at', [$start, $end])->sum('spin_count');
                $wheelRevenue = -LuckyWheelHistory::whereBetween('created_at', [$start, $end])->sum('total_cost');
                $wheelsCount = LuckyWheel::count();
                
                $serviceCompleted = ServiceHistory::where('status', 'completed')->whereBetween('updated_at', [$start, $end])->count();
                $serviceProcessing = ServiceHistory::where('status', 'processing')->count();
                
                $cardDeposits = CardDeposit::where('status', 'success')->whereBetween('updated_at', [$start, $end])->sum('amount');
                $bankDeposits = BankDeposit::whereBetween('created_at', [$start, $end])->sum('amount');

                return [
                    'revenue' => $revenue,
                    'profit' => $profit,
                    'orders_count' => $ordersCount,
                    'avg_order_value' => $avgOrderValue,
                    'deposits' => $deposits,
                    'new_members' => $newMembers,
                    'acc_sold' => $accSold,
                    'acc_revenue' => $accRevenue,
                    'acc_stock' => $accStock,
                    'wheel_spins' => $wheelSpins,
                    'wheel_revenue' => $wheelRevenue,
                    'wheels_count' => $wheelsCount,
                    'service_completed' => $serviceCompleted,
                    'service_revenue' => $serviceRevenue,
                    'service_processing' => $serviceProcessing,
                    'card_deposits' => $cardDeposits,
                    'bank_deposits' => $bankDeposits,
                ];
            };

            $statsA = $getStatsForPeriod($dates_a[0], $dates_a[1]);
            $statsB = $getStatsForPeriod($dates_b[0], $dates_b[1]);
            
            $calcDiff = function($a, $b) {
                if ($b == 0) return $a > 0 ? 100 : 0;
                return round((($a - $b) / $b) * 100, 1);
            };

            $comparison = [
                'period_a' => $period_a,
                'period_b' => $period_b,
                'a' => $statsA,
                'b' => $statsB,
                'diff' => [
                    'revenue' => $calcDiff($statsA['revenue'], $statsB['revenue']),
                    'profit' => $calcDiff($statsA['profit'], $statsB['profit']),
                    'orders_count' => $calcDiff($statsA['orders_count'], $statsB['orders_count']),
                    'avg_order_value' => $calcDiff($statsA['avg_order_value'], $statsB['avg_order_value']),
                    'deposits' => $calcDiff($statsA['deposits'], $statsB['deposits']),
                    'new_members' => $calcDiff($statsA['new_members'], $statsB['new_members']),
                    'wheel_revenue' => $calcDiff($statsA['wheel_revenue'], $statsB['wheel_revenue']),
                    'service_revenue' => $calcDiff($statsA['service_revenue'], $statsB['service_revenue']),
                ]
            ];
            // --- END COMPARISON LOGIC ---

            return view('admin.dashboard', compact(
                'comparison',
                'statistics',
                'servicesByType',
                'recentTransactions',
                'transactionSummary',
                'last7Days',
                'pendingServices',
                'pendingWithdrawals',
                'pendingResourceWithdrawals',
                'recentCardDeposits',
                'recentBankDeposits',
                'activeDiscountCodes',
                'monthlyRevenue',
                'recentPurchases',
                'notifications'
            ));
        } catch (\Exception $e) {
            // Ghi log lỗi
            Log::error('Dashboard error: ' . $e->getMessage());

            // Trả về view với thông báo lỗi và các biến trống để tránh lỗi undefined
            return view('admin.dashboard', [
                'comparison' => [
                    'period_a' => 'today', 'period_b' => 'yesterday',
                    'a' => ['revenue'=>0,'profit'=>0,'orders_count'=>0,'avg_order_value'=>0,'deposits'=>0,'new_members'=>0,'acc_sold'=>0,'acc_revenue'=>0,'acc_stock'=>0,'wheel_spins'=>0,'wheel_revenue'=>0,'wheels_count'=>0,'service_completed'=>0,'service_revenue'=>0,'service_processing'=>0,'card_deposits'=>0,'bank_deposits'=>0],
                    'b' => ['revenue'=>0,'profit'=>0,'orders_count'=>0,'avg_order_value'=>0,'deposits'=>0,'new_members'=>0,'acc_sold'=>0,'acc_revenue'=>0,'acc_stock'=>0,'wheel_spins'=>0,'wheel_revenue'=>0,'wheels_count'=>0,'service_completed'=>0,'service_revenue'=>0,'service_processing'=>0,'card_deposits'=>0,'bank_deposits'=>0],
                    'diff' => ['revenue'=>0,'profit'=>0,'orders_count'=>0,'avg_order_value'=>0,'deposits'=>0,'new_members'=>0,'wheel_revenue'=>0,'service_revenue'=>0]
                ],
                'error' => $e->getMessage(),
                'last7Days' => [],
                'statistics' => [],
                'servicesByType' => collect(),
                'recentTransactions' => collect(),
                'transactionSummary' => [],
                'pendingServices' => collect(),
                'pendingWithdrawals' => collect(),
                'pendingResourceWithdrawals' => collect(),
                'recentCardDeposits' => collect(),
                'recentBankDeposits' => collect(),
                'activeDiscountCodes' => collect(),
                'monthlyRevenue' => [],
                'recentPurchases' => collect(),
                'notifications' => collect()
            ]);
        }
    }
}
