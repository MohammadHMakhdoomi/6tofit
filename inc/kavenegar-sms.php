<?php
/**
 * Kavenegar SMS Integration - Verify Lookup & Fallback SMS (OTP)
 * فایل: inc/kavenegar-sms.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Kavenegar_SMS' ) ) {
    class Kavenegar_SMS {

        private $api_key;
        private $template_name;

        public function __construct() {
            // کلید API کاوه‌نگار
            $this->api_key       = '4C73397665742F6465333046473743572B2F416D556D484C63367A52536C6C5A6D47357A54324E4D4B53383D';
            // نام الگوی تایید شده در بخش «اعتبارسنجی» پنل کاوه‌نگار
            $this->template_name = 'otp';
        }

        /**
         * ارسال کد اعتبارسنجی با متد verify/lookup + فال‌بک خودکار به sms/send
         */
        public function send_otp( $receptor, $token ) {
            $receptor = $this->normalize_phone( $receptor );

            if ( ! $receptor ) {
                return array(
                    'success' => false,
                    'message' => 'شماره موبایل معتبر نیست',
                );
            }

            // ۱. تلاش اول با متد Verify Lookup (خط خدماتی سریع)
            $lookup_url = "https://api.kavenegar.com/v1/{$this->api_key}/verify/lookup.json";
            $params     = array(
                'receptor' => $receptor,
                'token'    => $token,
                'template' => $this->template_name,
            );

            $response = $this->request( $lookup_url, $params );

            if ( isset( $response['return']['status'] ) && (int) $response['return']['status'] === 200 ) {
                return array(
                    'success' => true,
                    'message' => 'کد تایید با موفقیت پیامک شد',
                    'data'    => $response['entries'][0] ?? null,
                );
            }

            // ۲. فال‌بک: اگر الگوی otp در پنل کاوه‌نگار تایید نشده بود، با پیامک عادی ارسال کن
            $send_url    = "https://api.kavenegar.com/v1/{$this->api_key}/sms/send.json";
            $send_params = array(
                'receptor' => $receptor,
                'message'  => "سیکس‌توفیت\nکد تایید شما: {$token}",
            );
            $fallback_res = $this->request( $send_url, $send_params );

            if ( isset( $fallback_res['return']['status'] ) && (int) $fallback_res['return']['status'] === 200 ) {
                return array(
                    'success' => true,
                    'message' => 'کد تایید با موفقیت ارسال شد',
                    'data'    => $fallback_res['entries'][0] ?? null,
                );
            }

            $error_message = $response['return']['message'] ?? ( $fallback_res['return']['message'] ?? 'خطا در ارسال پیامک کاوه‌نگار' );
            $error_status  = $response['return']['status'] ?? 0;

            return array(
                'success' => false,
                'message' => $error_message . ' (کد وضعیت کاوه‌نگار: ' . $error_status . ')',
                'code'    => $error_status,
            );
        }

        /**
         * نرمال‌سازی شماره موبایل (پشتیبانی از اعداد فارسی/عربی و پیش‌شماره +98)
         */
        public function normalize_phone( $phone ) {
            $persian = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' );
            $english = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
            $phone   = str_replace( $persian, $english, (string) $phone );
            $phone   = preg_replace( '/[^0-9]/', '', $phone );

            if ( strpos( $phone, '0098' ) === 0 && strlen( $phone ) === 14 ) {
                $phone = '0' . substr( $phone, 4 );
            } elseif ( strpos( $phone, '98' ) === 0 && strlen( $phone ) === 12 ) {
                $phone = '0' . substr( $phone, 2 );
            } elseif ( strpos( $phone, '9' ) === 0 && strlen( $phone ) === 10 ) {
                $phone = '0' . $phone;
            }

            if ( preg_match( '/^09[0-9]{9}$/', $phone ) ) {
                return $phone;
            }

            return false;
        }

        /**
         * ارسال درخواست به API کاوه‌نگار (با اجبار IPv4 برای جلوگیری از تایم‌اوت سرور)
         */
        public function request( $url, $params = array() ) {
            $full_url = $url . '?' . http_build_query( $params );

            if ( function_exists( 'curl_init' ) ) {
                $ch = curl_init();
                $curl_opts = array(
                    CURLOPT_URL            => $full_url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_CONNECTTIMEOUT => 5,
                    CURLOPT_TIMEOUT        => 10,
                    CURLOPT_HTTPHEADER     => array( 'Accept: application/json' ),
                );
                if ( defined( 'CURL_IPRESOLVE_V4' ) ) {
                    $curl_opts[ CURLOPT_IPRESOLVE ] = CURL_IPRESOLVE_V4;
                }
                curl_setopt_array( $ch, $curl_opts );

                $result = curl_exec( $ch );
                $error  = curl_error( $ch );
                curl_close( $ch );

                if ( ! $error && ! empty( $result ) ) {
                    $decoded = json_decode( $result, true );
                    if ( is_array( $decoded ) ) {
                        return $decoded;
                    }
                }
            }

            // فال‌بک به wp_remote_get در صورت غیرفعال بودن cURL
            $wp_res = wp_remote_get( $full_url, array(
                'timeout'   => 10,
                'sslverify' => false,
                'headers'   => array( 'Accept' => 'application/json' ),
            ) );

            if ( ! is_wp_error( $wp_res ) ) {
                $decoded = json_decode( wp_remote_retrieve_body( $wp_res ), true );
                if ( is_array( $decoded ) ) {
                    return $decoded;
                }
            }

            return array(
                'return' => array(
                    'status'  => 0,
                    'message' => is_wp_error( $wp_res ) ? $wp_res->get_error_message() : 'خطا در اتصال از هاست به سرور کاوه‌نگار',
                ),
            );
        }
    }
}

