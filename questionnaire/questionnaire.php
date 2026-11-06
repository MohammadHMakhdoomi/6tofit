<?php
/**
 * ==========================================================
 * Questionnaire System - Core (Guest + Logged-in Support)
 * Prefix: af_questionnaire_
 * ==========================================================
 *
 * - بخش لاگین کاملاً حذف شده است.
 * - کاربر مهمان می‌تواند پرسشنامه را پر کند (ذخیره در جدول موقت با guest_token).
 * - کاربر لاگین‌شده مثل قبل در جداول اصلی ذخیره می‌شود.
 * - تمام محتوا و سوالات در فایل questionnaire-content.php قرار دارد.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
 * تنظیمات کلی
 * ========================================================== */

define( 'AF_QUESTIONNAIRE_TOTAL_SECTIONS', 6 );
define( 'AF_QUESTIONNAIRE_LAST_ANSWER_SECTION', 5 );
define( 'AF_QUESTIONNAIRE_NONCE_ACTION', 'af_questionnaire_nonce' );
define( 'AF_QUESTIONNAIRE_DB_VERSION', '2.0.0' );
define( 'AF_QUESTIONNAIRE_DIR', trailingslashit( dirname( __FILE__ ) ) );

function af_questionnaire_calculate_base_uri() {
	$dir            = AF_QUESTIONNAIRE_DIR;
	$template_dir   = trailingslashit( get_template_directory() );
	$stylesheet_dir = trailingslashit( get_stylesheet_directory() );

	if ( strpos( $dir, $stylesheet_dir ) === 0 ) {
		$relative = ltrim( substr( $dir, strlen( $stylesheet_dir ) ), '/' );
		return trailingslashit( get_stylesheet_directory_uri() . '/' . $relative );
	}
	if ( strpos( $dir, $template_dir ) === 0 ) {
		$relative = ltrim( substr( $dir, strlen( $template_dir ) ), '/' );
		return trailingslashit( get_template_directory_uri() . '/' . $relative );
	}
	return trailingslashit( get_template_directory_uri() );
}
define( 'AF_QUESTIONNAIRE_URI', af_questionnaire_calculate_base_uri() );


/* ==========================================================
 * نام جداول
 * ========================================================== */

function af_questionnaire_table_attempts() {
	global $wpdb;
	return $wpdb->prefix . 'questionnaire';
}

function af_questionnaire_table_answers() {
	global $wpdb;
	return $wpdb->prefix . 'questionnaire_answers';
}

/** جدول موقت مخصوص مهمان‌ها */
function af_questionnaire_table_temp_attempts() {
	global $wpdb;
	return $wpdb->prefix . 'questionnaire_temp';
}

function af_questionnaire_table_temp_answers() {
	global $wpdb;
	return $wpdb->prefix . 'questionnaire_temp_answers';
}


/* ==========================================================
 * ساخت جداول
 * ========================================================== */

