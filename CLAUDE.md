# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a **Laravel 12 + React + Inertia.js** application for visualizing Indonesian Pemilu 2024 election data. The system displays vote distributions, party statistics, and electoral maps with interactive charts and geographical visualizations.

**Tech Stack:**
- Backend: Laravel 12, PHP 8.2+
- Frontend: React 18, Inertia.js 2.0, Tailwind CSS 4.0
- Database: MySQL (direct queries via Query Builder - no Eloquent models for electoral data)
- Charts: Chart.js with react-chartjs-2
- Maps: Leaflet.js with GeoJSON boundaries
- Build: Vite

## Development Commands

### Starting Development Server
```bash
# Start all services (recommended - includes server, queue, logs, and vite)
composer dev

# Or manually start each:
php artisan serve              # Laravel server
npm run dev                    # Vite dev server
```

### Build & Test
```bash
npm run build                  # Production build
composer test                  # Run PHPUnit tests
```

### Code Quality
```bash
./vendor/bin/pint              # Laravel Pint (code formatting)
```

## Architecture & Key Concepts

### Database Structure

**Core Tables:**
- `caleg_dpr_ri` - DPR RI candidate votes (main electoral data)
- `partai` - Political party details (nomor_urut, nama, warna, logo_url)
- `wilayah` - Administrative regions (provinsi, kabupaten, with boundaries)

**Critical Data Filtering:**
Always exclude aggregated totals when querying vote data:
```php
->where('caleg_id', '<>', 333333)  // MUST use <> operator with integer, NOT !=
```

### Rendering Architecture

The application uses **TWO distinct rendering approaches**:

**1. Inertia.js (React) Pages:**
- Located in `resources/js/Pages/`
- Example: `DprRi/Index.jsx`
- Uses Chart.js with custom plugins
- Routed through Inertia controllers

**2. Blade Template Pages:**
- Located in `resources/views/`
- Example: `peta-suara-temp.blade.php`, `data-partai.blade.php`, `data-provinsi.blade.php`
- Contain embedded Chart.js and Leaflet.js code
- Server-side rendering with client-side interactivity
- Used for map-heavy visualizations

### Controller Data Patterns

Controllers use **Laravel Query Builder** (not Eloquent) for performance:

```php
// Vote aggregation pattern
$suaraPerPartai = DB::table('caleg_dpr_ri')
    ->select('partai_id', DB::raw('SUM(suara) as total_suara'))
    ->where('pro_id', $proId)
    ->where('caleg_id', '<>', 333333)  // Critical filter
    ->groupBy('partai_id')
    ->pluck('total_suara', 'partai_id');
```

**Key Controllers:**
- `PetaSuaraController` - Vote map visualization (national overview)
- `DataPartaiController` - Party-focused analysis with province/dapil breakdown
- `DataProvinsiController` - Province-focused analysis with dapil breakdown
- `DprRiController` - DPR RI candidate data (Inertia)

### Map Implementation

**Color Gradation System:**
Maps use 10-level gradient coloring based on vote count or percentage:

```php
// Color blending formula (in DataPartaiController)
private function adjustColorOpacity($hexColor, $opacity)
{
    // Blend with white: lighter = less votes, darker = more votes
    $r = round(255 + ($r - 255) * $opacity);
    $g = round(255 + ($g - 255) * $opacity);
    $b = round(255 + ($b - 255) * $opacity);
    return sprintf('#%02x%02x%02x', $r, $g, $b);
}
```

**GeoJSON Boundaries:**
- Province boundaries: `/indonesia-provinces.geojson`
- Kabupaten boundaries: `/prov/indonesia-prov-{code}.geojson`
- Rendered with Leaflet.js in blade templates

### Styling Patterns

**Modern Light Theme:**
Uses animated gradient backgrounds with backdrop blur:

```html
<div class="relative bg-gradient-to-br from-white via-blue-50 to-cyan-50 rounded-2xl shadow-2xl p-8 border border-blue-200 mb-6 overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-cyan-200/30 to-blue-300/30 rounded-full blur-3xl animate-pulse"></div>
    </div>
</div>
```

### Party Logo Paths

Party logos are stored at:
```
public/lampiran/partai/{nomor_urut}.jpg
```

Valid party numbers: 1-17, 24 (18 parties total)

## Routing Structure

```
/                           - Home (Wilayah index)
/peta-suara                 - National vote map
/peta-suara/dprd-prov       - DPRD Provincial map
/data-utama/dpr-ri          - DPR RI data (Inertia)
/data-utama/partai          - Party analysis by province/dapil
/data-utama/provinsi        - Province analysis by dapil
```

## Common Patterns & Gotchas

### Database Query Operator Issue
**Problem:** The `!=` operator doesn't work correctly for filtering `caleg_id`
**Solution:** Always use `<>` with integer value:
```php
// ❌ Wrong - returns 0 results
->where('caleg_id', '!=', '333333')

// ✅ Correct
->where('caleg_id', '<>', 333333)
```

### DPT (Voter List) Calculation
Use province-level data directly, not aggregated from kabupaten:
```php
// ✅ Correct
'total_dpt' => $prov->jml_dpt  // Direct from wilayah table where tipe='provinsi'

// ❌ Wrong - summing kabupaten
'total_dpt' => Wilayah::where('id_prov', $prov->id_prov)->sum('jml_dpt')
```

### Chart Responsive Layout
For fitting multiple party bars without horizontal scroll:
```html
<div class="flex justify-between items-end gap-1 w-full">
    @foreach($partaiList as $partai)
    <div class="flex flex-col items-center flex-1 max-w-[5.5%]">
        <!-- 100% / 18 parties ≈ 5.5% each -->
    </div>
    @endforeach
</div>
```

### Pagination with Total Row
When implementing table pagination with a total row:
```javascript
// Exclude total row from data rows
let allRows = Array.from(document.querySelectorAll('#tableBody tr:not(#totalRow)'));

// Always display total row
if (totalRow) totalRow.style.display = '';

// Update row numbers in first column only
const numberCell = row.querySelector('td:first-child span');
```

## File Organization

```
app/Http/Controllers/
├── DataPartaiController.php      # Party-focused analysis
├── DataProvinsiController.php    # Province-focused analysis
├── PetaSuaraController.php       # National vote map
└── DprRiController.php           # DPR RI candidate data

resources/views/
├── peta-suara-temp.blade.php     # National map (main page)
├── data-partai.blade.php         # Party analysis page
└── data-provinsi.blade.php       # Province analysis page

resources/js/Pages/
└── DprRi/Index.jsx               # DPR RI candidate visualization (Inertia)

public/lampiran/
└── partai/                       # Party logo images (1.jpg-17.jpg, 24.jpg)
```

## Adding New Visualizations

When creating new electoral data visualizations:

1. **Always filter out aggregated totals:**
   ```php
   ->where('caleg_id', '<>', 333333)
   ```

2. **Use consistent party list:**
   ```php
   ->whereIn('nomor_urut', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,24])
   ```

3. **Apply color gradation for maps:**
   - 10 levels of opacity (0.1 to 1.0)
   - Blend with white for lighter shades
   - Darker = higher values

4. **Choose rendering approach:**
   - Use **Blade templates** for map-heavy pages with Leaflet
   - Use **Inertia/React** for interactive data tables and complex UI