if ( ! function_exists( 'generate_otp_code' ) ) {
    function generate_otp_code( $length = 4 ) {
        return str_pad( (string) wp_rand( 0, pow( 10, $length ) - 1 ), $length, '0', STR_PAD_LEFT );
    }
}

if ( ! function_exists( 'af_normalize_otp_identifier' ) ) {
    function af_normalize_otp_identifier( $identifier ) {
        $persian    = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' );
        $english    = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
        $identifier = strtolower( trim( str_replace( $persian, $english, (string) $identifier ) ) );
        if ( ! is_email( $identifier ) ) {
            $digits = preg_replace( '/[^0-9]/', '', $identifier );
            if ( strpos( $digits, '0098' ) === 0 && strlen( $digits ) === 14 ) {
                $digits = '0' . substr( $digits, 4 );
            } elseif ( strpos( $digits, '98' ) === 0 && strlen( $digits ) === 12 ) {
                $digits = '0' . substr( $digits, 2 );
            } elseif ( strpos( $digits, '9' ) === 0 && strlen( $digits ) === 10 ) {
                $digits = '0' . $digits;
            }
            if ( ! empty( $digits ) ) {
                $identifier = $digits;
            }
        }
        return $identifier;
    }
}

if ( ! function_exists( 'save_otp' ) ) {
    function save_otp( $phone, $code, $expire_seconds = 300 ) {
        $norm = af_normalize_otp_identifier( $phone );
        $key  = 'auth_otp_' . md5( $norm );
        set_transient( $key, array(
            'code' => (string) trim( $code ),
            'time' => time(),
        ), max( 300, (int) $expire_seconds ) );
    }
}

if ( ! function_exists( 'verify_otp' ) ) {
    function verify_otp( $phone, $code ) {
        $norm    = af_normalize_otp_identifier( $phone );
        $persian = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' );
        $english = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
        $code    = trim( str_replace( $persian, $english, (string) $code ) );

        $key  = 'auth_otp_' . md5( $norm );
        $data = get_transient( $key );

        if ( ! $data || ! isset( $data['code'] ) ) {
            return array(
                'success' => false,
                'message' => 'کد منقضی شده است. لطفاً مجدداً درخواست دهید.',
            );
        }

        if ( (string) $data['code'] !== (string) $code ) {
            return array(
                'success' => false,
                'message' => 'کد وارد شده اشتباه است.',
            );
        }

        delete_transient( $key );

        return array(
            'success' => true,
            'message' => 'کد تایید صحیح است.',
        );
    }
}