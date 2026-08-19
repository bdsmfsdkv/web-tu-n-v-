

<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-box me-2"></i> TÀI KHOẢN ĐÃ MUA</h1>
                </div>

                <div class="profile-content">
                    <?php echo $__env->make('layouts.user.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><i class="fa-solid fa-wallet me-2"></i> SỐ DƯ HIỆN TẠI:
                                        <?php echo e(number_format($user->balance)); ?> VND</span>
                                </div>
                            </div>

                            <div class="info-content">
                                <?php if(session('error')): ?>
                                    <div class="alert alert-danger">
                                        <i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo e(session('error')); ?>

                                    </div>
                                <?php endif; ?>

                                <?php if(session('success')): ?>
                                    <div class="alert alert-success">
                                        <i class="fa-solid fa-circle-check me-2"></i> <?php echo e(session('success')); ?>

                                    </div>
                                <?php endif; ?>

                                <div class="transaction-history">
                                    <style>
                                        .order-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; margin-bottom: 24px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
                                        .order-card-title { display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 1.1rem; color: #111827; margin-bottom: 16px; border-bottom: 1px solid #f0f0f0; padding-bottom: 12px;}
                                        .order-info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 16px; margin-bottom: 24px; }
                                        .order-info-box { background: #f8fafc; border-radius: 8px; padding: 12px; display: flex; align-items: center; gap: 12px; border: 1px solid #f1f5f9; }
                                        .order-info-label { font-size: 0.85rem; color: #64748b; width: 65px; line-height: 1.2; }
                                        .order-info-val { font-size: 0.95rem; color: #0f172a; font-weight: 700; line-height: 1.2; }
                                        .order-acc-list-title { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
                                        .order-acc-list-title-text { display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 1rem; color: #111827; }
                                        .order-acc-item { background: #f8fafc; border-radius: 8px; padding: 8px 12px; display: flex; align-items: center; gap: 12px; margin-bottom: 12px; border: 1px solid #f1f5f9; }
                                        .order-acc-index { width: 28px; height: 28px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem; flex-shrink: 0; }
                                        .order-acc-text { flex: 1; font-family: monospace; font-size: 0.95rem; color: #0f172a; word-break: break-all; }
                                        .order-btn-copy { background: #e2e8f0; color: #334155; border: none; padding: 6px 16px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 6px; font-size: 0.85rem; transition: 0.2s; font-weight: 600; }
                                        .order-btn-copy:hover { background: #cbd5e1; }
                                        .order-btn-copy-all { background: var(--primary); color: #fff; border: none; padding: 6px 16px; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; transition: 0.2s; }
                                        .order-btn-copy-all:hover { background: var(--primary-dark); }
                                        .order-btn-export { background: #334155; color: #fff; border: none; padding: 6px 16px; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 600; transition: 0.2s; }
                                        .order-btn-export:hover { background: #475569; }
                                        .order-warning { font-size: 0.85rem; color: #d97706; display: flex; align-items: center; gap: 6px; }
                                        
                                        [data-theme="dark"] .order-card { background: #171717; border-color: #2a2a2a; }
                                        [data-theme="dark"] .order-card-title { color: #f8fafc; border-color: #2a2a2a; }
                                        [data-theme="dark"] .order-acc-list-title-text { color: #f8fafc; }
                                        [data-theme="dark"] .order-info-box { background: #262626; border-color: #333; }
                                        [data-theme="dark"] .order-info-label { color: #a3a3a3; }
                                        [data-theme="dark"] .order-info-val { color: #f8fafc; }
                                        [data-theme="dark"] .order-acc-item { background: #262626; border-color: #333; }
                                        [data-theme="dark"] .order-acc-text { color: #f8fafc; }
                                        [data-theme="dark"] .order-btn-copy { background: #404040; color: #f8fafc; }
                                        [data-theme="dark"] .order-btn-copy:hover { background: #525252; }
                                        [data-theme="dark"] .order-btn-export { background: #262626; border: 1px solid #404040; color: #f8fafc; }
                                        [data-theme="dark"] .order-btn-export:hover { background: #333; }
                                        
                                        .empty-state-box { text-align: center; padding: 40px; background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; margin-bottom: 24px; }
                                        [data-theme="dark"] .empty-state-box { background: #171717; border-color: #2a2a2a; }
                                    </style>

                                    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="order-card">
                                            <div class="order-card-title">
                                                <span class="iconify" data-icon="ant-design:file-text-outlined"></span> Thông tin đơn hàng #<?php echo e($transaction->order_code); ?>

                                            </div>
                                            
                                            <div class="order-info-grid">
                                                <div class="order-info-box">
                                                    <div class="order-info-label">Danh mục</div>
                                                    <div class="order-info-val"><?php echo str_replace(' ', '<br>', $transaction->category->name ?? 'Tài khoản Game'); ?></div>
                                                </div>
                                                <div class="order-info-box">
                                                    <div class="order-info-label">Số lượng</div>
                                                    <div class="order-info-val">1 acc</div>
                                                </div>
                                                <div class="order-info-box">
                                                    <div class="order-info-label">Tổng tiền</div>
                                                    <div class="order-info-val" style="color: var(--primary); font-size: 1.05rem;"><?php echo e(number_format($transaction->price)); ?>đ</div>
                                                </div>
                                                <div class="order-info-box">
                                                    <div class="order-info-label">Trạng thái</div>
                                                    <div class="order-info-val" style="color: #22c55e; border: 1px solid rgba(34, 197, 94, 0.3); padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 0.85rem;">Hoàn thành</div>
                                                </div>
                                                <div class="order-info-box">
                                                    <div class="order-info-label">Thời gian</div>
                                                    <div class="order-info-val"><?php echo e($transaction->created_at->format('d/m/Y')); ?><br><?php echo e($transaction->created_at->format('H:i')); ?></div>
                                                </div>
                                            </div>

                                            <div class="order-acc-list-title">
                                                <div class="order-acc-list-title-text">
                                                    <span class="iconify" data-icon="ant-design:key-outlined"></span> Danh sách tài khoản (1)
                                                </div>
                                                <div>
                                                    <a href="<?php echo e(route('account.show', ['id' => $transaction->id])); ?>" target="_blank" class="order-btn-copy" style="text-decoration: none;">
                                                        <span class="iconify" data-icon="ant-design:eye-outlined"></span> Chi tiết
                                                    </a>
                                                </div>
                                            </div>

                                            <div style="display: flex; gap: 8px; margin-bottom: 12px; flex-wrap: wrap;">
                                                <button class="order-btn-copy-all" onclick="copyToClipboardText('<?php echo e(addslashes($transaction->account_name . "|" . $transaction->password)); ?>')">
                                                    <span class="iconify" data-icon="ant-design:copy-outlined"></span> Copy tất cả
                                                </button>
                                                <button class="order-btn-export" onclick="exportToTxt('<?php echo e(addslashes($transaction->account_name . "|" . $transaction->password)); ?>', 'don_hang_<?php echo e($transaction->id); ?>.txt')">
                                                    <span class="iconify" data-icon="ant-design:download-outlined"></span> Xuất file TXT
                                                </button>
                                            </div>

                                            <div class="order-acc-item">
                                                <div class="order-acc-index">1</div>
                                                <div class="order-acc-text">
                                                    <?php echo e($transaction->account_name); ?> | <?php echo e($transaction->password); ?>

                                                </div>
                                                <button class="order-btn-copy" onclick="copyToClipboardText('<?php echo e(addslashes($transaction->account_name . " | " . $transaction->password)); ?>')">
                                                    <span class="iconify" data-icon="ant-design:copy-outlined"></span> Copy
                                                </button>
                                            </div>

                                            <div class="order-warning">
                                                <span class="iconify" data-icon="ant-design:warning-outlined"></span> Hãy đổi mật khẩu ngay sau khi nhận tài khoản!
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="empty-state-box">
                                            <span class="iconify" data-icon="ant-design:inbox-outlined" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 12px;"></span>
                                            <p style="color: #64748b; margin: 0; font-weight: 600;">Bạn chưa mua tài khoản nào.</p>
                                        </div>
                                    <?php endif; ?>

                                    <div class="pagination">
                                        <?php echo e($transactions->links('user.pagination.custom')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function copyToClipboardText(text) {
            navigator.clipboard.writeText(text).then(() => {
                if (typeof FuiToast !== 'undefined') {
                    FuiToast.success("Đã sao chép: " + text);
                } else {
                    alert("Đã sao chép: " + text);
                }
            }).catch(err => {
                console.error('Lỗi khi sao chép: ', err);
                if (typeof FuiToast !== 'undefined') {
                    FuiToast.error("Trình duyệt không hỗ trợ sao chép tự động!");
                }
            });
        }

        function exportToTxt(content, filename) {
            try {
                const blob = new Blob([content], { type: 'text/plain;charset=utf-8' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
                if (typeof FuiToast !== 'undefined') {
                    FuiToast.success("Đã tải xuống file: " + filename);
                }
            } catch (err) {
                console.error('Lỗi khi xuất file: ', err);
                if (typeof FuiToast !== 'undefined') {
                    FuiToast.error("Có lỗi xảy ra khi xuất file TXT!");
                }
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/user/profile/purchased-accounts.blade.php ENDPATH**/ ?>