<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><span class="iconify me-2" data-icon="ant-design:history-outlined"></span> LỊCH SỬ VẬN MAY</h1>
                </div>

                <div class="profile-content">
                    <?php echo $__env->make('layouts.user.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><span class="iconify me-2" data-icon="ant-design:wallet-outlined"></span> SỐ DƯ HIỆN TẠI:
                                        <?php echo e(number_format($user->balance)); ?> VND</span>
                                </div>
                            </div>

                            <div class="info-content">
                                <?php if(session('error')): ?>
                                    <div class="alert alert-danger">
                                        <span class="iconify me-2" data-icon="ant-design:info-circle-outlined"></span> <?php echo e(session('error')); ?>

                                    </div>
                                <?php endif; ?>

                                <?php if(session('success')): ?>
                                    <div class="alert alert-success">
                                        <span class="iconify me-2" data-icon="ant-design:check-circle-outlined"></span> <?php echo e(session('success')); ?>

                                    </div>
                                <?php endif; ?>

                                <div class="transaction-history">
                                    <style>
                                        /* Custom Modal CSS */
                                        .modal { display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(4px); }
                                        .modal__content { background-color: #fff; margin: 10% auto; width: 90%; max-width: 500px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); animation: modalFadeIn 0.3s; overflow: hidden; display: flex; flex-direction: column; }
                                        @keyframes modalFadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
                                        .modal__header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid #e5e7eb; background-color: #f8fafc; }
                                        .modal__title { margin: 0; font-size: 1.25rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; }
                                        .modal__close { background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer; line-height: 1; padding: 0; transition: color 0.2s; }
                                        .modal__close:hover { color: #ef4444; }
                                        .modal__body { padding: 20px; flex: 1; }
                                        .modal__footer { padding: 16px 20px; border-top: 1px solid #e5e7eb; background-color: #f8fafc; text-align: right; }
                                        .modal__btn { padding: 8px 16px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: 0.2s; border: none; }
                                        .modal__btn--close { background-color: #e2e8f0; color: #475569; }
                                        .modal__btn--close:hover { background-color: #cbd5e1; }
                                        .modal__row { display: flex; margin-bottom: 12px; font-size: 0.95rem; }
                                        .modal__row:last-child { margin-bottom: 0; }
                                        .modal__label { width: 120px; color: #64748b; font-weight: 500; display: flex; align-items: center; flex-shrink: 0; }
                                        .modal__value { flex: 1; color: #0f172a; font-weight: 600; }
                                        .modal__value--price { color: #ef4444; font-size: 1.05rem; }

                                        /* Dark theme for Modal */
                                        [data-theme="dark"] .modal__content { background-color: #171717; border: 1px solid #2a2a2a; }
                                        [data-theme="dark"] .modal__header { background-color: #0f172a; border-bottom-color: #333; }
                                        [data-theme="dark"] .modal__title { color: #f8fafc; }
                                        [data-theme="dark"] .modal__close { color: #94a3b8; }
                                        [data-theme="dark"] .modal__close:hover { color: #ef4444; }
                                        [data-theme="dark"] .modal__footer { background-color: #0f172a; border-top-color: #333; }
                                        [data-theme="dark"] .modal__btn--close { background-color: #334155; color: #f8fafc; }
                                        [data-theme="dark"] .modal__btn--close:hover { background-color: #475569; }
                                        [data-theme="dark"] .modal__label { color: #94a3b8; }
                                        [data-theme="dark"] .modal__value { color: #f8fafc; }
                                    </style>
                                    <div class="history-table-container">
                                        <table class="history-table">
                                            <thead>
                                                <tr>
                                                    <th>Thời gian</th>
                                                    <th>Vòng quay</th>
                                                    <th>Số lượt quay</th>
                                                    <th>Chi phí</th>
                                                    <th>Phần thưởng</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__empty_1 = true; $__currentLoopData = $wheelHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td><?php echo e($history->created_at->format('H:i d/m/Y')); ?></td>
                                                        <td><?php echo e($history->luckyWheel->name); ?></td>
                                                        <td><?php echo e($history->spin_count); ?></td>
                                                        <td class="amount text-danger">
                                                            -<?php echo e(number_format($history->total_cost)); ?> VND</td>
                                                        <td>
                                                            <?php if($history->reward_type === 'gold'): ?>
                                                                <span class="status-badge status-completed">
                                                                    <span class="iconify me-1" data-icon="ri:coin-fill" style="color: #eab308;"></span>
                                                                    <?php echo e(number_format($history->reward_amount)); ?> vàng
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="status-badge status-completed">
                                                                    <span class="iconify me-1" data-icon="ri:vip-diamond-fill" style="color: #ec4899;"></span>
                                                                    <?php echo e(number_format($history->reward_amount)); ?> ngọc
                                                                </span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm view-details" data-id="<?php echo e($history->id); ?>" style="background: transparent; border: 1px solid #4b5563; color: #e5e5e5; display: inline-flex; align-items: center; justify-content: center; padding: 4px 8px; border-radius: 6px; transition: 0.2s;">
                                                                <span class="iconify" data-icon="ant-design:eye-outlined" style="font-size: 1.2rem;"></span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="6" class="no-data">Không có dữ liệu</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="pagination">
                                        <?php echo e($wheelHistories->links()); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lucky Wheel Details Modal -->
    <div id="wheelDetailsModal" class="modal">
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title"><span class="iconify me-2" data-icon="ant-design:info-circle-outlined"></span> Chi tiết vòng quay #<span
                        id="wheel-id"></span></h2>
                <button class="modal__close" onclick="closeWheelModal()">&times;</button>
            </div>

            <div class="modal__body">
                <div id="wheel-modal-loading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                    <p class="mt-2">Đang tải thông tin...</p>
                </div>

                <div id="wheel-modal-content" class="modal__info" style="display: none;">
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-calendar me-2"></i> Thời gian:</span>
                        <span class="modal__value" id="wheel-time"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-circle me-2"></i> Vòng quay:</span>
                        <span class="modal__value" id="wheel-name"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-rotate me-2"></i> Số lượt quay:</span>
                        <span class="modal__value" id="wheel-spin-count"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-money-bill me-2"></i> Chi phí:</span>
                        <span class="modal__value modal__value--price" id="wheel-cost"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-gift me-2"></i> Phần thưởng:</span>
                        <span class="modal__value" id="wheel-reward"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-note-sticky me-2"></i> Mô tả:</span>
                        <span class="modal__value" id="wheel-description"></span>
                    </div>
                </div>

                <div id="wheel-modal-error" class="alert alert-danger" style="display: none;">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> <span id="wheel-error-message"></span>
                </div>
            </div>

            <div class="modal__footer">
                <button class="modal__btn modal__btn--close" onclick="closeWheelModal()">ĐÓNG</button>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all view details buttons
            const viewButtons = document.querySelectorAll('.view-details');

            // Add click event to each button
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const wheelId = this.getAttribute('data-id');
                    document.getElementById('wheel-id').textContent = wheelId;

                    // Show loading, hide content and errors
                    document.getElementById('wheel-modal-loading').style.display = 'block';
                    document.getElementById('wheel-modal-content').style.display = 'none';
                    document.getElementById('wheel-modal-error').style.display = 'none';

                    // Show the modal
                    openWheelModal();

                    // Fetch wheel details via AJAX
                    fetch(`/profile/wheel-history/${wheelId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('wheel-modal-loading').style.display =
                                'none';

                            if (data.status === 'success') {
                                // Format data and populate the modal
                                document.getElementById('wheel-time').textContent = new Date(
                                    data.created_at).toLocaleString('vi-VN');
                                document.getElementById('wheel-name').textContent = data
                                    .lucky_wheel.name;
                                document.getElementById('wheel-spin-count').textContent = data
                                    .spin_count;
                                document.getElementById('wheel-cost').textContent = '-' +
                                    new Intl.NumberFormat('vi-VN').format(data.total_cost) +
                                    ' VND';

                                // Format reward based on type
                                let rewardText = '';
                                if (data.reward_type === 'gold') {
                                    rewardText =
                                        `<i class="fa-solid fa-coins me-1"></i> ${new Intl.NumberFormat('vi-VN').format(data.reward_amount)} vàng`;
                                } else {
                                    rewardText =
                                        `<i class="fa-solid fa-gem me-1"></i> ${new Intl.NumberFormat('vi-VN').format(data.reward_amount)} ngọc`;
                                }
                                document.getElementById('wheel-reward').innerHTML = rewardText;

                                document.getElementById('wheel-description').textContent = data
                                    .description || 'Không có mô tả';

                                // Show the content
                                document.getElementById('wheel-modal-content').style.display =
                                    'block';
                            } else {
                                // Show error message
                                document.getElementById('wheel-error-message').textContent =
                                    data
                                    .message || 'Đã xảy ra lỗi khi tải dữ liệu';
                                document.getElementById('wheel-modal-error').style.display =
                                    'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching wheel details:', error);
                            document.getElementById('wheel-modal-loading').style.display =
                                'none';
                            document.getElementById('wheel-error-message').textContent =
                                'Đã xảy ra lỗi kết nối, vui lòng thử lại sau';
                            document.getElementById('wheel-modal-error').style.display =
                                'block';
                        });
                });
            });
        });

        // Function to open wheel modal
        function openWheelModal() {
            document.getElementById('wheelDetailsModal').style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        }

        // Function to close wheel modal
        function closeWheelModal() {
            document.getElementById('wheelDetailsModal').style.display = 'none';
            document.body.style.overflow = ''; // Restore scrolling
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\user\profile\wheels-history.blade.php ENDPATH**/ ?>