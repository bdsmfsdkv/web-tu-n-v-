@extends('layouts.admin.app')
@section('title', $title ?? 'Cài đặt hệ thống')

@section('content')
    <div >
        <div >
            <div class="row align-items-center mb-4">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0"><i class="ti ti-settings me-2"></i>Cài đặt hệ thống</h2>
                        <p class="text-muted">Quản lý cấu hình website và hệ thống</p>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti ti-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ti ti-alert-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Tabs Navigation -->
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body p-2">

                    <ul class="nav nav-pills flex-wrap gap-2" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('tab', 'general') === 'general' ? 'active' : '' }}" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                                <i class="ti ti-settings me-1"></i> Chung
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('tab') === 'social' ? 'active' : '' }}" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab">
                                <i class="ti ti-share me-1"></i> Mạng xã hội
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('tab') === 'email' ? 'active' : '' }}" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button" role="tab">
                                <i class="ti ti-mail me-1"></i> Email & SMTP
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('tab') === 'payment' ? 'active' : '' }}" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button" role="tab">
                                <i class="ti ti-credit-card me-1"></i> Thanh toán
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('tab') === 'login' ? 'active' : '' }}" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">
                                <i class="ti ti-login me-1"></i> Đăng nhập MXH
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('tab') === 'terms' ? 'active' : '' }}" id="terms-tab" data-bs-toggle="tab" data-bs-target="#terms" type="button" role="tab">
                                <i class="ti ti-file-text me-1"></i> Điều khoản
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tabs Content -->
            <div class="tab-content" id="settingsTabsContent">
                <div class="tab-pane fade {{ session('tab', 'general') === 'general' ? 'show active' : '' }}" id="general" role="tabpanel">
                    @include('admin.settings.partials.general')
                </div>
                <div class="tab-pane fade {{ session('tab') === 'social' ? 'show active' : '' }}" id="social" role="tabpanel">
                    @include('admin.settings.partials.social')
                </div>
                <div class="tab-pane fade {{ session('tab') === 'email' ? 'show active' : '' }}" id="email" role="tabpanel">
                    @include('admin.settings.partials.email')
                </div>
                <div class="tab-pane fade {{ session('tab') === 'payment' ? 'show active' : '' }}" id="payment" role="tabpanel">
                    @include('admin.settings.partials.payment')
                </div>
                <div class="tab-pane fade {{ session('tab') === 'login' ? 'show active' : '' }}" id="login" role="tabpanel">
                    @include('admin.settings.partials.login')
                </div>
                <div class="tab-pane fade {{ session('tab') === 'terms' ? 'show active' : '' }}" id="terms" role="tabpanel">
                    @include('admin.settings.partials.terms')
                </div>
            
                    
</div>
        </div>
    </div>
@endsection
