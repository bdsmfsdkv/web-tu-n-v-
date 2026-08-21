

<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-clipboard-list me-2"></i> DỊCH VỤ ĐÃ THUÊ</h1>
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
                                                    <th>Máy chủ</th>
                                                    <th>Dịch vụ</th>
                                                    <th>Giá trị</th>
                                                    <th>Trạng thái</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__empty_1 = true; $__currentLoopData = $serviceHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td><?php echo e($service->created_at->format('H:i d/m/Y')); ?></td>

                                                        <td>Server <?php echo e($service->server); ?></td>
                                                        <td><?php echo e($service->gameService->name); ?></td>
                                                        <td class="amount text-danger">
                                                            -<?php echo e(number_format($service->price)); ?> VND</td>
                                                        <td>
                                                            <?php if($service->status === 'pending'): ?>
                                                                <span class="status-badge status-pending">
                                                                    <i class="fa-solid fa-clock me-1"></i> Đang xử lý
                                                                </span>
                                                            <?php elseif($service->status === 'completed'): ?>
                                                                <span class="status-badge status-completed">
                                                                    <i class="fa-solid fa-check me-1"></i> Hoàn thành
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="status-badge status-failed">
                                                                    <i class="fa-solid fa-xmark me-1"></i> Thất bại
                                                                </span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-info view-details"
                                                                data-id="<?php echo e($service->id); ?>">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="7" class="no-data">Không có dữ liệu</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="pagination">
                                        <?php echo e($serviceHistories->links('user.pagination.custom')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Details Modal -->
    <div id="serviceDetailsModal" class="modal">
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title"><i class="fa-solid fa-circle-info me-2"></i> Chi tiết dịch vụ #<span
                        id="service-id"></span></h2>
                <button class="modal__close" onclick="closeServiceModal()">&times;</button>
            </div>

            <div class="modal__body">
                <div id="modal-loading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                    <p class="mt-2">Đang tải thông tin...</p>
                </div>

                <div id="modal-content" class="modal__info" style="display: none;">
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-calendar me-2"></i> Thời gian:</span>
                        <span class="modal__value" id="service-time"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-server me-2"></i> Máy chủ:</span>
                        <span class="modal__value" id="service-server"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-cube me-2"></i> Dịch vụ:</span>
                        <span class="modal__value" id="service-name"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-money-bill me-2"></i> Giá trị:</span>
                        <span class="modal__value modal__value--price" id="service-price"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-circle-check me-2"></i> Trạng thái:</span>
                        <span class="modal__value" id="service-status"></span>
                    </div>
                    <div class="modal__row" id="admin-note-container">
                        <span class="modal__label"><i class="fa-solid fa-note-sticky me-2"></i> Ghi chú:</span>
                        <span class="modal__value" id="admin-note"></span>
                    </div>
                </div>

                <div id="modal-error" class="alert alert-danger" style="display: none;">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> <span id="error-message"></span>
                </div>
            </div>

            <div class="modal__footer">
                <button class="modal__btn modal__btn--close" onclick="closeServiceModal()">ĐÓNG</button>
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
                    const serviceId = this.getAttribute('data-id');
                    document.getElementById('service-id').textContent = serviceId;

                    // Show loading, hide content and errors
                    document.getElementById('modal-loading').style.display = 'block';
                    document.getElementById('modal-content').style.display = 'none';
                    document.getElementById('modal-error').style.display = 'none';

                    // Show the modal
                    openServiceModal();

                    // Fetch service details via AJAX
                    fetch(`/profile/service-history/${serviceId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('modal-loading').style.display = 'none';

                            if (data.status === 'success') {
                                // Format data and populate the modal
                                document.getElementById('service-time').textContent = new Date(
                                    data.created_at).toLocaleString('vi-VN');
                                document.getElementById('service-server').textContent =
                                    'Server ' + data.server;
                                document.getElementById('service-name').textContent = data
                                    .game_service.name;
                                document.getElementById('service-price').textContent = '-' +
                                    new Intl.NumberFormat('vi-VN').format(data.price) + ' VND';
                                document.getElementById('service-status').innerHTML = data
                                    .status_html;
                                document.getElementById('admin-note').textContent = data
                                    .admin_note ? data.admin_note : "Không có ghi chú";



                                // Show the content
                                document.getElementById('modal-content').style.display =
                                    'block';
                            } else {
                                // Show error message
                                document.getElementById('error-message').textContent = data
                                    .message || 'Đã xảy ra lỗi khi tải dữ liệu';
                                document.getElementById('modal-error').style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching service details:', error);
                            document.getElementById('modal-loading').style.display = 'none';
                            document.getElementById('error-message').textContent =
                                'Đã xảy ra lỗi kết nối, vui lòng thử lại sau';
                            document.getElementById('modal-error').style.display = 'block';
                        });
                });
            });
        });

        // Function to open service modal
        function openServiceModal() {
            document.getElementById('serviceDetailsModal').style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        }

        // Function to close service modal
        function closeServiceModal() {
            document.getElementById('serviceDetailsModal').style.display = 'none';
            document.body.style.overflow = ''; // Restore scrolling
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\user\profile\services-history.blade.php ENDPATH**/ ?>