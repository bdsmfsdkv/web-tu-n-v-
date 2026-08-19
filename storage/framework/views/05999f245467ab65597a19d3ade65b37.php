<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-coins me-2"></i> RÚT VÀNG</h1>
                </div>

                <div class="profile-content">
                    <?php echo $__env->make('layouts.user.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><i class="fa-solid fa-coins me-2"></i> SỐ VÀNG HIỆN TẠI:
                                        <?php echo e(number_format(auth()->user()->gold)); ?></span>
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

                                <form action="<?php echo e(route('profile.withdraw-gold')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="amount" class="form-label">
                                            <i class="fa-solid fa-coins me-2"></i> Số lượng vàng muốn rút
                                        </label>
                                        <input type="number" value="0"
                                            class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="amount"
                                            name="amount" required min="<?php echo e($minWithdrawGold); ?>" max="<?php echo e($maxWithdrawGold); ?>">
                                        <div class="form-text">Tối thiểu: <?php echo e(number_format($minWithdrawGold)); ?> vàng - Tối đa: <?php echo e(number_format($maxWithdrawGold)); ?> vàng</div>
                                        <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="game" class="form-label">
                                            <i class="fa-solid fa-gamepad me-2"></i> Chọn game
                                        </label>
                                        <select class="form-control <?php $__errorArgs = ['game'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="game" name="game" required>
                                            <option value="">Chọn loại game</option>
                                            <option value="Liên Quân Mobile" <?php echo e(old('game') == 'Liên Quân Mobile' ? 'selected' : ''); ?>>Liên Quân Mobile</option>
                                            <option value="Free Fire" <?php echo e(old('game') == 'Free Fire' ? 'selected' : ''); ?>>Free Fire</option>
                                            <option value="Ngọc Rồng Online" <?php echo e(old('game') == 'Ngọc Rồng Online' ? 'selected' : ''); ?>>Ngọc Rồng Online</option>
                                            <option value="Ninja School" <?php echo e(old('game') == 'Ninja School' ? 'selected' : ''); ?>>Ninja School</option>
                                            <option value="Khác" <?php echo e(old('game') == 'Khác' ? 'selected' : ''); ?>>Khác</option>
                                        </select>
                                        <?php $__errorArgs = ['game'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="character_name" class="form-label">
                                            <i class="fa-solid fa-user me-2"></i> Tên nhân vật
                                        </label>
                                        <input type="text"
                                            class="form-control <?php $__errorArgs = ['character_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="character_name" name="character_name" value="<?php echo e(old('character_name')); ?>"
                                            required>
                                        <?php $__errorArgs = ['character_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="server" class="form-label">
                                            <i class="fa-solid fa-server me-2"></i> Máy chủ
                                        </label>
                                        <input type="text"
                                            class="form-control <?php $__errorArgs = ['server'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="server" name="server" value="<?php echo e(old('server')); ?>"
                                            placeholder="Nhập máy chủ hoặc cách đăng nhập (VD: Facebook, Garena...)"
                                            required>
                                        <?php $__errorArgs = ['server'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="user_note" class="form-label">
                                            <i class="fa-solid fa-note-sticky me-2"></i> Ghi chú
                                        </label>
                                        <textarea class="form-control <?php $__errorArgs = ['user_note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="user_note" name="user_note" rows="3"
                                            placeholder="Ghi chú thêm về yêu cầu rút vàng (nếu có)"><?php echo e(old('user_note')); ?></textarea>
                                        <?php $__errorArgs = ['user_note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-check me-2"></i> Gửi yêu cầu
                                        </button>
                                    </div>
                                </form>

                                <div class="withdrawal-history mt-5">
                                    <div class="history-header">LỊCH SỬ RÚT VÀNG</div>
                                    <div class="history-table-container">
                                        <table class="history-table">
                                            <thead>
                                                <tr>
                                                    <th>Trạng thái</th>
                                                    <th>Thời gian</th>
                                                    <th>Game</th>
                                                    <th>Số lượng</th>
                                                    <th>Tên nhân vật</th>
                                                    <th>Máy chủ</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(isset($withdrawals) && count($withdrawals) > 0): ?>
                                                    <?php $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo display_status($withdrawal->status); ?>

                                                            </td>
                                                            <td><?php echo e($withdrawal->created_at->format('d/m/Y H:i:s')); ?></td>
                                                            <td><?php echo e($withdrawal->game); ?></td>
                                                            <td><?php echo e(number_format($withdrawal->amount)); ?></td>
                                                            <td><?php echo e($withdrawal->character_name); ?></td>
                                                            <td><?php echo e($withdrawal->server); ?></td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info view-details"
                                                                    data-id="<?php echo e($withdrawal->id); ?>" data-type="gold">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">Chưa có lịch sử rút vàng</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php if(isset($withdrawals) && count($withdrawals) > 0): ?>
                                        <div class="pagination-area mt-3">
                                            <?php echo e($withdrawals->links()); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Withdrawal Details Modal -->
    <div id="withdrawalDetailsModal" class="modal">
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title"><i class="fa-solid fa-circle-info me-2"></i> Chi tiết rút vàng #<span
                        id="withdrawal-id"></span></h2>
                <button class="modal__close" onclick="closeWithdrawalModal()">&times;</button>
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
                        <span class="modal__value" id="withdrawal-time"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-coins me-2"></i> Loại tài nguyên:</span>
                        <span class="modal__value" id="withdrawal-type"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-gamepad me-2"></i> Game:</span>
                        <span class="modal__value" id="withdrawal-game"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-coins me-2"></i> Số lượng:</span>
                        <span class="modal__value" id="withdrawal-amount"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-user me-2"></i> Tên nhân vật:</span>
                        <span class="modal__value" id="character-name"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-server me-2"></i> Máy chủ:</span>
                        <span class="modal__value" id="withdrawal-server"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-circle-check me-2"></i> Trạng thái:</span>
                        <span class="modal__value" id="withdrawal-status"></span>
                    </div>
                    <div class="modal__row" id="user-note-container">
                        <span class="modal__label"><i class="fa-solid fa-note-sticky me-2"></i> Ghi chú người dùng:</span>
                        <span class="modal__value" id="user-note"></span>
                    </div>
                    <div class="modal__row" id="admin-note-container">
                        <span class="modal__label"><i class="fa-solid fa-note-sticky me-2"></i> Ghi chú admin:</span>
                        <span class="modal__value" id="admin-note"></span>
                    </div>
                </div>

                <div id="modal-error" class="alert alert-danger" style="display: none;">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> <span id="error-message"></span>
                </div>
            </div>

            <div class="modal__footer">
                <button class="modal__btn modal__btn--close" onclick="closeWithdrawalModal()">ĐÓNG</button>
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
                    const withdrawalId = this.getAttribute('data-id');
                    document.getElementById('withdrawal-id').textContent = withdrawalId;

                    // Show loading, hide content and errors
                    document.getElementById('modal-loading').style.display = 'block';
                    document.getElementById('modal-content').style.display = 'none';
                    document.getElementById('modal-error').style.display = 'none';

                    // Show the modal
                    openWithdrawalModal();

                    // Fetch withdrawal details via AJAX
                    fetch(`/profile/withdrawal-history/${withdrawalId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('modal-loading').style.display = 'none';

                            if (data.status === 'success') {
                                // Format data and populate the modal
                                document.getElementById('withdrawal-time').textContent =
                                    new Date(
                                        data.created_at).toLocaleString('vi-VN');
                                document.getElementById('withdrawal-type').textContent = data
                                    .type === 'gold' ? 'Vàng' : 'Ngọc';
                                document.getElementById('withdrawal-game').textContent = data
                                    .game;
                                document.getElementById('withdrawal-amount').textContent =
                                    new Intl.NumberFormat('vi-VN').format(data.amount);
                                document.getElementById('character-name').textContent = data
                                    .character_name;
                                document.getElementById('withdrawal-server').textContent =
                                    data.server;
                                document.getElementById('withdrawal-status').innerHTML = data
                                    .status_html;

                                // Display user note if exists
                                if (data.user_note) {
                                    document.getElementById('user-note').textContent = data
                                        .user_note;
                                    document.getElementById('user-note-container').style
                                        .display = 'flex';
                                } else {
                                    document.getElementById('user-note').textContent =
                                        "Không có ghi chú";
                                }

                                // Display admin note if exists
                                if (data.admin_note) {
                                    document.getElementById('admin-note').textContent = data
                                        .admin_note;
                                    document.getElementById('admin-note-container').style
                                        .display = 'flex';
                                } else {
                                    document.getElementById('admin-note').textContent =
                                        "Không có ghi chú";
                                }

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
                            console.error('Error fetching withdrawal details:', error);
                            document.getElementById('modal-loading').style.display = 'none';
                            document.getElementById('error-message').textContent =
                                'Đã xảy ra lỗi kết nối, vui lòng thử lại sau';
                            document.getElementById('modal-error').style.display = 'block';
                        });
                });
            });
        });

        // Function to open withdrawal modal
        function openWithdrawalModal() {
            document.getElementById('withdrawalDetailsModal').style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        }

        // Function to close withdrawal modal
        function closeWithdrawalModal() {
            document.getElementById('withdrawalDetailsModal').style.display = 'none';
            document.body.style.overflow = ''; // Restore scrolling
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\user\profile\withdraw-gold.blade.php ENDPATH**/ ?>