<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>
    <div >
        <div >
            <div class="page-header">
                <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0">Chỉnh sửa tài khoản ngân hàng</h2>
                <p class="text-muted">Cập nhật thông tin tài khoản ngân hàng</p>
            </div>
        </div>
    </div>
</div>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.bank-accounts.update', $bankAccount->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Tên ngân hàng <span class="text-danger">*</span></label>
                                    <select name="bank_name" class="form-control <?php $__errorArgs = ['bank_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">-- Chọn ngân hàng --</option>
                                        <option value="Vietcombank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'Vietcombank' ? 'selected' : ''); ?>>
                                            Vietcombank</option>
                                        <option value="VietinBank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'VietinBank' ? 'selected' : ''); ?>>
                                            VietinBank</option>
                                        <option value="BIDV"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'BIDV' ? 'selected' : ''); ?>>BIDV
                                        </option>
                                        <option value="Techcombank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'Techcombank' ? 'selected' : ''); ?>>
                                            Techcombank</option>
                                        <option value="Sacombank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'Sacombank' ? 'selected' : ''); ?>>
                                            Sacombank</option>
                                        <option value="MBBank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'MBBank' ? 'selected' : ''); ?>>
                                            MBBank</option>
                                        <option value="ACB"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'ACB' ? 'selected' : ''); ?>>ACB
                                        </option>
                                        <option value="VPBank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'VPBank' ? 'selected' : ''); ?>>
                                            VPBank</option>
                                        <option value="Agribank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'Agribank' ? 'selected' : ''); ?>>
                                            Agribank</option>
                                        <option value="TPBank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'TPBank' ? 'selected' : ''); ?>>
                                            TPBank</option>
                                        <option value="HDBank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'HDBank' ? 'selected' : ''); ?>>
                                            HDBank</option>
                                        <option value="VIB"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'VIB' ? 'selected' : ''); ?>>VIB
                                        </option>
                                        <option value="MSB"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'MSB' ? 'selected' : ''); ?>>MSB
                                        </option>
                                        <option value="OCB"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'OCB' ? 'selected' : ''); ?>>OCB
                                        </option>
                                        <option value="Eximbank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'Eximbank' ? 'selected' : ''); ?>>
                                            Eximbank</option>
                                        <option value="SHB"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'SHB' ? 'selected' : ''); ?>>SHB
                                        </option>
                                        <option value="SeABank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'SeABank' ? 'selected' : ''); ?>>
                                            SeABank</option>
                                        <option value="NamABank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'NamABank' ? 'selected' : ''); ?>>
                                            NamABank</option>
                                        <option value="KienLongBank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'KienLongBank' ? 'selected' : ''); ?>>
                                            KienLongBank</option>
                                        <option value="PGBank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'PGBank' ? 'selected' : ''); ?>>
                                            PGBank</option>
                                        <option value="ABBank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'ABBank' ? 'selected' : ''); ?>>
                                            ABBank</option>
                                        <option value="LPBank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'LPBank' ? 'selected' : ''); ?>>
                                            LPBank</option>
                                        <option value="VietABank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'VietABank' ? 'selected' : ''); ?>>
                                            VietABank</option>
                                        <option value="VIETBANK"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'VIETBANK' ? 'selected' : ''); ?>>
                                            VIETBANK</option>
                                        <option value="BACABANK"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'BACABANK' ? 'selected' : ''); ?>>
                                            BACABANK</option>
                                        <option value="BVBank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'BVBank' ? 'selected' : ''); ?>>
                                            BVBank</option>
                                        <option value="NHQUOCDAN"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'NHQUOCDAN' ? 'selected' : ''); ?>>
                                            Ngân hàng Quốc Dân</option>
                                        <option value="PBVN"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'PBVN' ? 'selected' : ''); ?>>
                                            Public Bank Vietnam</option>
                                        <option value="ShinhanBank"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'ShinhanBank' ? 'selected' : ''); ?>>
                                            Shinhan Bank</option>
                                        <option value="WOORIVN"
                                            <?php echo e(old('bank_name', $bankAccount->bank_name) == 'WOORIVN' ? 'selected' : ''); ?>>
                                            Woori Bank Vietnam</option>
                                    </select>
                                    <?php $__errorArgs = ['bank_name'];
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
                                    <label class="form-label">Số tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="account_number"
                                        value="<?php echo e(old('account_number', $bankAccount->account_number)); ?>"
                                        class="form-control <?php $__errorArgs = ['account_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Nhập số tài khoản">
                                    <?php $__errorArgs = ['account_number'];
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
                                    <label class="form-label">Chi nhánh</label>
                                    <input type="text" name="branch" value="<?php echo e(old('branch', $bankAccount->branch)); ?>"
                                        class="form-control" placeholder="Nhập chi nhánh ngân hàng">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Cú pháp nạp tiền <span class="text-danger">*</span></label>
                                    <input type="text" name="prefix" value="<?php echo e(old('prefix', $bankAccount->prefix)); ?>"
                                        class="form-control <?php $__errorArgs = ['prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Nhập cú pháp nạp tiền (ví dụ: naptien)">
                                    <?php $__errorArgs = ['prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">Cú pháp nạp tiền sẽ được dùng để tự động xác định
                                        người dùng trong nội dung chuyển khoản. Ví dụ: naptien123 với 123 là ID người
                                        dùng.</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Ghi chú</label>
                                    <textarea class="form-control" name="note" placeholder="Nhập ghi chú (nếu có)"><?php echo e(old('note', $bankAccount->note)); ?></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Access Token</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['access_token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="access_token" placeholder="Nhập Access Token từ spay5s.com"
                                        value="<?php echo e(old('access_token', $bankAccount->access_token)); ?>">
                                    <?php $__errorArgs = ['access_token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">Token này được cung cấp bởi spay5s.com để kết nối API tự động cộng tiền.</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh đại diện (Logo hoặc QR Code)</label>
                                    <div class="image-upload">
                                        <input type="file" name="image" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <div class="image-uploads mt-2">
                                            <img src="<?php echo e(asset('assets/img/icons/upload.svg')); ?>" alt="img">
                                            <h4>Kéo thả hoặc click để tải ảnh lên</h4>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php if($bankAccount->image): ?>
                                        <div class="mt-3">
                                            <p>Ảnh hiện tại:</p>
                                            <img src="<?php echo e(asset($bankAccount->image)); ?>" alt="Current Image" style="max-height: 100px; border-radius: 8px; border: 1px solid #ddd;">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                            <?php echo e(old('is_active', $bankAccount->is_active) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="is_active">Kích hoạt tài khoản</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="auto_confirm"
                                            id="auto_confirm"
                                            <?php echo e(old('auto_confirm', $bankAccount->auto_confirm) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="auto_confirm">Tự động xác nhận và cộng
                                            tiền</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                                <a href="<?php echo e(route('admin.bank-accounts.index')); ?>" class="btn btn-secondary">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\admin\bank-accounts\edit.blade.php ENDPATH**/ ?>