function af_questionnaire_maybe_create_tables() {
	$installed = get_option( 'af_questionnaire_db_version' );
	if ( $installed === AF_QUESTIONNAIRE_DB_VERSION ) {
		return;
	}

	global $wpdb;
	$charset = $wpdb->get_charset_collate();

	$table_attempts = af_questionnaire_table_attempts();
	$table_answers  = af_questionnaire_table_answers();
	$table_temp_a   = af_questionnaire_table_temp_attempts();
	$table_temp_ans = af_questionnaire_table_temp_answers();

	$sql_attempts = "CREATE TABLE {$table_attempts} (
		id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		user_id BIGINT UNSIGNED NOT NULL,
		status VARCHAR(20) NOT NULL DEFAULT 'in_progress',
		current_section SMALLINT UNSIGNED NOT NULL DEFAULT 1,
		current_page SMALLINT UNSIGNED NOT NULL DEFAULT 1,
		current_question SMALLINT UNSIGNED NOT NULL DEFAULT 1,
		last_answered_section SMALLINT UNSIGNED NULL,
		last_answered_page SMALLINT UNSIGNED NULL,
		last_answered_question SMALLINT UNSIGNED NULL,
		started_at DATETIME NOT NULL,
		updated_at DATETIME NOT NULL,
		completed_at DATETIME NULL,
		PRIMARY KEY  (id),
		KEY user_id (user_id),
		KEY status (status)
	) {$charset};";

	$sql_answers = "CREATE TABLE {$table_answers} (
		id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		questionnaire_id BIGINT UNSIGNED NOT NULL,
		user_id BIGINT UNSIGNED NOT NULL,
		section SMALLINT UNSIGNED NOT NULL,
		page SMALLINT UNSIGNED NOT NULL,
		question_key VARCHAR(100) NOT NULL,
		answer LONGTEXT NULL,
		updated_at DATETIME NOT NULL,
		PRIMARY KEY  (id),
		KEY questionnaire_id (questionnaire_id),
		KEY user_id (user_id),
		KEY question_key (question_key)
	) {$charset};";

	// جدول موقت مهمان
	$sql_temp_a = "CREATE TABLE {$table_temp_a} (
		id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		guest_token VARCHAR(64) NOT NULL,
		status VARCHAR(20) NOT NULL DEFAULT 'in_progress',
		current_section SMALLINT UNSIGNED NOT NULL DEFAULT 1,
		current_page SMALLINT UNSIGNED NOT NULL DEFAULT 1,
		current_question SMALLINT UNSIGNED NOT NULL DEFAULT 1,
		last_answered_section SMALLINT UNSIGNED NULL,
		last_answered_page SMALLINT UNSIGNED NULL,
		last_answered_question SMALLINT UNSIGNED NULL,
		started_at DATETIME NOT NULL,
		updated_at DATETIME NOT NULL,
		completed_at DATETIME NULL,
		PRIMARY KEY  (id),
		KEY guest_token (guest_token),
		KEY status (status)
	) {$charset};";

	$sql_temp_ans = "CREATE TABLE {$table_temp_ans} (
		id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		questionnaire_id BIGINT UNSIGNED NOT NULL,
		guest_token VARCHAR(64) NOT NULL,
		section SMALLINT UNSIGNED NOT NULL,
		page SMALLINT UNSIGNED NOT NULL,
		question_key VARCHAR(100) NOT NULL,
		answer LONGTEXT NULL,
		updated_at DATETIME NOT NULL,
		PRIMARY KEY  (id),
		KEY questionnaire_id (questionnaire_id),
		KEY guest_token (guest_token),
		KEY question_key (question_key)
	) {$charset};";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql_attempts );
	dbDelta( $sql_answers );
	dbDelta( $sql_temp_a );
	dbDelta( $sql_temp_ans );

	update_option( 'af_questionnaire_db_version', AF_QUESTIONNAIRE_DB_VERSION );
}
add_action( 'init', 'af_questionnaire_maybe_create_tables' );


/* ==========================================================
 * Helper: تشخیص مهمان / لاگین + گرفتن شناسه
 * ========================================================== */

function af_questionnaire_is_guest() {
	return ! is_user_logged_in();
}

function af_questionnaire_get_guest_token() {
	$token = isset( $_COOKIE['af_q_guest_token'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['af_q_guest_token'] ) ) : '';
	if ( empty( $token ) || strlen( $token ) < 20 ) {
		$token = wp_generate_uuid4();
		// ست کردن کوکی برای ۳۰ روز
		setcookie( 'af_q_guest_token', $token, time() + ( 30 * DAY_IN_SECONDS ), COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true );
		$_COOKIE['af_q_guest_token'] = $token;
	}
	return $token;
}

function af_questionnaire_get_current_identity() {
	if ( is_user_logged_in() ) {
		return array(
			'type'    => 'user',
			'user_id' => get_current_user_id(),
			'token'   => null,
		);
	}
	return array(
		'type'    => 'guest',
		'user_id' => 0,
		'token'   => af_questionnaire_get_guest_token(),
	);
}


/* ==========================================================
 * توابع مدیریت Attempt (لاگین + مهمان)
 * ========================================================== */

function af_questionnaire_get_in_progress_attempt( $identity = null ) {
	global $wpdb;
	if ( null === $identity ) {
		$identity = af_questionnaire_get_current_identity();
	}

	if ( 'user' === $identity['type'] ) {
		$table = af_questionnaire_table_attempts();
		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$table} WHERE user_id = %d AND status = %s ORDER BY id DESC LIMIT 1",
				$identity['user_id'],
				'in_progress'
			)
		);
	}

	// مهمان
	$table = af_questionnaire_table_temp_attempts();
	return $wpdb->get_row(
		$wpdb->prepare(
			"SELECT * FROM {$table} WHERE guest_token = %s AND status = %s ORDER BY id DESC LIMIT 1",
			$identity['token'],
			'in_progress'
		)
	);
}

