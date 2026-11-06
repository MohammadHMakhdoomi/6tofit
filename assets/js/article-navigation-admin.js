jQuery(document).ready(function ($) {

    const container = $('#mytheme-navigation-items');

    const scanButton = $('#mytheme-scan-headings');


    /*
     * Sortable
     */
    container.sortable({

        handle: '.mytheme-navigation-item-drag',

        items: '.mytheme-navigation-item',

        cursor: 'move',

        tolerance: 'pointer'

    });


    /*
     * Scan headings
     */
    scanButton.on('click', function () {

        const button = $(this);

        const postId =
            container.data('post-id');


        button.prop('disabled', true);

        button.text('در حال بررسی...');


        $.ajax({

            url: myThemeArticleNavigation.ajaxUrl,

            type: 'POST',

            data: {

                action: 'mytheme_scan_article_headings',

                nonce: myThemeArticleNavigation.nonce,

                post_id: postId

            },

            success: function (response) {

                if (
                    !response.success ||
                    !response.data.items
                ) {

                    alert(
                        'خطا در دریافت عناوین مقاله.'
                    );

                    return;

                }


                const items =
                    response.data.items;


                container.empty();


                if (!items.length) {

                    container.html(
                        '<div class="mytheme-navigation-empty">' +
                        '<p>هیچ H2 یا H3 در مقاله پیدا نشد.</p>' +
                        '</div>'
                    );

                    return;

                }


                items.forEach(function (item, index) {

                    const html = `

                        <div
                            class="mytheme-navigation-item"
                            data-heading-id="${escapeHtml(item.heading_id)}"
                        >

                            <div class="mytheme-navigation-item-drag">
                                ☰
                            </div>

                            <div class="mytheme-navigation-item-content">

                                <div class="mytheme-navigation-item-title">

                                    <label>

                                        <input
                                            type="checkbox"
                                            name="mytheme_navigation[${index}][enabled]"
                                            value="1"
                                        >

                                        <span class="mytheme-heading-level level-${item.level}">
                                            H${item.level}
                                        </span>

                                        <strong>
                                            ${escapeHtml(item.heading_text)}
                                        </strong>

                                    </label>

                                </div>


                                <div class="mytheme-navigation-menu-title">

                                    <label>
                                        عنوان نمایش در منو:
                                    </label>

                                    <input
                                        type="text"
                                        class="widefat"
                                        name="mytheme_navigation[${index}][menu_title]"
                                        value="${escapeHtml(item.menu_title)}"
                                        placeholder="${escapeHtml(item.heading_text)}"
                                    >

                                </div>


                                <input
                                    type="hidden"
                                    name="mytheme_navigation[${index}][heading_id]"
                                    value="${escapeHtml(item.heading_id)}"
                                >

                                <input
                                    type="hidden"
                                    name="mytheme_navigation[${index}][heading_text]"
                                    value="${escapeHtml(item.heading_text)}"
                                >

                                <input
                                    type="hidden"
                                    name="mytheme_navigation[${index}][level]"
                                    value="${item.level}"
                                >

                            </div>

                        </div>

                    `;


                    container.append(html);

                });


                container.sortable({

                    handle: '.mytheme-navigation-item-drag',

                    items: '.mytheme-navigation-item',

                    cursor: 'move',

                    tolerance: 'pointer'

                });

            },

            error: function () {

                alert(
                    'ارتباط با سرور برقرار نشد.'
                );

            },

            complete: function () {

                button.prop(
                    'disabled',
                    false
                );

                button.text(
                    'بروزرسانی عناوین'
                );

            }

        });

    });


    /*
     * Escape HTML
     */
    function escapeHtml(text) {

        return $('<div>')
            .text(text)
            .html();

    }

});