@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div >
        <div >
            <div class="page-header">
                <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0">Cài đặt mạng xã hội</h2>
                <p class="text-muted">Quản lý liên kết mạng xã hội của website</p>
            </div>
        </div>
    </div>
</div>
            </div>

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
                                <div class="mb-3">
                                    <label class="form-label">Thông báo trang chủ</label>
                                    <textarea name="home_notification" class="form-control @error('home_notification') is-invalid @enderror" rows="3"
                                        placeholder="Thông báo hiển thị ở trang chủ">{{ old('home_notification', $configs['home_notification']) }}</textarea>
                                    @error('home_notification')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Thông báo này sẽ hiển thị ở trang chủ
                                        website</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-4 mt-3 border-top pt-4">
                                    <h5 class="mb-3">Cài đặt Modal Chào Mừng</h5>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" id="welcome_modal" name="welcome_modal" value="1" {{ $configs['welcome_modal'] ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="welcome_modal">Hiển thị thông báo khi vào website</label>
                                    </div>
                                    <small class="form-text text-muted d-block mt-2">Khi được bật, cửa sổ thông báo chào mừng sẽ hiển thị khi người dùng truy cập trang chủ.</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary me-2">Lưu thay đổi</button>
                                <a href="{{ route('admin.index') }}" class="btn btn-secondary">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