function af_questionnaire_get_attempt_by_id( $attempt_id, $identity = null ) {
	global $wpdb;
	if ( null === $identity ) {
		$identity = af_questionnaire_get_current_identity();
	}

	if ( 'user' === $identity['type'] ) {
		$table = af_questionnaire_table_attempts();
		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$table} WHERE id = %d AND user_id = %d LIMIT 1",
				$attempt_id,
				$identity['user_id']
			)
		);
	}

	$table = af_questionnaire_table_temp_attempts();
	return $wpdb->get_row(
		$wpdb->prepare(
			"SELECT * FROM {$table} WHERE id = %d AND guest_token = %s LIMIT 1",
			$attempt_id,
			$identity['token']
		)
	);
}

function af_questionnaire_get_status( $identity = null ) {
	$attempt = af_questionnaire_get_in_progress_attempt( $identity );
	if ( ! $attempt ) {
		return array( 'has_attempt' => false );
	}
	return array(
		'has_attempt'      => true,
		'questionnaire_id' => (int) $attempt->id,
		'current_section'  => (int) $attempt->current_section,
		'current_page'     => (int) $attempt->current_page,
		'current_question' => (int) $attempt->current_question,
	);
}

function af_questionnaire_start( $identity = null ) {
	global $wpdb;
	if ( null === $identity ) {
		$identity = af_questionnaire_get_current_identity();
	}
	$now = current_time( 'mysql' );

	if ( 'user' === $identity['type'] ) {
		$table = af_questionnaire_table_attempts();
		$wpdb->insert(
			$table,
			array(
				'user_id'                => $identity['user_id'],
				'status'                 => 'in_progress',
				'current_section'        => 1,
				'current_page'           => 1,
				'current_question'       => 1,
				'last_answered_section'  => null,
				'last_answered_page'     => null,
				'last_answered_question' => null,
				'started_at'             => $now,
				'updated_at'             => $now,
				'completed_at'           => null,
			),
			array( '%d', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s' )
		);
		$id = (int) $wpdb->insert_id;
		return af_questionnaire_get_attempt_by_id( $id, $identity );
	}

	// مهمان
	$table = af_questionnaire_table_temp_attempts();
	$wpdb->insert(
		$table,
		array(
			'guest_token'            => $identity['token'],
			'status'                 => 'in_progress',
			'current_section'        => 1,
			'current_page'           => 1,
			'current_question'       => 1,
			'last_answered_section'  => null,
			'last_answered_page'     => null,
			'last_answered_question' => null,
			'started_at'             => $now,
			'updated_at'             => $now,
			'completed_at'           => null,
		),
		array( '%s', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s' )
	);
	$id = (int) $wpdb->insert_id;
	return af_questionnaire_get_attempt_by_id( $id, $identity );
}

function af_questionnaire_resume( $identity = null ) {
	return af_questionnaire_get_in_progress_attempt( $identity );
}

function af_questionnaire_restart( $identity = null ) {
	global $wpdb;
	if ( null === $identity ) {
		$identity = af_questionnaire_get_current_identity();
	}

	$current = af_questionnaire_get_in_progress_attempt( $identity );
	if ( $current ) {
		$table = ( 'user' === $identity['type'] ) ? af_questionnaire_table_attempts() : af_questionnaire_table_temp_attempts();
		$wpdb->update(
			$table,
			array(
				'status'     => 'abandoned',
				'updated_at' => current_time( 'mysql' ),
			),
			array( 'id' => $current->id ),
			array( '%s', '%s' ),
			array( '%d' )
		);
	}
	return af_questionnaire_start( $identity );
}

/**
 * ذخیره پاسخ (لاگین یا مهمان)
 */
function af_questionnaire_save_answer( $identity, $questionnaire_id, $section, $page, $question_key, $answer, $question_number, $next_position = null ) {
	global $wpdb;

	$attempt = af_questionnaire_get_attempt_by_id( $questionnaire_id, $identity );
	if ( ! $attempt || $attempt->status !== 'in_progress' ) {
		return new WP_Error( 'invalid_attempt', 'Attempt یافت نشد یا فعال نیست.' );
	}

	$now = current_time( 'mysql' );
	$answer_value = is_array( $answer ) ? wp_json_encode( $answer ) : $answer;

	if ( 'user' === $identity['type'] ) {
		$answers_table  = af_questionnaire_table_answers();
		$attempts_table = af_questionnaire_table_attempts();

		$existing_id = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT id FROM {$answers_table} WHERE questionnaire_id = %d AND question_key = %s LIMIT 1",
				$questionnaire_id,
				$question_key
			)
		);

		if ( $existing_id ) {
			$wpdb->update(
				$answers_table,
				array(
					'answer'     => $answer_value,
					'section'    => $section,
					'page'       => $page,
					'updated_at' => $now,
				),
				array( 'id' => $existing_id ),
				array( '%s', '%d', '%d', '%s' ),
				array( '%d' )
			);
		} else {
			$wpdb->insert(
				$answers_table,
				array(
					'questionnaire_id' => $questionnaire_id,
					'user_id'          => $identity['user_id'],
					'section'          => $section,
					'page'             => $page,
					'question_key'     => $question_key,
					'answer'           => $answer_value,
					'updated_at'       => $now,
				),
				array( '%d', '%d', '%d', '%d', '%s', '%s', '%s' )
			);
		}
	} else {
		// مهمان
		$answers_table  = af_questionnaire_table_temp_answers();
		$attempts_table = af_questionnaire_table_temp_attempts();

		$existing_id = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT id FROM {$answers_table} WHERE questionnaire_id = %d AND question_key = %s LIMIT 1",
				$questionnaire_id,
				$question_key
			)
		);

		if ( $existing_id ) {
			$wpdb->update(
				$answers_table,
				array(
					'answer'     => $answer_value,
					'section'    => $section,
					'page'       => $page,
					'updated_at' => $now,
				),
				array( 'id' => $existing_id ),
				array( '%s', '%d', '%d', '%s' ),
				array( '%d' )
			);
		} else {
			$wpdb->insert(
				$answers_table,
				array(
					'questionnaire_id' => $questionnaire_id,
					'guest_token'      => $identity['token'],
					'section'          => $section,
					'page'             => $page,
					'question_key'     => $question_key,
					'answer'           => $answer_value,
					'updated_at'       => $now,
				),
				array( '%d', '%s', '%d', '%d', '%s', '%s', '%s' )
			);
		}
	}

	// آپدیت موقعیت
	$update_data = array(
		'last_answered_section'  => $section,
		'last_answered_page'     => $page,
		'last_answered_question' => (int) $question_number,
		'updated_at'             => $now,
	);
	$update_format = array( '%d', '%d', '%d', '%s' );

	if ( is_array( $next_position ) ) {
		$update_data['current_section']  = $next_position['section'];
		$update_data['current_page']     = $next_position['page'];
		$update_data['current_question'] = $next_position['question'];
		$update_format[] = '%d';
		$update_format[] = '%d';
		$update_format[] = '%d';
	}

	$wpdb->update(
		$attempts_table,
		$update_data,
		array( 'id' => $questionnaire_id ),
		$update_format,
		array( '%d' )
	);

	return true;
}

