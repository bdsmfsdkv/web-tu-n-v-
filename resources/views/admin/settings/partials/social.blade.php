@if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.settings.social.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Facebook <span class="manitory">*</span></label>
                                    <input type="text" name="facebook"
                                        class="form-control @error('facebook') is-invalid @enderror"
                                        value="{{ old('facebook', $configs['facebook']) }}"
                                        placeholder="https://facebook.com/example">
                                    @error('facebook')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Link Facebook fanpage hoặc trang cá nhân</small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Zalo <span class="manitory">*</span></label>
                                    <input type="text" name="zalo"
                                        class="form-control @error('zalo') is-invalid @enderror"
                                        value="{{ old('zalo', $configs['zalo']) }}" placeholder="Số điện thoại Zalo">
                                    @error('zalo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Số điện thoại đăng ký Zalo</small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">YouTube</label>
                                    <input type="text" name="youtube"
                                        class="form-control @error('youtube') is-invalid @enderror"
                                        value="{{ old('youtube', $configs['youtube']) }}"
                                        placeholder="https://youtube.com/c/example">
                                    @error('youtube')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Kênh YouTube của bạn</small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Discord</label>
                                    <input type="text" name="discord"
                                        class="form-control @error('discord') is-invalid @enderror"
                                        value="{{ old('discord', $configs['discord'] ?? '') }}"
                                        placeholder="https://discord.gg/example">
                                    @error('discord')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Máy chủ Discord của bạn</small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Telegram</label>
                                    <input type="text" name="telegram"
                                        class="form-control @error('telegram') is-invalid @enderror"
                                        value="{{ old('telegram', $configs['telegram'] ?? '') }}"
                                        placeholder="https://t.me/example">
                                    @error('telegram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Kênh hoặc nhóm Telegram của bạn</small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">TikTok</label>
                                    <input type="text" name="tiktok"
                                        class="form-control @error('tiktok') is-invalid @enderror"
                                        value="{{ old('tiktok', $configs['tiktok'] ?? '') }}"
                                        placeholder="https://tiktok.com/@example">
                                    @error('tiktok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Tài khoản TikTok của bạn</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Giờ làm việc</label>
                                    <input type="text" name="working_hours"
                                        class="form-control @error('working_hours') is-invalid @enderror"
                                        value="{{ old('working_hours', $configs['working_hours']) }}"
                                        placeholder="8:00 - 22:00">
                                    @error('working_hours')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Giờ làm việc hỗ trợ khách hàng</small>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3 mt-2 border-top pt-4">
                                    <h5 class="mb-3">Popup thông báo website</h5>
                                    <label class="form-label">Nội dung popup</label>
                                    <textarea name="home_notification" class="form-control @error('home_notification') is-invalid @enderror" rows="5"
                                        placeholder="Ví dụ: KUNCHEAP vừa cập nhật chương trình khuyến mãi mới...">{{ old('home_notification', $configs['home_notification']) }}</textarea>
                                    @error('home_notification')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Bạn có thể sửa nội dung bất cứ lúc nào. Khi nội dung thay đổi, popup mới sẽ được hiển thị lại cho người dùng.</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" id="welcome_modal" name="welcome_modal" value="1" {{ $configs['welcome_modal'] ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="welcome_modal">Bật popup thông báo trên website</label>
                                    </div>
                                    <small class="form-text text-muted d-block mt-2">Tắt công tắc để ẩn popup cho toàn bộ website.</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="welcome_modal_snooze" name="welcome_modal_snooze" value="1" {{ old('welcome_modal_snooze', $configs['welcome_modal_snooze']) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="welcome_modal_snooze">Cho phép người dùng ẩn thông báo theo giờ</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12"><div class="mb-3"><label class="form-label">Số giờ ẩn</label><input type="number" name="welcome_modal_snooze_hours" class="form-control" value="{{ old('welcome_modal_snooze_hours', $configs['welcome_modal_snooze_hours']) }}" min="0.1" max="720" step="0.1" required></div></div>
                            <div class="col-lg-4 col-12"><div class="mb-3"><label class="form-label">Text nút đóng</label><input type="text" name="welcome_modal_close_text" class="form-control" value="{{ old('welcome_modal_close_text', $configs['welcome_modal_close_text']) }}" maxlength="50" required></div></div>
                            <div class="col-lg-4 col-12"><div class="mb-3"><label class="form-label">Text nút ẩn</label><input type="text" name="welcome_modal_snooze_text" class="form-control" value="{{ old('welcome_modal_snooze_text', $configs['welcome_modal_snooze_text']) }}" maxlength="100" required><small class="form-text text-muted">Dùng <code>:hours</code> để hiện số giờ.</small></div></div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary me-2">Lưu thay đổi</button>
                                <a href="{{ route('admin.index') }}" class="btn btn-secondary">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
