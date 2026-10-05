---
paths:
  - 'resources/views/**/*.blade.php'
---

# Views

## Modal selalu latar terang (light), lepas dari mode gelap aplikasi
Setiap modal Bootstrap (`.modal-content`) di proyek ini harus selalu berlatar terang/cerah (background putih, teks gelap), tidak ikut mode gelap (dark mode) aplikasi — dikonfirmasi developer secara eksplisit untuk proyek ini.

Terapkan lewat CSS scoped per modal (id modal) di `page-css` section view terkait, contoh pola di `resources/views/sc/pameran-detail.blade.php` (`#modal-review`):
```css
#modal-xxx .modal-content { background-color: #ffffff !important; color: #0e1726 !important; }
#modal-xxx .form-label, #modal-xxx .form-check-label, #modal-xxx .text-muted { color: #0e1726 !important; }
#modal-xxx .form-control { background-color: #ffffff !important; color: #0e1726 !important; border-color: #e0e6ed !important; }
```
