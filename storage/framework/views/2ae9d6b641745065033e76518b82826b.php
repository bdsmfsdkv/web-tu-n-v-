

<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-credit-card me-2"></i> NẠP TIỀN THẺ CÀO</h1>
                </div>

                <div class="profile-content">
                    <?php echo $__env->make('layouts.user.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><i class="fa-solid fa-wallet me-2"></i> SỐ DƯ HIỆN TẠI:
                                        <?php echo e(number_format(Auth::user()->balance)); ?> VND</span>
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

                                <form action="<?php echo e(route('profile.deposit-card')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="telecom" class="form-label">
                                            <i class="fa-solid fa-building me-2"></i> Nhà mạng
                                        </label>
                                        <select class="form-control <?php $__errorArgs = ['telecom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="telecom"
                                            name="telco" required>
                                            <option value="">Chọn nhà mạng</option>
                                            <option value="VIETTEL" <?php echo e(old('telecom') == 'VIETTEL' ? 'selected' : ''); ?>>
                                                Viettel
                                            </option>
                                            <option value="MOBIFONE" <?php echo e(old('telecom') == 'MOBIFONE' ? 'selected' : ''); ?>>
                                                Mobifone
                                            </option>
                                            <option value="VINAPHONE" <?php echo e(old('telecom') == 'VINAPHONE' ? 'selected' : ''); ?>>
                                                Vinaphone
                                            </option>
                                        </select>
                                        <?php $__errorArgs = ['telecom'];
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
                                        <label for="amount" class="form-label">
                                            <i class="fa-solid fa-money-bill me-2"></i> Mệnh giá
                                        </label>
                                        <select class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="amount"
                                            name="amount" required>
                                            <option value="">Chọn mệnh giá</option>
                                            <option value="10000" <?php echo e(old('amount') == '10000' ? 'selected' : ''); ?>>
                                                10.000 VND
                                            </option>
                                            <option value="20000" <?php echo e(old('amount') == '20000' ? 'selected' : ''); ?>>
                                                20.000 VND
                                            </option>
                                            <option value="50000" <?php echo e(old('amount') == '50000' ? 'selected' : ''); ?>>
                                                50.000 VND
                                            </option>
                                            <option value="100000" <?php echo e(old('amount') == '100000' ? 'selected' : ''); ?>>
                                                100.000 VND
                                            </option>
                                            <option value="200000" <?php echo e(old('amount') == '200000' ? 'selected' : ''); ?>>
                                                200.000 VND
                                            </option>
                                            <option value="500000" <?php echo e(old('amount') == '500000' ? 'selected' : ''); ?>>
                                                500.000 VND
                                            </option>
                                        </select>
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
                                        <label for="serial" class="form-label">
                                            <i class="fa-solid fa-barcode me-2"></i> Mã thẻ
                                        </label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['serial'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="serial" name="serial" value="<?php echo e(old('serial')); ?>" required>
                                        <?php $__errorArgs = ['serial'];
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
                                        <label for="pin" class="form-label">
                                            <i class="fa-solid fa-key me-2"></i> Mã PIN
                                        </label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['pin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="pin" name="pin" value="<?php echo e(old('pin')); ?>" required>
                                        <?php $__errorArgs = ['pin'];
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
                                            <i class="fa-solid fa-check me-2"></i> Nạp tiền
                                        </button>
                                    </div>
                                </form>

                                <div class="deposit-notice">
                                    <div class="notice-header">
                                        <?php if(config_get('payment.card.discount_percent') == 0): ?>
                                            NẠP THẺ KHÔNG CHIẾT KHẤU
                                        <?php else: ?>
                                            NẠP THẺ CHIẾT KHẤU <?php echo e(config_get('payment.card.discount_percent')); ?>%
                                        <?php endif; ?>
                                    </div>
                                    <div class="notice-content">Ví dụ nạp 100K nhận
                                        <?php echo e(100 - (100 * config_get('payment.card.discount_percent')) / 100); ?>K</div>
                                    <div class="notice-warning">SAI MỆNH GIÁ -50% GIÁ TRỊ GỐC CỦA THẺ</div>
                                </div>

                                <div class="deposit-history">
                                    <div class="history-header">LỊCH SỬ NẠP THẺ</div>
                                    <div class="history-table-container">
                                        <table class="history-table">
                                            <thead>
                                                <tr>
                                                    <th>Trạng thái</th>
                                                    <th>Thời gian</th>
                                                    <th>Nhà mạng</th>
                                                    <th>Mệnh giá</th>
                                                    <th>Thực nhận</th>
                                                    <th>Mã thẻ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td><?php echo display_status($transaction->status); ?></td>
                                                        <td><?php echo e($transaction->created_at); ?></td>
                                                        <td><?php echo e($transaction->telco); ?></td>
                                                        <td><?php echo e(number_format($transaction->amount)); ?> VND</td>
                                                        <td><?php echo e(number_format($transaction->received_amount)); ?> VND</td>
                                                        <td><?php echo e(substr($transaction->pin, 0, 3) . '******'); ?></td>
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

    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const amountSelect = document.getElementById('amount');
                const receiveAmount = document.getElementById('receive-amount');

                // Update received amount when amount changes
                amountSelect.addEventListener('change', function() {
                    receiveAmount.textContent = new Intl.NumberFormat('vi-VN').format(this.value) + ' VND';
                });

            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\user\profile\deposit-card.blade.php ENDPATH**/ ?>