<?php
function render_my_changes_popup($title = "تغییرات من", $submit_text = "ادامه") {
    ob_start();
}
add_shortcode('my_changes_popup', 'render_my_changes_popup');
?>
<style>
/* ==================== My Changes Popup Base ==================== */
.mychanges-popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(13, 13, 13, 0.56);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    backdrop-filter: blur(50px);
    -webkit-backdrop-filter: blur(50px);
}

.mychanges-popup-overlay.active {
    display: flex !important;
}

.mychanges-popup-content {
    background: #F7F7F8;
    border-radius: 40px;
    text-align: center;
    overflow: hidden;
    min-width: 700px;
}

.mychanges-popup-content .mychanges-stage {
    display: none;
}

.mychanges-popup-content .mychanges-stage.active {
    display: block;
}

/* ==================== Stage Wrapper ==================== */
.mychanges-stage-wrapper {
    display: flex;
    height: 100%;
    min-height: 520px;
	    max-height: 800px;
    border-radius: 40px;
    overflow: hidden;
}

.mychanges-stage-left {
    flex: 1.4;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mychanges-stage-image {
    width: 60%;
    display: block;
}

.mychanges-stage-right {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
}

.mychanges-stage-box {
    background: #FFFFFF;
    border-radius: 28px;
    padding: 36px 72px;
    width: 100%;
  
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

/* دکمه بستن */
.mychanges-close {
    position: absolute;
    top: 16px;
    right: 16px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    z-index: 10;
}

.mychanges-close img {
    width: 40px;
    height: 40px;
}

/* لوگو */
.mychanges-logo {
    margin-bottom: 28px;
    margin-top: 12px;
}

.mychanges-logo img {
    height: 42px;
    width: auto;
}

/* عنوان و توضیحات */
.mychanges-title {
    font-size: 24px;
    font-weight: 700;
    color: #000000;
    margin: 0 0 12px 0;
    text-align: center;
}

.mychanges-desc {
    font-size: 14px;
    font-weight: 400;
    color: #6B6B6F;
    line-height: 1.7;
    text-align: center;
    margin: 0 0 28px 0;
}

/* فیلدهای فرم */
.mychanges-form-field {
    position: relative;
    width: 100%;
    
    margin-bottom: 16px;
}

.mychanges-form-field input {
    width: 100%;
    height: 56px;
    border: 1px solid rgba(0, 0, 0, 0.12);
    border-radius: 1000000px;
    padding: 8px 20px;
    font-size: 16px;
    font-family: 'iranyekan', sans-serif;
    box-sizing: border-box;
    transition: all 0.3s ease;
    text-align: right;
    background: #fff;
}

.mychanges-form-field label {
    position: absolute;
    top: 50%;
    right: 29px;
    transform: translateY(-50%);
    font-size: 16px;
    color: #161618;
    font-family: 'iranyekan', sans-serif;
    pointer-events: none;
    transition: all 0.3s ease;
}

.mychanges-form-field input:focus + label,
.mychanges-form-field input:not(:placeholder-shown) + label {
    opacity: 0;
    transform: translateY(-1.5rem);
}

/* دکمه اصلی */
.mychanges-submit-button {
    background: #000000;
    border: none;
    padding: 12px 10px;
    font-size: 15px;
    color: #FFFFFF;
    border-radius: 1000000px;
    cursor: pointer;
    font-family: 'iranyekan', sans-serif;
    min-width: 240px;
    max-width: 420px;
    height: 56px;
    margin-top: 8px;
    margin-bottom: 20px;
    transition: background-color 0.3s ease;
}

.mychanges-submit-button:hover {
    background: #000000;
}

.mychanges-submit-button.active {
    background: #000000;
    color: #FFFFFF;
}

/* ==================== موبایل ==================== */
@media only screen and (max-width: 768px) {
    .mychanges-popup-overlay {
        z-index: 9999;
    }

    .mychanges-popup-content {
        width: 100%;
        height: 100%;
        border-radius: 0;
		    min-width: unset;
    }

    .mychanges-stage-wrapper {
        flex-direction: column;
        min-height: auto;
        border-radius: 0;
		        height: 100vh;
    }

    .mychanges-stage-left {
        display: none;
    }

    .mychanges-stage-right {
        padding: 0;
    }

    .mychanges-stage-box {
        padding: 28px 20px;
        border-radius: 24px;
        max-width: 100%;
    }

    .mychanges-close {
        top: 12px;
        right: 12px;
    }

    .mychanges-close img {
        width: 36px;
        height: 36px;
    }

    .mychanges-title {
        font-size: 22px;
    }

    .mychanges-desc {
        font-size: 13px;
        margin-bottom: 24px;
    }

    .mychanges-form-field,
    .mychanges-submit-button {
        max-width: 100%;
    }
}
</style>

<div class="mychanges-popup-overlay" id="mychanges-popup">
  <div class="mychanges-popup-content">

   <!-- ==================== استیج ۱ - تغییرات من (عکس‌های قبل / بعد) ==================== -->
<div class="mychanges-stage active" id="mychanges-stage-1">
  <div class="mychanges-stage-wrapper">
    <div class="mychanges-stage-right">
      <div class="mychanges-stage-box mychanges-view-box">

        <!-- دکمه بستن -->
        <button class="mychanges-close">
          <img src="http://6tofit.com/wp-content/uploads/2025/10/State.svg" alt="Close">
        </button>

        <!-- عنوان -->
        <h2 class="mychanges-view-title">تغییرات من</h2>

        <!-- ==================== تب‌ها ==================== -->
        <div class="mychanges-tabs-container">
          <div class="mychanges-tab active" data-tab="before" onclick="switchMyChangesTab('before', this)">
            عکس‌های قبل
          </div>
          <div class="mychanges-tab" data-tab="after" onclick="switchMyChangesTab('after', this)">
            عکس‌های بعد
          </div>
        </div>

        <!-- ==================== محتوای تب قبل ==================== -->
        <div class="mychanges-tab-content active" id="mychanges-tab-before">

          <!-- حالت بدون عکس -->
          <div class="mychanges-empty-state" id="mychanges-before-empty">
            <p>
              یادت نره از مسیر پیشرفتت عکس بگیری و به پروفایلت اضافه کنی. این کار بهت نشون می‌ده چقدر جلو رفتی و انگیزه‌ی دوباره‌ای بهت می‌ده برای ادامه‌ی راه.
            </p>
          </div>

          <!-- لیست عکس‌ها (وقتی عکس داره) -->
          <div class="mychanges-photos-grid" id="mychanges-before-grid" style="display: none;">
            <!-- اینجا بعداً با PHP یا JS عکس‌ها لود می‌شن -->
            <!-- مثال ساختار هر ردیف:
            <div class="mychanges-photo-row">
              <div class="mychanges-photo-item">
                <img src="..." alt="قبل">
                <button class="mychanges-photo-edit-btn" onclick="editMyChangesPhoto('before', 'PHOTO_ID')">
                  <img src="آیکون-ویرایش-خودت.svg" alt="ویرایش">
                </button>
              </div>
              <div class="mychanges-photo-item">
                <img src="..." alt="قبل">
                <button class="mychanges-photo-edit-btn" onclick="editMyChangesPhoto('before', 'PHOTO_ID')">
                  <img src="آیکون-ویرایش-خودت.svg" alt="ویرایش">
                </button>
              </div>
            </div>
            -->
          </div>

          <!-- دکمه افزودن عکس جدید (قبل) -->
          <button class="mychanges-add-photo-btn" onclick="addMyChangesPhoto('before')">
            + افزودن عکس جدید
          </button>
        </div>

        <!-- ==================== محتوای تب بعد ==================== -->
        <div class="mychanges-tab-content" id="mychanges-tab-after">

          <!-- حالت بدون عکس -->
          <div class="mychanges-empty-state" id="mychanges-after-empty">
            <p>
              یادت نره از مسیر پیشرفتت عکس بگیری و به پروفایلت اضافه کنی. این کار بهت نشون می‌ده چقدر جلو رفتی و انگیزه‌ی دوباره‌ای بهت می‌ده برای ادامه‌ی راه.
            </p>
          </div>

          <!-- لیست عکس‌ها (وقتی عکس داره) -->
          <div class="mychanges-photos-grid" id="mychanges-after-grid" style="display: none;">
            <!-- همین ساختار بالا -->
          </div>

          <!-- دکمه افزودن عکس جدید (بعد) -->
          <button class="mychanges-add-photo-btn" onclick="addMyChangesPhoto('after')">
            + افزودن عکس جدید
          </button>
        </div>

      </div>
    </div>
  </div>
</div>

<style>
/* ==================== استیج ۱ - تغییرات من ==================== */
.mychanges-view-title {
  font-size: 22px;
  font-weight: 600;
  color: #000000;
  margin: 42px 0 28px 0;
  text-align: right;
  width: 100%;
  padding-right: 68px;
}

/* کانتینر تب‌ها */
.mychanges-tabs-container {
  width: 80%;
  background: #F0F0F1;
  border-radius: 1000px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  padding: 5px;
}

/* استایل تب‌ها */
.mychanges-tab {
  flex: 1;
  text-align: center;
  padding: 14px 0;
  font-size: 16px;
  font-weight: 700;
  color: #65656D;
  background: transparent;
  cursor: pointer;
  transition: all 0.25s ease;
  border-radius: 1000px;
  font-family: 'iranyekan', sans-serif;
}

/* تب فعال */
.mychanges-tab.active {
  background: #FFFFFF;
  color: #161618;
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

/* محتوای تب‌ها */
.mychanges-tab-content {
  width: 100%;
  max-width: 420px;
  display: none;
  flex-direction: column;
  align-items: center;
}

.mychanges-tab-content.active {
  display: flex;
}

/* حالت خالی */
.mychanges-empty-state {
  text-align: center;
  padding: 40px 16px 30px;
}

.mychanges-empty-state p {
  font-size: 14px;
  line-height: 1.8;
  color: #6B6B6F;
  font-family: 'iranyekan', sans-serif;
  margin: 0;
}

/* ==================== استایل‌های جدید برای استیج ۱ ==================== */
.mychanges-photos-grid {
  width: 100%;
  max-height: 280px;          /* تقریباً ارتفاع دو ردیف */
  overflow-y: auto;           /* اسکرول عمودی */
  overflow-x: hidden;
  margin-bottom: 20px;
  padding-left: 4px;          /* فضای کوچک برای اسکرول‌بار */
  scrollbar-width: thin;      /* اسکرول‌بار نازک در فایرفاکس */
}
/* ظاهر اسکرول‌بار در کروم و سافاری */
.mychanges-photos-grid::-webkit-scrollbar {
  width: 5px;
}

.mychanges-photos-grid::-webkit-scrollbar-track {
  background: transparent;
}

.mychanges-photos-grid::-webkit-scrollbar-thumb {
  background: #D0D0D3;
  border-radius: 10px;
}

.mychanges-photos-grid::-webkit-scrollbar-thumb:hover {
  background: #A0A0A5;
}

/* اطمینان از اینکه ردیف‌ها درست فاصله داشته باشن */
.mychanges-photo-row {
  display: flex;
  gap: 12px;
  margin-bottom: 12px;
  align-items: flex-start;
}

.mychanges-photo-row:last-child {
  margin-bottom: 0;
}

.mychanges-photo-row {
    display: flex;
    gap: 12px;
    margin-bottom: 12px;
    align-items: flex-start;
}

.mychanges-photo-item {
    position: relative;
    flex: 1;
    aspect-ratio: 1 / 1;
    border-radius: 16px;
    overflow: hidden;
    background: #F2F2F8;
    min-height: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mychanges-photo-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    border-radius: 16px;
}

.mychanges-photo-edit-btn {
    position: absolute;
    top: 8px;
    left: 8px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255,255,255,0.9);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    padding: 0;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    z-index: 5;
}

.mychanges-photo-edit-btn img {
    width: 16px;
    height: 16px;
    object-fit: contain;
}

.mychanges-add-photo-btn {
    background: #000000;
    border: none;
    padding: 12px 10px;
    font-size: 15px;
    color: #FFFFFF;
    border-radius: 1000000px;
    cursor: pointer;
    font-family: 'iranyekan', sans-serif;
    min-width: 250px;
    max-width: 420px;
    height: 56px;
    margin-top: 40px;
    margin-bottom: 10px;
    transition: background-color 0.3s ease;
}

.mychanges-add-photo-btn:hover {
    background: #222;
}

/* موبایل */
@media only screen and (max-width: 768px) {
    .mychanges-view-box {
        padding: 32px 20px 28px !important;
		        height: 100%;
				justify-content: space-between;
    }

    .mychanges-view-title {
        font-size: 20px;
        margin-bottom: 24px;
                padding-right: 0px;
        text-align: center;
        margin: 0px 5px 18px;
    }

    .mychanges-tabs-container {
        width: 100%;
    }

    .mychanges-tab {
        font-size: 14px;
        padding: 12px 0;
    }

    .mychanges-tab-content {
        max-width: 100%;
    }

    .mychanges-empty-state {
        padding: 28px 10px 24px;
    }

    .mychanges-empty-state p {
        font-size: 13px;
    }

    .mychanges-photo-row {
        gap: 10px;
    }

    .mychanges-photo-edit-btn {
        width: 28px;
        height: 28px;
    }

    .mychanges-photo-edit-btn img {
        width: 14px;
        height: 14px;
    }
}
</style>

<script>
// ==================== تب‌های استیج ۱ ====================
window.switchMyChangesTab = function(tabName, btn) {
  // فعال کردن تب
  document.querySelectorAll('.mychanges-tab').forEach(t => t.classList.remove('active'));
  if (btn) btn.classList.add('active');

  // نمایش محتوای مربوطه
  document.querySelectorAll('.mychanges-tab-content').forEach(c => c.classList.remove('active'));
  const content = document.getElementById('mychanges-tab-' + tabName);
  if (content) content.classList.add('active');
};

// افزودن عکس جدید (قبل یا بعد)
// افزودن عکس جدید (قبل یا بعد)
window.addMyChangesPhoto = function(type) {
  // type = 'before' یا 'after'
  window.mychangesCurrentPhotoType = type;
  window.mychangesCurrentPhotoId   = null;
  window.mychangesIsNewPhoto       = true;

  // مهم: فرم رو کامل پاک کن تا دیتای ویرایش قبلی نمونه
  resetMyChangesUploadForm();

  // برو به استیج ۲
  showMyChangesStage('mychanges-stage-2');
};

// ویرایش عکس موجود
// ویرایش عکس موجود
window.editMyChangesPhoto = function(type, photoId) {
    window.mychangesCurrentPhotoType = type;
    window.mychangesCurrentPhotoId   = photoId;
    window.mychangesIsNewPhoto       = false;

    showMyChangesStage('mychanges-stage-2');

    // بعد از نمایش استیج، فرم را با دیتای عکس پر می‌کنیم
    setTimeout(() => {
        fillMyChangesEditForm(photoId);
    }, 80);
};

// این تابع رو هم اضافه کن (ساده)
// پر کردن فرم استیج ۲ برای ویرایش عکس
function fillMyChangesEditForm(photoId) {
    // اول لیست فعلی رو دوباره از سرور لود می‌کنیم (قبل از پر کردن فرم)
    loadMyChangesPhotosFromServer();

    // بعد از لود شدن لیست، دیتای عکس رو پیدا می‌کنیم
    setTimeout(() => {
        const photo = findPhotoById(photoId);
        if (!photo) {
            showMyChangesToast('عکس پیدا نشد!', 'error');
            return;
        }

        // پر کردن پیش‌نمایش عکس
        const preview = document.getElementById('mychanges-upload-preview');
        const previewImg = document.getElementById('mychanges-preview-img');
        const input = document.getElementById('mychanges-photo-input');

        preview.style.display = 'block';
        previewImg.src = photo.url;
        input.value = ''; // فایل جدید رو پاک می‌کنیم (فقط ویرایش)

        // پر کردن فیلدها
        const dateEl    = document.getElementById('mychanges-photo-date');
        const weightEl  = document.getElementById('mychanges-photo-weight');
        const descEl    = document.getElementById('mychanges-photo-desc');

        if (dateEl)    dateEl.value = photo.date || '';
        if (weightEl)  weightEl.value = photo.weight || '';
        if (descEl)    descEl.value = photo.description || '';

        // فعال کردن دکمه حذف
        enableMyChangesDeleteBtn(true);
    }, 300);
}

// پیدا کردن عکس بر اساس ID از لیست فعلی
function findPhotoById(photoId) {
    const lists = [getPhotosFromGrid('before'), getPhotosFromGrid('after')];
    for (let list of lists) {
        for (let p of list) {
            if (p.id == photoId) return p;
        }
    }
    return null;
}

function getPhotosFromGrid(type) {
    const grid = document.getElementById(`mychanges-${type}-grid`);
    if (!grid) return [];

    const photos = [];
    grid.querySelectorAll('.mychanges-photo-item').forEach(item => {
        const img = item.querySelector('img');
        const btn = item.querySelector('.mychanges-photo-edit-btn');

        if (img && btn) {
            photos.push({
                id: btn.getAttribute('data-photo-id') || '',
                url: img.src,
                date: img.getAttribute('data-date') || '',
                weight: parseFloat(img.getAttribute('data-weight')) || null,
                description: img.getAttribute('data-desc') || ''
            });
        }
    });
    return photos;
}
// این فانکشن رو بعداً می‌تونی صدا بزنی تا عکس‌ها رو لود کنی
// مثلاً بعد از لود شدن صفحه یا بعد از ذخیره عکس
window.loadMyChangesPhotos = function(beforePhotos = [], afterPhotos = []) {
  // beforePhotos و afterPhotos آرایه‌ای از آبجکت‌ها باشن:
  // [{ id: 1, url: '...' }, { id: 2, url: '...' }, ...]

  renderMyChangesPhotos('before', beforePhotos);
  renderMyChangesPhotos('after', afterPhotos);
};

// ==================== رندر عکس‌ها با منطق جدید ====================
function renderMyChangesPhotos(type, photos) {
    const emptyEl = document.getElementById(`mychanges-${type}-empty`);
    const gridEl  = document.getElementById(`mychanges-${type}-grid`);

    if (!emptyEl || !gridEl) return;

    emptyEl.style.display = 'none';
    gridEl.style.display  = 'block';
    gridEl.innerHTML = '';

    // اگر هیچ عکسی نبود، فقط خالی نمایش بده
    if (!photos || photos.length === 0) {
        gridEl.innerHTML = `
            <div class="mychanges-photo-row">
                <div class="mychanges-photo-item empty">
                    <div style="text-align:center; padding:40px 0; color:#999;">
                        <p></p>
                    </div>
                </div>
            </div>
        `;
        return;
    }

    // حالا همیشه دقیقاً دو ستون (ردیف دو عکس)
    for (let i = 0; i < photos.length; i += 2) {
        const row = document.createElement('div');
        row.className = 'mychanges-photo-row';

        row.appendChild(createPhotoItem(type, photos[i]));

        if (photos[i + 1]) {
            row.appendChild(createPhotoItem(type, photos[i + 1]));
        } else {
            // ردیف خالی
            const emptyItem = document.createElement('div');
            emptyItem.className = 'mychanges-photo-item empty';
            emptyItem.innerHTML = `
                <div style="display:flex; align-items:center; justify-content:center; width:100%; height:100%;">
                    <div style="text-align:center; padding:20px 0; color:#999;">
                        <p>هنوز عکسی اضافه نشده</p>
                    </div>
                </div>
            `;
            row.appendChild(emptyItem);
        }

        gridEl.appendChild(row);
    }
}
function createPhotoItem(type, photo) {
    const item = document.createElement('div');
    item.className = 'mychanges-photo-item';

    item.innerHTML = `
        <img src="${photo.url || ''}" 
             alt="${type === 'before' ? 'قبل' : 'بعد'}" 
             data-date="${photo.date || ''}" 
             data-weight="${photo.weight || ''}" 
             data-desc="${photo.description || ''}"
             style="cursor: pointer;"
             onclick="openMyChangesPhotoDetail('${type}', '${photo.id}')">
        <button class="mychanges-photo-edit-btn" 
                onclick="event.stopPropagation(); editMyChangesPhoto('${type}', '${photo.id}')"
                data-photo-id="${photo.id || ''}">
            <img src="http://6tofit.com/wp-content/uploads/2026/08/Icon-Button.svg" alt="ویرایش">
        </button>
    `;

    return item;
}
</script>

<!-- ==================== استیج ۲ - بارگذاری عکس ==================== -->
<div class="mychanges-stage" id="mychanges-stage-2">
  <div class="mychanges-stage-wrapper">
    <div class="mychanges-stage-right">
      <div class="mychanges-stage-box mychanges-upload-box">

        <!-- دکمه بازگشت به استیج ۱ -->
        <button class="mychanges-back-btn" onclick="showMyChangesStage('mychanges-stage-1')">
          <img src="http://6tofit.com/wp-content/uploads/2026/08/State-Layer.svg" alt="Back">
        </button>

        <!-- عنوان وسط‌چین -->
        <h2 class="mychanges-upload-title">بارگذاری عکس</h2>

        <!-- ==================== باکس آپلود تصویر ==================== -->
        <div class="mychanges-upload-area" id="mychanges-upload-area" onclick="triggerMyChangesFileInput()">
          <input type="file" id="mychanges-photo-input" accept="image/png, image/jpeg, image/jpg" style="display: none;" onchange="handleMyChangesPhotoSelect(event)">

          <!-- حالت خالی (قبل از انتخاب عکس) -->
          <div class="mychanges-upload-placeholder" id="mychanges-upload-placeholder">
            <div class="mychanges-upload-icon">
              <!-- آیکن آپلود خودت رو اینجا بگذار -->
              <img src="http://6tofit.com/wp-content/uploads/2026/08/Frame-1597880727.svg" alt="Upload">
            </div>
            <p class="mychanges-upload-text">عکس را از فایل‌های خود انتخاب کنید</p>
            <p class="mychanges-upload-hint">عکس باید با فرمت png یا jpeg و تا اندازه ۵ مگابایت باشد</p>
          </div>

          <!-- پیش‌نمایش عکس بعد از انتخاب -->
          <div class="mychanges-upload-preview" id="mychanges-upload-preview" style="display: none;">
            <img id="mychanges-preview-img" src="" alt="Preview">
          </div>
        </div>

        <!-- ==================== فیلدهای اطلاعات ==================== -->
        <div class="mychanges-fields-wrapper">

          <!-- ردیف تاریخ + وزن -->
          <div class="mychanges-fields-row">
            <!-- تاریخ گرفته شدن تصویر -->
            <div class="mychanges-form-field mychanges-date-field">
              <input type="text" id="mychanges-photo-date" placeholder=" " readonly value="">
              <label for="mychanges-photo-date">تاریخ گرفته شدن تصویر</label>
              <button type="button" class="mychanges-date-icon" onclick="openMyChangesPhotoDatePicker()">
                <!-- آیکن تقویم خودت رو اینجا بگذار -->
                <img src="http://6tofit.com/wp-content/uploads/2026/08/Calendar-Iconly-Pro.svg" alt="Calendar">
              </button>
            </div>

            <!-- وزن در عکس -->
            <div class="mychanges-form-field mychanges-weight-field">
              <input type="number" id="mychanges-photo-weight" placeholder=" " step="0.1" min="0">
              <label for="mychanges-photo-weight">وزن در عکس</label>
              <span class="mychanges-weight-unit">کیلوگرم</span>
            </div>
          </div>

          <!-- فیلد توضیحات -->
          <div class="mychanges-form-field mychanges-desc-field">
            <textarea id="mychanges-photo-desc" placeholder=" " rows="3"></textarea>
            <label for="mychanges-photo-desc">توضیحات</label>
          </div>
        </div>

        <!-- ==================== دکمه‌های پایین ==================== -->
        <div class="mychanges-actions-row">
		 <!-- سمت راست: تایید + انصراف -->
          <div class="mychanges-actions-right">
		     <button type="button" class="mychanges-confirm-btn" id="mychanges-confirm-btn" onclick="confirmMyChangesPhoto()">
              تایید
            </button>
            <button type="button" class="mychanges-cancel-btn" onclick="showMyChangesStage('mychanges-stage-1')">
              انصراف
            </button>
         
          </div>
          <!-- سمت چپ: حذف عکس -->
          <button type="button" class="mychanges-delete-btn disabled" id="mychanges-delete-btn" disabled onclick="deleteMyChangesPhoto()">
            حذف عکس
          </button>

         
        </div>

      </div>
    </div>
  </div>
</div>

<style>
/* ==================== استیج ۲ - بارگذاری عکس ==================== */
.mychanges-upload-box {
  padding: 48px 48px 36px !important;

}

.mychanges-back-btn {
  position: absolute;
  top: 16px;
  right: 16px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
  z-index: 10;
}

.mychanges-back-btn img {
  width: 40px;
  height: 40px;
}

/* عنوان وسط‌چین */
.mychanges-upload-title {
  font-size: 22px;
  font-weight: 600;
  color: #000000;
  margin: 12px 0 28px 0;
  text-align: center;
  width: 100%;
  font-family: 'iranyekan', sans-serif;
}

/* ==================== باکس آپلود ==================== */
.mychanges-upload-area {
  width: 300px;
  height: 300px;
  border: 2px dashed #D0D0D3;
  border-radius: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  margin: 0 auto 28px;
  background: #FAFAFA;
  transition: all 0.25s ease;
  overflow: hidden;
  position: relative;
}

.mychanges-upload-area:hover {
  border-color: #A0A0A5;
  background: #F5F5F7;
}

.mychanges-upload-placeholder {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 20px;
}

.mychanges-upload-icon {
  width: 56px;
  height: 56px;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.mychanges-upload-icon img {
  width: 48px;
  height: 48px;
  object-fit: contain;
}

.mychanges-upload-text {
  font-size: 15px;
  font-weight: 500;
  color: #161618;
  margin: 0 0 8px 0;
  font-family: 'iranyekan', sans-serif;
}

.mychanges-upload-hint {
  font-size: 12px;
  color: #9B9BA1;
  margin: 0;
  line-height: 1.5;
  font-family: 'iranyekan', sans-serif;
}

/* پیش‌نمایش عکس */
.mychanges-upload-preview {
  width: 100%;
  height: 100%;
  position: absolute;
  inset: 0;
}

.mychanges-upload-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

/* ==================== فیلدها ==================== */
.mychanges-fields-wrapper {
  width: 100%;
  max-width: 520px;
  margin: 0 auto 24px;
}

.mychanges-fields-row {
  display: flex;
  gap: 12px;
  margin-bottom: 16px;
}

.mychanges-form-field {
  position: relative;
  flex: 1;
  margin-bottom: 0;
}

.mychanges-form-field input,
.mychanges-form-field textarea {
  width: 100%;
  height: 56px;
  border: 1px solid rgba(0, 0, 0, 0.12);
  border-radius: 1000000px;
  padding: 8px 20px;
  font-size: 16px;
  font-family: 'iranyekan', sans-serif;
  box-sizing: border-box;
  transition: all 0.3s ease;
  text-align: right;
  background: #fff;
  color: #161618;
}

.mychanges-form-field textarea {
  height: auto;
  min-height: 100px;
  border-radius: 20px;
  padding: 16px 20px;
  resize: none;
  line-height: 1.5;
}

.mychanges-form-field label {
  position: absolute;
  top: 50%;
  right: 20px;
  transform: translateY(-50%);
  font-size: 15px;
  color: #9B9BA1;
  font-family: 'iranyekan', sans-serif;
  pointer-events: none;
  transition: all 0.25s ease;
  background: #fff;
  padding: 0 4px;
}

.mychanges-form-field textarea + label {
  top: 18px;
  transform: none;
}

.mychanges-form-field input:focus + label,
.mychanges-form-field input:not(:placeholder-shown) + label,
.mychanges-form-field textarea:focus + label,
.mychanges-form-field textarea:not(:placeholder-shown) + label {
  opacity: 0;
  visibility: hidden;
}

/* فیلد تاریخ */
.mychanges-date-field input {
  padding-left: 48px !important;
  cursor: pointer;
}

.mychanges-date-icon {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 5;
}

.mychanges-date-icon img {
  width: 22px;
  height: 22px;
}

/* فیلد وزن */
.mychanges-weight-field input {
  padding-left: 70px !important;
}

.mychanges-weight-unit {
  position: absolute;
  left: 16px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 13px;
  color: #9B9BA1;
  font-family: 'iranyekan', sans-serif;
  pointer-events: none;
}

/* ==================== دکمه‌های پایین ==================== */
.mychanges-actions-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  max-width: 520px;
  margin: 0 auto;
  gap: 12px;
}

.mychanges-actions-right {
  display: flex;
  gap: 10px;
}

/* دکمه حذف */
.mychanges-delete-btn {
  background: transparent;
  border:  unset;
  color:  #FF4D4F;
  padding: 0 20px;
  height: 52px;

  font-size: 14px;
  font-family: 'iranyekan', sans-serif;
  cursor: pointer;
  transition: all 0.25s ease;
  white-space: nowrap;
}

.mychanges-delete-btn.disabled,
.mychanges-delete-btn:disabled {
  opacity: 0.35;
  cursor: not-allowed;
  border: unset;
  color: #FF4D4F;
}

.mychanges-delete-btn:not(.disabled):hover {
  background: #FFF1F0;
}

/* دکمه انصراف */
.mychanges-cancel-btn {
  background: #FFFFFF;
  border: 1px solid #D0D0D3;
  color: #161618;
  padding: 0 24px;
  height: 52px;
  border-radius: 100px;
  font-size: 14px;
  font-family: 'iranyekan', sans-serif;
  cursor: pointer;
  transition: all 0.25s ease;
}

.mychanges-cancel-btn:hover {
  background: #F5F5F7;
}

/* دکمه تایید */
.mychanges-confirm-btn {
  background: #000000;
  border: none;
  color: #FFFFFF;
  padding: 0 28px;
  height: 52px;
  border-radius: 100px;
  font-size: 14px;
  font-family: 'iranyekan', sans-serif;
  cursor: pointer;
  transition: all 0.25s ease;
  min-width: 110px;
}

.mychanges-confirm-btn:hover {
  background: #222;
}

/* موبایل */
@media only screen and (max-width: 768px) {
  .mychanges-upload-box {
    padding: 32px 20px 28px !important;
  }

  .mychanges-back-btn {
    top: 12px;
    right: 12px;
  }

  .mychanges-back-btn img {
    width: 36px;
    height: 36px;
  }

  .mychanges-upload-title {
    font-size: 20px;
        margin: 0px 0 10px 0;
  }

  .mychanges-upload-area {
    width: 260px;
    height: 160px;
  }
    .mychanges-popup-content:has(#mychanges-stage-3.active) {
    background: unset;
	display: flex;
        flex-direction: column;
        justify-content: flex-end;
}

  .mychanges-fields-row {
    flex-direction: column;
    gap: 12px;
  }

  .mychanges-actions-row {
    flex-direction: column-reverse;
    gap: 12px;
  }

  .mychanges-actions-right {
    width: 100%;
    justify-content: space-between;
  }

  .mychanges-delete-btn,
  .mychanges-cancel-btn,
  .mychanges-confirm-btn {
    flex: 1;
    height: 50px;
  }
}
</style>

<script>
// ==================== استیج ۲ - بارگذاری عکس ====================

let mychangesSelectedPhotoFile = null;   // فایل انتخاب‌شده
let mychangesSelectedPhotoDataUrl = null; // base64 پیش‌نمایش

// باز کردن فایل‌پیکر
window.triggerMyChangesFileInput = function() {
  document.getElementById('mychanges-photo-input').click();
};

// انتخاب فایل
window.handleMyChangesPhotoSelect = function(event) {
  const file = event.target.files[0];
  if (!file) return;

  // اعتبارسنجی فرمت
  const validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
  if (!validTypes.includes(file.type)) {
    showMyChangesToast('فرمت فایل باید PNG یا JPEG باشد', 'error');
    return;
  }

  // اعتبارسنجی حجم (۵ مگابایت)
  if (file.size > 5 * 1024 * 1024) {
    showMyChangesToast('حجم عکس نباید بیشتر از ۵ مگابایت باشد', 'error');
    return;
  }

  mychangesSelectedPhotoFile = file;

  const reader = new FileReader();
  reader.onload = function(e) {
    mychangesSelectedPhotoDataUrl = e.target.result;

    // نمایش پیش‌نمایش
    const placeholder = document.getElementById('mychanges-upload-placeholder');
    const preview = document.getElementById('mychanges-upload-preview');
    const previewImg = document.getElementById('mychanges-preview-img');

    if (placeholder) placeholder.style.display = 'none';
    if (preview) preview.style.display = 'block';
    if (previewImg) previewImg.src = mychangesSelectedPhotoDataUrl;

    // فعال کردن دکمه حذف
    enableMyChangesDeleteBtn(true);
  };
  reader.readAsDataURL(file);
};

// فعال / غیرفعال کردن دکمه حذف
function enableMyChangesDeleteBtn(enable) {
    const btn = document.getElementById('mychanges-delete-btn');
    if (!btn) return;

    if (enable) {
        btn.classList.remove('disabled');
        btn.disabled = false;
    } else {
        btn.classList.add('disabled');
        btn.disabled = true;
    }
}

// حذف عکس انتخاب‌شده
// حذف از استیج ۲ (وقتی عکس موجود ویرایش می‌شود)
window.deleteMyChangesPhoto = async function() {
    const photoId = window.mychangesCurrentPhotoId;

    // اگر عکس جدید است (هنوز ذخیره نشده)
    if (!photoId) {
        // فقط ریست لوکال
        mychangesSelectedPhotoFile = null;
        mychangesSelectedPhotoDataUrl = null;

        const placeholder = document.getElementById('mychanges-upload-placeholder');
        const preview = document.getElementById('mychanges-upload-preview');
        const previewImg = document.getElementById('mychanges-preview-img');
        const input = document.getElementById('mychanges-photo-input');

        if (placeholder) placeholder.style.display = 'flex';
        if (preview) preview.style.display = 'none';
        if (previewImg) previewImg.src = '';
        if (input) input.value = '';

        enableMyChangesDeleteBtn(false);
        return;
    }

    // حذف از سرور
    if (!confirm('آیا از حذف این عکس مطمئن هستید؟')) return;

    const formData = new FormData();
    formData.append('action', 'delete_my_changes_photo');
    formData.append('photo_id', photoId);

    try {
        const res = await fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();

        if (data.success) {
            showMyChangesToast('عکس حذف شد', 'success');
            loadMyChangesPhotosFromServer(); // آپدیت لایو

            setTimeout(() => {
                hideMyChangesToast();
                resetMyChangesUploadForm();
                showMyChangesStage('mychanges-stage-1');
            }, 1200);
        } else {
            showMyChangesToast(data.data?.message || 'خطا در حذف', 'error');
        }
    } catch (err) {
        console.error(err);
        showMyChangesToast('خطا در ارتباط با سرور', 'error');
    }
};

// باز کردن انتخابگر تاریخ برای عکس
window.openMyChangesPhotoDatePicker = function() {
  // علامت می‌زنیم که تاریخ برای فیلد عکس است (نه تاریخ تولد)
  window.mychangesDateTarget = 'photo';
  showMyChangesStage('mychanges-stage-3');
  setTimeout(initMyChangesDatePicker, 50);
  setTimeout(initMyChangesDatePicker, 150);
  setTimeout(initMyChangesDatePicker, 300);
};

// تایید و ذخیره عکس
window.confirmMyChangesPhoto = async function() {
    const date   = document.getElementById('mychanges-photo-date')?.value.trim();
    const weight = document.getElementById('mychanges-photo-weight')?.value.trim();
    const desc   = document.getElementById('mychanges-photo-desc')?.value.trim();
    const type   = window.mychangesCurrentPhotoType || 'before';
    const photoId = window.mychangesCurrentPhotoId || 0;

    if (!mychangesSelectedPhotoFile && !mychangesSelectedPhotoDataUrl && !photoId) {
        showMyChangesToast('لطفاً یک عکس انتخاب کنید', 'error');
        return;
    }

    if (!date) {
        showMyChangesToast('لطفاً تاریخ گرفته شدن تصویر را انتخاب کنید', 'error');
        return;
    }

    const btn = document.getElementById('mychanges-confirm-btn');
    if (btn) {
        btn.disabled = true;
        btn.textContent = 'در حال ذخیره...';
    }

    const formData = new FormData();
    formData.append('action', 'save_my_changes_photo');
    formData.append('type', type);
    formData.append('date', date);
    formData.append('weight', weight || '');
    formData.append('description', desc || '');
    formData.append('photo_id', photoId);

    // اگر فایل جدید انتخاب شده
    if (mychangesSelectedPhotoFile) {
        formData.append('photo', mychangesSelectedPhotoFile);
    }

    try {
        const res = await fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();

        if (btn) {
            btn.disabled = false;
            btn.textContent = 'تایید';
        }

        if (data.success) {
            showMyChangesToast(data.data.message || 'عملیات با موفقیت انجام شد', 'success');

            // آپدیت لایو لیست عکس‌ها
            loadMyChangesPhotosFromServer();

            setTimeout(() => {
                hideMyChangesToast();
                resetMyChangesUploadForm();
                showMyChangesStage('mychanges-stage-1');
            }, 1400);
        } else {
            showMyChangesToast(data.data?.message || 'خطا در ذخیره', 'error');
        }
    } catch (err) {
        console.error(err);
        if (btn) {
            btn.disabled = false;
            btn.textContent = 'تایید';
        }
        showMyChangesToast('خطا در ارتباط با سرور', 'error');
    }
};

// ریست کردن فرم آپلود
function resetMyChangesUploadForm() {
    // ریست فرم آپلود
    mychangesSelectedPhotoFile = null;
    mychangesSelectedPhotoDataUrl = null;

    const placeholder = document.getElementById('mychanges-upload-placeholder');
    const preview = document.getElementById('mychanges-upload-preview');
    const previewImg = document.getElementById('mychanges-preview-img');
    const input = document.getElementById('mychanges-photo-input');

    if (placeholder) placeholder.style.display = 'flex';
    if (preview) preview.style.display = 'none';
    if (previewImg) previewImg.src = '';
    if (input) input.value = '';

    enableMyChangesDeleteBtn(false);

    // ریست فیلدها
    const dateEl   = document.getElementById('mychanges-photo-date');
    const weightEl = document.getElementById('mychanges-photo-weight');
    const descEl   = document.getElementById('mychanges-photo-desc');

    if (dateEl)    dateEl.value = '';
    if (weightEl)  weightEl.value = '';
    if (descEl)    descEl.value = '';

    // ریست متغیرهای حالت
    window.mychangesCurrentPhotoType = null;
    window.mychangesCurrentPhotoId   = null;
    window.mychangesIsNewPhoto       = true;
}

// وقتی از استیج ۳ برمی‌گردیم، تاریخ رو داخل فیلد عکس می‌گذاریم
// این قسمت رو باید در handleMyChangesDateContinue هم آپدیت کنی
</script>

    <!-- ==================== استیج ۳ - انتخاب تاریخ تولد (دقیقاً مثل قبل) ==================== -->
    <div class="mychanges-stage" id="mychanges-stage-3">
      <div class="mychanges-stage-4-wrapper">
        <div class="mychanges-stage-4-box">

          <button class="mychanges-back-btn" onclick="showMyChangesStage('mychanges-stage-2')">
            <img src="http://6tofit.com/wp-content/uploads/2026/08/State-Layer.svg" alt="Back">
          </button>

          <h2 class="mychanges-stage-4-title">تاریخ تولد</h2>

          <div class="mychanges-date-labels">
            <span>روز</span>
            <span>ماه</span>
            <span>سال</span>
          </div>

          <div class="mychanges-date-picker">
            <div class="mychanges-date-highlight"></div>

            <div class="mychanges-date-column" data-type="day">
              <div class="mychanges-date-scroller" id="mychanges-day-scroller"></div>
            </div>

            <div class="mychanges-date-column" data-type="month">
              <div class="mychanges-date-scroller" id="mychanges-month-scroller"></div>
            </div>

            <div class="mychanges-date-column" data-type="year">
              <div class="mychanges-date-scroller" id="mychanges-year-scroller"></div>
            </div>
          </div>

          <button class="mychanges-submit-button active" id="mychanges-date-continue-btn" onclick="handleMyChangesDateContinue()">
            ادامه
          </button>

        </div>
      </div>
    </div>

<style>
/* ==================== استیج ۳ - انتخابگر تاریخ (دقیقاً مثل قبل) ==================== */
.mychanges-stage-4-wrapper {
  display: flex;
  height: 100%;
  min-height: 520px;
  border-radius: 40px;
  overflow: hidden;
}

.mychanges-stage-4-box {
  background: #FFFFFF;
  border-radius: 28px;
  padding: 48px 72px 40px;
  width: 100%;
  min-width: 620px;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
}

.mychanges-stage-4-title {
  font-size: 22px;
  font-weight: 700;
  color: #000000;
  margin: 12px 0 28px 0;
  text-align: center;
}

.mychanges-date-labels {
  display: flex;
  width: 100%;
  margin-bottom: 12px;
  font-size: 16px;
  color: #000000;
  font-family: 'iranyekan', sans-serif;
}

.mychanges-date-labels span {
  flex: 1;
  text-align: center;
}

.mychanges-date-picker {
  position: relative;
  display: flex;
  width: 100%;
  height: 192px;
  margin-bottom: 36px;
  overflow: hidden;
  user-select: none;
  -webkit-user-select: none;
}

.mychanges-date-highlight {
  position: absolute;
  top: 40%;
  left: 8px;
  right: 8px;
  height: 48px;
  transform: translateY(-50%);
  background: #F2F2F8;
  border-radius: 14px;
  z-index: 1;
  pointer-events: none;
}

.mychanges-date-column {
  flex: 1;
  height: 100%;
  overflow: hidden;
  position: relative;
  z-index: 2;
  cursor: grab;
}

.mychanges-date-column:active {
  cursor: grabbing;
}

.mychanges-date-scroller {
  display: flex;
  flex-direction: column;
  align-items: center;
  will-change: transform;
}

.mychanges-date-item {
  height: 48px;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 17px;
  font-family: 'iranyekan', sans-serif;
  color: #B0B0B5;
  flex-shrink: 0;
  transition: color 0.15s ease, font-weight 0.15s ease;
}

.mychanges-date-item.selected {
  color: #161618;
  font-weight: 700;
  font-size: 18px;
}

#mychanges-date-continue-btn {
  width: 100%;
  max-width: 320px;
  margin-top: 0;
  margin-bottom: 0;
  background: #000000 !important;
  color: #FFFFFF !important;
}

@media only screen and (max-width: 768px) {
  .mychanges-stage-4-wrapper {
    min-height: auto;
            padding: 20px 0px 0px;
			        border-radius: 40px 40px 0px 0px;
  }
  .mychanges-stage-4-title{
	      font-size: 20px;
    font-weight: 600;
	    margin: 2px 0 18px 0;
  }
  .mychanges-stage-4-box {
    padding: 36px 20px 32px;
    max-width: 100%;
    min-width: auto;
	        border-radius: 40px 40px 0px 0px;
  }
}
</style>

<script>
// ==================== استیج ۲ و ۳ - ویرایش اطلاعات + تاریخ ====================
let mychangesSelectedGender = null;
let mychangesSelectedDay = 15;
let mychangesSelectedMonth = 6;
let mychangesSelectedYear = 1375;
const MYCHANGES_ITEM_HEIGHT = 48;

const mychangesPersianMonths = [
  { num: 1, name: 'فروردین' }, { num: 2, name: 'اردیبهشت' }, { num: 3, name: 'خرداد' },
  { num: 4, name: 'تیر' }, { num: 5, name: 'مرداد' }, { num: 6, name: 'شهریور' },
  { num: 7, name: 'مهر' }, { num: 8, name: 'آبان' }, { num: 9, name: 'آذر' },
  { num: 10, name: 'دی' }, { num: 11, name: 'بهمن' }, { num: 12, name: 'اسفند' }
];

window.selectMyChangesGender = function(btn) {
  document.querySelectorAll('.mychanges-gender-btn').forEach(b => b.classList.remove('selected'));
  btn.classList.add('selected');
  mychangesSelectedGender = btn.getAttribute('data-gender');
  checkMyChangesFormComplete();
};

function checkMyChangesFormComplete() {
    const fullname  = document.getElementById('mychanges-fullname')?.value.trim();
    const phone     = document.getElementById('mychanges-phone')?.value.trim();
    const email     = document.getElementById('mychanges-email')?.value.trim();
    const birthdate = document.getElementById('mychanges-birthdate')?.value.trim();
    const gender    = mychangesSelectedGender;

    if (fullname && phone && email && birthdate && gender) {
        const btn = document.getElementById('mychanges-submit-btn');
        if (btn) btn.classList.add('active');
    } else {
        const btn = document.getElementById('mychanges-submit-btn');
        if (btn) btn.classList.remove('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
  ['mychanges-fullname', 'mychanges-phone', 'mychanges-email', 'mychanges-birthdate'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', checkMyChangesFormComplete);
  });

  const selectedBtn = document.querySelector('.mychanges-gender-btn.selected');
  if (selectedBtn) {
    mychangesSelectedGender = selectedBtn.getAttribute('data-gender');
  }
  checkMyChangesFormComplete();
});

window.openMyChangesBirthdatePicker = function() {
  showMyChangesStage('mychanges-stage-3');
  setTimeout(initMyChangesDatePicker, 50);
  setTimeout(initMyChangesDatePicker, 150);
  setTimeout(initMyChangesDatePicker, 300);
};

function createMyChangesDateScroller(scrollerId, items, selectedValue, type) {
  const scroller = document.getElementById(scrollerId);
  if (!scroller) return;

  scroller.innerHTML = '';
  const paddingCount = 2;

  for (let i = 0; i < paddingCount; i++) {
    const empty = document.createElement('div');
    empty.className = 'mychanges-date-item';
    empty.innerHTML = '&nbsp;';
    scroller.appendChild(empty);
  }

  items.forEach(item => {
    const el = document.createElement('div');
    el.className = 'mychanges-date-item';
    el.dataset.value = item.value;
    el.textContent = item.label;
    scroller.appendChild(el);
  });

  for (let i = 0; i < paddingCount; i++) {
    const empty = document.createElement('div');
    empty.className = 'mychanges-date-item';
    empty.innerHTML = '&nbsp;';
    scroller.appendChild(empty);
  }

  const selectedIndex = items.findIndex(i => i.value === selectedValue);
  const safeIndex = selectedIndex >= 0 ? selectedIndex : 0;
  const offset = (safeIndex + paddingCount - 1) * MYCHANGES_ITEM_HEIGHT;
  scroller.style.transform = `translateY(-${offset}px)`;
  updateMyChangesSelectedClass(scroller, safeIndex + paddingCount);
  setupMyChangesDrag(scroller, items, type, paddingCount);
}

function updateMyChangesSelectedClass(scroller, index) {
  scroller.querySelectorAll('.mychanges-date-item').forEach((el, i) => {
    el.classList.toggle('selected', i === index);
  });
}

function setupMyChangesDrag(scroller, items, type, paddingCount) {
  let startY = 0, startOffset = 0, isDragging = false;

  const getOffset = () => {
    const m = scroller.style.transform.match(/translateY\((-?\d+(?:\.\d+)?)px\)/);
    return m ? parseFloat(m[1]) : 0;
  };
  const setOffset = (v) => scroller.style.transform = `translateY(${v}px)`;
  const clamp = (v, min, max) => Math.max(min, Math.min(max, v));

  const onStart = (clientY) => {
    isDragging = true;
    startY = clientY;
    startOffset = getOffset();
    scroller.style.transition = 'none';
  };

  const onMove = (clientY) => {
    if (!isDragging) return;
    let newOffset = startOffset + (clientY - startY);
    const minOffset = -((items.length + paddingCount * 2 - 3) * MYCHANGES_ITEM_HEIGHT);
    newOffset = clamp(newOffset, minOffset, 0);
    setOffset(newOffset);

    const rawIndex = Math.round((-newOffset) / MYCHANGES_ITEM_HEIGHT);
    const realIndex = clamp(rawIndex - paddingCount + 1, 0, items.length - 1);
    updateMyChangesSelectedClass(scroller, realIndex + paddingCount);

    if (type === 'day') mychangesSelectedDay = items[realIndex].value;
    if (type === 'month') mychangesSelectedMonth = items[realIndex].value;
    if (type === 'year') mychangesSelectedYear = items[realIndex].value;
  };

  const onEnd = () => {
    if (!isDragging) return;
    isDragging = false;
    scroller.style.transition = 'transform 0.2s ease-out';
    const current = getOffset();
    const rawIndex = Math.round((-current) / MYCHANGES_ITEM_HEIGHT);
    const realIndex = clamp(rawIndex - paddingCount + 1, 0, items.length - 1);
    const finalOffset = -((realIndex + paddingCount - 1) * MYCHANGES_ITEM_HEIGHT);
    setOffset(finalOffset);
    updateMyChangesSelectedClass(scroller, realIndex + paddingCount);

    if (type === 'day') mychangesSelectedDay = items[realIndex].value;
    if (type === 'month') mychangesSelectedMonth = items[realIndex].value;
    if (type === 'year') mychangesSelectedYear = items[realIndex].value;
  };

  scroller.addEventListener('mousedown', e => { e.preventDefault(); onStart(e.clientY); });
  window.addEventListener('mousemove', e => onMove(e.clientY));
  window.addEventListener('mouseup', onEnd);

  scroller.addEventListener('touchstart', e => onStart(e.touches[0].clientY), { passive: true });
  scroller.addEventListener('touchmove', e => onMove(e.touches[0].clientY), { passive: true });
  scroller.addEventListener('touchend', onEnd);
}

function initMyChangesDatePicker() {
  const days = Array.from({ length: 31 }, (_, i) => ({ value: i + 1, label: String(i + 1) }));
  const months = mychangesPersianMonths.map(m => ({ value: m.num, label: m.name }));
  const years = [];
  for (let y = 1404; y >= 1330; y--) years.push({ value: y, label: String(y) });

  createMyChangesDateScroller('mychanges-day-scroller', days, mychangesSelectedDay, 'day');
  createMyChangesDateScroller('mychanges-month-scroller', months, mychangesSelectedMonth, 'month');
  createMyChangesDateScroller('mychanges-year-scroller', years, mychangesSelectedYear, 'year');
}

window.handleMyChangesDateContinue = function() {
  const formatted = `${mychangesSelectedYear}/${String(mychangesSelectedMonth).padStart(2, '0')}/${String(mychangesSelectedDay).padStart(2, '0')}`;

  if (window.mychangesDateTarget === 'photo') {
    const input = document.getElementById('mychanges-photo-date');
    if (input) {
      input.value = formatted;
      input.dispatchEvent(new Event('input'));
    }
  } else {
    // حالت قبلی (تاریخ تولد)
    const input = document.getElementById('mychanges-birthdate');
    if (input) {
      input.value = formatted;
      input.dispatchEvent(new Event('input'));
    }
  }

  showMyChangesStage('mychanges-stage-2');
  window.mychangesDateTarget = null;
};
</script>

<!-- ==================== استیج ۴ - جزئیات عکس ==================== -->
<div class="mychanges-stage" id="mychanges-stage-4">
  <div class="mychanges-stage-wrapper">
    <div class="mychanges-stage-right">
      <div class="mychanges-stage-box mychanges-photo-detail-box">

        <!-- دکمه بازگشت به استیج ۱ -->
        <button class="mychanges-back-btn" onclick="showMyChangesStage('mychanges-stage-1')">
          <img src="http://6tofit.com/wp-content/uploads/2026/08/State-Layer.svg" alt="Back">
        </button>

        <!-- تصویر اصلی -->
        <div class="mychanges-detail-image-wrapper">
          <img id="mychanges-detail-image" src="" alt="عکس">
        </div>

        <!-- ردیف تاریخ + وزن -->
        <div class="mychanges-detail-info-row">
          <!-- ستون تاریخ -->
          <div class="mychanges-detail-col">
            <span class="mychanges-detail-label">تاریخ گرفتن عکس</span>
            <span class="mychanges-detail-value" id="mychanges-detail-date">—</span>
          </div>

          <!-- بوردر وسط -->
          <div class="mychanges-detail-divider"></div>

          <!-- ستون وزن -->
          <div class="mychanges-detail-col">
            <span class="mychanges-detail-label">وزن</span>
            <span class="mychanges-detail-value" id="mychanges-detail-weight">—</span>
          </div>
        </div>

        <!-- ردیف توضیحات -->
        <div class="mychanges-detail-desc-block">
          <span class="mychanges-detail-label">توضیحات</span>
          <p class="mychanges-detail-desc-text" id="mychanges-detail-desc">—</p>
        </div>

        <!-- دکمه‌های پایین -->
        <div class="mychanges-detail-actions">
          <button type="button" class="mychanges-detail-edit-btn" onclick="editCurrentDetailPhoto()">
            ویرایش
          </button>
          <button type="button" class="mychanges-detail-delete-btn" onclick="deleteCurrentDetailPhoto()">
            حذف عکس
          </button>
        </div>

      </div>
    </div>
  </div>
</div>

<style>
/* ==================== استیج ۴ - جزئیات عکس ==================== */
.mychanges-photo-detail-box {
  padding: 48px 48px 36px !important;

}

.mychanges-detail-image-wrapper {
  width: 100%;
  max-width: 360px;
  margin: 12px auto 28px;
  border-radius: 24px;
  overflow: hidden;
  background: #F2F2F8;
  aspect-ratio: 1 / 1;
}

.mychanges-detail-image-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

/* ردیف تاریخ + وزن */
.mychanges-detail-info-row {
  display: flex;
  align-items: stretch;
  width: 100%;
  max-width: 420px;
  margin: 0 auto 24px;
  gap: 0;
}

.mychanges-detail-col {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: flex-end; /* راست‌چین */
  padding: 0 16px;
}

.mychanges-detail-divider {
  width: 1px;
  background: rgba(0, 0, 0, 0.1);
  align-self: stretch;
}

.mychanges-detail-label {
  font-size: 13px;
  color: #9B9BA1;
  font-family: 'iranyekan', sans-serif;
  margin-bottom: 6px;
  text-align: right;
  width: 100%;
}

.mychanges-detail-value {
  font-size: 16px;
  font-weight: 600;
  color: #161618;
  font-family: 'iranyekan', sans-serif;
  text-align: right;
  width: 100%;
}

/* بلوک توضیحات */
.mychanges-detail-desc-block {
  width: 100%;
  max-width: 420px;
  margin: 0 auto 32px;
  text-align: right;
}

.mychanges-detail-desc-block .mychanges-detail-label {
  display: block;
  margin-bottom: 8px;
}

.mychanges-detail-desc-text {
  font-size: 15px;
  line-height: 1.7;
  color: #161618;
  font-family: 'iranyekan', sans-serif;
  margin: 0;
  white-space: pre-wrap;
  word-break: break-word;
}

/* دکمه‌های پایین */
.mychanges-detail-actions {
  display: flex;
  gap: 12px;
  width: 100%;
  max-width: 420px;
  margin: 0 auto;
  justify-content: center;
}

.mychanges-detail-edit-btn {
  background: #000000;
  border: none;
  color: #FFFFFF;
  padding: 0 32px;
  height: 52px;
  border-radius: 100px;
  font-size: 15px;
  font-family: 'iranyekan', sans-serif;
  cursor: pointer;
  transition: background 0.25s ease;
  min-width: 140px;
}

.mychanges-detail-edit-btn:hover {
  background: #222;
}

.mychanges-detail-delete-btn {
  background: transparent;
  border: none;
  color: #FF4D4F;
  padding: 0 24px;
  height: 52px;
  font-size: 15px;
  font-family: 'iranyekan', sans-serif;
  cursor: pointer;
  transition: all 0.25s ease;
  white-space: nowrap;
}

.mychanges-detail-delete-btn:hover {
  background: #FFF1F0;
  border-radius: 100px;
}

/* موبایل */
@media only screen and (max-width: 768px) {
  .mychanges-photo-detail-box {
    padding: 32px 20px 28px !important;
  }

  .mychanges-detail-image-wrapper {
    max-width: 280px;
    margin-bottom: 24px;
  }

  .mychanges-detail-info-row,
  .mychanges-detail-desc-block,
  .mychanges-detail-actions {
    max-width: 100%;
  }

  .mychanges-detail-actions {
    flex-direction: column-reverse;
  }

  .mychanges-detail-edit-btn,
  .mychanges-detail-delete-btn {
    width: 100%;
    height: 50px;
  }
}
/* ==================== پاپ‌آپ پیام ==================== */
.userinfo-toast-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.45);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 10001;
  backdrop-filter: blur(6px);
}

