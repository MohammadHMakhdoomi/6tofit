<?php
/**
 * FAQ Custom Post Type and Repeater Metabox
 * File: inc/faq-cpt.php
 * Include in functions.php: require_once get_template_directory() . '/inc/faq-cpt.php';
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. Register Custom Post Type for FAQ
 */
function sixtofit_register_faq_post_type() {
    $labels = array(
        'name'                  => _x( 'سوالات متداول', 'Post Type General Name', 'sixtofit' ),
        'singular_name'         => _x( 'سوال متداول', 'Post Type Singular Name', 'sixtofit' ),
        'menu_name'             => __( 'سوالات متداول', 'sixtofit' ),
        'name_admin_bar'        => __( 'سوال متداول', 'sixtofit' ),
        'archives'              => __( 'آرشیو سوالات متداول', 'sixtofit' ),
        'attributes'            => __( 'ویژگی‌های سوال متداول', 'sixtofit' ),
        'parent_item_colon'     => __( 'والد سوال متداول:', 'sixtofit' ),
        'all_items'             => __( 'همه سوالات متداول', 'sixtofit' ),
        'add_new_item'          => __( 'افزودن سوال متداول جدید', 'sixtofit' ),
        'add_new'               => __( 'افزودن جدید', 'sixtofit' ),
        'new_item'              => __( 'سوال متداول جدید', 'sixtofit' ),
        'edit_item'             => __( 'ویرایش سوال متداول', 'sixtofit' ),
        'update_item'           => __( 'بروزرسانی سوال متداول', 'sixtofit' ),
        'view_item'             => __( 'مشاهده سوال متداول', 'sixtofit' ),
        'view_items'            => __( 'مشاهده سوالات متداول', 'sixtofit' ),
        'search_items'          => __( 'جستجوی سوالات متداول', 'sixtofit' ),
        'not_found'             => __( 'سوالی یافت نشد', 'sixtofit' ),
        'not_found_in_trash'    => __( 'سوالی در سطل زباله یافت نشد', 'sixtofit' ),
        'featured_image'        => __( 'تصویر برجسته', 'sixtofit' ),
        'set_featured_image'    => __( 'تصویر برجسته را تنظیم کنید', 'sixtofit' ),
        'remove_featured_image' => __( 'حذف تصویر برجسته', 'sixtofit' ),
        'use_featured_image'    => __( 'به عنوان تصویر برجسته استفاده کنید', 'sixtofit' ),
    );

    $args = array(
        'label'                 => __( 'سوال متداول', 'sixtofit' ),
        'description'           => __( 'پست‌های سوالات متداول', 'sixtofit' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-editor-help',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'faq',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'rewrite'               => array( 'slug' => 'faq' ),
    );

    register_post_type( 'faq', $args );
}
add_action( 'init', 'sixtofit_register_faq_post_type', 0 );

/**
 * 2. Add Custom Metabox for Repeater Questions
 */
function sixtofit_add_faq_metabox() {
    add_meta_box(
        'faq_questions_metabox',
        __( 'سوالات و پاسخ‌ها', 'sixtofit' ),
        'sixtofit_faq_metabox_callback',
        'faq',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'sixtofit_add_faq_metabox' );

/**
 * Metabox Callback - Display the repeater fields
 */
function sixtofit_faq_metabox_callback( $post ) {
    wp_nonce_field( 'sixtofit_faq_meta_nonce', 'sixtofit_faq_meta_nonce' );
    
    $faq_questions = get_post_meta( $post->ID, '_faq_questions', true );
    $faq_questions = is_array( $faq_questions ) ? $faq_questions : array();
    
    echo '<div id="faq-repeater-container">';
    if ( ! empty( $faq_questions ) ) {
        foreach ( $faq_questions as $index => $question ) {
            echo sixtofit_render_faq_question_row( $index, $question['question'], $question['answer'] );
        }
    } else {
        echo sixtofit_render_faq_question_row( 0, '', '' );
    }
    echo '</div>';
    
    echo '<p><a href="#" id="add-new-faq-question" class="button button-secondary">' . __( 'افزودن سوال جدید', 'sixtofit' ) . '</a></p>';
}

/**
 * Render a single question row
 */
function sixtofit_render_faq_question_row( $index, $question, $answer ) {
    ob_start();
    ?>
    <div class="faq-question-row" data-index="<?php echo esc_attr( $index ); ?>">
        <table class="form-table" style="width: 100%; border-spacing: 0;">
            <tr>
                <th style="width: 20%; vertical-align: top; padding-right: 10px;">
                    <label for="faq_question_<?php echo esc_attr( $index ); ?>"><?php _e( 'سوال', 'sixtofit' ); ?></label>
                </th>
                <td style="width: 80%;">
                    <input type="text" id="faq_question_<?php echo esc_attr( $index ); ?>" name="faq_questions[<?php echo esc_attr( $index ); ?>][question]" value="<?php echo esc_attr( $question ); ?>" class="widefat" placeholder="<?php _e( 'سوال را وارد کنید...', 'sixtofit' ); ?>" />
                </td>
                <td style="width: 60px; text-align: center; vertical-align: top;">
                    <button type="button" class="button move-up" data-index="<?php echo esc_attr( $index ); ?>"><?php _e( 'بالا', 'sixtofit' ); ?></button><br>
                    <button type="button" class="button move-down" data-index="<?php echo esc_attr( $index ); ?>"><?php _e( 'پایین', 'sixtofit' ); ?></button>
                </td>
            </tr>
            <tr>
                <th style="vertical-align: top; padding-right: 10px; padding-top: 10px;">
                    <label for="faq_answer_<?php echo esc_attr( $index ); ?>"><?php _e( 'پاسخ', 'sixtofit' ); ?></label>
                </th>
                <td colspan="2" style="padding-top: 10px;">
                    <?php
                    wp_editor( $answer, 'faq_answer_' . $index, array(
                        'textarea_name' => 'faq_questions[' . $index . '][answer]',
                        'textarea_rows' => 5,
                        'media_buttons' => true,
                        'teeny' => false,
                        'quicktags' => true,
                    ) );
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right; padding-top: 10px;">
                    <button type="button" class="button button-small remove-question" data-index="<?php echo esc_attr( $index ); ?>"><?php _e( 'حذف سوال', 'sixtofit' ); ?></button>
                </td>
            </tr>
        </table>
        <hr style="margin: 20px 0;">
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Admin Scripts and Styles for Repeater
 */
function sixtofit_faq_admin_scripts() {
    global $post;
    if ( ! $post || get_current_screen()->post_type !== 'faq' ) {
        return;
    }
    
    $faq_questions = get_post_meta( $post->ID, '_faq_questions', true );
    $faq_questions = is_array( $faq_questions ) ? $faq_questions : array();
    $question_count = count( $faq_questions );
    ?>
    <style>
        .faq-question-row { margin-bottom: 20px; border: 1px solid #ddd; padding: 10px; border-radius: 4px; }
        .remove-question { color: #a00; }
        .move-up, .move-down { margin: 2px; }
        .move-up:disabled, .move-down:disabled { opacity: 0.5; cursor: not-allowed; }
    </style>
    <script>
    jQuery(document).ready(function($) {
        var questionIndex = <?php echo $question_count; ?>;
        
        // Template for new row
        var rowTemplate = '<div class="faq-question-row" data-index="{index}">' +
            '<table class="form-table" style="width: 100%; border-spacing: 0;">' +
                '<tr>' +
                    '<th style="width: 20%; vertical-align: top; padding-right: 10px;">' +
                        '<label for="faq_question_{index}">سوال</label>' +
                    '</th>' +
                    '<td style="width: 80%;">' +
                        '<input type="text" id="faq_question_{index}" name="faq_questions[{index}][question]" class="widefat" placeholder="سوال را وارد کنید..." />' +
                    '</td>' +
                    '<td style="width: 60px; text-align: center; vertical-align: top;">' +
                        '<button type="button" class="button move-up" data-index="{index}">بالا</button><br>' +
                        '<button type="button" class="button move-down" data-index="{index}">پایین</button>' +
                    '</td>' +
                '</tr>' +
                '<tr>' +
                    '<th style="vertical-align: top; padding-right: 10px; padding-top: 10px;">' +
                        '<label for="faq_answer_{index}">پاسخ</label>' +
                    '</th>' +
                    '<td colspan="2" style="padding-top: 10px;">' +
                        '<textarea id="faq_answer_{index}" name="faq_questions[{index}][answer]" rows="5" class="wp-editor-area"></textarea>' +
                        '<div id="wp-faq_answer_{index}-wrap" class="wp-core-ui wp-editor-wrap tmce-active quicktags-toolbar-enabled">' +
                            // Quicktags and TinyMCE buttons would need full init, but for simplicity, we'll re-init after add
                        '</div>' +
                    '</td>' +
                '</tr>' +
                '<tr>' +
                    '<td colspan="3" style="text-align: right; padding-top: 10px;">' +
                        '<button type="button" class="button button-small remove-question" data-index="{index}">حذف سوال</button>' +
                    '</td>' +
                '</tr>' +
            '</table>' +
            '<hr style="margin: 20px 0;">' +
        '</div>';
        
        // Add new question
        $('#add-new-faq-question').on('click', function(e) {
            e.preventDefault();
            var newIndex = questionIndex;
            var newRow = rowTemplate.replace(/\{index\}/g, newIndex);
            $('#faq-repeater-container').append(newRow);
            
            // Re-init WP Editor for new row
            if (typeof wp !== 'undefined' && wp.editor && wp.editor.initialize) {
                wp.editor.initialize('faq_answer_' + newIndex, {
                    tinymce: {
                        wpautop: true,
                        mediaButtons: true,
                        quicktags: true
                    },
                    quicktags: true,
                    mediaButtons: true
                });
            } else if (typeof tinymce !== 'undefined') {
                tinymce.init({
                    selector: '#faq_answer_' + newIndex,
                    plugins: 'wordpress',
                    toolbar: 'bold italic underline | link | wp_adv'
                });
            }
            
            questionIndex++;
            updateButtons();
        });
        
        // Remove question
        $(document).on('click', '.remove-question', function(e) {
            e.preventDefault();
            if ( $('.faq-question-row').length > 1 ) {
                $(this).closest('.faq-question-row').remove();
                updateButtons();
            } else {
                alert('حداقل یک سوال باید وجود داشته باشد.');
            }
        });
        
        // Move up
        $(document).on('click', '.move-up:not(:disabled)', function(e) {
            e.preventDefault();
            var $row = $(this).closest('.faq-question-row');
            var $prev = $row.prev('.faq-question-row');
            if ($prev.length) {
                $row.insertBefore($prev);
                updateButtons();
            }
        });
        
        // Move down
        $(document).on('click', '.move-down:not(:disabled)', function(e) {
            e.preventDefault();
            var $row = $(this).closest('.faq-question-row');
            var $next = $row.next('.faq-question-row');
            if ($next.length) {
                $row.insertAfter($next);
                updateButtons();
            }
        });
        
        function updateButtons() {
            $('.faq-question-row').each(function(index) {
                var $row = $(this);
                $row.find('.move-up').prop('disabled', index === 0);
                $row.find('.move-down').prop('disabled', index === $('.faq-question-row').length - 1);
            });
        }
        
        // Initial update
        updateButtons();
    });
    </script>
    <?php
}
add_action( 'admin_footer', 'sixtofit_faq_admin_scripts' );

/**
 * 3. Save Metabox Data
 */
function sixtofit_save_faq_meta( $post_id ) {
    if ( ! isset( $_POST['sixtofit_faq_meta_nonce'] ) || ! wp_verify_nonce( $_POST['sixtofit_faq_meta_nonce'], 'sixtofit_faq_meta_nonce' ) ) {
        return;
    }
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    if ( isset( $_POST['faq_questions'] ) && is_array( $_POST['faq_questions'] ) ) {
        $questions = array();
        foreach ( $_POST['faq_questions'] as $q ) {
            if ( ! empty( $q['question'] ) ) {
                $questions[] = array(
                    'question' => sanitize_text_field( $q['question'] ),
                    'answer'   => wp_kses_post( $q['answer'] ), // Sanitize HTML for answer
                );
            }
        }
        update_post_meta( $post_id, '_faq_questions', $questions );
    } else {
        delete_post_meta( $post_id, '_faq_questions' );
    }
}
add_action( 'save_post', 'sixtofit_save_faq_meta' );

/**
 * 4. Display Function for Frontend
 */
function sixtofit_display_faq_post( $post_id ) {
    $post = get_post( $post_id );
    if ( ! $post || $post->post_type !== 'faq' ) {
        return;
    }
    
    $faq_questions = get_post_meta( $post_id, '_faq_questions', true );
    $faq_questions = is_array( $faq_questions ) ? $faq_questions : array();
    ?>
    <div class="faq-item" id="faq-<?php echo esc_attr( $post_id ); ?>">
        <h2><?php echo esc_html( get_the_title( $post_id ) ); ?></h2>
        <?php if ( $excerpt = get_the_excerpt( $post_id ) ) : ?>
            <p class="faq-excerpt"><?php echo esc_html( $excerpt ); ?></p>
        <?php endif; ?>
        
        <?php if ( ! empty( $faq_questions ) ) : ?>
            <div class="faq-questions">
                <?php foreach ( $faq_questions as $question ) : ?>
                    <div class="faq-question">
                        <h3><?php echo esc_html( $question['question'] ); ?></h3>
                        <div class="faq-answer"><?php echo wp_kses_post( $question['answer'] ); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * 5. Enqueue Frontend Styles and Scripts (Optional - for accordion)
 */
function sixtofit_faq_frontend_assets() {
    if ( is_post_type_archive( 'faq' ) || is_singular( 'faq' ) ) {
        wp_enqueue_style( 'sixtofit-faq-style', get_template_directory_uri() . '/assets/faq-style.css', array(), '1.0' ); // Add your CSS file
        wp_enqueue_script( 'sixtofit-faq-script', get_template_directory_uri() . '/assets/faq-script.js', array( 'jquery' ), '1.0', true );
    }
}
add_action( 'wp_enqueue_scripts', 'sixtofit_faq_frontend_assets' );



// Sample JS for accordion (move to separate file if needed)
function sixtofit_faq_inline_scripts() {
    if ( is_post_type_archive( 'faq' ) || is_singular( 'faq' ) ) {
        ?>
        <script>
        jQuery(document).ready(function($) {
            $('.faq-question h3').on('click', function() {
                var $answer = $(this).next('.faq-answer');
                $answer.toggleClass('active');
            });
        });
        </script>
        <?php
    }
}
add_action( 'wp_footer', 'sixtofit_faq_inline_scripts' );
?>