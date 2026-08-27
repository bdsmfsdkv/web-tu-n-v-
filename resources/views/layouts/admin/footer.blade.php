<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col my-1">
                <p class="m-0 fw-semibold">© Copyright {{ date('Y') }}</p>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts from old theme (to ensure functionality) -->
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var el = document.getElementById(previewId);
                if (el) {
                    el.src = e.target.result;
                    el.style.display = 'inline-block';
                }
                var placeholder = document.getElementById(previewId + '-placeholder');
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
                var icon = input.parentElement ? input.parentElement.querySelector('i') : null;
                if (icon) {
                    icon.style.display = 'none';
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewMultipleImages(input, previewId) {
        var preview = document.getElementById(previewId);
        if (!preview) return;
        preview.innerHTML = '';
        if (input.files) {
            Array.from(input.files).forEach(file => {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '200px';
                    img.style.maxHeight = '200px';
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>

<!-- New theme Scripts -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="/cmsbvq/template/frontend/js/plugins/popper.min.js"></script>
<script src="/cmsbvq/template/frontend/js/plugins/simplebar.min.js"></script>
<script src="/cmsbvq/template/frontend/js/plugins/bootstrap.min.js"></script>
<script src="/cmsbvq/template/frontend/js/icon/custom-font.js"></script>
<script src="/cmsbvq/template/frontend/js/script.js"></script>
<script src="/cmsbvq/template/frontend/js/theme.js"></script>
<script src="/cmsbvq/template/frontend/js/plugins/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.4/dist/simple-notify.min.js"></script>

<script>
    (function() {
        function showAdminNotifications() {
            const body = document.body;
            if (body) {
                body.setAttribute('data-pc-preset', 'preset-1');
                body.setAttribute('data-pc-sidebar-caption', 'true');
                body.setAttribute('data-pc-layout', 'vertical');
                body.setAttribute('data-pc-direction', 'ltr');
                body.setAttribute('data-pc-theme_contrast', '');
                body.setAttribute('data-pc-theme', 'dark');
                body.setAttribute('style', '');
            }

            @if(session('success'))
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        html: {!! json_encode(session('success')) !!},
                        confirmButtonText: 'Đóng',
                        timer: 3500,
                        timerProgressBar: true,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                } else if (typeof Notify !== 'undefined') {
                    new Notify({
                        status: 'success',
                        title: 'Thành công',
                        text: {!! json_encode(session('success')) !!},
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: true,
                        autoclose: true,
                        autotimeout: 3500
                    });
                }
            @endif

            @if(session('error'))
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Thất bại!',
                        html: {!! json_encode(session('error')) !!},
                        confirmButtonText: 'Đóng',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    });
                } else if (typeof Notify !== 'undefined') {
                    new Notify({
                        status: 'error',
                        title: 'Lỗi',
                        text: {!! json_encode(session('error')) !!},
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: true
                    });
                }
            @endif

            @if($errors->any())
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Dữ liệu không hợp lệ!',
                        html: '{!! implode("<br>", array_map("e", $errors->all())) !!}',
                        confirmButtonText: 'Đóng',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    });
                }
            @endif
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', showAdminNotifications);
        } else {
            showAdminNotifications();
        }
    })();
</script>

<script>
    // Mobile sidebar overlay toggle
    (function() {
        var overlay = document.getElementById('pc-sidebar-overlay');
        var sidebar = document.querySelector('.pc-sidebar');
        if (!overlay || !sidebar) return;

        // Watch for sidebar open/close via class changes
        var observer = new MutationObserver(function() {
            if (sidebar.classList.contains('mob-sidebar-active')) {
                overlay.classList.add('active');
            } else {
                overlay.classList.remove('active');
            }
        });
        observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });

        // Click overlay to close sidebar
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('mob-sidebar-active');
            overlay.classList.remove('active');
        });
    })();
</script>

@stack('scripts')
