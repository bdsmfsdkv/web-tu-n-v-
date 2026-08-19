<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('content'); ?>


<div >
    <div >
        <div class="page-header">
            <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0"><?php echo e($title); ?></h2>
                <p class="text-muted">Quản lý chiến dịch Flash Sale</p>
            
                
            </div>
        </div></div>
</div>
            <div class="page-btn">
                <a href="javascript:void(0);" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFlashSaleModal">
                    <img src="<?php echo e(asset('assets/admin/img/icons/plus.svg')); ?>" alt="img" class="me-1"> Tạo Flash Sale mới
                </a>
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
        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card overflow-hidden shadow-sm border border-dashed">
            <div class="card-body px-0 py-0">
                <form class="p-3 bg-auto-subtle border-bottom filter-form" method="GET">
                    <div class="row align-items-center g-2">
                        <div class="col-md-2">
                            <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">--Hiển thị--</option>
                                <option value="10" <?php echo e(request('per_page') == 10 ? 'selected' : ''); ?>>10</option>
                                <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25</option>
                                <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50</option>
                                <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm kiếm..." value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-3 d-flex gap-2 ms-auto">
                            <button type="submit" class="btn btn-sm btn-primary w-100">
                                <i class="ti ti-search me-1"></i> Tìm kiếm
                            </button>
                            <a href="?" class="btn btn-sm btn-light-danger w-100">
                                <i class="ti ti-trash me-1"></i> Bỏ lọc
                            </a>
                        </div>
                    </div>
                </form>
                <div class="table-responsive table-border-style">
                    <table class="table table-hover table-borderless align-middle mb-0 text-nowrap w-100">
                        <thead class="bg-light-subtle text-muted">
                            <tr>
                                <th class="text-uppercase small">Tên chiến dịch</th>
                                <th class="text-uppercase small">Số lượng SP</th>
                                <th class="text-uppercase small">Bắt đầu</th>
                                <th class="text-uppercase small">Kết thúc</th>
                                <th class="text-uppercase small">Trạng thái</th>
                                <th class="text-uppercase small">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $flashSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><strong><?php echo e($fs->campaign_name); ?></strong></td>
                                    <td><?php echo e($fs->items->count()); ?> sản phẩm</td>
                                    <td><?php echo e(\Carbon\Carbon::parse($fs->start_time)->format('d/m/Y H:i')); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($fs->end_time)->format('d/m/Y H:i')); ?></td>
                                    <td>
                                        <?php if($fs->status == 1 && \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($fs->end_time))): ?>
                                            <span class="badge bg-success">Đang chạy</span>
                                        <?php elseif($fs->status == 0): ?>
                                            <span class="badge bg-lightsecondary">Tạm dừng</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Đã kết thúc</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form action="<?php echo e(route('admin.flash-sales.destroy', $fs->id)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa chiến dịch Flash Sale này?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="100%">
                                            <div class="text-center py-5">
                                                <svg style="width: 184px; height: 152px;" viewBox="0 0 184 152" xmlns="http://www.w3.org/2000/svg">
                                                    <g fill="none" fill-rule="evenodd">
                                                        <g transform="translate(24 31.67)">
                                                            <ellipse fill-opacity=".8" fill="#F5F5F7" cx="67.797" cy="106.89" rx="67.797" ry="12.668"></ellipse>
                                                            <path d="M122.034 69.674L98.109 40.229c-1.148-1.386-2.826-2.225-4.593-2.225h-51.44c-1.766 0-3.444.839-4.592 2.225L13.56 69.674v15.383h108.475V69.674z" fill="#AEB8C2"></path>
                                                            <path d="M33.83 0h67.933a4 4 0 0 1 4 4v93.344a4 4 0 0 1-4 4H33.83a4 4 0 0 1-4-4V4a4 4 0 0 1 4-4z" fill="#F5F5F7"></path>
                                                            <path d="M42.678 9.953h50.237a2 2 0 0 1 2 2V36.91a2 2 0 0 1-2 2H42.678a2 2 0 0 1-2-2V11.953a2 2 0 0 1 2-2zM42.94 49.767h49.713a2.262 2.262 0 1 1 0 4.524H42.94a2.262 2.262 0 0 1 0-4.524zM42.94 61.53h49.713a2.262 2.262 0 1 1 0 4.525H42.94a2.262 2.262 0 0 1 0-4.525zM121.813 105.032c-.775 3.071-3.497 5.36-6.735 5.36H20.515c-3.238 0-5.96-2.29-6.734-5.36a7.309 7.309 0 0 1-.222-1.79V69.675h26.318c2.907 0 5.25 2.448 5.25 5.42v.04c0 2.971 2.37 5.37 5.277 5.37h34.785c2.907 0 5.277-2.421 5.277-5.393V75.1c0-2.972 2.343-5.426 5.25-5.426h26.318v33.569c0 .617-.077 1.216-.221 1.789z" fill="#DCE0E6"></path>
                                                        </g>
                                                        <path d="M149.121 33.292l-6.83 2.65a1 1 0 0 1-1.317-1.23l1.937-6.207c-2.589-2.944-4.109-6.534-4.109-10.408C138.802 8.102 148.92 0 161.402 0 173.881 0 184 8.102 184 18.097c0 9.995-10.118 18.097-22.599 18.097-4.528 0-8.744-1.066-12.28-2.902z" fill="#DCE0E6"></path>
                                                    </g>
                                                </svg>
                                                <p class="mt-3 text-muted">Không tìm thấy dữ liệu</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                    </table>
                
                    