.userinfo-toast-overlay.active {
  display: flex;
}

.userinfo-toast {
  background: #FFFFFF;
  border-radius: 24px;
  padding: 32px 28px 24px;
  width: 90%;
  max-width: 340px;
  text-align: center;
  box-shadow: 0 20px 50px rgba(0,0,0,0.15);
  animation: toastIn 0.25s ease;
}

@keyframes toastIn {
  from { transform: scale(0.9); opacity: 0; }
  to   { transform: scale(1); opacity: 1; }
}

.userinfo-toast-icon {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  margin: 0 auto 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
}

.userinfo-toast.success .userinfo-toast-icon {
  background: #E8F5E9;
  color: #2E7D32;
}

.userinfo-toast.error .userinfo-toast-icon {
  background: #FFEBEE;
  color: #C62828;
}

.userinfo-toast-message {
  font-size: 15px;
  color: #161618;
  line-height: 1.6;
  margin: 0 0 24px 0;
  font-family: 'iranyekan', sans-serif;
}

.userinfo-toast-close {
  background: #000;
  color: #fff;
  border: none;
  border-radius: 100px;
  padding: 12px 32px;
  font-size: 14px;
  font-family: 'iranyekan', sans-serif;
  cursor: pointer;
  min-width: 120px;
}
/* ==================== پاپ‌آپ پیام (Toast) ==================== */
.mychanges-toast-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.45);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 10001;
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
}

