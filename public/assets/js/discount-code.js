/**
 * Discount Code Handler
 *
 * This script provides functionality for validating and applying discount codes
 * across different purchase types: accounts, random accounts, and services.
 */

class DiscountCodeHandler {
    constructor() {
        this.discountCode = '';
        this.originalPrice = 0;
        this.discountedPrice = 0;
        this.context = ''; // 'account', 'random_account', or 'service'
        this.itemId = 0;
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    /**
     * Initialize the discount code handler for a specific context
     *
     * @param {string} context - The context ('account', 'random_account', or 'service')
     * @param {number} itemId - The ID of the item being purchased
     * @param {number} originalPrice - The original price of the item
     */
    init(context, itemId, originalPrice) {
        this.context = context;
        this.itemId = itemId;
        this.originalPrice = originalPrice;
        this.discountedPrice = originalPrice;
        this.discountCode = '';
        this.showMessage('', 'info');
        this.updatePriceDisplay(originalPrice);
    }

    async validateCode(code, quantity = 1) {
        if (!code) {
            this.showMessage('Vui lòng nhập mã giảm giá!', 'error');
            return false;
        }

        this.showMessage('Đang kiểm tra mã...', 'info');

        try {
            const response = await fetch('/discount-code/validate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify({
                    code: code,
                    context: this.context,
                    item_id: this.itemId,
                    quantity: quantity
                })
            });

            const data = await response.json();
            console.log(data);
            if (data.success) {
                this.discountCode = code;
                this.discountedPrice = data.data.discounted_price;
                this.updatePriceDisplay(data.data.discounted_price);

                const savings = data.data.original_price - data.data.discounted_price;
                const formattedSavings = new Intl.NumberFormat('vi-VN').format(savings);

                this.showMessage(`Mã giảm giá đã được áp dụng! Bạn tiết kiệm được ${formattedSavings}đ`, 'success');
                return true;
            } else {
                this.discountCode = '';
                this.discountedPrice = this.originalPrice;
                this.updatePriceDisplay(this.originalPrice);
                this.showMessage(data.message || 'Mã giảm giá không hợp lệ', 'error');
                return false;
            }
        } catch (error) {
            console.error('Error validating discount code:', error);
            this.showMessage('Có lỗi xảy ra khi kiểm tra mã giảm giá', 'error');
            return false;
        }
    }

    updatePriceDisplay(price) {
        let priceElements = [];

        if (this.context === 'account' || this.context === 'random_account') {
            priceElements = document.querySelectorAll('#account-price, .account-price-value, #totalPriceDisplay');
        } else if (this.context === 'service') {
            priceElements = document.querySelectorAll('.service-modal__value--price, .service-price-value');
        }

        priceElements.forEach(element => {
            if (element) {
                element.textContent = `${new Intl.NumberFormat('vi-VN').format(price)}đ`;
            }
        });
    }

    showMessage(message, type) {
        let messageElements = [];

        if (this.context === 'account' || this.context === 'random_account') {
            messageElements = document.querySelectorAll('#discount-message, .modal__discount-message');
        } else if (this.context === 'service') {
            messageElements = document.querySelectorAll('.service-modal__discount-message');
        }

        messageElements.forEach(element => {
            if (element) {
                element.textContent = message;

                if (type === 'error') {
                    element.style.color = '#ef4444';
                    if (typeof FuiToast !== 'undefined' && message) FuiToast.error(message);
                } else if (type === 'success') {
                    element.style.color = '#10b981';
                    if (typeof FuiToast !== 'undefined' && message) FuiToast.success(message);
                } else {
                    element.style.color = '#3b82f6';
                    if (typeof FuiToast !== 'undefined' && message) FuiToast.info(message);
                }
            }
        });
    }

    getDiscountInfo() {
        return {
            discountCode: this.discountCode,
            originalPrice: this.originalPrice,
            discountedPrice: this.discountedPrice
        };
    }
}

const discountHandler = new DiscountCodeHandler();