</div>
<?php
                        $paginator = null;
                        foreach(get_defined_vars() as $var) {
                            if (is_object($var) && method_exists($var, 'hasPages')) {
                                $paginator = $var;
                                break;
                            }
                        }
                    ?>
                    <?php if($paginator && $paginator->hasPages()): ?>
                        <div class="d-flex justify-content-end p-3 border-top">
                            <?php echo e($paginator->withQueryString()->links('pagination::bootstrap-5')); ?>

                        </div>
                    <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<!-- Add Flash Sale Modal -->
<div class="modal fade" id="addFlashSaleModal" tabindex="-1" aria-labelledby="addFlashSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title d-flex align-items-center gap-2" id="addFlashSaleModalLabel">
                    <i class="ti ti-bolt text-warning fs-4"></i> Tạo Flash Sale mới
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <form action="<?php echo e(route('admin.flash-sales.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-4">Thiết lập chiến dịch giảm giá chớp nhoáng với giao diện trực quan.</p>
                    
                    <div class="mb-4">
                        <label class="form-label fw-medium">Tên chiến dịch <span class="text-danger">*</span></label>
                        <input type="text" name="campaign_name" class="form-control" placeholder="VD: Flash Sale Cuối Tuần" required>
                    </div>

                    <div class="row mb-4 g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-medium">Thời gian diễn ra <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="datetime-local" name="start_time" class="form-control" required>
                                <span class="input-group-text"><i class="ti ti-arrow-right"></i></span>
                                <input type="datetime-local" name="end_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Trạng thái <span class="text-danger">*</span></label>
                            <select name="status" class="form-select text-success fw-medium">
                                <option value="1">Kích hoạt</option>
                                <option value="0" class="text-danger">Tạm ẩn</option>
                            </select>
                        </div>
                    </div>

                    <div class="card border shadow-none mb-0">
                        <div class="card-header border-bottom py-3">
                            <h6 class="mb-0 fw-semibold"><i class="ti ti-box me-1"></i> Sản phẩm tham gia</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2 d-none d-md-flex text-muted small fw-medium text-uppercase">
                                <div class="col-md-4">Sản phẩm <span class="text-danger">*</span></div>
                                <div class="col-md-3">Giá cũ <span class="text-danger">*</span></div>
                                <div class="col-md-3">Giá Flash Sale <span class="text-danger">*</span></div>
                                <div class="col-md-2"></div>
                            </div>

                            <div id="products_container">
                                <!-- Product Row Template -->
                                <div class="row align-items-center product-item mb-3 g-2">
                                    <div class="col-md-4 mb-2 mb-md-0">
                                        <select name="products[0][id]" class="form-select" required>
                                            <option value="">Chọn sản phẩm</option>
                                            <optgroup label="Tài Khoản Game">
                                                <?php $__currentLoopData = $allGameCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="game_<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </optgroup>
                                            <optgroup label="Tài Khoản Random">
                                                <?php $__currentLoopData = $allRandomCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="random_<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <div class="input-group">
                                            <input type="number" name="products[0][old_price]" class="form-control" placeholder="Giá cũ" required min="0">
                                            <span class="input-group-text">đ</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <div class="input-group">
                                            <input type="number" name="products[0][new_price]" class="form-control text-danger fw-medium" placeholder="Giá mới" required min="0">
                                            <span class="input-group-text text-danger border-danger-subtle">đ</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-md-end">
                                        <button type="button" class="btn btn-light-danger w-100" onclick="removeProduct(this)" title="Xóa">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-light-primary w-100 border-dashed mt-2" onclick="addProduct()">
                                <i class="ti ti-plus me-1"></i> Thêm sản phẩm
                            </button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Xác nhận tạo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let productIndex = 1;
    function addProduct() {
        const container = document.getElementById('products_container');
        const template = `
            <div class="row align-items-center product-item mb-3 g-2">
                <div class="col-md-4 mb-2 mb-md-0">
                    <select name="products[${productIndex}][id]" class="form-select" required>
                        <option value="">Chọn sản phẩm</option>
                        <optgroup label="Tài Khoản Game">
                            <?php $__currentLoopData = $allGameCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="game_<?php echo e($cat->id); ?>"><?php echo e(str_replace("'", "\'", $cat->name)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </optgroup>
                        <optgroup label="Tài Khoản Random">
                            <?php $__currentLoopData = $allRandomCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="random_<?php echo e($cat->id); ?>"><?php echo e(str_replace("'", "\'", $cat->name)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                    <div class="input-group">
                        <input type="number" name="products[${productIndex}][old_price]" class="form-control" placeholder="Giá cũ" required min="0">
                        <span class="input-group-text">đ</span>
                    </div>
                </div>
                <div class="col-md-3 mb-2 mb-md-0">
                    <div class="input-group">
                        <input type="number" name="products[${productIndex}][new_price]" class="form-control text-danger fw-medium" placeholder="Giá mới" required min="0">
                        <span class="input-group-text text-danger border-danger-subtle">đ</span>
                    </div>
                </div>
                <div class="col-md-2 text-md-end">
                    <button type="button" class="btn btn-light-danger w-100" onclick="removeProduct(this)" title="Xóa">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', template);
        productIndex++;
    }

    function removeProduct(button) {
        const rows = document.querySelectorAll('.product-item');
        if (rows.length > 1) {
            button.closest('.product-item').remove();
        } else {
            alert('Phải có ít nhất 1 sản phẩm tham gia!');
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/admin/flash-sales/index.blade.php ENDPATH**/ ?>