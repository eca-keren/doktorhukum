Improvement Plan: News & Announcements Module
Overview
Setelah menganalisis kode News dan Announcements yang ada, saya menemukan beberapa area yang dapat ditingkatkan untuk meningkatkan fungsionalitas, user experience, SEO, dan maintainability.

User Review Required
IMPORTANT

Breaking Changes & Significant Decisions

Database Migration: Penambahan kolom baru akan memerlukan migration baru. Data existing tidak akan terpengaruh, tetapi perlu run migration.
Status/Category System: Apakah Anda ingin menggunakan enum atau relasi ke tabel terpisah untuk categories?
Slug System: Apakah Anda ingin menggunakan auto-generated slug dari title atau manual input?
Rich Text Editor: Apakah Anda ingin menggunakan TinyMCE, Quill, atau Trix untuk content editor?
Proposed Changes
Database Layer
[NEW] 
2024_11_29_000003_improve_news_table.php
Improvements untuk News Table:

✅ Slug field - SEO-friendly URLs (e.g., /news/breaking-news-title)
✅ Status field - Draft/Published/Archived untuk workflow management
✅ Category field - Kategorisasi berita (Legal, Research, Events, dll)
✅ Featured flag - Menandai berita featured untuk hero section
✅ View count - Tracking popularitas artikel
✅ Published_at timestamp - Scheduled publishing
✅ Content field - Full rich text content (terpisah dari description/excerpt)
✅ Meta fields - SEO meta title & description
✅ Tags - JSON field untuk tagging system
✅ Soft deletes - Recovery capability
[NEW] 
2024_11_29_000004_improve_announcements_table.php
Improvements untuk Announcements Table:

✅ Slug field - SEO-friendly URLs
✅ Status field - Draft/Published/Archived
✅ Priority field - Low/Medium/High/Urgent untuk sorting
✅ Type field - General/Event/Deadline/Important
✅ Content field - Full rich text content
✅ Expires_at timestamp - Auto-archive expired announcements
✅ Published_at timestamp - Scheduled publishing
✅ View count - Tracking
✅ Meta fields - SEO optimization
✅ Soft deletes - Recovery capability
Model Layer
[MODIFY] 
News.php
Enhancements:

✅ Add fillable fields untuk kolom baru
✅ Add casts untuk dates, JSON, boolean
✅ Add scopes: published(), featured(), byCategory(), popular()
✅ Add accessor untuk excerpt (auto-generate dari content)
✅ Add mutator untuk auto-generate slug dari title
✅ Add relationship methods jika menggunakan separate category table
✅ Implement SoftDeletes trait
[MODIFY] 
Announcement.php
Enhancements:

✅ Add fillable fields untuk kolom baru
✅ Add casts untuk dates, JSON, boolean, enums
✅ Add scopes: published(), active(), byPriority(), byType()
✅ Add accessor untuk checking if expired
✅ Add mutator untuk auto-generate slug
✅ Implement SoftDeletes trait
Livewire Components - Admin
[MODIFY] 
News.php
Feature Additions:

✅ Bulk actions - Delete, publish, archive multiple items
✅ Advanced filters - By status, category, date range
✅ Status toggle - Quick publish/unpublish
✅ Featured toggle - Quick mark as featured
✅ Rich text editor integration untuk content field
✅ Slug auto-generation dengan preview
✅ Image optimization - Multiple sizes (thumbnail, medium, large)
✅ SEO fields - Meta title, meta description
✅ Tags input - Tag management
✅ Scheduled publishing - Date/time picker
✅ Preview mode - Preview before publish
[MODIFY] 
Announcement.php
Feature Additions:

✅ Bulk actions - Delete, publish, archive multiple items
✅ Advanced filters - By status, priority, type, date range
✅ Status toggle - Quick publish/unpublish
✅ Priority badge - Visual priority indicators
✅ Rich text editor integration
✅ Slug auto-generation
✅ Expiration management - Auto-archive expired
✅ SEO fields
✅ Scheduled publishing
Livewire Components - Public
[MODIFY] 
PublicNews.php
Feature Additions:

✅ Category filter - Filter by category
✅ Tag filter - Filter by tags
✅ Date range filter - Filter by date
✅ View counter - Increment on view
✅ Related news - Show related articles
✅ Share buttons - Social media sharing
✅ Reading time estimate - Calculate from content
✅ SEO meta tags - Dynamic meta tags per article
[MODIFY] 
PublicAnnouncement.php
Feature Additions:

✅ Type filter - Filter by announcement type
✅ Priority filter - Filter by priority
✅ Active only - Hide expired announcements
✅ View counter - Increment on view
✅ Urgent badge - Visual indicator for urgent items
✅ Countdown timer - For deadline announcements
✅ SEO meta tags - Dynamic meta tags
Views - Admin
[MODIFY] 
news.blade.php
UI/UX Improvements:

✅ Status badges - Visual status indicators (Draft/Published/Archived)
✅ Category badges - Color-coded categories
✅ Featured star icon - Visual featured indicator
✅ View count display - Show popularity
✅ Bulk action checkboxes - Select multiple items
✅ Advanced filter panel - Collapsible filter section
✅ Rich text editor - TinyMCE/Quill integration
✅ Image gallery - Multiple image upload support
✅ SEO preview - Google search result preview
✅ Slug editor - Editable slug with auto-generation
✅ Tag input - Tag selector/creator
✅ Schedule picker - Date/time picker for publishing
[MODIFY] 
announcement.blade.php
UI/UX Improvements:

