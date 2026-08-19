@extends('layouts.user.app')

@section('title', 'Câu Hỏi Thường Gặp')

@push('css')
<style>
    .faq-page {
        padding: 60px 0;
        background-color: transparent;
        min-height: 100vh;
    }
    
    .faq-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .faq-header {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .faq-icon-wrapper {
        width: 64px;
        height: 64px;
        background-color: var(--primary, #dc2626);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.3);
    }
    
    .faq-icon-wrapper .iconify {
        font-size: 32px;
        color: #ffffff;
    }

    .faq-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--text-color, #1f2937);
        margin: 0 0 12px 0;
    }

    .faq-subtitle {
        color: var(--text-muted, #6b7280);
        font-size: 1.1rem;
        margin: 0;
    }

    .faq-category {
        margin-bottom: 40px;
    }
    
    .faq-category-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-color, #1f2937);
        margin: 0 0 16px 0;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--primary, #dc2626);
    }
    
    .faq-category-title .iconify {
        color: var(--primary, #dc2626);
        font-size: 1.4rem;
    }

    .faq-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .faq-item {
        background: var(--bg-card, #fff);
        border: 1px solid var(--border-color, #e5e7eb);
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s;
    }

    .faq-question {
        width: 100%;
        text-align: left;
        background: transparent;
        border: none;
        padding: 16px 20px;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-color, #1f2937);
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }

    .faq-question .iconify {
        color: var(--text-muted, #9ca3af);
        transition: transform 0.3s;
    }

    .faq-item.active .faq-question .iconify {
        transform: rotate(180deg);
        color: var(--primary, #dc2626);
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
        background: var(--bg-body, #f9fafb);
    }
    
    .faq-answer-inner {
        padding: 0 20px 20px 20px;
        color: var(--text-muted, #4b5563);
        line-height: 1.6;
        border-top: 1px solid transparent;
    }
    
    .faq-item.active .faq-answer {
        max-height: 500px; /* Adjust if content is very long */
    }
    
    .faq-item.active .faq-answer-inner {
        border-top-color: var(--border-color, #e5e7eb);
        padding-top: 16px;
    }

    /* Dark mode adjustments */
    [data-theme="dark"] .faq-title { color: #f9fafb; }
    [data-theme="dark"] .faq-subtitle { color: #9ca3af; }
    [data-theme="dark"] .faq-category-title { color: #f9fafb; }
    [data-theme="dark"] .faq-item { background: #171717; border-color: #2a2a2a; }
    [data-theme="dark"] .faq-question { color: #f9fafb; }
    [data-theme="dark"] .faq-answer { background: #171717; }
    [data-theme="dark"] .faq-answer-inner { color: #d1d5db; border-top-color: #2a2a2a; }
    [data-theme="dark"] .faq-item.active { border-color: #404040; }
</style>
@endpush

@section('content')
<div class="faq-page">
    <div class="container">
        <div class="faq-container">
            
            <div class="faq-header">
                <div class="faq-icon-wrapper">
                    <span class="iconify" data-icon="ant-design:question-outlined"></span>
                </div>
                <h1 class="faq-title">Câu Hỏi Thường Gặp</h1>
                <p class="faq-subtitle">Tìm câu trả lời nhanh cho những thắc mắc phổ biến</p>
            </div>

            <div class="faq-categories">
                <!-- Category 1 -->
                <div class="faq-category">
                    <h3 class="faq-category-title">
                        <span class="iconify" data-icon="ant-design:user-outlined"></span> Tài Khoản & Đăng Ký
                    </h3>
                    <div class="faq-list">
                        <div class="faq-item">
                            <button class="faq-question">
                                <span>Làm thế nào để đăng ký tài khoản?</span>
                                <span class="iconify" data-icon="ant-design:down-outlined"></span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-inner">
                                    Bạn chỉ cần bấm vào nút "Đăng Ký" góc trên cùng bên phải màn hình, điền các thông tin cơ bản như Tên đăng nhập, Email và Mật khẩu. Sau khi đăng ký, bạn có thể đăng nhập ngay để trải nghiệm dịch vụ.
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button class="faq-question">
                                <span>Tôi quên mật khẩu, phải làm sao?</span>
                                <span class="iconify" data-icon="ant-design:down-outlined"></span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-inner">
                                    Vui lòng liên hệ với bộ phận CSKH qua Facebook hoặc Zalo (thông tin liên hệ ở phần chân trang) để được hỗ trợ cấp lại mật khẩu mới.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category 2 -->
                <div class="faq-category">
                    <h3 class="faq-category-title">
                        <span class="iconify" data-icon="ant-design:dollar-circle-outlined"></span> Nạp Tiền
                    </h3>
                    <div class="faq-list">
                        <div class="faq-item">
                            <button class="faq-question">
                                <span>Có những hình thức nạp tiền nào?</span>
                                <span class="iconify" data-icon="ant-design:down-outlined"></span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-inner">
                                    Hiện tại hệ thống hỗ trợ 2 hình thức chính: Nạp thẻ cào (Viettel, Vina, Mobi...) và Nạp ngân hàng/Momo tự động duyệt trong 1 phút.
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button class="faq-question">
                                <span>Nạp thẻ cào bao lâu thì nhận được tiền?</span>
                                <span class="iconify" data-icon="ant-design:down-outlined"></span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-inner">
                                    Sau khi nhập đúng mã thẻ và seri, hệ thống sẽ tự động gạch thẻ trong vòng 5s - 30s. Tiền sẽ được cộng tự động vào tài khoản của bạn ngay lập tức.
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button class="faq-question">
                                <span>Nạp ngân hàng nhưng chưa được cộng tiền?</span>
                                <span class="iconify" data-icon="ant-design:down-outlined"></span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-inner">
                                    Xin kiểm tra lại phần Nội dung chuyển khoản xem bạn có điền đúng Cú pháp hệ thống yêu cầu hay không. Nếu lỡ quên nội dung, hãy nhắn tin ngay cho Admin cùng kèm ảnh biên lai để được cộng tay nhé.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category 3 -->
                <div class="faq-category">
                    <h3 class="faq-category-title">
                        <span class="iconify" data-icon="ant-design:shopping-cart-outlined"></span> Mua Hàng & Bảo Hành
                    </h3>
                    <div class="faq-list">
                        <div class="faq-item">
                            <button class="faq-question">
                                <span>Mua tài khoản như thế nào?</span>
                                <span class="iconify" data-icon="ant-design:down-outlined"></span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-inner">
                                    Bạn nạp đủ số tiền vào web, sau đó chọn tài khoản cần mua, bấm "Mua ngay". Mật khẩu và tài khoản game sẽ được hiển thị ngay trên màn hình và lưu vào phần "Tài khoản đã mua" trong trang cá nhân của bạn.
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button class="faq-question">
                                <span>Tài khoản mua rồi có được bảo hành không?</span>
                                <span class="iconify" data-icon="ant-design:down-outlined"></span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-inner">
                                    Tất cả tài khoản đều được bảo hành sai pass 1 đổi 1 ngay lập tức. Sau khi đăng nhập thành công, bạn vui lòng đổi mật khẩu để bảo vệ tài sản của mình.
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button class="faq-question">
                                <span>Tôi có thể xem lại tài khoản đã mua ở đâu?</span>
                                <span class="iconify" data-icon="ant-design:down-outlined"></span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-inner">
                                    Bạn vào "Tài Khoản" góc trên cùng, chọn phần "Tài khoản đã mua" hoặc "Tài khoản random đã mua" để xem lại danh sách tất cả các tài khoản bạn đã thanh toán.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Category 4 -->
                <div class="faq-category">
                    <h3 class="faq-category-title">
                        <span class="iconify" data-icon="ant-design:info-circle-outlined"></span> Câu Hỏi Khác
                    </h3>
                    <div class="faq-list">
                        <div class="faq-item">
                            <button class="faq-question">
                                <span>Website có uy tín không?</span>
                                <span class="iconify" data-icon="ant-design:down-outlined"></span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-inner">
                                    Với hơn 3 năm hoạt động trong lĩnh vực kinh doanh tài khoản Game, hệ thống đã thực hiện hàng trăm ngàn giao dịch tự động. Bạn hoàn toàn có thể yên tâm và trải nghiệm dịch vụ.
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button class="faq-question">
                                <span>Làm thế nào để liên hệ hỗ trợ?</span>
                                <span class="iconify" data-icon="ant-design:down-outlined"></span>
                            </button>
                            <div class="faq-answer">
                                <div class="faq-answer-inner">
                                    Ở góc dưới cùng bên phải màn hình có nút "Liên hệ hỗ trợ". Hoặc kéo xuống chân trang web để lấy link Fanpage và Zalo của Shop. Admin luôn online 24/7 để hỗ trợ bạn!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const questions = document.querySelectorAll('.faq-question');
        
        questions.forEach(question => {
            question.addEventListener('click', function() {
                const item = this.closest('.faq-item');
                const isActive = item.classList.contains('active');
                
                // Close all other items (optional - remove if you want multiple items open at once)
                // document.querySelectorAll('.faq-item.active').forEach(openItem => {
                //     if (openItem !== item) {
                //         openItem.classList.remove('active');
                //     }
                // });
                
                // Toggle current item
                if (isActive) {
                    item.classList.remove('active');
                } else {
                    item.classList.add('active');
                }
            });
        });
    });
</script>
@endpush
