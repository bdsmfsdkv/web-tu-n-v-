<div class="row">
                <!-- Notification -->
                <div class="card-body p-2">
                    <div class="alert alert-notication-custom alert-dismissible fade show" role="alert">
                        <strong>Xem video hướng dẫn cấu hình khi sử dụng gmail.com để gửi mail tại <a
                                href="https://youtu.be/3Daci3bR4pM">ĐÂY</a></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-light-subtle">
                            <h5 class="card-title mb-0 d-flex align-items-center">
                                <i class="ti ti-mail text-primary fs-3 me-2"></i> Cấu hình máy chủ email
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.settings.email.update')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Máy chủ gửi mail (Mailer) <span class="text-danger">*</span></label>
                                            <select name="mail_mailer"
                                                class="form-select <?php $__errorArgs = ['mail_mailer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <option value="smtp"
                                                    <?php echo e(old('mail_mailer', $configs['mail_mailer']) == 'smtp' ? 'selected' : ''); ?>>
                                                    SMTP</option>
                                                <option value="sendmail"
                                                    <?php echo e(old('mail_mailer', $configs['mail_mailer']) == 'sendmail' ? 'selected' : ''); ?>>
                                                    Sendmail</option>
                                                <option value="mailgun"
                                                    <?php echo e(old('mail_mailer', $configs['mail_mailer']) == 'mailgun' ? 'selected' : ''); ?>>
                                                    Mailgun</option>
                                                <option value="ses"
                                                    <?php echo e(old('mail_mailer', $configs['mail_mailer']) == 'ses' ? 'selected' : ''); ?>>
                                                    Amazon SES</option>
                                                <option value="postmark"
                                                    <?php echo e(old('mail_mailer', $configs['mail_mailer']) == 'postmark' ? 'selected' : ''); ?>>
                                                    Postmark</option>
                                            </select>
                                            <?php $__errorArgs = ['mail_mailer'];
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
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Mail Host <span class="text-danger">*</span></label>
                                            <input type="text" name="mail_host"
                                                value="<?php echo e(old('mail_host', $configs['mail_host'])); ?>"
                                                class="form-control <?php $__errorArgs = ['mail_host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="smtp.gmail.com">
                                            <?php $__errorArgs = ['mail_host'];
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
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Mail Port <span class="text-danger">*</span></label>
                                            <input type="text" name="mail_port"
                                                value="<?php echo e(old('mail_port', $configs['mail_port'])); ?>"
                                                class="form-control <?php $__errorArgs = ['mail_port'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="587">
                                            <?php $__errorArgs = ['mail_port'];
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
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Mail Encryption <span class="text-danger">*</span></label>
                                            <select name="mail_encryption"
                                                class="form-select <?php $__errorArgs = ['mail_encryption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <option value="tls"
                                                    <?php echo e(old('mail_encryption', $configs['mail_encryption']) == 'tls' ? 'selected' : ''); ?>>
                                                    TLS</option>
                                                <option value="ssl"
                                                    <?php echo e(old('mail_encryption', $configs['mail_encryption']) == 'ssl' ? 'selected' : ''); ?>>
                                                    SSL</option>
                                                <option value="null"
                                                    <?php echo e(old('mail_encryption', $configs['mail_encryption']) == 'null' ? 'selected' : ''); ?>>
                                                    None</option>
                                            </select>
                                            <?php $__errorArgs = ['mail_encryption'];
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
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Mail Username <span class="text-danger">*</span></label>
                                            <input type="text" name="mail_username"
                                                value="<?php echo e(old('mail_username', $configs['mail_username'])); ?>"
                                                class="form-control <?php $__errorArgs = ['mail_username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="example@gmail.com">
                                            <?php $__errorArgs = ['mail_username'];
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
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Mail Password <span class="text-danger">*</span></label>
                                            <div class="pass-group">
                                                <input type="password" name="mail_password"
                                                    value="<?php echo e(old('mail_password', $configs['mail_password'])); ?>"
                                                    class="form-control pass-input <?php $__errorArgs = ['mail_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    placeholder="Nhập mật khẩu email">
                                                <span class="fas toggle-password fa-eye-slash"></span>
                                                <?php $__errorArgs = ['mail_password'];
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
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Mail From Address <span class="text-danger">*</span></label>
                                            <input type="text" name="mail_from_address"
                                                value="<?php echo e(old('mail_from_address', $configs['mail_from_address'])); ?>"
                                                class="form-control <?php $__errorArgs = ['mail_from_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="noreply@example.com">
                                            <?php $__errorArgs = ['mail_from_address'];
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
                                            <label class="form-label">Mail From Name <span class="text-danger">*</span></label>
                                            <input type="text" name="mail_from_name"
                                                value="<?php echo e(old('mail_from_name', $configs['mail_from_name'])); ?>"
                                                class="form-control <?php $__errorArgs = ['mail_from_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Shop Game Ngọc Rồng">
                                            <?php $__errorArgs = ['mail_from_name'];
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
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Kiểm tra cấu hình email</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.settings.email.test')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ email nhận thử nghiệm <span class="text-danger">*</span></label>
                                    <input type="email" name="test_email"
                                        class="form-control <?php $__errorArgs = ['test_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Nhập email để gửi thử" required>
                                    <small class="form-text text-muted">
                                        Nhập địa chỉ email để nhận thư kiểm tra. Email sẽ được gửi với cấu hình hiện tại.
                                    </small>
                                    <?php $__errorArgs = ['test_email'];
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
                                <div class="mb-3 mb-0">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-1"></i> Gửi email kiểm tra
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title">Mẹo sử dụng Gmail</h5>
                        </div>
                        <div class="card-body">
                            <p>Nếu bạn sử dụng Gmail để gửi email:</p>
                            <ol class="mt-2">
                                <li class="mb-2">Đảm bảo sử dụng các cấu hình sau:
                                    <ul class="mt-1">
                                        <li><strong>Mail Host:</strong> smtp.gmail.com</li>
                                        <li><strong>Mail Port:</strong> 587</li>
                                        <li><strong>Mail Encryption:</strong> tls</li>
                                        <li><strong>Mail Username:</strong> email gmail của bạn</li>
                                        <li><strong>Mail Password:</strong> mật khẩu ứng dụng (không phải mật khẩu Gmail)
                                        </li>
                                    </ul>
                                </li>
                                <li class="mb-2">Bạn cần <a href="https://myaccount.google.com/security"
                                        target="_blank">tạo mật khẩu ứng dụng</a> cho Gmail:
                                    <ul class="mt-1">
                                        <li>Bật xác minh 2 bước trong tài khoản Google</li>
                                        <li>Vào "Bảo mật" > "Đăng nhập vào Google" > "Mật khẩu ứng dụng"</li>
                                        <li>Tạo mật khẩu mới với tên "Laravel Mail"</li>
                                        <li>Sử dụng mật khẩu được tạo làm Mail Password</li>
                                    </ul>
                                </li>

                            </ol>
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle me-2"></i> Lỗi "Connection could not be established" thường do
                                cấu hình host/port không chính xác hoặc bị chặn bởi tường lửa.
                            </div>
                        </div>
                    </div>
                </div>
            </div><?php /**PATH C:\xampp\htdocs\resources\views\admin\settings\partials\email.blade.php ENDPATH**/ ?>