<!DOCTYPE html>
<html lang="vi"data-theme="light">
@include('layouts.admin.head')
  <body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="dark" style=""> 
    <div class="loader-bg">
        <div class="loader-track"><div class="loader-fill"></div></div>
    </div>
    
    <div class="main-wrapper">
        @include('layouts.admin.sidebar')
        @include('layouts.admin.header')

        <div class="pc-container">
            <div class="pc-content">
                @yield('content')
            </div>
        </div>
    </div>

    @include('layouts.admin.footer')
</body>
</html>
