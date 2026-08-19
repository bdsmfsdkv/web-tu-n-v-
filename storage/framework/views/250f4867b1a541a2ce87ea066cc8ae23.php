<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
    <div >
        <div >
            <div class="page-header">
                <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0"><?php echo e(isset($notification) ? 'Chỉnh sửa thông báo' : 'Thêm thông báo mới'); ?></h2>
                <p class="text-muted"><?php echo e(isset($notification) ? 'Cập nhật thông tin thông báo' : 'Tạo thông báo mới hiển thị trên trang chủ'); ?>

                    </p>
            </div>
        </div>
    </div>
</div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form
                        action="<?php echo e(isset($notification) ? route('admin.settings.notifications.update', $notification->id) : route('admin.settings.notifications.store')); ?>"
                        method="POST">
                        <?php echo csrf_field(); ?>
                        <?php if(isset($notification)): ?>
                            <?php echo method_field('PUT'); ?>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Biểu tượng <span class="text-danger">*</span></label>
                                    <input type="text" name="class_favicon"
                                        class="form-control <?php $__errorArgs = ['class_favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="icon-selector"
                                        value="<?php echo e(old('class_favicon', $notification->class_favicon ?? '')); ?>"
                                        placeholder="Nhập class biểu tượng, ví dụ: fa-user-circle">
                                    <?php $__errorArgs = ['class_favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">
                                        Nhập class của biểu tượng FontAwesome.
                                        <a href="https://fontawesome.com/v5/search?m=free" target="_blank">
                                            Xem danh sách biểu tượng tại đây
                                        </a>.
                                        <strong>Lưu ý:</strong> Chỉ nhập phần class (ví dụ: fa-shield-alt), không cần nhập
                                        "fas" hoặc "fa".
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Xem trước biểu tượng</label>
                                    <div class="icon-preview"
                                        style="padding: 20px; border: 1px solid #eee; border-radius: 5px; text-align: center; background-color: #f9f9f9;">
                                        <i id="icon-preview"
                                            class="fas <?php echo e(old('class_favicon', $notification->class_favicon ?? '')); ?>"
                                            style="font-size: 3rem; color: #5757f7;"></i>
                                        <div style="margin-top: 10px;">
                                            <code
                                                id="icon-class-display"><?php echo e(old('class_favicon', $notification->class_favicon ?? '')); ?></code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Nội dung thông báo <span class="text-danger">*</span></label>
                                    <textarea name="content" class="form-control <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3"
                                        placeholder="Nhập nội dung thông báo"><?php echo e(old('content', $notification->content ?? '')); ?></textarea>
                                    <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="form-text text-muted">Nội dung thông báo hiển thị trên modal chào mừng
                                        trang chủ</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary me-2">
                                    <?php echo e(isset($notification) ? 'Cập nhật' : 'Thêm thông báo'); ?>

                                </button>
                                <a href="<?php echo e(route('admin.settings.notifications')); ?>" class="btn btn-secondary">Hủy bỏ</a>
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
            // Cập nhật xem trước biểu tượng khi nhập
            $('#icon-selector').on('input', function() {
                let iconClass = $(this).val();
                // Đảm bảo iconClass bắt đầu với "fa-"
                if (iconClass && !iconClass.startsWith('fa-')) {
                    iconClass = 'fa-' + iconClass;
                }
                $('#icon-preview').attr('class', 'fas ' + iconClass);
                $('#icon-class-display').text(iconClass);
            });

            // Hiển thị trước khi load trang
            let initialIcon = $('#icon-selector').val();
            if (initialIcon) {
                $('#icon-preview').attr('class', 'fas ' + initialIcon);
                $('#icon-class-display').text(initialIcon);
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views/admin/settings/notifications-form.blade.php ENDPATH**/ ?>