<?php
/* Template Name: صفحه وبلاگ (آرشیو پست‌ها) */
get_header('product'); ?>


<style>
  .blog-search-section {
    width: 100%;
    padding: 80px 0;
    margin-top:80px;
    position: relative;
  }

  .blog-search-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 15; /* بالاتر از overlay */
  }

  .blog-search-field {
    width: -webkit-fill-available;
    background-color: #F0F0F1;
    border-radius: 30px;
    padding: 12px 56px 12px 26px; /* فضای کافی برای آیکن‌ها */
    border: none;
    font-size: 16px;
    font-weight: 400;
    color: #161618;
    transition: background-color 0.3s ease, border-radius 0.3s ease;
    position: relative;
    outline: none;
  }

  .blog-search-field.active {
    background-color: #FFFFFF;
    border-radius: 30px 30px 0 0;
  }

  .blog-search-icon-right {
    position: absolute;
    right: 26px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    color: #65656D;
  }

  .blog-search-icon-right img {
    width: 20px;
    height: 20px;
  }

  .blog-search-icon-left {
    position: absolute;
    left: 26px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .blog-search-field.active ~ .blog-search-icon-left {
    opacity: 1;
  }

  .blog-search-results {
    margin-top: 2px;
    top: 100%;
    left: 0;
    right: 0;
    background-color: #FFFFFF;
    border-radius: 0 0 30px 30px;
    padding: 16px 0;
    max-height: 400px;
    overflow-y: auto;
    display: none;
    z-index: 10;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .blog-search-results.active {
    display: block;
  }

  .blog-search-result-item {
    display: flex;
    padding: 12px 12px;
    cursor: pointer;
    transition: background-color 0.2s ease;
    gap: 5px;
  }

  .blog-search-result-item:last-child {
    border-bottom: none;
  }

  .blog-search-result-item:hover {
    background-color: #F8F8F8;
  }

  .blog-search-result-icon {
    flex-shrink: 0;
  }
  .blog-search-result-icon img {
    width: 20px;
  }

  .blog-search-result-title {
    font-size: 16px;
    font-weight: 400;
    color: #8D8D94;
    margin: 0;
    flex: 1;
    text-align: right;
  }

  .blog-search-result-highlight {
    color: #161618;
    font-weight: 500;
  }

  .blog-search-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #FFFFFF80;
    backdrop-filter: blur(50px);
    z-index: 5;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    overflow: hidden;
  }

  .blog-search-overlay.active {
    opacity: 1;
    visibility: visible;
  }

  /* موبایل */
  @media only screen and (max-width: 768px) {
    .blog-search-section {
      padding: 40px 0;
    }

    .blog-search-container {
      padding: 0 10px;
    }

    .blog-search-field {
      padding: 12px 40px 12px 20px;
      font-size: 16px;
    }

    .blog-search-icon-right {
      right: 20px;
    }

    .blog-search-icon-left {
      left: 20px;
    }

    .blog-search-results {
      padding: 12px 0;
      max-height: 300px;
    }

    .blog-search-result-item {
      padding: 10px 20px;
      gap: 8px;
    }

    .blog-search-result-title {
      font-size: 14px;
    }

    .blog-search-result-icon {
      width: 32px;
      height: 32px;
    }
  }
 .blog-search-results.active a{
  text-decoration: none;
}

</style>

<section class="blog-search-section">
  <div class="blog-search-container">
    <div style="position: relative; width: 100%;">
      <input type="text" class="blog-search-field" placeholder="جستجو..." id="blogSearchInput">
      <span class="blog-search-icon-right">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/Search-Iconly-Pro.svg" alt="آیکون جستجو">
      </span>
      <img src="http://6tofit.com/wp-content/uploads/2025/10/close.svg" alt="پاک کردن" class="blog-search-icon-left" id="blogSearchClear">
    </div>
    <div class="blog-search-results" id="blogSearchResults"></div>
  </div>
</section>

<div class="blog-search-overlay" id="blogSearchOverlay"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('blogSearchInput');
    const searchResults = document.getElementById('blogSearchResults');
    const searchClear = document.getElementById('blogSearchClear');
    const searchOverlay = document.getElementById('blogSearchOverlay');

    async function fetchPosts(query) {
        try {
            const formData = new FormData();
            formData.append('action', 'search_posts');
            formData.append('query', query);

            const response = await fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            if (data.success) {
                return data.data;
            } else {
                console.error('خطا در دریافت پست‌ها:', data);
                return [];
            }
        } catch (error) {
            console.error('خطا در AJAX:', error);
            return [];
        }
    }

    async function performSearch(query) {
        if (!query.trim()) {
            searchResults.innerHTML = '';
            searchResults.classList.remove('active');
            searchInput.classList.remove('active');
            searchOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
            return;
        }

        const posts = await fetchPosts(query);
        let resultsHTML = '';

        posts.forEach(post => {
            const highlightedTitle = highlightMatch(post.title, query);
            resultsHTML += `
                <a href="${post.permalink}" class="blog-search-result-item">
                    <div class="blog-search-result-icon">
                        <img src="http://6tofit.com/wp-content/uploads/2025/10/Search-Iconly-Pro.svg" alt="آیکون پست">
                    </div>
                    <p class="blog-search-result-title">${highlightedTitle}</p>
                </a>
            `;
        });

        searchResults.innerHTML = resultsHTML || '<div style="padding: 20px; text-align: center; color: #65656D;">نتیجه‌ای یافت نشد</div>';
        searchResults.classList.add('active');
        searchInput.classList.add('active');
        searchOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function highlightMatch(text, query) {
        const regex = new RegExp(`(${query})`, 'gi');
        return text.replace(regex, '<span class="blog-search-result-highlight">$1</span>');
    }

    searchInput.addEventListener('input', function() {
        performSearch(this.value);
    });

    searchClear.addEventListener('click', function() {
        searchInput.value = '';
        performSearch('');
    });

    searchOverlay.addEventListener('click', function() {
        searchInput.value = '';
        performSearch('');
    });

    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            window.location.href = '<?php echo esc_url(home_url('/')); ?>?s=' + encodeURIComponent(this.value);
        }
    });
});
</script>

