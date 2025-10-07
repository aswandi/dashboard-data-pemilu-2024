<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDapilKursi extends Command
{
    protected $signature = 'import:dapil-kursi';
    protected $description = 'Import jumlah kursi per dapil from CSV';

    public function handle()
    {
        $csvFile = base_path('lampiran/JUMLAH KURSI PER DAPIL DPR RI.csv');

        if (!file_exists($csvFile)) {
            $this->error('CSV file not found!');
            return 1;
        }

        $this->info('Reading CSV file...');

        $file = fopen($csvFile, 'r');

        // Skip header with BOM
        $header = fgets($file);

        $updated = 0;
        $notFound = 0;
        $errors = [];

        while (($line = fgets($file)) !== false) {
            $data = str_getcsv($line, ';');

            if (count($data) < 4) continue;

            $provinsi = trim($data[1]);
            $dapil = trim($data[2]);
            $jumlahKursi = (int) trim($data[3]);

            // Update based on dapil_nama
            $result = DB::table('dapil_dpr_ri')
                ->where('dapil_nama', $dapil)
                ->update(['jumlah_kursi' => $jumlahKursi]);

            if ($result > 0) {
                $updated++;
                $this->info("Updated: {$provinsi} - {$dapil} ({$jumlahKursi} kursi)");
            } else {
                $notFound++;
                $errors[] = "Not found: {$provinsi} - {$dapil}";
            }
        }

        fclose($file);

        $this->info("\n=== Import Summary ===");
        $this->info("Updated: {$updated} dapil");
        $this->warn("Not found: {$notFound} dapil");

        if (!empty($errors)) {
            $this->warn("\nDapil not found in database:");
            foreach ($errors as $error) {
                $this->warn("  - {$error}");
            }
        }

        return 0;
    }
}
