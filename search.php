<?php get_header('product'); ?>
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
  /* استایل‌های موجود */
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
  .blog-posts-grid a{
	text-decoration: none;
}

  .blog-post-title a {
    text-decoration: none;
    color: inherit;
  }

  .blog-post-title a:hover {
    color: #5247FF;
  }

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
    background-color: #F0F0F1;
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

  .search-results-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .blog-category-icon svg path {
    fill: currentColor;
  }

  .blog-category-icon {
    color: #000000; /* این رنگ به جای fill استفاده میشه */
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

<section class="blog-filter-section">
<div class="search-results-container">
  <?php
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => 8,
    'paged' => $paged,
    'post_status' => 'publish',
    's' => get_search_query()
  );
  $query = new WP_Query($args);
  ?>
  <h2><?php echo $query->found_posts; ?> نتیجه برای شما پیدا شد</h2>
  <div class="blog-posts-grid" id="blogPostsGrid">
    <?php
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
      echo '<div class="no-results">نتیجه‌ای یافت نشد</div>';
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
document.addEventListener('DOMContentLoaded', function() {
  let currentPage = <?php echo $paged; ?>;
  let maxPages = <?php echo $query->max_num_pages; ?>;

  // تابع برای ارسال درخواست AJAX به وردپرس
  async function fetchPosts(query, page = 1) {
    try {
      const formData = new FormData();
      formData.append('action', 'search_posts');
      formData.append('query', query);
      formData.append('paged', page);

      const response = await fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
      });

      const data = await response.json();
      if (data.success) {
        return data.data; // آرایه پست‌ها و اطلاعات صفحه‌بندی
      } else {
        console.error('خطا در دریافت پست‌ها:', data);
        return { posts: [], found_posts: 0, max_pages: 1 };
      }
    } catch (error) {
      console.error('خطا در AJAX:', error);
      return { posts: [], found_posts: 0, max_pages: 1 };
    }
  }

  // تابع برای لود پست‌ها با صفحه‌بندی
  async function loadPosts(page = 1) {
    const query = '<?php echo esc_js(get_search_query()); ?>';
    const data = await fetchPosts(query, page);
    let postsHTML = '';

    if (data.posts.length > 0) {
      data.posts.forEach(post => {
        const category = post.category || { name: 'دسته‌بندی', color: '#000000', icon: '' };
        postsHTML += `
          <article class="blog-post-card">
            ${post.thumbnail ? `<img src="${post.thumbnail}" alt="${post.title}" class="blog-post-image">` : ''}
            <div class="blog-post-content">
              <div class="blog-post-category" style="background-color: ${category.color};">
                ${category.icon ? `<img src="${category.icon}" alt="${category.name}" class="blog-post-category-icon">` : ''}
                <span class="blog-post-category-name">${category.name}</span>
              </div>
              <h3 class="blog-post-title"><a href="${post.permalink}">${post.title}</a></h3>
            </div>
          </article>
        `;
      });
    } else {
      postsHTML = '<div class="no-results">نتیجه‌ای یافت نشد</div>';
    }

    document.getElementById('blogPostsGrid').innerHTML = postsHTML;
    document.querySelector('h2').textContent = `${data.found_posts} نتیجه برای شما پیدا شد`;
    currentPage = page;
    maxPages = data.max_pages;
    updatePagination();
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
});
</script>

<?php get_footer(); ?>