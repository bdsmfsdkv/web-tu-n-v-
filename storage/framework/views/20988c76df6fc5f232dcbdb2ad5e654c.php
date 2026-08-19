<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col my-1">
                <p class="m-0 fw-semibold">© Copyright <?php echo e(date('Y')); ?> ♥ by <a href="#" target="_blank">Bùi Văn Quyết</a></p>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts from old theme (to ensure functionality) -->
<script src="<?php echo e(asset('assets/js/jquery-3.6.0.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/select2/js/select2.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/sweetalert/sweetalert2.all.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/plugins/sweetalert/sweetalerts.min.js')); ?>"></script>
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewMultipleImages(input, previewId) {
        var preview = document.getElementById(previewId);
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
    window.addEventListener('DOMContentLoaded', () => {
        const body = document.body;
        body.setAttribute('data-pc-preset', 'preset-1');
        body.setAttribute('data-pc-sidebar-caption', 'true');
        body.setAttribute('data-pc-layout', 'vertical');
        body.setAttribute('data-pc-direction', 'ltr');
        body.setAttribute('data-pc-theme_contrast', '');
        body.setAttribute('data-pc-theme', 'dark');
        body.setAttribute('style', '');
    });
</script>

<?php echo $__env->yieldPushContent('scripts'); ?>
<?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views\layouts\admin\footer.blade.php ENDPATH**/ ?>