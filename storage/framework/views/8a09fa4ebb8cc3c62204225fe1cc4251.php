<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
    <div >
        <div >
            <div class="page-header">
                <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0">Cài đặt thanh toán</h2>
                <p class="text-muted">Cấu hình các phương thức thanh toán</p>
            </div>
        </div>
    </div>
</div>
            </div>
            <!-- Notication -->
            <div class="card-body">
                <div class="alert alert-notication-custom alert-dismissible fade show" role="alert">
                    <strong>Chúng tôi hiện đang hỗ trợ 3 đối tác thanh toán:</strong>
                    <a href="https://thesieure.com" target="_blank">THESIEURE.COM</a>,
                    <a href="https://doithe1s.vn" target="_blank">DOITHE1S.VN</a>,
                    <a href="https://cardvip.vn" target="_blank">CARDVIP.VN</a>.
                    Nếu bạn có nhu cầu chọn đối tác khác, xin vui lòng liên hệ với chúng tôi (phí dịch vụ là
                    100K).
                    <br>
                    Địa chỉ nhận Callback theo phương thức GET hoặc POST đều được:
                    <b><strong><?php echo e(url(route('callback.card', [], ''))); ?></strong></b>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card">

                <div class="card-body">
                    <form action="<?php echo e(route('admin.settings.payment.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <!-- CÀI ĐẶT THẺ CÀO -->
                        <div class="card border border-light-subtle shadow-sm mb-4">
                            <div class="card-header bg-light-subtle">
                                <h5 class="card-title mb-0">
                                    <i class="ti ti-credit-card text-primary me-2"></i>Cài đặt nạp thẻ <span class="text-muted fw-normal fs-6">(Thanh toán qua thẻ cào)</span>
                                </h5>
                            </div>
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-4 pb-2 border-bottom">
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" type="checkbox" id="card_active" name="card_active" value="1" <?php echo e(old('card_active', $configs['card_active']) ? 'checked' : ''); ?>>
                                                <label class="form-check-label fw-semibold" for="card_active">Kích hoạt phương thức thanh toán thẻ cào</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        <div class="row">

                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Website đối tác <span class="text-danger">*</span></label>
                                    <select name="partner_website_card"
                                        class="form-select <?php $__errorArgs = ['partner_website_card'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">Chọn đối tác</option>
                                        <option value="thesieure.com"
                                            <?php echo e($configs['partner_website_card'] === 'thesieure.com' ? 'selected' : ''); ?>>
                                            THESIEURE.COM</option>
                                        <option value="cardvip.vn"
                                            <?php echo e($configs['partner_website_card'] === 'cardvip.vn' ? 'selected' : ''); ?>>
                                            CARDVIP.VN</option>
                                        <option value="doithe1s.vn"
                                            <?php echo e($configs['partner_website_card'] === 'doithe1s.vn' ? 'selected' : ''); ?>>
                                            DOITHE1S.VN</option>
                                    </select>
                                    <?php $__errorArgs = ['partner_website_card'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Chiết khấu nạp thẻ <span class="text-danger">*</span></label>
                                    <input type="text" name="discount_percent_card"
                                        value="<?php echo e(old('discount_percent_card', $configs['discount_percent_card'])); ?>"
                                        class="form-control <?php $__errorArgs = ['discount_percent_card'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Nhập chiết khấu nạp thẻ">
                                    <?php $__errorArgs = ['discount_percent_card'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Partner ID <span class="text-danger">*</span></label>
                                    <input type="text" name="partner_id_card"
                                        value="<?php echo e(old('partner_id_card', $configs['partner_id_card'])); ?>"
                                        class="form-control <?php $__errorArgs = ['partner_id_card'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Nhập Partner ID">
                                    <?php $__errorArgs = ['partner_id_card'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Partner Key <span class="text-danger">*</span></label>
                                    <input type="text" name="partner_key_card"
                                        value="<?php echo e(old('partner_key_card', $configs['partner_key_card'])); ?>"
                                        class="form-control <?php $__errorArgs = ['partner_key_card'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Nhập Partner Key">
                                    <?php $__errorArgs = ['partner_key_card'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                        </div>
                        </div> <!-- end card-body -->
                        </div> <!-- end card -->

                        <!-- CÀI ĐẶT USDT -->
                        <div class="card border border-light-subtle shadow-sm mb-4">
                            <div class="card-header bg-light-subtle">
                                <h5 class="card-title mb-0">
                                    <i class="fa-brands fa-usps text-success me-2"></i>Cài đặt nạp USDT <span class="text-muted fw-normal fs-6">(Tự động qua Spay5s)</span>
                                </h5>
                            </div>
                            <div class="card-body pb-0 payment-method-container" data-checkbox="usdt_active" data-container="usdt-container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-4 pb-2 border-bottom">
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" type="checkbox" id="usdt_active" name="usdt_active" value="1" <?php echo e(old('usdt_active', $configs['usdt_active']) ? 'checked' : ''); ?>>
                                                <label class="form-check-label fw-semibold" for="usdt_active">Kích hoạt phương thức nạp USDT</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row usdt-container">
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">API Token (Spay5s) <span class="text-danger">*</span></label>
                                            <input type="text" name="spay5s_token"
                                                value="<?php echo e(old('spay5s_token', $configs['spay5s_token'])); ?>"
                                                class="form-control <?php $__errorArgs = ['spay5s_token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Ví dụ: 39D6670A-1B9A...">
                                            <?php $__errorArgs = ['spay5s_token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            <small class="text-muted">Token lấy từ https://api.spay5s.com</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Tỷ giá quy đổi (1 USDT = ? VND) <span class="text-danger">*</span></label>
                                            <input type="number" name="usdt_rate"
                                                value="<?php echo e(old('usdt_rate', $configs['usdt_rate'])); ?>"
                                                class="form-control <?php $__errorArgs = ['usdt_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Ví dụ: 25000">
                                            <?php $__errorArgs = ['usdt_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Địa chỉ ví USDT (TRC20/BEP20) <span class="text-danger">*</span></label>
                                            <input type="text" name="usdt_wallet_address"
                                                value="<?php echo e(old('usdt_wallet_address', $configs['usdt_wallet_address'])); ?>"
                                                class="form-control <?php $__errorArgs = ['usdt_wallet_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Nhập địa chỉ ví của bạn để nhận tiền...">
                                            <?php $__errorArgs = ['usdt_wallet_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end card-body -->
                        </div> <!-- end card -->

                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary me-2">Lưu thay đổi</button>
                                <a href="<?php echo e(route('admin.index')); ?>" class="btn btn-secondary">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            // Toggle input fields based on payment method status
            function toggleInputFields(checkboxId, containerClass) {
                const isChecked = $('#' + checkboxId).is(':checked');
                $('.' + containerClass + ' input, .' + containerClass + ' select').prop('disabled', !isChecked);
            }

            // Initial state and event handlers
            $('.payment-method-container').each(function() {
                const checkboxId = $(this).data('checkbox');
                const containerClass = $(this).data('container');
                toggleInputFields(checkboxId, containerClass);

                $('#' + checkboxId).on('change', function() {
                    toggleInputFields(checkboxId, containerClass);
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\admin\settings\payment.blade.php ENDPATH**/ ?>