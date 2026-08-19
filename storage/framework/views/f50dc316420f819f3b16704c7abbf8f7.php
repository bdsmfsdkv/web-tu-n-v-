
<?php $__env->startSection('title', $title); ?>

<?php $__env->startPush('css'); ?>
    <style>
        :root {
            --bg-card: #ffffff;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border-subtle: #e5e7eb;
            --bg-body: #f8f9fa;
        }

        [data-theme="dark"] {
            --bg-card: #121212;
            --text-main: #f8fafc;
            --text-muted: #9ca3af;
            --border-subtle: #27272a;
            --bg-body: #000000;
        }

        .affiliate-container {
            padding: 40px 0;
            color: var(--text-main, #1f2937);
        }

        .affiliate-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .affiliate-line {
            width: 30px;
            height: 4px;
            background: #10b981;
            border-radius: 4px;
        }

        .affiliate-header-text h2 {
            font-size: 1.5rem;
            font-weight: 900;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .affiliate-header-text p {
            font-size: 0.75rem;
            color: var(--text-muted, #6b7280);
            margin: 5px 0 0 0;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .affiliate-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }

        @media (min-width: 992px) {
            .affiliate-layout {
                grid-template-columns: 2fr 1fr;
            }
        }

        .affiliate-card {
            background: var(--bg-card, #ffffff);
            border-radius: 24px;
            border: 1px solid var(--border-subtle, #e5e7eb);
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: var(--bg-card, #ffffff);
            border: 1px solid var(--border-subtle, #e5e7eb);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.green {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .stat-icon.blue {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .stat-info h4 {
            font-size: 0.8rem;
            color: var(--text-muted, #6b7280);
            margin: 0 0 5px 0;
            text-transform: uppercase;
            font-weight: 700;
        }

        .stat-info p {
            font-size: 1.25rem;
            color: var(--text-main, #1f2937);
            margin: 0;
            font-weight: 900;
        }

        .link-box {
            background: var(--bg-card, #ffffff);
            border: 1px dashed var(--primary, #3b82f6);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 30px;
        }

        .link-box label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-muted, #6b7280);
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .link-input-group {
            display: flex;
            gap: 10px;
        }

        .link-input-group input {
            flex: 1;
            background: var(--bg-body, #f8f9fa);
            border: 1px solid var(--border-subtle, #e5e7eb);
            color: var(--text-main, #1f2937);
            padding: 0 15px;
            border-radius: 10px;
            font-weight: 600;
        }

        .link-input-group button {
            background: #10b981;
            color: white;
            border: none;
            padding: 0 20px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .link-input-group button:hover {
            background: #059669;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .history-table th {
            text-align: left;
            padding: 15px;
            color: var(--text-muted, #6b7280);
            font-size: 0.85rem;
            text-transform: uppercase;
            border-bottom: 1px solid var(--border-subtle, #e5e7eb);
        }

        .history-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-subtle, #e5e7eb);
            color: var(--text-main, #1f2937);
            font-size: 0.95rem;
        }

        .notes-card {
            background: var(--bg-card, #ffffff);
            border-radius: 24px;
            border: 1px solid var(--border-subtle, #e5e7eb);
            padding: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .notes-card::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 6px;
            background: #10b981;
        }

        .notes-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .notes-title {
            font-size: 1.1rem;
            font-weight: 900;
            color: var(--text-main, #1f2937);
            margin: 0;
        }

        .notes-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .notes-list li {
            position: relative;
            padding-left: 15px;
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: var(--text-muted, #6b7280);
            line-height: 1.6;
        }

        .notes-list li::before {
            content: '-';
            position: absolute;
            left: 0;
            color: #6b7280;
        }

        .notes-list li strong {
            color: #10b981;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <section class="affiliate-container">
        <div class="container">
            <div class="profile-content">
                <?php echo $__env->make('layouts.user.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="profile-main">
                    <div class="affiliate-header">
                        <div class="affiliate-line"></div>
                        <div class="affiliate-header-text">
                            <h2>TIẾP THỊ LIÊN KẾT</h2>
                            <p>CHIA SẺ LINK - NHẬN HOA HỒNG TỪ NGƯỜI ĐĂNG KÝ</p>
                        </div>
                    </div>

                    <div class="affiliate-layout">
                        <!-- Left Panel: Stats and Link -->
                        <div class="affiliate-card">
                            <div class="stats-grid">
                                <div class="stat-box">
                                    <div class="stat-icon blue">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h4>ĐÃ GIỚI THIỆU</h4>
                                        <p><?php echo e(number_format($referredUsersCount)); ?> <span style="font-size:0.8rem; font-weight: 400; color:#9ca3af">người</span></p>
                                    </div>
                                </div>
                                <div class="stat-box">
                                    <div class="stat-icon green">
                                        <i class="fas fa-coins"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h4>TỔNG HOA HỒNG</h4>
                                        <p><?php echo e(number_format($user->total_commission)); ?> <span style="font-size:0.8rem; font-weight: 400; color:#9ca3af">VNĐ</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="link-box">
                                <label><i class="fas fa-link me-2"></i> LINK GIỚI THIỆU CỦA BẠN</label>
                                <div class="link-input-group">
                                    <input type="text" id="ref-link" value="<?php echo e(url('/')); ?>?ref=<?php echo e($user->username); ?>" readonly>
                                    <button onclick="copyRefLink()"><i class="fas fa-copy"></i> Sao chép</button>
                                </div>
                            </div>

                            <h3 style="font-size: 1.1rem; font-weight: 800; margin-bottom: 15px; color: #f8fafc;"><i class="fas fa-history me-2"></i> Lịch sử nhận hoa hồng</h3>
                            <div style="overflow-x: auto;">
                                <table class="history-table">
                                    <thead>
                                        <tr>
                                            <th>Thời gian</th>
                                            <th>Người nạp</th>
                                            <th>Loại</th>
                                            <th>Hoa hồng (VNĐ)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $affiliateHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($history->created_at->format('d/m/Y H:i')); ?></td>
                                                <td><?php echo e($history->referred ? $history->referred->username : 'Ẩn danh'); ?></td>
                                                <td><?php echo e(ucfirst($history->type)); ?></td>
                                                <td style="color: #10b981; font-weight: bold;">+<?php echo e(number_format($history->commission_amount)); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="4" style="text-align: center; color: #9ca3af;">Chưa có dữ liệu hoa hồng.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php if(isset($affiliateHistories) && count($affiliateHistories) > 0): ?>
                                <div class="mt-3">
                                    <?php echo e($affiliateHistories->links('user.pagination.custom')); ?>

                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Right Panel: Rules -->
                        <div>
                            <div class="notes-card">
                                <div class="notes-header">
                                    <h3 class="notes-title">CHÍNH SÁCH HOA HỒNG</h3>
                                </div>
                                <ul class="notes-list">
                                    <li>Bạn sẽ nhận được <strong>10%</strong> giá trị mỗi khi người được bạn giới thiệu NẠP TIỀN thành công.</li>
                                    <li>Hoa hồng được cộng trực tiếp vào Số Dư (VND) của bạn.</li>
                                    <li>Không giới hạn số lượng người giới thiệu và số lần nạp.</li>
                                    <li>Nghiêm cấm các hành vi gian lận (tạo nhiều tài khoản clone), nếu phát hiện sẽ <strong>khóa vĩnh viễn</strong>.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        function copyRefLink() {
            var copyText = document.getElementById("ref-link");
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */
            navigator.clipboard.writeText(copyText.value);
            
            if (typeof FuiToast !== 'undefined') {
                FuiToast.success('Đã sao chép link giới thiệu!');
            } else {
                alert('Đã sao chép: ' + copyText.value);
            }
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views/user/profile/affiliate.blade.php ENDPATH**/ ?>