.mychanges-toast-overlay.active {
  display: flex !important;
}

.mychanges-toast {
  background: #FFFFFF;
  border-radius: 24px;
  padding: 32px 28px 24px;
  width: 90%;
  max-width: 340px;
  text-align: center;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
  animation: mychangesToastIn 0.25s ease;
  font-family: 'iranyekan', sans-serif;
}

@keyframes mychangesToastIn {
  from { transform: scale(0.9); opacity: 0; }
  to   { transform: scale(1); opacity: 1; }
}

.mychanges-toast-icon {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  margin: 0 auto 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  font-weight: bold;
}

.mychanges-toast.success .mychanges-toast-icon {
  background: #E8F5E9;
  color: #2E7D32;
}

.mychanges-toast.error .mychanges-toast-icon {
  background: #FFEBEE;
  color: #C62828;
}

.mychanges-toast-message {
  font-size: 15px;
  color: #161618;
  line-height: 1.6;
  margin: 0 0 24px 0;
}

.mychanges-toast-close {
  background: #000000;
  color: #FFFFFF;
  border: none;
  border-radius: 100px;
  padding: 12px 32px;
  font-size: 14px;
  font-family: 'iranyekan', sans-serif;
  cursor: pointer;
  min-width: 120px;
  transition: background 0.2s ease;
}

