<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
    <div >
        <div >
            <div class="page-header">
                <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0">Chỉnh sửa tài khoản game</h2>
                <p class="text-muted">Cập nhật thông tin tài khoản game</p>
            </div>
        </div>
    </div>
</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.accounts.update', $account->id)); ?>" method="POST"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <?php if($account->status == 'sold' && $account->buyer_id): ?>
                            <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                                <i class="ti ti-alert-circle me-2 fs-4"></i>
                                <div>
                                    Tài khoản này đã được bán cho khách hàng: 
                                    <a href="<?php echo e(route('admin.users.show', $account->buyer_id)); ?>" target="_blank" class="fw-bold text-dark text-decoration-underline"><?php echo e(optional($account->buyer)->username ?? 'Không rõ'); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Danh mục game <span class="text-danger">*</span></label>
                                    <select name="game_category_id"
                                        class="form-select <?php $__errorArgs = ['game_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">-- Chọn danh mục --</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"
                                                <?php echo e(old('game_category_id', $account->game_category_id) == $category->id ? 'selected' : ''); ?>>
                                                <?php echo e($category->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['game_category_id'];
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
                                    <label class="form-label">Tên tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="account_name"
                                        value="<?php echo e(old('account_name', $account->account_name)); ?>"
                                        class="form-control <?php $__errorArgs = ['account_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Nhập tên đăng nhập">
                                    <?php $__errorArgs = ['account_name'];
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
                                    <label class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="text" name="password" value="<?php echo e(old('password', $account->password)); ?>"
                                        class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Nhập mật khẩu">
                                    <?php $__errorArgs = ['password'];
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
                                    <label class="form-label">Giá tiền <span class="text-danger">*</span></label>
                                    <input type="number" name="price" value="<?php echo e(old('price', $account->price)); ?>"
                                        class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="VD: 50000">
                                    <?php $__errorArgs = ['price'];
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
                                    <input class="form-check-input" type="checkbox" name="status" id="status" value="available" <?php echo e(old('status', $account->status) == 'available' ? 'checked' : ''); ?>>
                                    <label class="form-check-label fw-semibold" for="status">Đang mở bán (Bỏ chọn để đánh dấu Đã bán)</label>
                                </div>
                                <?php $__errorArgs = ['status'];
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
                                <hr class="my-4">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <h6 class="mb-1 fw-bold">Thuộc tính đa dạng (Liên Quân, FF, Valorant...)</h6>
                                            <p class="text-muted mb-0 small">Thêm các thuộc tính như Rank, Tướng, Trang phục,...</p>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="add-attribute">
                                            <i class="ti ti-plus me-1"></i> Thêm thuộc tính
                                        </button>
                                    </div>
                                    <div id="dynamic-attributes" class="bg-light p-3 rounded border">
                                        <?php
                                            $details = old('details', is_array($account->details) ? $account->details : json_decode($account->details, true) ?? []);
                                        ?>
                                        <?php if(is_array($details) && count($details) > 0): ?>
                                            <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="row align-items-center mb-2 attribute-row">
                                                    <div class="col-5">
                                                        <input type="text" name="details[<?php echo e($index); ?>][key]" class="form-control" value="<?php echo e($detail['key'] ?? ''); ?>" placeholder="Tên thuộc tính (VD: Rank)" required>
                                                    </div>
                                                    <div class="col-5">
                                                        <input type="text" name="details[<?php echo e($index); ?>][value]" class="form-control" value="<?php echo e($detail['value'] ?? ''); ?>" placeholder="Giá trị (VD: Kim Cương)" required>
                                                    </div>
                                                    <div class="col-2 text-end">
                                                        <button type="button" class="btn btn-danger btn-sm remove-attribute"><i class="ti ti-trash"></i> Xóa</button>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 mt-2 mb-3">
                                <h6 class="fw-bold border-bottom pb-2">Hình ảnh</h6>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh đại diện <span class="text-danger">*</span></label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #4680ff; background: rgba(70, 128, 255, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="thumb" class="form-control <?php $__errorArgs = ['thumb'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                                        <div class="image-uploads mt-2">
                                            <?php if($account->thumb): ?>
                                                <img src="<?php echo e(asset($account->thumb)); ?>" alt="img" style="max-height: 80px; object-fit: contain; margin-bottom: 10px; border-radius: 4px;">
                                                <h5 class="mb-0 fw-semibold">Đổi ảnh đại diện (Kéo thả hoặc click)</h5>
                                            <?php else: ?>
                                                <i class="ti ti-photo-plus text-primary" style="font-size: 40px;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold">Kéo thả hoặc click để tải ảnh lên</h5>
                                            <?php endif; ?>
                                            <p class="text-muted small mt-1">Hỗ trợ JPG, PNG, GIF</p>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['thumb'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Ảnh chi tiết (Nhiều ảnh)</label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #20c997; background: rgba(32, 201, 151, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="images[]" multiple class="form-control <?php $__errorArgs = ['images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                                        <div class="image-uploads mt-2">
                                            <i class="ti ti-photos text-success" style="font-size: 40px;"></i>
                                            <h5 class="mt-2 mb-0 fw-semibold text-success">Kéo thả hoặc click để tải lên nhiều ảnh</h5>
                                            <p class="text-muted small">Hỗ trợ tải lên nhiều file cùng lúc. Sẽ thay thế các ảnh cũ (nếu có).</p>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    
                                    <?php if($account->images): ?>
                                        <div class="mt-3 bg-light p-3 rounded">
                                            <label class="form-label fw-semibold text-muted d-block mb-2">Các ảnh chi tiết hiện tại:</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php $__currentLoopData = json_decode($account->images); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="border rounded p-1 bg-white">
                                                        <img src="<?php echo e(asset($image)); ?>" alt="preview" style="height: 80px; width: auto; object-fit: contain;">
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Ghi chú (Tùy chọn)</label>
                                    <textarea name="note" class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="4" placeholder="Ghi chú chi tiết về tài khoản này..."><?php echo e(old('note', $account->note)); ?></textarea>
                                    <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <button type="submit" class="btn btn-primary me-2">Cập nhật</button>
                                <a href="<?php echo e(route('admin.accounts.index')); ?>" class="btn btn-secondary">Hủy bỏ</a>
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
            let attrIndex = <?php echo e(isset($details) && is_array($details) ? count($details) : 0); ?>;
            $('#add-attribute').click(function() {
                $('#dynamic-attributes').append(`
                    <div class="row align-items-center mb-2 attribute-row">
                        <div class="col-5">
                            <input type="text" name="details[${attrIndex}][key]" class="form-control" placeholder="Tên thuộc tính (VD: Rank)" required>
                        </div>
                        <div class="col-5">
                            <input type="text" name="details[${attrIndex}][value]" class="form-control" placeholder="Giá trị (VD: Kim Cương)" required>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-danger btn-sm remove-attribute">Xóa</button>
                        </div>
                    </div>
                `);
                attrIndex++;
            });

            $(document).on('click', '.remove-attribute', function() {
                $(this).closest('.attribute-row').remove();
            });
        });

        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewMultipleImages(input, previewId) {
            var preview = document.getElementById(previewId);
            preview.innerHTML = '';
            if (input.files) {
                Array.from(input.files).forEach(file => {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '200px';
                        img.style.maxHeight = '200px';
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views/admin/accounts/edit.blade.php ENDPATH**/ ?>