function af_questionnaire_complete( $identity, $questionnaire_id ) {
	global $wpdb;
	$attempt = af_questionnaire_get_attempt_by_id( $questionnaire_id, $identity );
	if ( ! $attempt ) {
		return new WP_Error( 'invalid_attempt', 'Attempt یافت نشد.' );
	}

	$table = ( 'user' === $identity['type'] ) ? af_questionnaire_table_attempts() : af_questionnaire_table_temp_attempts();
	$now   = current_time( 'mysql' );

	$wpdb->update(
		$table,
		array(
			'status'          => 'completed',
			'completed_at'    => $now,
			'updated_at'      => $now,
			'current_section' => AF_QUESTIONNAIRE_TOTAL_SECTIONS,
			'current_page'    => 1,
			'current_question'=> 1,
		),
		array( 'id' => $questionnaire_id ),
		array( '%s', '%s', '%s', '%d', '%d', '%d' ),
		array( '%d' )
	);
	return true;
}

/**
 * گرفتن همه پاسخ‌های یک Attempt (برای دسترسی لایو به جواب‌های قبلی)
 */
function af_questionnaire_get_answers( $identity, $questionnaire_id ) {
	global $wpdb;
	$attempt = af_questionnaire_get_attempt_by_id( $questionnaire_id, $identity );
	if ( ! $attempt ) {
		return array();
	}

	if ( 'user' === $identity['type'] ) {
		$table = af_questionnaire_table_answers();
		$rows  = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT question_key, answer, section, page FROM {$table} WHERE questionnaire_id = %d",
				$questionnaire_id
			)
		);
	} else {
		$table = af_questionnaire_table_temp_answers();
		$rows  = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT question_key, answer, section, page FROM {$table} WHERE questionnaire_id = %d",
				$questionnaire_id
			)
		);
	}

	$result = array();
	if ( $rows ) {
		foreach ( $rows as $row ) {
			$result[ $row->question_key ] = $row->answer;
		}
	}
	return $result;
}


