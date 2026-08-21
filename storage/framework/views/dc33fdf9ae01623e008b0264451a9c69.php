<?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.settings.terms.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Điều khoản sử dụng</label>
                                    <textarea id="terms_of_use" name="terms_of_use" class="form-control editor <?php $__errorArgs = ['terms_of_use'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="10"
                                        placeholder="Nhập nội dung điều khoản sử dụng..."><?php echo e(old('terms_of_use', $configs['terms_of_use'])); ?></textarea>
                                    <?php $__errorArgs = ['terms_of_use'];
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
                                    <label class="form-label">Chính sách bảo mật</label>
                                    <textarea id="privacy_policy" name="privacy_policy" class="form-control editor <?php $__errorArgs = ['privacy_policy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="10"
                                        placeholder="Nhập nội dung chính sách bảo mật..."><?php echo e(old('privacy_policy', $configs['privacy_policy'])); ?></textarea>
                                    <?php $__errorArgs = ['privacy_policy'];
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
                                <button type="submit" class="btn btn-primary me-2">Lưu thay đổi</button>
                                <a href="<?php echo e(route('admin.index')); ?>" class="btn btn-secondary">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let termsEditor;
            let privacyEditor;
            
            if (document.querySelector('#terms_of_use')) {
                ClassicEditor
                    .create(document.querySelector('#terms_of_use'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'insertTable', 'blockQuote', 'undo', 'redo']
                    })
                    .then(editor => {
                        termsEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
            
            if (document.querySelector('#privacy_policy')) {
                ClassicEditor
                    .create(document.querySelector('#privacy_policy'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'insertTable', 'blockQuote', 'undo', 'redo']
                    })
                    .then(editor => {
                        privacyEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            document.querySelector('form').addEventListener('submit', function(e) {
                if (termsEditor) {
                    document.querySelector('#terms_of_use').value = termsEditor.getData();
                }
                if (privacyEditor) {
                    document.querySelector('#privacy_policy').value = privacyEditor.getData();
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\resources\views\admin\settings\partials\terms.blade.php ENDPATH**/ ?>