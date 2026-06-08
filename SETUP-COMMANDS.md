# Hướng dẫn các lệnh cài đặt Stack Laravel

Tài liệu này ghi lại toàn bộ lệnh đã chạy khi cài đặt stack cho project, kèm giải thích ý nghĩa từng bước.

**Stack đã cài:** FilamentPHP 5, Livewire 4, Lighthouse GraphQL, TailwindCSS 4, Flexiwind, Pest PHP, Redis, CockroachDB driver.

---

## 1. Kiểm tra môi trường

```bash
php -v
composer --version
```

| Lệnh | Ý nghĩa |
|------|---------|
| `php -v` | Kiểm tra phiên bản PHP đang dùng. Project yêu cầu PHP 8.3+. |
| `composer --version` | Kiểm tra Composer đã cài và phiên bản hiện tại. Composer dùng để quản lý package PHP. |

---

## 2. Cài FilamentPHP 5 (kèm Livewire 4)

```bash
composer require filament/filament:"~5.0" --no-interaction
```

| Thành phần | Giải thích |
|------------|------------|
| `composer require` | Thêm package PHP vào project và cài vào thư mục `vendor/`. |
| `filament/filament:"~5.0"` | Cài Filament phiên bản 5.x. Dùng `~5.0` thay vì `^5.0` vì PowerShell trên Windows bỏ qua ký tự `^`. |
| `--no-interaction` | Không hỏi xác nhận tương tác, chạy tự động. |

**Kết quả:** Filament 5 được cài kèm Livewire 4, các package con (forms, tables, widgets, …).

```bash
php artisan filament:install --panels --no-interaction
```

| Thành phần | Giải thích |
|------------|------------|
| `php artisan` | Chạy lệnh CLI của Laravel. |
| `filament:install --panels` | Cài panel builder: tạo `AdminPanelProvider`, đăng ký panel admin, publish assets JS/CSS. |
| `--no-interaction` | Dùng giá trị mặc định (panel ID: `admin`) thay vì hỏi từng bước. |

**Kết quả:** Panel admin tại `/admin`, file `app/Providers/Filament/AdminPanelProvider.php`.

```bash
php artisan filament:install --no-interaction
```

Cài frontend assets Filament cho project Laravel đã tồn tại (không ghi đè scaffold như project mới).

```bash
php artisan vendor:publish --tag=filament-config --no-interaction
```

Publish file `config/filament.php` để tùy chỉnh cấu hình Filament (disk, UI, …).

---

## 3. Cài Lighthouse GraphQL

```bash
composer require nuwave/lighthouse --no-interaction
```

Cài framework GraphQL cho Laravel — schema-first, tự động map Eloquent models.

```bash
php artisan vendor:publish --tag=lighthouse-schema --no-interaction
php artisan vendor:publish --tag=lighthouse-config --no-interaction
```

| Tag | File tạo ra | Ý nghĩa |
|-----|-------------|---------|
| `lighthouse-schema` | `graphql/schema.graphql` | Schema GraphQL mặc định, chỉnh sửa tại đây. |
| `lighthouse-config` | `config/lighthouse.php` | Cấu hình route `/graphql`, cache, middleware, namespaces. |

```bash
composer require mll-lab/laravel-graphiql --dev --no-interaction
```

Cài GraphiQL (công cụ test GraphQL trên trình duyệt) tại `/graphiql`. Đặt trong `--dev` vì chỉ dùng khi phát triển.

---

## 4. Cài CockroachDB driver

```bash
composer require vuthaihoc/cockroachdb-laravel --no-interaction
```

| Ghi chú | Chi tiết |
|---------|----------|
| Package | `vuthaihoc/cockroachdb-laravel` v2.x — hỗ trợ Laravel 13. |
| Lý do không dùng `ylsideas/cockroachdb-laravel` | Package gốc chỉ hỗ trợ đến Laravel 11. |
| Driver name | `crdb` — dùng trong `DB_CONNECTION=crdb`. |

Sau đó thêm connection `crdb` vào `config/database.php` (port mặc định CockroachDB: `26257`).

---

## 5. Cài Pest PHP (thay PHPUnit)

```bash
composer require pestphp/pest pestphp/pest-plugin-laravel --dev --with-all-dependencies --no-interaction
```

| Thành phần | Giải thích |
|------------|------------|
| `pestphp/pest` | Framework test với cú pháp gọn hơn PHPUnit. |
| `pestphp/pest-plugin-laravel` | Plugin tích hợp Laravel (HTTP test, RefreshDatabase, …). |
| `--dev` | Chỉ dùng khi phát triển, không đưa lên production. |
| `--with-all-dependencies` | Cập nhật các dependency liên quan để tránh xung đột phiên bản. |

```bash
vendor/bin/pest --init
```

Khởi tạo Pest: tạo `tests/Pest.php`, cấu hình test suite. PHPUnit vẫn chạy nền (Pest build trên PHPUnit).

```bash
vendor/bin/pest
# hoặc
php artisan test
```

Chạy toàn bộ test.

---

## 6. Cài Flexiwind (UI components)

```bash
composer require unoforge/flexi-cli --dev --no-interaction
```