/* ==========================================================
 * Enqueue
 * ==========================================================
 * استایل‌ها و اسکریپت‌ها به صورت inline داخل questionnaire-content.php
 * قرار گرفته‌اند. دیگر نیازی به فایل‌های questionnaire.css و questionnaire.js نیست.
 * ========================================================== */

// function af_questionnaire_enqueue_assets() { ... }  // غیرفعال شد - همه چیز inline است


/* ==========================================================
 * Render Helpers
 * ========================================================== */

function af_questionnaire_render_popup() {
	static $already = false;
	if ( $already ) {
		return;
	}
	$file = AF_QUESTIONNAIRE_DIR . 'questionnaire-popup.php';
	if ( file_exists( $file ) ) {
		include $file;
		$already = true;
	}
}

function af_questionnaire_render_content() {
	$file = AF_QUESTIONNAIRE_DIR . 'questionnaire-content.php';
	if ( file_exists( $file ) ) {
		include $file;
	}
}


/* ==========================================================
 * AJAX Handlers (هم برای لاگین و هم مهمان)
 * ========================================================== */

function af_questionnaire_verify_ajax() {
	check_ajax_referer( AF_QUESTIONNAIRE_NONCE_ACTION, 'nonce' );
	return af_questionnaire_get_current_identity();
}

function af_questionnaire_ajax_check_status() {
	$identity = af_questionnaire_verify_ajax();
	$status   = af_questionnaire_get_status( $identity );
	wp_send_json_success( $status );
}
add_action( 'wp_ajax_af_questionnaire_check_status', 'af_questionnaire_ajax_check_status' );
add_action( 'wp_ajax_nopriv_af_questionnaire_check_status', 'af_questionnaire_ajax_check_status' );

function af_questionnaire_ajax_start() {
	$identity = af_questionnaire_verify_ajax();
	$existing = af_questionnaire_get_in_progress_attempt( $identity );
	$attempt  = $existing ? $existing : af_questionnaire_start( $identity );

	wp_send_json_success( array(
		'questionnaire_id' => (int) $attempt->id,
		'current_section'  => (int) $attempt->current_section,
		'current_page'     => (int) $attempt->current_page,
		'current_question' => (int) $attempt->current_question,
	) );
}
add_action( 'wp_ajax_af_questionnaire_start', 'af_questionnaire_ajax_start' );
add_action( 'wp_ajax_nopriv_af_questionnaire_start', 'af_questionnaire_ajax_start' );

function af_questionnaire_ajax_resume() {
	$identity = af_questionnaire_verify_ajax();
	$attempt  = af_questionnaire_resume( $identity );
	if ( ! $attempt ) {
		wp_send_json_error( array( 'message' => 'هیچ پرسشنامه ناتمامی وجود ندارد.' ) );
	}
	wp_send_json_success( array(
		'questionnaire_id' => (int) $attempt->id,
		'current_section'  => (int) $attempt->current_section,
		'current_page'     => (int) $attempt->current_page,
		'current_question' => (int) $attempt->current_question,
	) );
}
add_action( 'wp_ajax_af_questionnaire_resume', 'af_questionnaire_ajax_resume' );
add_action( 'wp_ajax_nopriv_af_questionnaire_resume', 'af_questionnaire_ajax_resume' );

function af_questionnaire_ajax_restart() {
	$identity = af_questionnaire_verify_ajax();
	$attempt  = af_questionnaire_restart( $identity );
	wp_send_json_success( array(
		'questionnaire_id' => (int) $attempt->id,
		'current_section'  => (int) $attempt->current_section,
		'current_page'     => (int) $attempt->current_page,
		'current_question' => (int) $attempt->current_question,
	) );
}
add_action( 'wp_ajax_af_questionnaire_restart', 'af_questionnaire_ajax_restart' );
add_action( 'wp_ajax_nopriv_af_questionnaire_restart', 'af_questionnaire_ajax_restart' );

