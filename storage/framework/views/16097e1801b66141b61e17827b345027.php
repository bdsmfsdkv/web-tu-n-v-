<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
    <div >
        <div >
            <div class="page-header">
                <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0">Chỉnh sửa danh mục mẹ</h2>
                <p class="text-muted">Cập nhật thông tin danh mục mẹ (Game Group)</p>
            </div>
        </div>
    </div>
</div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.game-groups.update', $gameGroup->id)); ?>" method="POST"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Tên danh mục mẹ <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="<?php echo e(old('name', $gameGroup->name)); ?>"
                                        class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Nhập tên danh mục mẹ">
                                    <?php $__errorArgs = ['name'];
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
                                    <label class="form-label">Đường dẫn liên kết (Link)</label>
                                    <input type="text" name="link" value="<?php echo e(old('link', $gameGroup->link)); ?>"
                                        class="form-control <?php $__errorArgs = ['link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="VD: /danh-muc-lien-quan">
                                    <?php $__errorArgs = ['link'];
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
                                    <label class="form-label">Slug</label>
                                    <input type="text" name="slug" value="<?php echo e(old('slug', $gameGroup->slug)); ?>"
                                        class="form-control" readonly>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Thứ tự hiển thị (Order)</label>
                                    <input type="number" name="order" value="<?php echo e(old('order', $gameGroup->order)); ?>"
                                        class="form-control <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="VD: 1">
                                    <?php $__errorArgs = ['order'];
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
                                <div class="mb-3">
                                    <label class="form-label">Ảnh đại diện (Thumbnail)</label>
                                    <div class="image-upload" style="position: relative; border: 1px dashed #4680ff; background: rgba(70, 128, 255, 0.05); padding: 20px; border-radius: 8px; text-align: center;">
                                        <input type="file" name="thumbnail" class="form-control <?php $__errorArgs = ['thumbnail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" onchange="previewImage(this, 'preview-gg-edit-thumb')">
                                        <div class="image-uploads mt-2">
                                            <?php if($gameGroup->thumbnail): ?>
                                                <img id="preview-gg-edit-thumb" src="<?php echo e(asset($gameGroup->thumbnail)); ?>" alt="img" style="max-height: 80px; object-fit: contain; margin-bottom: 10px; border-radius: 4px;">
                                                <h5 class="mb-0 fw-semibold">Đổi ảnh đại diện (Kéo thả hoặc click)</h5>
                                            <?php else: ?>
                                                <img id="preview-gg-edit-thumb" src="" alt="Preview" style="max-height: 80px; display:none; object-fit: contain; margin-bottom: 10px; border-radius: 4px;">
                                                <i class="ti ti-cloud-upload text-primary" style="font-size: 40px;"></i>
                                                <h5 class="mt-2 mb-0 fw-semibold">Kéo thả hoặc click để tải ảnh lên</h5>
                                            <?php endif; ?>
                                            <p class="text-muted small mt-1">Hỗ trợ JPG, PNG, GIF, WEBP</p>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['thumbnail'];
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

                            <div class="col-lg-12 d-flex align-items-center">
                                <div class="mb-3">
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="active" id="active" value="1" <?php echo e(old('active', $gameGroup->active) ? 'checked' : ''); ?>>
                                        <label class="form-check-label fw-semibold" for="active">Kích hoạt hiển thị</label>
                                    </div>
                                    <?php $__errorArgs = ['active'];
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
                                <a href="<?php echo e(route('admin.game-groups.index')); ?>" class="btn btn-secondary">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views\admin\game-groups\edit.blade.php ENDPATH**/ ?>