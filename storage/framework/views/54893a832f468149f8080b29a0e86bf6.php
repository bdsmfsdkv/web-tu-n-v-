<div class="card">
                <div class="card-body">
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


                    <form method="POST" action="<?php echo e(route('admin.settings.login.update')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Google Login</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="google_client_id">Client ID</label>
                                            <input id="google_client_id" name="google_client_id" type="text"
                                                class="form-control <?php $__errorArgs = ['google_client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                value="<?php echo e(old('google_client_id', $configs['google_client_id'])); ?>">
                                            <?php $__errorArgs = ['google_client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="google_client_secret">Client Secret</label>
                                            <input id="google_client_secret" name="google_client_secret" type="text"
                                                class="form-control <?php $__errorArgs = ['google_client_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                value="<?php echo e(old('google_client_secret', $configs['google_client_secret'])); ?>">
                                            <?php $__errorArgs = ['google_client_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="google_redirect">Redirect URL</label>
                                            <input id="google_redirect" name="google_redirect" type="text"
                                                class="form-control <?php $__errorArgs = ['google_redirect'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                value="<?php echo e(old('google_redirect', $configs['google_redirect'])); ?>">
                                            <?php $__errorArgs = ['google_redirect'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" type="checkbox" id="google_active" name="google_active" value="1" <?php echo e(old('google_active', $configs['google_active']) ? 'checked' : ''); ?>>
                                                <label class="form-check-label fw-semibold" for="google_active">Kích hoạt đăng nhập Google</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top pt-3 mt-3">
                                    <div class="mb-3">
                                        <label class="text-secondary">Hướng dẫn cấu hình</label>
                                        <ol class="text-secondary">
                                            <li>Truy cập <a href="https://console.cloud.google.com/apis/credentials"
                                                    target="_blank">Google Cloud Console</a></li>
                                            <li>Tạo dự án mới hoặc chọn dự án hiện có</li>
                                            <li>Tạo OAuth consent screen</li>
                                            <li>Tạo OAuth Client ID cho Web application</li>
                                            <li>Thêm Redirect URL: <code><?php echo e(url(route('callback.google'))); ?></code></li>
                                            <li>Sao chép Client ID và Client Secret vào form này</li>
                                        </ol>
                                        <hr>
                                        <label class="text-secondary">Hoặc xem hướng dẫn: <a href="//"
                                                target="_blank">Cách
                                                cấu hình đăng nhập Google</a></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4 border border-light-subtle shadow-sm">
                            <div class="card-header bg-light-subtle">
                                <h5 class="card-title mb-0 d-flex align-items-center">
                                    <i class="ti ti-brand-facebook text-primary fs-3 me-2"></i> Facebook Login
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="facebook_client_id">App ID</label>  
                                            <input id="facebook_client_id" name="facebook_client_id" type="text"
                                                class="form-control <?php $__errorArgs = ['facebook_client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                value="<?php echo e(old('facebook_client_id', $configs['facebook_client_id'])); ?>">
                                            <?php $__errorArgs = ['facebook_client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="facebook_client_secret">App Secret</label>
                                            <input id="facebook_client_secret" name="facebook_client_secret" type="text"
                                                class="form-control <?php $__errorArgs = ['facebook_client_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                value="<?php echo e(old('facebook_client_secret', $configs['facebook_client_secret'])); ?>">
                                            <?php $__errorArgs = ['facebook_client_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="facebook_redirect">Redirect URL</label>
                                            <input id="facebook_redirect" name="facebook_redirect" type="text"
                                                class="form-control <?php $__errorArgs = ['facebook_redirect'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                value="<?php echo e(old('facebook_redirect', $configs['facebook_redirect'])); ?>">
                                            <?php $__errorArgs = ['facebook_redirect'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" type="checkbox" id="facebook_active" name="facebook_active" value="1" <?php echo e(old('facebook_active', $configs['facebook_active']) ? 'checked' : ''); ?>>
                                                <label class="form-check-label fw-semibold" for="facebook_active">Kích hoạt đăng nhập Facebook</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top pt-3 mt-3">
                                    <div class="mb-3">
                                        <label class="text-secondary">Hướng dẫn cấu hình</label>
                                        <ol class="text-secondary">
                                            <li>Truy cập <a href="https://developers.facebook.com/apps"
                                                    target="_blank">Facebook Developers</a></li>
                                            <li>Tạo ứng dụng mới hoặc chọn ứng dụng hiện có</li>
                                            <li>Thêm sản phẩm Facebook Login</li>
                                            <li>Cấu hình OAuth redirect URI:
                                                <code><?php echo e(url(route('callback.facebook'))); ?></code>
                                            </li>
                                            <li>Sao chép App ID và App Secret vào form này</li>
                                        </ol>
                                        <hr>
                                        <label class="text-secondary">Hoặc xem hướng dẫn: <a href="//"
                                                target="_blank">Cách
                                                cấu hình đăng nhập Facebook</a></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary me-2">Cập nhật cấu hình</button>
                        </div>
                    </form>
                </div>
            </div><?php /**PATH C:\xampp\htdocs\resources\views/admin/settings/partials/login.blade.php ENDPATH**/ ?>