.mychanges-toast-close:hover {
  background: #222;
}
</style>

<script>
// ذخیره اطلاعات عکس فعلی که در استیج ۴ نمایش داده می‌شود
window.mychangesCurrentDetailPhoto = null;

// باز کردن استیج ۴ با کلیک روی عکس
window.openMyChangesPhotoDetail = function(type, photoId) {
  const photo = findPhotoById(photoId);
  if (!photo) {
    showMyChangesToast('عکس پیدا نشد!', 'error');
    return;
  }

  window.mychangesCurrentDetailPhoto = {
    id: photo.id,
    type: type,
    url: photo.url,
    date: photo.date || '',
    weight: photo.weight || null,
    description: photo.description || ''
  };

  // پر کردن UI
  const imgEl = document.getElementById('mychanges-detail-image');
  const dateEl = document.getElementById('mychanges-detail-date');
  const weightEl = document.getElementById('mychanges-detail-weight');
  const descEl = document.getElementById('mychanges-detail-desc');

  if (imgEl) imgEl.src = photo.url || '';
  if (dateEl) dateEl.textContent = photo.date || '—';
  if (weightEl) {
    weightEl.textContent = photo.weight 
      ? (photo.weight + ' کیلوگرم') 
      : '—';
  }
  if (descEl) descEl.textContent = photo.description || '—';

  showMyChangesStage('mychanges-stage-4');
};

