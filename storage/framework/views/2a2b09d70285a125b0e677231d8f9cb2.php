<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
    <div >
        <div >
            <div class="page-header">
                <div class="page-block mb-3">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="page-header-title">
                <h2 class="mb-0">Danh sách danh mục random</h2>
                <p class="text-muted">Quản lý danh mục tài khoản random</p>
            
                
            </div>
        </div></div>
</div>
                <div class="page-btn">
                    <a href="<?php echo e(route('admin.random-categories.create')); ?>" class="btn btn-success">
                        <i class="ti ti-plus me-1"></i>
                        <span>Thêm danh mục</span>
                    </a>
                </div>
            </div>
            <?php if(session('success')): ?>
                <?php if (isset($component)) { $__componentOriginaldb3b56596ae08e65d7cddff31f5007cb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb = $attributes; } ?>
<?php $component = App\View\Components\AlertAdmin::resolve(['type' => 'success','message' => session('success')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('alert-admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AlertAdmin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb)): ?>
<?php $attributes = $__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb; ?>
<?php unset($__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldb3b56596ae08e65d7cddff31f5007cb)): ?>
<?php $component = $__componentOriginaldb3b56596ae08e65d7cddff31f5007cb; ?>
<?php unset($__componentOriginaldb3b56596ae08e65d7cddff31f5007cb); ?>
<?php endif; ?>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <?php if (isset($component)) { $__componentOriginaldb3b56596ae08e65d7cddff31f5007cb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb = $attributes; } ?>
<?php $component = App\View\Components\AlertAdmin::resolve(['type' => 'danger','message' => session('error')] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('alert-admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AlertAdmin::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb)): ?>
<?php $attributes = $__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb; ?>
<?php unset($__attributesOriginaldb3b56596ae08e65d7cddff31f5007cb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldb3b56596ae08e65d7cddff31f5007cb)): ?>
<?php $component = $__componentOriginaldb3b56596ae08e65d7cddff31f5007cb; ?>
<?php unset($__componentOriginaldb3b56596ae08e65d7cddff31f5007cb); ?>
<?php endif; ?>
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
                                    <th class="text-uppercase small">
                                        <div class="form-check"><input class="form-check-input" type="checkbox" id="select-all"></div>
                                    </th>
                                    <th class="text-uppercase small">ID</th>
                                    <th class="text-uppercase small">Tên danh mục</th>
                                    <th class="text-uppercase small">Ảnh đại diện</th>
                                    <th class="text-uppercase small">Trạng thái</th>
                                    <th class="text-uppercase small">Ngày tạo</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <div class="form-check"><input class="form-check-input" type="checkbox"></div>
                                        </td>
                                        <td><?php echo e($category->id); ?></td>
                                        <td class="text-bolds"><?php echo e($category->name); ?></td>
                                        <td>
                                            <?php if($category->thumbnail): ?>
                                                <img src="<?php echo e(asset($category->thumbnail)); ?>" alt="<?php echo e($category->name); ?>"
                                                    class="img-thumbnail" style="max-width: 200px;">
                                            <?php else: ?>
                                                (Không có ảnh)
                                            <?php endif; ?>
                                        </td>
                                        <td><span
                                                class="badge <?php echo e($category->active ? 'bg-lightgreen' : 'bg-lightred'); ?>"><?php echo e($category->active ? 'Hoạt động' : 'Đã ẩn'); ?></span>
                                        </td>
                                        <td><?php echo e($category->created_at->format('d/m/Y')); ?></td>
                                        <td class="text-center">
                                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="<?php echo e(route('admin.random-categories.edit', $category->id)); ?>"
                                                        class="dropdown-item">
                                                        <i class="ti ti-edit fs-5 text-primary"></i>
                                                        Sửa danh mục
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"
                                                        onclick="showDeleteModal(<?php echo e($category->id); ?>)">
                                                        <i class="ti ti-trash fs-5 text-danger"></i>
                                                        Xóa danh mục
                                                    </a>
                                                </li>
                                            </ul>
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

    <?php if (isset($component)) { $__componentOriginalb9d375e327010d368ba2916bd420fa84 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb9d375e327010d368ba2916bd420fa84 = $attributes; } ?>
<?php $component = App\View\Components\ModalConfirmDelete::resolve(['message' => 'Bạn có chắc chắn muốn xóa danh mục random này không? Tất cả dữ liệu có liên quan đến nó sẽ
                biến mất khỏi hệ thống!'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modal-confirm-delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ModalConfirmDelete::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb9d375e327010d368ba2916bd420fa84)): ?>
<?php $attributes = $__attributesOriginalb9d375e327010d368ba2916bd420fa84; ?>
<?php unset($__attributesOriginalb9d375e327010d368ba2916bd420fa84); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb9d375e327010d368ba2916bd420fa84)): ?>
<?php $component = $__componentOriginalb9d375e327010d368ba2916bd420fa84; ?>
<?php unset($__componentOriginalb9d375e327010d368ba2916bd420fa84); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            let categoryId;

            // Store ID when delete button is clicked
            function showDeleteModal(id) {
                categoryId = id;
                $('#deleteModal').modal('show');
            }

            // Make showDeleteModal function globally available
            window.showDeleteModal = showDeleteModal;

            // Handle confirm delete button click
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: "<?php echo e(route('admin.random-categories.destroy', ':id')); ?>".replace(':id',
                        categoryId),
                    type: 'DELETE',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        if (response.success) {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: 'Đã xóa danh mục random thành công',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Reload page
                                window.location.reload();
                            });
                        } else {
                            // Show error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: response.message ||
                                    'Có lỗi xảy ra khi xóa danh mục random',
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#deleteModal').modal('hide');
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: xhr.responseJSON?.message ||
                                'Có lỗi xảy ra khi xóa danh mục random',
                        });
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\SHOP BÁN ACC GAME V1\resources\views/admin/random-categories/index.blade.php ENDPATH**/ ?>