<style>
  .blog-hero-section {
    width: 100%;
    height: 60vh; /* ارتفاع مناسب برای هیرو */
    background-image: url('http://6tofit.com/wp-content/uploads/2025/10/blogdescback2.png');
    
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    direction: rtl;
  }

  .blog-hero-text {
    font-size: 44px;
    font-weight: 500;
    color: #161618;
    text-align: center;
    margin: 0;
    line-height: 1.2;
    font-family: 'iranyekanen', sans-serif;
  }

  /* موبایل */
  @media only screen and (max-width: 768px) {
    .blog-hero-section {
      background-image: url('http://6tofit.com/wp-content/uploads/2025/10/blogmobback2.png');
      height: 40vh;
    }

    .blog-hero-text {
      font-size: 24px;
    }
  }
</style>

<section class="blog-hero-section">
  <h1 class="blog-hero-text">خواندنی‌های 6toFit</h1>
</section>


<style>
  .blog-filter-section {
    width: 100%;
    padding: 60px 0;
  
    direction: rtl;
  }

  .blog-filter-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .blog-categories-scroll {
    position: relative;
    overflow: hidden;
    margin-bottom: 20px;
  }

  .blog-categories-list {
    display: flex;
    gap: 12px;
    transition: transform 0.3s ease;
    padding: 0 50px; /* فضای دکمه‌ها */
  }

  .blog-category-item {
   
    border: 1px solid #D4D4D7;
    border-radius: 10000px;
    padding: 8px 16px;
    font-size: 16px;
    font-weight: 400;
    color: #161618;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
	padding-left: 35px;
  }

  .blog-category-item.active {
    background-color: var(--cat-color, #000000);
    border-color: var(--cat-color, #000000);
    color: #FFFFFF;
  }

  .blog-category-item.active::after {
    content: '';
    position: absolute;
    left: 8px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    background-image: url('http://6tofit.com/wp-content/uploads/2025/10/closecat.svg'); /* آیکن ضربدر */
    background-size: contain;
    background-repeat: no-repeat;
  }

  .blog-category-icon {
    width: 20px;
    height: 20px;
  }

  .blog-scroll-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    border-radius: 1000px;
    border: none;
    cursor: pointer;
    width: 40px;
    height: 40px;
    z-index: 5;
    opacity: 0.5;
    transition: opacity 0.3s ease;
  }

  .blog-scroll-btn:hover {
    opacity: 1;
  }

  .blog-scroll-left {
    left: 0;
  }

  .blog-scroll-right {
    right: 0;
    opacity: 0; /* ابتدا پنهان */
  }

  .blog-scroll-right.active {
    opacity: 0.5;
  }

  .blog-scroll-btn img {
    width: 100%;
    height: 100%;
  }

  .blog-fade-left,
  .blog-fade-right {
    position: absolute;
    top: 0;
    height: 100%;
    width: 50px;
    pointer-events: none;
    z-index: 3;
  }

  .blog-fade-left {
    left: 0;
   
  }

  .blog-fade-right {
    right: 0;
   
  }

  /* مقالات - 2 ستونی */
  .blog-posts-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 40px;
    margin-bottom: 60px;
  }

  .blog-post-card {
    background-color: #FFFFFF;
    border-radius: 24px;
    overflow: hidden;
    transition: transform 0.3s ease;
  }

  .blog-post-card:hover {
    transform: translateY(-4px);
  }

  .blog-post-image {
    width: 100%;
    height: 350px;
    object-fit: cover;
  }

  .blog-post-content {
    padding: 24px;
  }

  .blog-post-category {
    display: flex;
    align-items: center;
    width: fit-content;
    background-color: var(--cat-color, #000000);
    border-radius: 100px;
    padding: 8px 16px;
    margin-bottom: 16px;
    color: #FFFFFF;
    font-size: 16px;
    font-weight: 400;
  }

  .blog-post-category-icon {
    width: 20px;
    height: 20px;
    margin-left: 8px;
  }

  .blog-post-category-name {
    margin: 0;
  }

  .blog-post-title {
    font-size: 24px;
    font-weight: 500;
    color: #191919;
    margin: 0 0 10px 0;
    line-height: 1.3;
	min-height: 5rem;
  }

  .blog-post-title a {
    text-decoration: none;
    color: inherit;
  }

  .blog-post-title a:hover {
    color: #5247FF;
  }

  /* صفحه‌بندی */
  .blog-pagination {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 0 auto;
    
    gap: 20px;
  }

  .blog-pagination-btn {
    width: 40px;
    height: 40px;
    background: none;
    border: none;
    cursor: pointer;
    opacity: 0.5;
    transition: opacity 0.3s ease;
  }

  .blog-pagination-btn:hover {
    opacity: 1;
  }

  .blog-pagination-btn img {
    width: 48px;
    height: 48px;
  }

  .blog-pagination-info {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 18px;
    font-weight: 400;
    color: #161618;
  }

  .blog-pagination-current {
    background: none;
    border: 1px solid #0000001F;
    border-radius: 12px;
    padding: 10px 20px;
    font-size: 18px;
    font-weight: 400;
    color: #161618;
  }

  /* موبایل */
  @media only screen and (max-width: 768px) {
    .blog-filter-section {
      padding: 40px 0;
    }

    .blog-categories-list {
      gap: 8px;
      padding: 0 40px;
    }

    .blog-category-item {
      padding: 6px 12px;
      font-size: 14px;
    }

    .blog-posts-grid {
      grid-template-columns: 1fr;
      gap: 20px;
    }

    .blog-post-content {
      padding: 20px;
    }

    .blog-post-title {
      font-size: 20px;
	  min-height: 0rem;
    }

    .blog-pagination {
      max-width: 250px;
      gap: 12px;
    }

    .blog-pagination-info {
      font-size: 16px;
      gap: 8px;
    }

    .blog-pagination-current {
      padding: 12px;
      font-size: 16px;
    }
  }
  .blog-category-icon svg path {
  fill: currentColor;
}

.blog-category-icon {
  color: #000000; /* این رنگ به جای fill استفاده میشه */
}
.blog-posts-grid a{
	text-decoration: none;
}
</style>

<section class="blog-filter-section">
  <div class="blog-filter-container">
    <div class="blog-categories-scroll">
      <button class="blog-scroll-btn blog-scroll-left" onclick="scrollCategories(-1)">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/IconButtonL.svg" alt="چپ">
      </button>
      <div class="blog-fade-left"></div>
      <div class="blog-categories-list" id="blogCategoriesList">
        <?php
        $categories = get_categories(array(
          'taxonomy' => 'category',
          'hide_empty' => true,
          'orderby' => 'name',
          'order' => 'ASC'
        ));
        foreach ($categories as $category) {
          $term_id = $category->term_id;
          $icon = get_term_meta($term_id, 'category_icon', true);
          $color = get_term_meta($term_id, 'category_color', true) ?: '#000000';
          echo '<div class="blog-category-item" data-color="' . esc_attr($color) . '" onclick="toggleCategory(this, ' . $term_id . ')">';
          if ($icon) {
           
$attachment_id = attachment_url_to_postid( $icon );
$icon_path = get_attached_file( $attachment_id );
$icon_ext  = pathinfo( $icon_path, PATHINFO_EXTENSION );

if ( file_exists( $icon_path ) ) {
    if ( strtolower( $icon_ext ) === 'svg' ) {
        // خواندن محتوای SVG
        $svg = file_get_contents( $icon_path );

        // حذف هدر XML در صورت وجود
        $svg = preg_replace('/<\?xml.*?\?>/i', '', $svg);
		$svg = preg_replace('/fill="[^"]*"/i', '', $svg);

        // اطمینان از وجود تگ <svg>
        if ( strpos( $svg, '<svg' ) !== false ) {
            echo '<span class="blog-category-icon">' . $svg . '</span>';
        } else {
            echo '<img src="' . esc_url( $icon ) . '" alt="' . esc_attr( $category->name ) . '" class="blog-category-icon">';
        }
    } else {
        // اگر فایل SVG نبود، همون عکس معمولی نشون داده بشه
        echo '<img src="' . esc_url( $icon ) . '" alt="' . esc_attr( $category->name ) . '" class="blog-category-icon">';
    }
}


          }
          echo esc_html($category->name);
          echo '</div>';
        }
        ?>
      </div>
      <div class="blog-fade-right"></div>
      <button class="blog-scroll-btn blog-scroll-right" onclick="scrollCategories(1)">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/IconButtonR.svg" alt="راست">
      </button>
    </div>

    <!-- مقالات -->
    <div class="blog-posts-grid" id="blogPostsGrid">
      <?php
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      $args = array(
        'post_type' => 'post',
        'posts_per_page' => 8,
        'paged' => $paged,
        'post_status' => 'publish'
      );
      $query = new WP_Query($args);
      if ($query->have_posts()) {
        while ($query->have_posts()) {
          $query->the_post();
          $categories = get_the_category();
          $category = !empty($categories) ? $categories[0] : null;
          $term_id = $category ? $category->term_id : 0;
          $icon = $term_id ? get_term_meta($term_id, 'category_icon', true) : '';
          $color = $term_id ? get_term_meta($term_id, 'category_color', true) : '#000000';
          $cat_name = $category ? $category->name : 'دسته‌بندی';
      ?>
	  <a href="<?php the_permalink(); ?>">
          <article class="blog-post-card">
            <?php if (has_post_thumbnail()) : ?>
              <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>" class="blog-post-image">
            <?php endif; ?>
            <div class="blog-post-content">
              <?php if ($category) : ?>
                <div class="blog-post-category" style="background-color: <?php echo esc_attr($color); ?>;">
                  <?php if ($icon) : ?>
                    <img src="<?php echo esc_url($icon); ?>" alt="<?php echo esc_attr($cat_name); ?>" class="blog-post-category-icon">
                  <?php endif; ?>
                  <span class="blog-post-category-name"><?php echo esc_html($cat_name); ?></span>
                </div>
              <?php endif; ?>
              <h3 class="blog-post-title"><?php the_title(); ?></h3>
            </div>
          </article>
		  </a>
      <?php
        }
        wp_reset_postdata();
      } else {
        echo '<p>هیچ مقاله‌ای یافت نشد.</p>';
      }
      ?>
    </div>

    <!-- صفحه‌بندی -->
    <div class="blog-pagination">
      <button class="blog-pagination-btn" onclick="changePage(-1)">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/IconButtonR.svg" alt="صفحه قبلی">
      </button>
      <div class="blog-pagination-info">
        <span class="blog-pagination-current"><?php echo $paged; ?></span>
        <span>از</span>
        <span><?php echo $query->max_num_pages; ?></span>
      </div>
      <button class="blog-pagination-btn" onclick="changePage(1)">
        <img src="http://6tofit.com/wp-content/uploads/2025/10/IconButtonL.svg" alt="صفحه بعدی">
      </button>
    </div>
  </div>
</section>

<script>
  let selectedCategories = [];
  let currentPage = 1;
  let maxPages = <?php echo $query->max_num_pages; ?>;

  // اسکرول دسته‌بندی‌ها
  function scrollCategories(direction) {
    const list = document.getElementById('blogCategoriesList');
    const scrollAmount = 200;
    list.scrollLeft += direction * scrollAmount;

    const rightBtn = document.querySelector('.blog-scroll-right');
    if (list.scrollLeft > 0) {
      rightBtn.classList.add('active');
    } else {
      rightBtn.classList.remove('active');
    }
  }

  // Toggle دسته
function toggleCategory(item, termId) {
  const icon = item.querySelector('svg path'); // پیدا کردن آیکن داخل دسته
  
  if (item.classList.contains('active')) {
    // حالت غیرفعال
    item.classList.remove('active');
    selectedCategories = selectedCategories.filter(cat => cat !== termId);
    item.style.backgroundColor = '#F0F0F1';
    item.style.borderColor = '#D4D4D7';
    item.style.color = '#161618';
    if (icon) icon.style.fill = '#161618'; // بازگرداندن رنگ آیکن به حالت اصلی
  } else {
    // حالت فعال
    item.classList.add('active');
    selectedCategories.push(termId);
    const color = item.dataset.color;
    item.style.backgroundColor = color;
    item.style.borderColor = color;
    item.style.color = '#FFFFFF';
    if (icon) icon.style.fill = '#FFFFFF'; // تغییر رنگ آیکن به سفید
  }

  loadPosts();
}


  // لود پست‌ها با فیلتر
  function loadPosts(page = 1) {
    // AJAX call to PHP for filtered query
    fetch('/wp-admin/admin-ajax.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'action=filter_blog_posts&categories=' + encodeURIComponent(JSON.stringify(selectedCategories)) + '&paged=' + page
    })
    .then(response => response.json())
    .then(data => {
      document.getElementById('blogPostsGrid').innerHTML = data.html;
      currentPage = page;
      maxPages = data.max_pages;
      updatePagination();
    });
  }

  // تغییر صفحه
  function changePage(direction) {
    const newPage = currentPage + direction;
    if (newPage >= 1 && newPage <= maxPages) {
      loadPosts(newPage);
    }
  }

  // به‌روزرسانی صفحه‌بندی
  function updatePagination() {
    document.querySelector('.blog-pagination-current').textContent = currentPage;
    document.querySelector('.blog-pagination-info span:last-child').textContent = maxPages;
  }
</script>



<?php get_footer(); ?>