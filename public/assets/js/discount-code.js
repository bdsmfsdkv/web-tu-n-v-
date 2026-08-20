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

        // Reset any previous discount code
        this.discountCode = '';

        // Reset any previous messages
        this.showMessage('', 'info');

        // Update UI with initial price
        this.updatePriceDisplay(originalPrice);
    }

    /**
     * Validate a discount code
     *
     * @param {string} code - The discount code to validate
     * @param {number} quantity - Quantity of items
     * @returns {Promise} - A promise that resolves with the validation result
     */
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
                // Reset to original price if code is invalid
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

    /**
     * Update the price display in the UI
     *
     * @param {number} price - The price to display
     */
    updatePriceDisplay(price) {
        // Find price display elements based on context
        let priceElements = [];

        if (this.context === 'account' || this.context === 'random_account') {
            priceElements = document.querySelectorAll('#account-price, .account-price-value, #totalPriceDisplay');
        } else if (this.context === 'service') {
            priceElements = document.querySelectorAll('.service-modal__value--price, .service-price-value');
        }

        // Update all price display elements
        priceElements.forEach(element => {
            if (element) {
                element.textContent = `${new Intl.NumberFormat('vi-VN').format(price)}đ`;
            }
        });
    }

    /**
     * Show a message in the UI
     *
     * @param {string} message - The message to display
     * @param {string} type - The type of message ('info', 'success', or 'error')
     */
    showMessage(message, type) {
        // Find message elements based on context
        let messageElements = [];

        if (this.context === 'account' || this.context === 'random_account') {
            messageElements = document.querySelectorAll('#discount-message, .modal__discount-message');
        } else if (this.context === 'service') {
            messageElements = document.querySelectorAll('.service-modal__discount-message');
        }

        // Update all message elements
        messageElements.forEach(element => {
            if (element) {
                element.textContent = message;

                // Set color based on message type
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

    /**
     * Get the current discount code and discounted price
     *
     * @returns {Object} - Object containing the discount code and discounted price
     */
    getDiscountInfo() {
        return {
            discountCode: this.discountCode,
            originalPrice: this.originalPrice,
            discountedPrice: this.discountedPrice
        };
    }
}

// Create a global instance
const discountHandler = new DiscountCodeHandler();

/**
 * Initialize the discount code handler for a specific context
 *
 * @param {string} context - The context ('account', 'random_account', or 'service')
 * @param {number} itemId - The ID of the item being purchased
 * @param {number} originalPrice - The original price of the item
 */
function initDiscountHandler(context, itemId, originalPrice) {
    discountHandler.init(context, itemId, originalPrice);
}

/**
 * Check a discount code from the input field
 *
 * @param {string} contextSelector - The selector for the discount code input
 */
async function checkDiscountCode(contextSelector, quantity = 1) {
    const codeInput = document.querySelector('#discount-code') || document.querySelector('#discountCode');
    if (!codeInput) return;

    const code = codeInput.value.trim();
    await discountHandler.validateCode(code, quantity);
}

/**
 * Get the current discount information for use in purchase functions
 *
 * @returns {Object} - Object containing the discount code and discounted price
 */
function getDiscountInfo() {
    return discountHandler.getDiscountInfo();
}

/**
 * Account/random purchase screens previously opened the generic deposit chooser
 * after the user had already clicked NẠP ATM. Override that helper after the
 * page-specific script has loaded so ATM goes straight to the bank/QR page.
 */
window.showRechargeModal = function () {
    window.location.href = '/profile/deposit/atm';
};

/**
 * Purchase modal payment flow:
 * - If the server rendered NẠP THẺ CÀO / NẠP ATM, the balance is insufficient.
 *   Keep those two deposit actions and never show a purchase-confirm button there.
 * - If the balance is sufficient, the server renders only XÁC NHẬN MUA (plus ĐÓNG).
 * - NẠP ATM always goes directly to the bank/QR deposit page.
 */
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

/**
 * Desktop navbar precise-hover fix.
 * Older CSS opens dropdowns from li:hover while the li fills the whole 64px
 * header height. That makes invisible/empty areas around the visible button
 * trigger the menu. Only the real button now opens it; a short close delay lets
 * the pointer travel from the button into the panel without an invisible wide
 * hover zone.
 */
function setupPreciseDesktopNavHover() {
    const desktopPointer = window.matchMedia('(min-width: 1200px) and (hover: hover) and (pointer: fine)');
    if (!desktopPointer.matches) return;

    if (!document.getElementById('precise-desktop-nav-hover-style')) {
        const style = document.createElement('style');
        style.id = 'precise-desktop-nav-hover-style';
        style.textContent = `
            @media (min-width: 1200px) and (hover: hover) and (pointer: fine) {
                html body nav.navbar > .nav-container > #navLinks > li.nav-dropdown:hover:not(.pointer-open):not(.deposit-click-open):not(:focus-within) > .modern-dropdown-menu,
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
                if (!trigger.matches(':hover') && !panel.matches(':hover') && !owner.matches(':focus-within')) {
                    owner.classList.remove('pointer-open');
                }
            }, 220);
        };

        trigger.addEventListener('mouseenter', openMenu);
        trigger.addEventListener('mouseleave', scheduleClose);
        panel.addEventListener('mouseenter', openMenu);
        panel.addEventListener('mouseleave', scheduleClose);
    });
}

function runGlobalUiFixes() {
    syncAccountPurchaseModalActions();
    setupPreciseDesktopNavHover();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', runGlobalUiFixes);
} else {
    runGlobalUiFixes();
}