Cài Flexi CLI — công cụ thêm component Flexiwind (Blade + Livewire + Tailwind 4) vào project.

**Khởi tạo Flexiwind** (đã chạy qua script tương đương `flexi-cli init`):

- Tạo `flexiwind.yaml` — cấu hình theme, icon, registry
- Tạo `app/Flexiwind/`, `resources/css/flexiwind.css`, `resources/js/flexilla.js`
- Cài npm: `@iconify/tailwind4`, `@iconify-json/heroicons`

```bash
php vendor/bin/flexi-cli add @flexiwind/flexiwind-base --no-interaction
```

Tải base CSS từ registry Flexiwind:

- `resources/css/flexiwind/base.css`
- `resources/css/flexiwind/button.css`
- `resources/css/flexiwind/form.css`
- `resources/css/flexiwind/ui.css`
- `resources/css/flexiwind/utils.css`

**Thêm component khác (ví dụ):**

```bash
php vendor/bin/flexi-cli add @flexiwind/button
php vendor/bin/flexi-cli add @flexiwind/card
```

---

## 7. Cài Redis client

```bash
composer require predis/predis --no-interaction
```

| Ghi chú | Chi tiết |
|---------|----------|
| Predis | Client Redis thuần PHP, không cần extension `phpredis`. |
| `.env` | `REDIS_CLIENT=predis` |
| Thay thế | Nếu máy có extension `phpredis`, đổi `REDIS_CLIENT=phpredis` cho hiệu năng tốt hơn. |

Redis được dùng cho: `CACHE_STORE`, `SESSION_DRIVER`, `QUEUE_CONNECTION` trong `.env`.

---

## 8. Frontend (TailwindCSS 4 + Vite)

```bash
npm install
```

Cài dependencies Node.js theo `package.json` (Tailwind 4, Vite, Flexiwind icons, …).

```bash
npm run build
```

Build assets production: compile CSS/JS vào `public/build/`. Dùng khi deploy hoặc test production.

```bash
npm run dev
```

Chạy Vite dev server — hot reload khi sửa CSS/JS (thường chạy qua `composer dev`).

---

## 9. Lệnh Laravel bổ sung

```bash
php artisan storage:link --no-interaction
```

Tạo symlink `public/storage` → `storage/app/public` để truy cập file upload qua URL `/storage/...`.

```bash
php artisan about
```

Hiển thị tổng quan: phiên bản Laravel, PHP, drivers (database, cache, queue, session), Filament, Livewire.

```bash
php artisan make:filament-user
```

Tạo tài khoản admin đăng nhập panel Filament tại `/admin`.

```bash
php artisan migrate
```

Chạy migration lên database (cần CockroachDB đang chạy khi `DB_CONNECTION=crdb`).

```bash
php artisan optimize
php artisan optimize:clear
```

| Lệnh | Khi nào dùng |
|------|--------------|
| `optimize` | Production: cache config, routes, views → tải nhanh hơn. |
| `optimize:clear` | Development: xóa cache sau khi đổi config/routes/views. |

---

## 10. Chạy development

```bash
composer dev
```

Chạy đồng thời (qua `concurrently`):

- `php artisan serve` — web server
- `php artisan queue:listen` — xử lý queue Redis
- `php artisan pail` — xem log realtime
- `npm run dev` — Vite dev server

---

## 11. Tóm tắt endpoints

| URL | Mục đích |
|-----|----------|
| `/` | Trang chủ Laravel |
| `/admin` | Filament admin panel |
| `/graphql` | GraphQL API (Lighthouse) |
| `/graphiql` | GraphQL IDE (chỉ dev) |

---

## 12. Biến môi trường quan trọng (`.env`)

```env
# CockroachDB
DB_CONNECTION=crdb
DB_HOST=127.0.0.1
DB_PORT=26257
DB_DATABASE=defaultdb
DB_USERNAME=root
DB_PASSWORD=

# Redis
REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379

CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# GraphQL
LIGHTHOUSE_CACHE_ENABLE=false
```

| Biến | Ý nghĩa |
|------|---------|
| `DB_CONNECTION=crdb` | Dùng driver CockroachDB thay vì mysql/pgsql/sqlite. |
| `DB_PORT=26257` | Port mặc định của CockroachDB (khác PostgreSQL `5432`). |
| `CACHE_STORE=redis` | Cache lưu trên Redis thay vì file/database. |
| `SESSION_DRIVER=redis` | Session lưu trên Redis — phù hợp nhiều server. |
| `QUEUE_CONNECTION=redis` | Job queue chạy qua Redis. |

---

## 13. Thứ tự cài đặt gợi ý (từ đầu)

Nếu cần cài lại trên máy mới:

```bash
# 1. Clone/copy project
composer install
npm install

# 2. Môi trường
cp .env.example .env
php artisan key:generate

# 3. Build assets
npm run build

# 4. Database & storage (khi CockroachDB + Redis đã chạy)
php artisan migrate
php artisan storage:link
php artisan make:filament-user

# 5. Chạy dev
composer dev
```

---

*Tài liệu được tạo sau quá trình cài đặt stack — tháng 6/2026.*