function initDiscountHandler(context, itemId, originalPrice) {
    discountHandler.init(context, itemId, originalPrice);
}

async function checkDiscountCode(contextSelector, quantity = 1) {
    const codeInput = document.querySelector('#discount-code') || document.querySelector('#discountCode');
    if (!codeInput) return;

    const code = codeInput.value.trim();
    await discountHandler.validateCode(code, quantity);
}

function getDiscountInfo() {
    return discountHandler.getDiscountInfo();
}

window.showRechargeModal = function () {
    window.location.href = '/profile/deposit/atm';
};

function syncAccountPurchaseModalActions() {
    const modal = document.getElementById('purchaseModal');
    if (!modal) return;

    const cardButton = modal.querySelector('.modal__btn--card');
    const atmButton = modal.querySelector('.modal__btn--wallet');
    const confirmButton = modal.querySelector('.modal__btn--submit');

    const needsDeposit = Boolean(cardButton || atmButton);

    if (needsDeposit) {
        if (confirmButton) {
            confirmButton.style.display = 'none';
        }

        if (atmButton) {
            atmButton.onclick = function (event) {
                if (event) event.preventDefault();
                window.location.href = '/profile/deposit/atm';
            };
        }
    }
}

function setupPreciseDesktopNavHover() {
    const desktopPointer = window.matchMedia('(min-width: 1200px) and (hover: hover) and (pointer: fine)');
    if (!desktopPointer.matches) return;

    if (!document.getElementById('precise-desktop-nav-hover-style')) {
        const style = document.createElement('style');
        style.id = 'precise-desktop-nav-hover-style';
        style.textContent = `
            @media (min-width: 1200px) and (hover: hover) and (pointer: fine) {
                /*
                 * NẠP TIỀN: only the visible trigger and the real dropdown panel may
                 * keep the menu open. Older CSS/app.js created wide invisible hover
                 * bridges and opened from the whole 64px <li>; neutralize those here.
                 */
                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown::after,
                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown > .modern-dropdown-menu::before {
                    content: none !important;
                    display: none !important;
                    width: 0 !important;
                    height: 0 !important;
                    pointer-events: none !important;
                }

                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown:hover:not(.pointer-open):not(.deposit-click-open) > .modern-dropdown-menu,
                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown.deposit-hover-open:not(.pointer-open):not(.deposit-click-open) > .modern-dropdown-menu,
                html body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown:hover:not(.pointer-open):not(:focus-within) > .mega-menu {
                    display: none !important;
                    visibility: hidden !important;
                    opacity: 0 !important;
                    pointer-events: none !important;
                    animation: none !important;
                }

                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown.pointer-open > .modern-dropdown-menu,
                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown.deposit-click-open > .modern-dropdown-menu {
                    display: grid !important;
                    visibility: visible !important;
                    opacity: 1 !important;
                    pointer-events: auto !important;
                }

                html body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown.pointer-open > .mega-menu {
                    display: block !important;
                    visibility: visible !important;
                    opacity: 1 !important;
                    pointer-events: auto !important;
                }

                /* Do not paint Nạp Tiền red when the cursor is only in empty li space. */
                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown:hover:not(.pointer-open):not(.deposit-click-open) > .nav-link-item:not(:hover),
                html body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown:hover:not(.pointer-open) > .nav-link-item:not(:hover) {
                    color: #242424 !important;
                    background: transparent !important;
                }

                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown:hover:not(.pointer-open):not(.deposit-click-open) > .nav-link-item:not(:hover) .nav-item-icon,
                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown:hover:not(.pointer-open):not(.deposit-click-open) > .nav-link-item:not(:hover) .nav-arrow,
                html body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown:hover:not(.pointer-open) > .nav-link-item:not(:hover) .nav-item-icon,
                html body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown:hover:not(.pointer-open) > .nav-link-item:not(:hover) .nav-arrow {
                    color: #888 !important;
                }

                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown:hover:not(.pointer-open):not(.deposit-click-open) > .nav-link-item .nav-arrow,
                html body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown:hover:not(.pointer-open) > .nav-link-item .nav-arrow {
                    transform: rotate(0deg) !important;
                }

                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown.pointer-open > .nav-link-item,
                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown.deposit-click-open > .nav-link-item,
                html body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown.pointer-open > .nav-link-item {
                    color: var(--primary, #dc2626) !important;
                    background: rgba(220, 38, 38, .07) !important;
                }

                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown.pointer-open > .nav-link-item .nav-arrow,
                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown.deposit-click-open > .nav-link-item .nav-arrow,
                html body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown.pointer-open > .nav-link-item .nav-arrow {
                    color: var(--primary, #dc2626) !important;
                    transform: rotate(180deg) !important;
                }

                [data-theme="dark"] body nav.navbar > .nav-container > #navLinks > li.nav-dropdown:hover:not(.pointer-open):not(.deposit-click-open) > .nav-link-item:not(:hover),
                [data-theme="dark"] body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown:hover:not(.pointer-open) > .nav-link-item:not(:hover) {
                    color: #e5e7eb !important;
                    background: transparent !important;
                }

                [data-theme="dark"] body nav.navbar > .nav-container > #navLinks > li.nav-dropdown.pointer-open > .nav-link-item,
                [data-theme="dark"] body nav.navbar > .nav-container > #navLinks > li.nav-dropdown.deposit-click-open > .nav-link-item,
                [data-theme="dark"] body nav.navbar > .nav-container > #navLinks > li.nav-mega-dropdown.pointer-open > .nav-link-item {
                    background: rgba(248, 113, 113, .1) !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    const owners = document.querySelectorAll('nav.navbar #navLinks > li.nav-dropdown, nav.navbar #navLinks > li.nav-mega-dropdown');

    owners.forEach(owner => {
        if (owner.dataset.preciseHoverReady === '1') return;

        const trigger = owner.querySelector(':scope > .nav-link-item');
        const panel = owner.querySelector(':scope > .modern-dropdown-menu, :scope > .mega-menu');
        if (!trigger || !panel) return;

        owner.dataset.preciseHoverReady = '1';
        let closeTimer = null;
        const isDepositMenu = owner.classList.contains('nav-dropdown');

        const openMenu = () => {
            if (closeTimer) {
                window.clearTimeout(closeTimer);
                closeTimer = null;
            }
            owner.classList.add('pointer-open');
        };

        const scheduleClose = () => {
            if (closeTimer) window.clearTimeout(closeTimer);
            closeTimer = window.setTimeout(() => {
                const pointerStillInsideRealArea = trigger.matches(':hover') || panel.matches(':hover');
                const keepMegaForKeyboard = !isDepositMenu && owner.matches(':focus-within');

                if (!pointerStillInsideRealArea && !keepMegaForKeyboard) {
                    owner.classList.remove('pointer-open');
                }
            }, 180);
        };

        /* Important: never bind mouseenter to the whole <li>. */
        trigger.addEventListener('mouseenter', openMenu);
        trigger.addEventListener('mouseleave', scheduleClose);
        panel.addEventListener('mouseenter', openMenu);
        panel.addEventListener('mouseleave', scheduleClose);
    });
}

function setupDirectPurchaseDepositLinks() {
    document.addEventListener('click', function (event) {
        const target = event.target.closest(
            '#purchaseModal .modal__btn--card, #purchaseModal .modal__btn--wallet, .ecom-actions .ecom-btn-atm'
        );

        if (!target) return;

        event.preventDefault();
        event.stopImmediatePropagation();

        if (target.matches('#purchaseModal .modal__btn--card')) {
            window.location.href = '/profile/deposit/card';
            return;
        }

        window.location.href = '/profile/deposit/atm';
    }, true);
}

function runGlobalUiFixes() {
    syncAccountPurchaseModalActions();
    setupPreciseDesktopNavHover();
    setupDirectPurchaseDepositLinks();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', runGlobalUiFixes);
} else {
    runGlobalUiFixes();
}