// دکمه ویرایش در استیج ۴ → می‌رود به استیج ۲
window.editCurrentDetailPhoto = function() {
  const photo = window.mychangesCurrentDetailPhoto;
  if (!photo) return;

  // از همان تابع ویرایش قبلی استفاده می‌کنیم
  editMyChangesPhoto(photo.type, photo.id);
};

// دکمه حذف در استیج ۴
window.deleteCurrentDetailPhoto = async function() {
  const photo = window.mychangesCurrentDetailPhoto;
  if (!photo || !photo.id) return;

  if (!confirm('آیا از حذف این عکس مطمئن هستید؟')) return;

  const formData = new FormData();
  formData.append('action', 'delete_my_changes_photo');
  formData.append('photo_id', photo.id);

  try {
    const res = await fetch('/wp-admin/admin-ajax.php', {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      showMyChangesToast('عکس حذف شد', 'success');
      loadMyChangesPhotosFromServer();

      setTimeout(() => {
        hideMyChangesToast();
        window.mychangesCurrentDetailPhoto = null;
        showMyChangesStage('mychanges-stage-1');
      }, 1200);
    } else {
      showMyChangesToast(data.data?.message || 'خطا در حذف', 'error');
    }
  } catch (err) {
    console.error(err);
    showMyChangesToast('خطا در ارتباط با سرور', 'error');
  }
};
</script>



    <!-- پاپ‌آپ پیام موفقیت / خطا -->
    <div class="mychanges-toast-overlay" id="mychanges-toast-overlay">
      <div class="mychanges-toast" id="mychanges-toast">
        <div class="mychanges-toast-icon" id="mychanges-toast-icon"></div>
        <p class="mychanges-toast-message" id="mychanges-toast-message"></p>
        <button class="mychanges-toast-close" onclick="hideMyChangesToast()">باشه</button>
      </div>
    </div>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('mychanges-popup');
    if (!popup) {
        console.error('MyChanges popup element not found!');
        return;
    }
	window.showMyChangesPopup = function() {
    const popup = document.getElementById('mychanges-popup');
    if (popup) {
        popup.classList.add('active');
        showMyChangesStage('mychanges-stage-1');
        loadMyChangesPhotosFromServer(); // ← اضافه شد
    }
};

// لود از سرور
// لود از سرور - اضافه شده برای جلوگیری از خطا
window.loadMyChangesPhotosFromServer = function() {
    fetch('/wp-admin/admin-ajax.php?action=get_my_changes_photos')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                loadMyChangesPhotos(data.data.before || [], data.data.after || []);
            }
        })
        .catch(err => console.error('خطا در دریافت عکس‌ها:', err));
};

 

    window.hideMyChangesPopup = function() {
        popup.classList.remove('active');
        showMyChangesStage('mychanges-stage-1');
    };

    window.showMyChangesStage = function(stageId) {
        document.querySelectorAll('.mychanges-stage').forEach(stage => {
            stage.classList.remove('active');
        });
        const stage = document.getElementById(stageId);
        if (stage) {
            stage.classList.add('active');
        } else {
            console.error('Stage not found: ' + stageId);
        }
    };

    popup.addEventListener('click', function(e) {
        if (e.target === this) hideMyChangesPopup();
    });

    document.querySelectorAll('.mychanges-close').forEach(button => {
        button.addEventListener('click', hideMyChangesPopup);
    });
});

