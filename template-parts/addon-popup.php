<?php
/**
 * Addons Only Popup - Synced with Product Page (CURCY Compatible)
 */
if ( ! function_exists( 'render_addons_popup' ) ) {
    function render_addons_popup( $product_id = 0 ) {
        if ( ! $product_id ) {
            global $product;
            $product_id = ( $product && is_a( $product, 'WC_Product' ) ) ? $product->get_id() : 0;
        }

        $product = wc_get_product( $product_id );
        if ( ! $product ) return;

        $addons = get_post_meta( $product_id, '_product_addons', true );
        if ( ! is_array( $addons ) ) $addons = array();

        // تشخیص ارز
        $current_currency = get_woocommerce_currency();
        if ( class_exists( 'WOOMULTI_CURRENCY_Data' ) ) {
            $current_currency = WOOMULTI_CURRENCY_Data::get_ins()->get_current_currency();
        }
        $is_usd = ( $current_currency === 'USD' );

        // اگر تابع تبدیل قیمت Addonها وجود ندارد (مبلغ دلاری ثابت یا تبدیل با نرخ)، آن را تعریف می‌کنیم
        if ( ! function_exists( 'af_get_addon_converted_price' ) ) {
            function af_get_addon_converted_price( $addon ) {
                $base_price = isset( $addon['price'] ) ? floatval( $addon['price'] ) : 0;
                if ( class_exists( 'WOOMULTI_CURRENCY_Data' ) ) {
                    $curcy_data = WOOMULTI_CURRENCY_Data::get_ins();
                    if ( $curcy_data->get_current_currency() === 'USD' ) {
                        if ( isset( $addon['price_usd'] ) && $addon['price_usd'] !== '' ) {
                            return floatval( $addon['price_usd'] );
                        }
                        if ( function_exists( 'wmc_get_price' ) ) {
                            return floatval( wmc_get_price( $base_price ) );
                        }
                    }
                }
                return $base_price;
            }
        }

        ob_start();
        ?>
        <style>
        .af-addons-popup-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(13,13,13,0.56); display: none; align-items: center; justify-content: center; z-index: 99999; backdrop-filter: blur(50px); -webkit-backdrop-filter: blur(50px); }
        .af-addons-popup-overlay.active { display: flex !important; }
        .af-addons-popup-content { background: #F7F7F8; border-radius: 40px; max-width: 46%; min-width: 700px; width: 100%; max-height: 90vh; overflow: hidden; position: relative; display: flex; flex-direction: column; }
        .af-addons-header { padding: 28px 32px 10px; position: relative; text-align: center; }
        .af-addons-close { position: absolute; top: 18px; right: 18px; background: none; border: none; cursor: pointer; padding: 0; z-index: 10; }
        .af-addons-close img { width: 40px; height: 40px; }
        .af-addons-title { font-size: 24px; font-weight: 600; color: #000; margin: 0 0 8px 0; }
        .af-addons-body { padding: 30px 150px 50px; overflow-y: auto; flex: 1; }
        .af-addons-cards { display: grid; grid-template-columns: repeat(1, 1fr); gap: 16px; }
        .af-addon-card { border: 1.5px solid rgba(0,0,0,0.08); border-radius: 20px; padding: 18px 16px; background: #fff; cursor: pointer; transition: all 0.25s ease; text-align: right; }
        .af-addon-card:hover { border-color: rgba(82, 71, 255, 0.35); }
        .af-addon-card.selected { border-color: #5247FF; }
        .af-addon-checkbox-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .af-addon-checkbox { width: 20px; height: 20px; accent-color: #5247FF; cursor: pointer; flex-shrink: 0; }
        .af-addon-title { font-size: 15px; font-weight: 500; color: #161618; margin: 0; cursor: pointer; }
        .af-addon-description { font-size: 13px; color: #65656D; line-height: 1.6; margin-bottom: 14px; }
        .af-addon-price-row { display: flex; align-items: center; gap: 6px; }
        .af-addon-price { font-size: 15px; font-weight: 500; color: #161618; }
        .af-addon-plus { font-size: 16px; color: #5247FF; font-weight: 600; }
        .af-addons-confirm-wrapper { padding: 20px 32px 28px; display: flex; justify-content: center; background: #F7F7F8; }
        .af-addons-confirm-btn { background: #5247FF; color: #fff; border: none; border-radius: 999px; padding: 14px 48px; font-size: 16px; font-weight: 500; cursor: pointer; font-family: 'iranyekan', sans-serif; transition: background 0.25s ease; min-width: 200px; }
        .af-addons-confirm-btn:hover { background: #4338e0; }
        @media only screen and (max-width: 768px) {
            .af-addons-popup-content { min-width: unset; width: 100%; height: 100%; max-height: 100%; border-radius: 0; max-width: unset; }
            .af-addons-header { padding: 20px 20px 8px; }
            .af-addons-title { font-size: 20px; }
            .af-addons-body { padding: 10px 16px 20px; }
            .af-addons-cards { grid-template-columns: 1fr; gap: 12px; }
            .af-addons-confirm-wrapper { padding: 16px 20px 24px; }
            .af-addons-confirm-btn { width: 100%; max-width: 100%; }
        }
        </style>

        <div class="af-addons-popup-overlay" id="af-addons-popup">
            <div class="af-addons-popup-content">
                <div class="af-addons-header">
                    <button class="af-addons-close" onclick="hideAfAddonsPopup()">
                        <img src="https://6tofit.com/wp-content/uploads/2025/10/State.svg" alt="Close">
                    </button>
                    <h2 class="af-addons-title">افزودن خدمات پرو</h2>
                </div>

                <div class="af-addons-body">
                    <?php if ( empty( $addons ) ) : ?>
                        <p style="text-align:center;color:#999;padding:40px 0;">هیچ خدمت اضافی تعریف نشده است.</p>
                    <?php else : ?>
                        <div class="af-addons-cards">
                            <?php foreach ( $addons as $index => $addon ) :
                                $title       = esc_html( $addon['title'] ?? '' );
                                $description = esc_html( $addon['description'] ?? '' );
                                $price       = af_get_addon_converted_price( $addon );
                                
                                if ( $is_usd ) {
                                    $price_html = '$' . number_format( $price, ( floor( $price ) == $price ? 0 : 2 ), '.', ',' );
                                    $currency_label = 'دلار';
                                } else {
                                    $price_html = number_format( $price, 0, '', '.' );
                                    $currency_label = 'تومان';
                                }
                            ?>
                                <div class="af-addon-card" data-index="<?php echo esc_attr( $index ); ?>" data-price="<?php echo esc_attr( $price ); ?>">
                                    <div class="af-addon-checkbox-row">
                                        <input type="checkbox"
                                               id="af_addon_<?php echo esc_attr( $index ); ?>"
                                               class="af-addon-checkbox"
                                               value="<?php echo esc_attr( $index ); ?>"
                                               data-price="<?php echo esc_attr( $price ); ?>">
                                        <label for="af_addon_<?php echo esc_attr( $index ); ?>" class="af-addon-title"><?php echo $title; ?></label>
                                    </div>
                                    <div class="af-addon-description"><?php echo $description; ?></div>
                                    <div class="af-addon-price-row">
                                        <span class="af-addon-price" style="direction: ltr; display: inline-block;"><?php echo $price_html; ?></span>
                                        <span style="color:#65656D;font-size:13px;margin-right: 4px;"><?php echo $currency_label; ?></span>
                                        <span class="af-addon-plus">+</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="af-addons-confirm-wrapper">
                    <button type="button" class="af-addons-confirm-btn" onclick="handleAfAddonsConfirm()">
                        تایید
                    </button>
                </div>
            </div>
        </div>

        <script>
        (function() {
            function syncFromProductPage() {
                document.querySelectorAll('.af-addon-checkbox').forEach(popupCb => {
                    const index = popupCb.value;
                    const productCb = document.querySelector(`.addon-checkbox[value="${index}"]`);
                    if (productCb) popupCb.checked = productCb.checked;
                    const card = popupCb.closest('.af-addon-card');
                    if (card) card.classList.toggle('selected', popupCb.checked);
                });
            }

            function syncToProductPage() {
                document.querySelectorAll('.af-addon-checkbox').forEach(popupCb => {
                    const index = popupCb.value;
                    const productCb = document.querySelector(`.addon-checkbox[value="${index}"]`);
                    if (productCb) {
                        productCb.checked = popupCb.checked;
                        productCb.dispatchEvent(new Event('change'));
                    }
                });
            }

            function updatePopupCards() {
                document.querySelectorAll('.af-addon-checkbox').forEach(cb => {
                    const card = cb.closest('.af-addon-card');
                    if (card) card.classList.toggle('selected', cb.checked);
                });
            }

            document.querySelectorAll('.af-addon-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    if (e.target.tagName === 'INPUT' || e.target.tagName === 'LABEL') return;
                    const checkbox = this.querySelector('.af-addon-checkbox');
                    if (checkbox) {
                        checkbox.checked = !checkbox.checked;
                        checkbox.dispatchEvent(new Event('change'));
                    }
                });
            });

            document.querySelectorAll('.af-addon-checkbox').forEach(cb => {
                cb.addEventListener('change', function() { updatePopupCards(); });
            });

            window.showAfAddonsPopup = function() {
                const popup = document.getElementById('af-addons-popup');
                if (!popup) return;
                syncFromProductPage();
                popup.classList.add('active');
            };

            window.hideAfAddonsPopup = function() {
                const popup = document.getElementById('af-addons-popup');
                if (popup) popup.classList.remove('active');
            };

            document.getElementById('af-addons-popup')?.addEventListener('click', function(e) {
                if (e.target === this) hideAfAddonsPopup();
            });

            window.handleAfAddonsConfirm = function() {
                syncToProductPage();
                hideAfAddonsPopup();
            };
        })();
        </script>
        <?php
        echo ob_get_clean();
    }
}