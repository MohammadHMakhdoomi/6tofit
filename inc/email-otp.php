<?php
/**
 * Email OTP System with Professional Template + Error Catching
 * فایل: inc/email-otp.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Email_OTP' ) ) {
    class Email_OTP {

        private $from_email;
        private $from_name;
        private $site_name;
        public  $last_error = '';

        public function __construct() {
            $this->site_name  = get_bloginfo( 'name' ) ?: '6toFit';
            $host             = parse_url( home_url(), PHP_URL_HOST ) ?: '6tofit.com';
            $host             = preg_replace( '/^www\./i', '', $host );
            $this->from_email = 'noreply@' . $host;
            $this->from_name  = $this->site_name;
        }

        public function send_otp( $email, $code ) {
            $email = sanitize_email( $email );

            if ( ! is_email( $email ) ) {
                return array(
                    'success' => false,
                    'message' => 'آدرس ایمیل معتبر نیست',
                );
            }

            $self = $this;
            add_action( 'wp_mail_failed', function( $wp_error ) use ( $self ) {
                if ( is_wp_error( $wp_error ) ) {
                    $self->last_error = $wp_error->get_error_message();
                }
            } );

            $subject   = 'کد تایید ورود به ' . $this->site_name . ': ' . $code;
            $html_body = $this->get_email_template( $code );

            $headers = array(
                'Content-Type: text/html; charset=UTF-8',
                'From: ' . $this->from_name . ' <' . $this->from_email . '>',
                'Reply-To: ' . $this->from_email,
            );

            $sent = @wp_mail( $email, $subject, $html_body, $headers );

            // تلاش دوم بدون هدر From سفارشی در صورتی که پلاگین SMTP هدر خودش را اجبار کرده باشد
            if ( ! $sent ) {
                $sent = @wp_mail( $email, $subject, $html_body, array( 'Content-Type: text/html; charset=UTF-8' ) );
            }

            if ( $sent ) {
                return array(
                    'success' => true,
                    'message' => 'کد تایید به ایمیل شما ارسال شد',
                );
            }

            return array(
                'success' => false,
                'message' => 'خطا در ارسال ایمیل: ' . ( $this->last_error ?: 'سرویس ایمیل سرور پاسخ نداد' ),
            );
        }

        private function get_email_template( $code ) {
            $logo_url = 'https://6tofit.com/wp-content/uploads/2025/10/6toFit_logo_Black_2.svg';
            $year     = date( 'Y' );

            return '<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head><meta charset="UTF-8"><title>کد تایید</title></head>
<body style="margin:0;padding:0;background-color:#f4f4f7;font-family:Tahoma,Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f7;padding:40px 0;">
    <tr>
      <td align="center">
        <table width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;background:#ffffff;border-radius:16px;overflow:hidden;">
          <tr>
            <td style="background:#5247FF;padding:28px 40px;text-align:center;">
              <img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $this->site_name ) . '" style="height:36px;max-width:160px;">
            </td>
          </tr>
          <tr>
            <td style="padding:40px 40px 20px;text-align:center;">
              <h1 style="margin:0 0 12px;font-size:22px;color:#161618;font-weight:700;">کد تایید ورود</h1>
              <p style="margin:0 0 28px;font-size:15px;color:#6B6B6F;line-height:1.7;">کد تایید شما برای ورود به حساب کاربری:</p>
              <div style="background:#F7F7F8;border-radius:14px;padding:20px 30px;display:inline-block;margin-bottom:28px;">
                <span style="font-size:32px;font-weight:700;letter-spacing:8px;color:#5247FF;font-family:monospace;">' . esc_html( $code ) . '</span>
              </div>
              <p style="margin:0 0 8px;font-size:14px;color:#9B9BA1;">این کد تا ۵ دقیقه معتبر است.</p>
            </td>
          </tr>
          <tr>
            <td style="padding:24px 40px 32px;text-align:center;border-top:1px solid #eee;">
              <p style="margin:0;font-size:12px;color:#9B9BA1;">© ' . $year . ' ' . esc_html( $this->site_name ) . '</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>';
        }
    }
}