<?php
/**
 * SixToFit — WordPress 404 template.
 * Place this file in the root of the active theme (or child theme).
 */
defined( 'ABSPATH' ) || exit;

status_header( 404 );
nocache_headers();

$af_404_home = home_url( '/' );
$af_404_shop = home_url( '/product/' ) ;
if ( ! is_string( $af_404_shop ) || '' === $af_404_shop || $af_404_home === $af_404_shop ) {
    $af_404_shop = '';
}
get_header("light");
?>
<style>
.af-error-page { direction: rtl; padding: clamp(32px, 7vw, 88px) 20px; background: #f9f9fb; color: #161618; }
.af-error-page, .af-error-page * { box-sizing: border-box; }
.af-error-page__card { max-width: 800px; margin: 0 auto; padding: clamp(28px, 6vw, 64px) clamp(20px, 5vw, 56px); border: 1px solid #eeeef3; border-radius: 32px; background: #fff; text-align: center; }
.af-error-page__code { margin: 0; color: #5247ff; font-size: clamp(88px, 18vw, 160px); font-weight: 800; line-height: 1.15; letter-spacing: -.06em; direction: ltr; }
.af-error-page__tag { margin: 12px 0 24px; color: #65656d; font-size: 14px; }
.af-error-page__title { margin: 0 0 16px; color: #161618; font-size: clamp(23px, 4vw, 34px); font-weight: 700; line-height: 1.7; }
.af-error-page__text { max-width: 540px; margin: 0 auto; color: #65656d; font-size: 16px; line-height: 2; }
.af-error-page__actions { display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; margin-top: 32px; }
.af-error-page .af-error-page__link { display: inline-flex; align-items: center; justify-content: center; min-height: 52px; padding: 12px 26px; border: 1px solid #5247ff; border-radius: 999px; background: #5247ff; color: #fff; font-size: 15px; font-weight: 600; line-height: 1.7; text-decoration: none; }
.af-error-page .af-error-page__link:hover { background: #4239d0; border-color: #4239d0; color: #fff; }
.af-error-page .af-error-page__link--secondary { background: #fff; color: #5247ff; }
.af-error-page .af-error-page__link--secondary:hover { background: #f1f0ff; color: #4239d0; }
.af-error-page .af-error-page__link:focus-visible { outline: 3px solid #161618; outline-offset: 5px; }
@media (max-width: 480px) {
    .af-error-page { padding: 32px 16px; }
    .af-error-page__card { border-radius: 24px; }
    .af-error-page__actions { flex-direction: column; }
    .af-error-page .af-error-page__link { width: 100%; }
}
</style>
<main id="af-error-page" class="af-error-page" lang="fa" dir="rtl" aria-labelledby="af-error-page-title">
    <section class="af-error-page__card">
        <p class="af-error-page__code" aria-hidden="true">404</p>
        <p class="af-error-page__tag">سیکس‌توفیت · صفحه پیدا نشد</p>
        <h1 id="af-error-page-title" class="af-error-page__title">این مسیر به مقصد نرسید!</h1>
        <p class="af-error-page__text">ممکن است آدرس را اشتباه وارد کرده باشید یا این صفحه جابه‌جا شده باشد. از صفحهٔ اصلی ادامه دهید و مسیر تناسب‌اندامتان را پیدا کنید.</p>
        <nav class="af-error-page__actions" aria-label="مسیرهای پیشنهادی">
            <a class="af-error-page__link" href="<?php echo esc_url( $af_404_home ); ?>">بازگشت به صفحهٔ اصلی</a>
            <?php if ( $af_404_shop ) : ?>
                <a class="af-error-page__link af-error-page__link--secondary" href="<?php echo esc_url( $af_404_shop ); ?>">مشاهدهٔ برنامه‌ها</a>
            <?php endif; ?>
        </nav>
    </section>
</main>
<?php get_footer(); ?>