function showMyChangesToast(message, type = 'success') {
  const overlay = document.getElementById('mychanges-toast-overlay');
  const toast   = document.getElementById('mychanges-toast');
  const icon    = document.getElementById('mychanges-toast-icon');
  const msg     = document.getElementById('mychanges-toast-message');

  if (!overlay || !toast || !icon || !msg) {
    console.error('عناصر پاپ‌آپ پیام پیدا نشد');
    return;
  }

  toast.className = 'mychanges-toast ' + type;
  icon.textContent = type === 'success' ? '✓' : '✕';
  msg.textContent = message;
  overlay.classList.add('active');
}

function hideMyChangesToast() {
  const overlay = document.getElementById('mychanges-toast-overlay');
  if (overlay) overlay.classList.remove('active');
}

function updateMyChangesStage1Info(data) {
  const nameEl = document.querySelector('#mychanges-stage-1 .mychanges-info-row:nth-child(1) .mychanges-info-value');
  if (nameEl) nameEl.textContent = data.fullname || '—';

  const phoneEl = document.querySelector('#mychanges-stage-1 .mychanges-info-row:nth-child(2) .mychanges-info-value');
  if (phoneEl) phoneEl.textContent = data.phone || '—';

  const emailEl = document.querySelector('#mychanges-stage-1 .mychanges-info-row:nth-child(3) .mychanges-info-value');
  if (emailEl) emailEl.textContent = data.email || '—';

  const genderMap = { male: 'مرد', female: 'زن', other: 'سایر' };
  const genderEl = document.querySelector('#mychanges-stage-1 .mychanges-info-row:nth-child(4) .mychanges-info-value');
  if (genderEl) genderEl.textContent = genderMap[data.gender] || '—';

  const birthEl = document.querySelector('#mychanges-stage-1 .mychanges-info-row:nth-child(5) .mychanges-info-value');
  if (birthEl) birthEl.textContent = data.birthdate || '—';

  const avatarEl = document.querySelector('#mychanges-stage-1 .mychanges-avatar');
  if (avatarEl && data.avatar) {
    avatarEl.src = data.avatar;
  }
}

