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
                <h2 class="mb-0">Điều Khoản & Chính Sách</h2>
                <p class="text-muted">Quản lý nội dung điều khoản sử dụng và chính sách bảo mật</p>
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
                    <form action="{{ route('admin.settings.terms.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Điều khoản sử dụng</label>
                                    <textarea id="terms_of_use" name="terms_of_use" class="form-control editor @error('terms_of_use') is-invalid @enderror" rows="10"
                                        placeholder="Nhập nội dung điều khoản sử dụng...">{{ old('terms_of_use', $configs['terms_of_use']) }}</textarea>
                                    @error('terms_of_use')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Chính sách bảo mật</label>
                                    <textarea id="privacy_policy" name="privacy_policy" class="form-control editor @error('privacy_policy') is-invalid @enderror" rows="10"
                                        placeholder="Nhập nội dung chính sách bảo mật...">{{ old('privacy_policy', $configs['privacy_policy']) }}</textarea>
                                    @error('privacy_policy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let termsEditor;
            let privacyEditor;
            
            if (document.querySelector('#terms_of_use')) {
                ClassicEditor
                    .create(document.querySelector('#terms_of_use'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'insertTable', 'blockQuote', 'undo', 'redo']
                    })
                    .then(editor => {
                        termsEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
            
            if (document.querySelector('#privacy_policy')) {
                ClassicEditor
                    .create(document.querySelector('#privacy_policy'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'insertTable', 'blockQuote', 'undo', 'redo']
                    })
                    .then(editor => {
                        privacyEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            document.querySelector('form').addEventListener('submit', function(e) {
                if (termsEditor) {
                    document.querySelector('#terms_of_use').value = termsEditor.getData();
                }
                if (privacyEditor) {
                    document.querySelector('#privacy_policy').value = privacyEditor.getData();
                }
            });
        });
    </script>
@endpush