function af_questionnaire_ajax_save_answer() {
	$identity         = af_questionnaire_verify_ajax();
	$questionnaire_id = isset( $_POST['questionnaire_id'] ) ? (int) $_POST['questionnaire_id'] : 0;
	$section          = isset( $_POST['section'] ) ? (int) $_POST['section'] : 0;
	$page             = isset( $_POST['page'] ) ? (int) $_POST['page'] : 0;
	$question_key     = isset( $_POST['question_key'] ) ? sanitize_text_field( wp_unslash( $_POST['question_key'] ) ) : '';
	$question_number  = isset( $_POST['question_number'] ) ? (int) $_POST['question_number'] : 0;
	$answer           = isset( $_POST['answer'] ) ? sanitize_text_field( wp_unslash( $_POST['answer'] ) ) : '';

	if ( ! $questionnaire_id || ! $section || ! $page || ! $question_key || ! $question_number ) {
		wp_send_json_error( array( 'message' => 'اطلاعات ارسالی ناقص است.' ) );
	}

	$next_position = null;
	if ( isset( $_POST['next_section'], $_POST['next_page'], $_POST['next_question'] ) ) {
		$next_position = array(
			'section'  => (int) $_POST['next_section'],
			'page'     => (int) $_POST['next_page'],
			'question' => (int) $_POST['next_question'],
		);
	}

	$result = af_questionnaire_save_answer( $identity, $questionnaire_id, $section, $page, $question_key, $answer, $question_number, $next_position );

	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'message' => $result->get_error_message() ) );
	}
	wp_send_json_success();
}
add_action( 'wp_ajax_af_questionnaire_save_answer', 'af_questionnaire_ajax_save_answer' );
add_action( 'wp_ajax_nopriv_af_questionnaire_save_answer', 'af_questionnaire_ajax_save_answer' );

function af_questionnaire_ajax_complete() {
	$identity         = af_questionnaire_verify_ajax();
	$questionnaire_id = isset( $_POST['questionnaire_id'] ) ? (int) $_POST['questionnaire_id'] : 0;
	if ( ! $questionnaire_id ) {
		wp_send_json_error( array( 'message' => 'شناسه پرسشنامه ارسال نشده.' ) );
	}
	$result = af_questionnaire_complete( $identity, $questionnaire_id );
	if ( is_wp_error( $result ) ) {
		wp_send_json_error( array( 'message' => $result->get_error_message() ) );
	}
	wp_send_json_success();
}
add_action( 'wp_ajax_af_questionnaire_complete', 'af_questionnaire_ajax_complete' );
add_action( 'wp_ajax_nopriv_af_questionnaire_complete', 'af_questionnaire_ajax_complete' );

function af_questionnaire_ajax_get_answers() {
	$identity         = af_questionnaire_verify_ajax();
	$questionnaire_id = isset( $_POST['questionnaire_id'] ) ? (int) $_POST['questionnaire_id'] : 0;
	if ( ! $questionnaire_id ) {
		wp_send_json_error( array( 'message' => 'شناسه پرسشنامه ارسال نشده.' ) );
	}
	$answers = af_questionnaire_get_answers( $identity, $questionnaire_id );
	wp_send_json_success( array( 'answers' => $answers ) );
}
add_action( 'wp_ajax_af_questionnaire_get_answers', 'af_questionnaire_ajax_get_answers' );
add_action( 'wp_ajax_nopriv_af_questionnaire_get_answers', 'af_questionnaire_ajax_get_answers' );


/* ==========================================================
 * چاپ Popup در Footer + Shortcode
 * ========================================================== */

function af_questionnaire_print_popup_in_footer() {
	if ( is_admin() ) {
		return;
	}
	af_questionnaire_render_popup();
}
add_action( 'wp_footer', 'af_questionnaire_print_popup_in_footer' );

function af_questionnaire_shortcode( $atts ) {
	ob_start();
	?>
	<button type="button" class="af-pro-open-questionnaire" onclick="AFQuestionnaire.open()">
		شروع پرسشنامه
	</button>
	<?php
	return ob_get_clean();
}
add_shortcode( 'af_questionnaire', 'af_questionnaire_shortcode' );

/**
 * نسخه دستی برای چاپ مستقیم (اختیاری)
 * استایل و اسکریپت‌ها از داخل content لود می‌شوند (inline).
 */
function render_questionnaire_popup() {
	af_questionnaire_render_popup();
}