window.handleUpdateMyChanges = async function () {
  const fullname  = document.getElementById('mychanges-fullname')?.value.trim();
  const phone     = document.getElementById('mychanges-phone')?.value.trim();
  const email     = document.getElementById('mychanges-email')?.value.trim();
  const birthdate = document.getElementById('mychanges-birthdate')?.value.trim();
  const gender    = mychangesSelectedGender;

  if (!fullname || !phone || !email || !birthdate || !gender) {
    showMyChangesToast('لطفاً همه فیلدها را کامل پر کنید', 'error');
    return;
  }

  if (!/^09\d{9}$/.test(phone.replace(/\s/g, ''))) {
    showMyChangesToast('شماره موبایل معتبر نیست (مثال: 09123456789)', 'error');
    return;
  }

  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    showMyChangesToast('ایمیل وارد شده معتبر نیست', 'error');
    return;
  }

  const btn = document.getElementById('mychanges-submit-btn');
  if (btn) {
    btn.disabled = true;
    btn.textContent = 'در حال ذخیره...';
  }

  const avatarImg = document.getElementById('mychanges-edit-avatar');
  let avatarData = '';
  let avatarBg   = '';

  if (avatarImg) {
    avatarData = avatarImg.src || '';
    avatarBg   = avatarImg.style.backgroundColor || '';
  }

  const formData = new FormData();
  formData.append('action', 'update_user_info');
  formData.append('fullname', fullname);
  formData.append('phone', phone);
  formData.append('email', email);
  formData.append('birthdate', birthdate);
  formData.append('gender', gender);
  formData.append('avatar', avatarData);
  formData.append('avatar_bg', avatarBg);

  try {
    const res  = await fetch('/wp-admin/admin-ajax.php', {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (btn) {
      btn.disabled = false;
      btn.textContent = 'ذخیره تغییرات';
    }

    if (data.success) {
      updateMyChangesStage1Info({
        fullname: fullname,
        phone: phone,
        email: email,
        gender: gender,
        birthdate: birthdate,
        avatar: avatarData
      });

      showMyChangesToast(data.data?.message || 'اطلاعات با موفقیت ذخیره شد', 'success');

      setTimeout(() => {
        hideMyChangesToast();
        showMyChangesStage('mychanges-stage-1');
      }, 1800);

    } else {
      showMyChangesToast(data.data?.message || 'خطا در ذخیره اطلاعات', 'error');
    }

  } catch (err) {
    console.error(err);
    if (btn) {
      btn.disabled = false;
      btn.textContent = 'ذخیره تغییرات';
    }
    showMyChangesToast('خطا در ارتباط با سرور. لطفاً دوباره تلاش کنید', 'error');
  }
};

function createMyChangesFinalAvatar(imageSrc, bgColor, size = 280) {
  return new Promise((resolve) => {
    const canvas = document.createElement('canvas');
    canvas.width = size;
    canvas.height = size;
    const ctx = canvas.getContext('2d');

    ctx.beginPath();
    ctx.arc(size / 2, size / 2, size / 2, 0, Math.PI * 2);
    ctx.closePath();
    ctx.fillStyle = bgColor || '#F2F2F8';
    ctx.fill();

    const img = new Image();
    img.crossOrigin = 'anonymous';
    img.onload = function () {
      const padding = size * 0.08;
      const drawSize = size - padding * 2;

      ctx.drawImage(
        img,
        padding,
        padding,
        drawSize,
        drawSize
      );

      resolve(canvas.toDataURL('image/png'));
    };
    img.onerror = function () {
      resolve(canvas.toDataURL('image/png'));
    };
    img.src = imageSrc;
  });
}
</script>
