<section class="page-title-section">
    <div class="container">
        @if(!isset($hideBreadcrumb) || !$hideBreadcrumb)
        <!-- Breadcrumb -->
        <div class="page-breadcrumb">
            <a href="/" class="breadcrumb-link"><i class="fas fa-home"></i> Trang Chủ</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">{{ $title }}</span>
        </div>
        @endif

        <!-- Title -->
        <h1 class="page-title-heading">
            <span class="title-bar"></span>
            {{ $title }}
        </h1>

        <!-- Description Box -->
        @if (isset($description) && $description)
            <div class="page-desc-box">
                {!! $description !!}
            </div>
        @endif
    </div>
</section>