✅ Status badges - Visual status indicators
✅ Priority badges - Color-coded priority (Low/Medium/High/Urgent)
✅ Type badges - Announcement type indicators
✅ Expiration indicator - Show expiry date/countdown
✅ Bulk action checkboxes
✅ Advanced filter panel
✅ Rich text editor
✅ Schedule picker
✅ Expiry picker - Date/time for expiration
Views - Public
[MODIFY] 
public-news.blade.php
Feature Additions:

✅ Category filter sidebar - Interactive category filter
✅ Tag cloud - Popular tags display
✅ Date archive - Browse by month/year
✅ Reading time badge - Estimated reading time
✅ Share buttons - Social media share
✅ Related articles - "You might also like" section
✅ Breadcrumbs - Navigation breadcrumbs
✅ SEO meta tags - Dynamic meta tags
✅ Schema.org markup - Rich snippets for Google
[MODIFY] 
public-announcement.blade.php
Feature Additions:

✅ Type filter - Filter by announcement type
✅ Priority filter - Filter by priority
✅ Urgent banner - Highlight urgent announcements
✅ Countdown timer - For deadline announcements
✅ Archive toggle - Show/hide expired
✅ Breadcrumbs - Navigation
✅ SEO meta tags - Dynamic meta tags
✅ Schema.org markup - Event/Announcement markup
New Components
[NEW] 
NewsDetail.php
Single News Detail Page:

✅ Full content display dengan rich text formatting
✅ View counter increment
✅ Share buttons (Facebook, Twitter, LinkedIn, WhatsApp)
✅ Related news section
✅ Previous/Next navigation
✅ Breadcrumbs
✅ SEO meta tags
✅ Schema.org Article markup
✅ Print-friendly version
[NEW] 
AnnouncementDetail.php
Single Announcement Detail Page:

✅ Full content display
✅ View counter increment
✅ Priority badge
✅ Expiration countdown
✅ Share buttons
✅ Related announcements
✅ Breadcrumbs
✅ SEO meta tags
✅ Schema.org Event markup (for event-type announcements)
Routes
[MODIFY] 
web.php
New Routes:

// Public News Routes
Route::get('/news', PublicNews::class)->name('news.index');
Route::get('/news/{slug}', NewsDetail::class)->name('news.show');
Route::get('/news/category/{category}', PublicNews::class)->name('news.category');
Route::get('/news/tag/{tag}', PublicNews::class)->name('news.tag');
// Public Announcement Routes
Route::get('/announcements', PublicAnnouncement::class)->name('announcements.index');
Route::get('/announcements/{slug}', AnnouncementDetail::class)->name('announcements.show');
Route::get('/announcements/type/{type}', PublicAnnouncement::class)->name('announcements.type');
Additional Improvements
[NEW] 
NewsCategorySeeder.php
Seed Default Categories:

Legal Updates
Research Publications
Events & Conferences
Academic News
General Announcements
[NEW] 
NewsPolicy.php
Authorization:

✅ View any/view
✅ Create
✅ Update
✅ Delete
✅ Publish/unpublish
✅ Feature/unfeature
[NEW] 
AnnouncementPolicy.php
Authorization:

✅ View any/view
✅ Create
✅ Update
✅ Delete
✅ Publish/unpublish
Verification Plan
Automated Tests
Feature Tests:

php artisan test --filter=NewsTest
php artisan test --filter=AnnouncementTest
Test Coverage:

✅ CRUD operations untuk News & Announcements
✅ Slug generation dan uniqueness
✅ Status transitions (draft → published → archived)
✅ Featured toggle
✅ View counter increment
✅ Scheduled publishing
✅ Expiration handling
✅ Filter dan search functionality
✅ Bulk actions
✅ SEO meta tags generation
Manual Verification
Admin Panel:

✅ Create news dengan semua field baru
✅ Test rich text editor
✅ Test image upload dan optimization
✅ Test slug auto-generation
✅ Test scheduled publishing
✅ Test bulk actions
✅ Test filters (status, category, date range)
✅ Test SEO preview
Public Pages:

✅ View news list dengan F-Pattern layout
✅ Test category filter
✅ Test tag filter
✅ View single news detail
✅ Test share buttons
✅ Test related articles
✅ Verify SEO meta tags
✅ Test responsive design
Performance:

✅ Page load time < 2s
✅ Image optimization working
✅ Lazy loading images
✅ Database query optimization (N+1 prevention)
SEO:

✅ Google Search Console validation
✅ Schema.org markup validation
✅ Open Graph tags
✅ Twitter Card tags
✅ Sitemap generation
Summary of Key Improvements
🎯 Functionality
Content Management - Rich text editor, scheduled publishing, draft system
Organization - Categories, tags, status management
Engagement - View counter, featured system, related content
Workflow - Bulk actions, advanced filters, status transitions
🎨 User Experience
Admin UX - Better forms, visual indicators, bulk operations
Public UX - Detail pages, filters, share buttons, related content
Navigation - Breadcrumbs, category/tag navigation
Accessibility - Better semantic HTML, ARIA labels
🚀 SEO & Performance
SEO - Slugs, meta tags, Schema.org markup, Open Graph
Performance - Image optimization, lazy loading, query optimization
Analytics - View tracking, popular content
🔒 Security & Maintenance
Authorization - Policies untuk access control
Data Integrity - Soft deletes, validation rules
Code Quality - Scopes, accessors, mutators, DRY principles