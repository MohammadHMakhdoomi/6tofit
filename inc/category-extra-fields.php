<?php
// افزودن فیلد آیکن و رنگ به دسته‌ها
add_action('category_add_form_fields', 'add_category_icon_field');
add_action('category_edit_form_fields', 'edit_category_icon_field');

function add_category_icon_field($taxonomy) {
    ?>
    <div class="form-field">
        <label for="category_icon">آیکن دسته</label>
        <input type="text" name="category_icon" id="category_icon" value="">
        <button class="upload_category_icon_button button">انتخاب آیکن</button>
        <p class="description">یک تصویر برای آیکن دسته انتخاب کنید.</p>
    </div>
    <div class="form-field">
        <label for="category_color">رنگ دسته</label>
        <input type="color" name="category_color" id="category_color" value="#ffffff">
        <p class="description">رنگ نمایش برای دسته‌بندی.</p>
    </div>
    <?php
}

function edit_category_icon_field($term) {
    $icon  = get_term_meta($term->term_id, 'category_icon', true);
    $color = get_term_meta($term->term_id, 'category_color', true);
    ?>
    <tr class="form-field">
        <th scope="row"><label for="category_icon">آیکن دسته</label></th>
        <td>
            <input type="text" name="category_icon" id="category_icon" value="<?php echo esc_attr($icon); ?>">
            <button class="upload_category_icon_button button">انتخاب آیکن</button>
            <p class="description">یک تصویر برای آیکن دسته انتخاب کنید.</p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="category_color">رنگ دسته</label></th>
        <td>
            <input type="color" name="category_color" id="category_color" value="<?php echo esc_attr($color ?: '#ffffff'); ?>">
            <p class="description">رنگ نمایش برای دسته‌بندی.</p>
        </td>
    </tr>
    <?php
}

// ذخیره فیلدها
add_action('created_category', 'save_category_extra_fields');
add_action('edited_category', 'save_category_extra_fields');

function save_category_extra_fields($term_id) {
    if (isset($_POST['category_icon'])) {
        update_term_meta($term_id, 'category_icon', sanitize_text_field($_POST['category_icon']));
    }
    if (isset($_POST['category_color'])) {
        update_term_meta($term_id, 'category_color', sanitize_hex_color($_POST['category_color']));
    }
}

// enqueue اسکریپت مدیا
add_action('admin_enqueue_scripts', 'category_icon_media_script');
function category_icon_media_script($hook) {
    if ( 'edit-tags.php' !== $hook ) return;

    wp_enqueue_media(); // کتابخانه مدیا
    wp_enqueue_script(
        'category-icon-upload',
        get_template_directory_uri() . '/inc/js/category-icon-upload.js',
        array('jquery'),
        null,
        true
    );
}
