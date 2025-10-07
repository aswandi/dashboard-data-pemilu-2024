# Import Wilayah Boundaries Data

## Tabel yang sudah dibuat:
- `wilayah_boundaries` (kode, nama, lat, lng, path)

## Data yang sudah diimport:
- ✅ Provinsi 11-15 (Aceh, Sumatera Utara, Sumatera Barat, Riau, Jambi)
- ✅ Kabupaten Aceh (kode 11.xx)

## Cara import data boundaries lainnya:

### Import Provinsi (per grup):
```bash
# Grup 1: Provinsi 11-15
php artisan tinker --execute="
\$sql = file_get_contents('lampiran/wilayah_boundaries-main/db/prov/wilayah_boundaries_prov_1.sql');
DB::unprepared(\$sql);
echo 'Imported prov 1 (codes 11-15)';
"

# Grup 2: Provinsi 16-21
php artisan tinker --execute="
\$sql = file_get_contents('lampiran/wilayah_boundaries-main/db/prov/wilayah_boundaries_prov_2.sql');
DB::unprepared(\$sql);
echo 'Imported prov 2 (codes 16-21)';
"

# Dan seterusnya...
```

### Import Kabupaten (per provinsi):
```bash
# Aceh (11)
php artisan tinker --execute="
\$sql = file_get_contents('lampiran/wilayah_boundaries-main/db/kab/wilayah_boundaries_kab_11.sql');
DB::unprepared(\$sql);
echo 'Imported kabupaten for Aceh (11)';
"

# Sumatera Utara (12)
php artisan tinker --execute="
\$sql = file_get_contents('lampiran/wilayah_boundaries-main/db/kab/wilayah_boundaries_kab_12.sql');
DB::unprepared(\$sql);
echo 'Imported kabupaten for Sumatera Utara (12)';
"

# Dan seterusnya untuk provinsi lainnya...
```

### Import All Provinsi sekaligus:
```bash
php artisan tinker --execute="
\$files = glob('lampiran/wilayah_boundaries-main/db/prov/*.sql');
foreach (\$files as \$file) {
    \$sql = file_get_contents(\$file);
    DB::unprepared(\$sql);
    echo 'Imported: ' . basename(\$file) . PHP_EOL;
}
"
```

### Import All Kabupaten sekaligus:
```bash
php artisan tinker --execute="
\$files = glob('lampiran/wilayah_boundaries-main/db/kab/*.sql');
foreach (\$files as \$file) {
    \$sql = file_get_contents(\$file);
    DB::unprepared(\$sql);
    echo 'Imported: ' . basename(\$file) . PHP_EOL;
}
"
```

## Struktur File SQL:
- `lampiran/wilayah_boundaries-main/db/prov/` - Boundaries provinsi
- `lampiran/wilayah_boundaries-main/db/kab/` - Boundaries kabupaten

## Catatan:
- Data boundaries digunakan untuk menampilkan peta dengan batas wilayah
- Setiap provinsi memiliki file boundaries terpisah
- Setiap kabupaten dalam provinsi juga memiliki file boundaries
- Format data: kode, nama, lat, lng, path (polygon coordinates dalam format JSON)
