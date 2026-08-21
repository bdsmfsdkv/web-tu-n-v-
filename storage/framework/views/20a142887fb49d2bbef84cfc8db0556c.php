<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
    <div >
        <div >
            <div class="page-header">
                <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0">Thêm Mã Giảm Giá</h2>
                <p class="text-muted">Tạo mã giảm giá mới</p>
            </div>
        </div>
    </div>
</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.discount-codes.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Mã giảm giá <span class="text-danger">*</span></label>
                                    <input type="text" name="code" value="<?php echo e(old('code')); ?>"
                                        class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Để trống để tạo mã tự động">
                                    <?php $__errorArgs = ['code'];
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
                                    <label class="form-label">Kiểu giảm giá <span class="text-danger">*</span></label>
                                    <select name="type" class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="discountType">
                                        <option value="percentage" <?php echo e(old('type') == 'percentage' ? 'selected' : ''); ?>>Phần
                                            trăm (%)</option>
                                        <option value="fixed_amount" <?php echo e(old('type') == 'fixed_amount' ? 'selected' : ''); ?>>
                                            Số tiền cố
                                            định (VNĐ)</option>
                                    </select>
                                    <?php $__errorArgs = ['type'];
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
                                    <label class="form-label">Giá trị <span class="text-danger">*</span></label>
                                    <input type="number" name="value" value="<?php echo e(old('value')); ?>"
                                        class="form-control <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Nhập giá trị giảm">
                                    <?php $__errorArgs = ['value'];
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
                            <div class="col-lg-6 col-sm-6 col-12" id="maxDiscountGroup">
                                <div class="mb-3">
                                    <label class="form-label">Giảm tối đa (VNĐ) <span class="text-muted">(0 = Không giới hạn)</span></label>
                                    <input type="number" name="max_discount" value="<?php echo e(old('max_discount', 0)); ?>"
                                        class="form-control <?php $__errorArgs = ['max_discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Nhập số tiền tối đa">
                                    <?php $__errorArgs = ['max_discount'];
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
                            
                            <div class="col-12 mt-2 mb-3">
                                <h6 class="fw-bold border-bottom pb-2">Điều kiện áp dụng</h6>
                            </div>
                            
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Số tiền mua tối thiểu (VNĐ)</label>
                                    <input type="number" name="min_purchase_amount"
                                        value="<?php echo e(old('min_purchase_amount', 0)); ?>"
                                        class="form-control <?php $__errorArgs = ['min_purchase_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="VD: 50000">
                                    <?php $__errorArgs = ['min_purchase_amount'];
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
                                    <label class="form-label">Áp dụng cho <span class="text-danger">*</span></label>
                                    <select name="applicable_to"
                                        class="form-select <?php $__errorArgs = ['applicable_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">Tất cả danh mục</option>
                                        <option value="account" <?php echo e(old('applicable_to') == 'account' ? 'selected' : ''); ?>>
                                            Chỉ Tài khoản</option>
                                        <option value="random_account"
                                            <?php echo e(old('applicable_to') == 'random_account' ? 'selected' : ''); ?>>Chỉ Random tài
                                            khoản</option>
                                        <option value="service" <?php echo e(old('applicable_to') == 'service' ? 'selected' : ''); ?>>
                                            Chỉ Dịch vụ</option>
                                    </select>
                                    <?php $__errorArgs = ['applicable_to'];
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
                                    <label class="form-label">Lượt sử dụng tối đa <span class="text-muted">(Để trống = Không giới hạn)</span></label>
                                    <input type="number" name="usage_limit" value="<?php echo e(old('usage_limit')); ?>"
                                        class="form-control <?php $__errorArgs = ['usage_limit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Nhập tổng số lần dùng">
                                    <?php $__errorArgs = ['usage_limit'];
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
                                    <label class="form-label">Giới hạn mỗi người <span class="text-muted">(Để trống = Không giới hạn)</span></label>
                                    <input type="number" name="per_user_limit" value="<?php echo e(old('per_user_limit')); ?>"
                                        class="form-control <?php $__errorArgs = ['per_user_limit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Số lần một user được dùng">
                                    <?php $__errorArgs = ['per_user_limit'];
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
                                    <label class="form-label">Ngày hết hạn <span class="text-muted">(Để trống = Không hết hạn)</span></label>
                                    <input type="date" name="expires_at" value="<?php echo e(old('expires_at')); ?>"
                                        class="form-control <?php $__errorArgs = ['expires_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <?php $__errorArgs = ['expires_at'];
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
                            <div class="col-lg-12 d-flex align-items-center mb-3">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" <?php echo e(old('is_active', '1') == '1' ? 'checked' : ''); ?>>
                                    <label class="form-check-label fw-semibold" for="is_active">Hoạt động (Kích hoạt mã)</label>
                                </div>
                                <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block ms-3"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Mô tả</label>
                                    <textarea name="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description')); ?></textarea>
                                    <?php $__errorArgs = ['description'];
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
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary me-2">Tạo mã giảm giá</button>
                                <a href="<?php echo e(route('admin.discount-codes.index')); ?>" class="btn btn-secondary">Hủy</a>
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
        document.addEventListener('DOMContentLoaded', function() {
            const discountType = document.getElementById('discountType');
            const valueInput = document.querySelector('input[name="value"]');
            const maxDiscountGroup = document.getElementById('maxDiscountGroup');

            // Initial state
            updateValueLabel();
            updateMaxDiscountVisibility();

            // Event listener
            discountType.addEventListener('change', function() {
                updateValueLabel();
                updateMaxDiscountVisibility();
            });

            function updateValueLabel() {
                const label = valueInput.closest('.form-group').querySelector('label');
                if (discountType.value === 'percentage') {
                    label.innerHTML = 'Giá trị (%) <span class="text-danger">*</span>';
                } else {
                    label.innerHTML = 'Giá trị (VNĐ) <span class="text-danger">*</span>';
                }
            }

            function updateMaxDiscountVisibility() {
                if (discountType.value === 'percentage') {
                    maxDiscountGroup.style.display = 'block';
                } else {
                    maxDiscountGroup.style.display = 'none';
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\admin\discount-codes\create.blade.php ENDPATH**/ ?>