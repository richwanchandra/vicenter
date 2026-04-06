<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $create = function (array $data) {
            return Module::firstOrCreate(['slug' => $data['slug']], $data);
        };
        // === SECTION 4: HOW WE WORK ===
        $howWeWork = $create([
            'name' => 'How We Work',
            'slug' => 'how-we-work',
            'order_number' => 1,
            'is_active' => true,
        ]);

        // ---- HRD ----
        $hrd = $create([
            'name' => 'Human Resource Development (HRD)',
            'slug' => 'human-resource-development',
            'parent_id' => $howWeWork->id,
            'order_number' => 1,
            'is_active' => true,
        ]);

        // HRD Children
        $tugasHrd = $create([
            'name' => 'Tugas & Tanggung Jawab HRD',
            'slug' => 'tugas-tanggung-jawab-hrd',
            'parent_id' => $hrd->id,
            'order_number' => 1,
            'is_active' => true,
        ]);

        $create([
            'name' => 'General Responsibility',
            'slug' => 'general-responsibility',
            'parent_id' => $tugasHrd->id,
            'order_number' => 1,
            'is_active' => true,
        ]);

        $create([
            'name' => 'Struktur Organisasi',
            'slug' => 'struktur-organisasi',
            'parent_id' => $hrd->id,
            'order_number' => 2,
            'is_active' => true,
        ]);

        // ---- GA ----
        $ga = $create([
            'name' => 'General Affair (GA)',
            'slug' => 'general-affair',
            'parent_id' => $howWeWork->id,
            'order_number' => 2,
            'is_active' => true,
        ]);

        $create([
            'name' => 'Tugas & Tanggung Jawab GA',
            'slug' => 'tugas-tanggung-jawab-ga',
            'parent_id' => $ga->id,
            'order_number' => 1,
            'is_active' => true,
        ]);

        // Prosedur Pemeliharaan Aset
        $pemeliharaan = $create([
            'name' => 'Prosedur Pemeliharaan Aset',
            'slug' => 'prosedur-pemeliharaan-aset',
            'parent_id' => $ga->id,
            'order_number' => 2,
            'is_active' => true,
        ]);

        $store = $create(['name' => 'Store', 'slug' => 'store-aset', 'parent_id' => $pemeliharaan->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Aset', 'slug' => 'store-aset-list', 'parent_id' => $store->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Bangunan', 'slug' => 'store-bangunan', 'parent_id' => $store->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Taman / Outdoor', 'slug' => 'store-outdoor', 'parent_id' => $store->id, 'order_number' => 3, 'is_active' => true]);

        $office = $create(['name' => 'Office & Central Kitchen', 'slug' => 'office-central-kitchen', 'parent_id' => $pemeliharaan->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Aset (AC, Freezer, Mesin)', 'slug' => 'office-aset-appliances', 'parent_id' => $office->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Kendaraan', 'slug' => 'office-kendaraan', 'parent_id' => $office->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Bangunan', 'slug' => 'office-bangunan', 'parent_id' => $office->id, 'order_number' => 3, 'is_active' => true]);
        $create(['name' => 'Taman / Outdoor', 'slug' => 'office-outdoor', 'parent_id' => $office->id, 'order_number' => 4, 'is_active' => true]);

        $staff = $create(['name' => 'Staff', 'slug' => 'staff-aset', 'parent_id' => $pemeliharaan->id, 'order_number' => 3, 'is_active' => true]);
        $create(['name' => 'Seragam', 'slug' => 'staff-seragam', 'parent_id' => $staff->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Aset (Laptop, Mouse, HP)', 'slug' => 'staff-aset-devices', 'parent_id' => $staff->id, 'order_number' => 2, 'is_active' => true]);
        

        // Manajemen Kandidat Karyawan
        $kandidat = $create([
            'name' => 'Manajemen Kandidat Karyawan',
            'slug' => 'manajemen-kandidat-karyawan',
            'parent_id' => $hrd->id,
            'order_number' => 7,
            'is_active' => true,
        ]);

        $rekrutmen = $create([
            'name' => 'Prosedur Rekrutmen',
            'slug' => 'prosedur-rekrutmen',
            'parent_id' => $kandidat->id,
            'order_number' => 1,
            'is_active' => true,
        ]);

        $create(['name' => 'SLA HRD', 'slug' => 'sla-hrd', 'parent_id' => $rekrutmen->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Download Form', 'slug' => 'download-form-rekrutmen', 'parent_id' => $rekrutmen->id, 'order_number' => 2, 'is_active' => true]);

        $create(['name' => 'Terminasi Kandidat', 'slug' => 'terminasi-kandidat', 'parent_id' => $kandidat->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Poin & KPI', 'slug' => 'poin-kpi', 'parent_id' => $kandidat->id, 'order_number' => 3, 'is_active' => true]);

        // Prosedur Seragam & Berbusana
        $seragam = $create([
            'name' => 'Prosedur Seragam & Berbusana',
            'slug' => 'prosedur-seragam-berbusana',
            'parent_id' => $hrd->id,
            'order_number' => 8,
            'is_active' => true,
        ]);
        $create(['name' => 'Office', 'slug' => 'seragam-office', 'parent_id' => $seragam->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Central Kitchen', 'slug' => 'seragam-central-kitchen', 'parent_id' => $seragam->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Store', 'slug' => 'seragam-store', 'parent_id' => $seragam->id, 'order_number' => 3, 'is_active' => true]);

        // Kompensasi & Tunjangan
        $kompensasi = $create([
            'name' => 'Kompensasi & Tunjangan',
            'slug' => 'kompensasi-tunjangan',
            'parent_id' => $hrd->id,
            'order_number' => 9,
            'is_active' => true,
        ]);

        // === SECTION 5: OPERATION HANDBOOK ===
        $operationHandbook = $create([
            'name' => 'Operation Handbook',
            'slug' => 'operation-handbook',
            'order_number' => 2,
            'is_active' => true,
        ]);

        // 5.1 Marketing
        $marketing = $create([
            'name' => '5.1 Marketing',
            'slug' => '5-1-marketing',
            'parent_id' => $operationHandbook->id,
            'order_number' => 1,
            'is_active' => true,
        ]);

        $marketingDept = $create(['name' => 'Marketing Department', 'slug' => 'marketing-department', 'parent_id' => $marketing->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Perkenalan Team Marketing dan Fungsi & Tanggung Jawab', 'slug' => 'marketing-team-intro', 'parent_id' => $marketingDept->id, 'order_number' => 1, 'is_active' => true]);

        $sopMarketing = $create(['name' => 'SOP Marketing', 'slug' => 'sop-marketing', 'parent_id' => $marketing->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Prosedur Sosialisasi Program Marketing', 'slug' => 'prosedur-sosialisasi-marketing', 'parent_id' => $sopMarketing->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Ruang Lingkup Marketing untuk Store', 'slug' => 'ruang-lingkup-marketing-store', 'parent_id' => $sopMarketing->id, 'order_number' => 2, 'is_active' => true]);

        $create(['name' => 'Prosedur Permintaan Design kepada Marketing', 'slug' => 'prosedur-permintaan-design', 'parent_id' => $marketing->id, 'order_number' => 3, 'is_active' => true]);

        // 5.2 Finance & Accounting
        $finance = $create([
            'name' => '5.2 Finance & Accounting',
            'slug' => '5-2-finance-accounting',
            'parent_id' => $operationHandbook->id,
            'order_number' => 2,
            'is_active' => true,
        ]);

        $financeProc = $create(['name' => 'Prosedur Finance', 'slug' => 'prosedur-finance', 'parent_id' => $finance->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Pengajuan Pembayaran', 'slug' => 'pengajuan-pembayaran', 'parent_id' => $financeProc->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Proses Pelaporan Sales', 'slug' => 'proses-pelaporan-sales', 'parent_id' => $financeProc->id, 'order_number' => 2, 'is_active' => true]);

        $accounting = $create(['name' => 'Prosedur Accounting', 'slug' => 'prosedur-accounting', 'parent_id' => $finance->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Proses Pengurusan Pajak', 'slug' => 'proses-pengurusan-pajak', 'parent_id' => $accounting->id, 'order_number' => 1, 'is_active' => true]);

        $capex = $create(['name' => 'CAPEX', 'slug' => 'capex', 'parent_id' => $accounting->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Definisi', 'slug' => 'capex-definisi', 'parent_id' => $capex->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Kriteria', 'slug' => 'capex-kriteria', 'parent_id' => $capex->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Approval Level', 'slug' => 'capex-approval-level', 'parent_id' => $capex->id, 'order_number' => 3, 'is_active' => true]);

        $opex = $create(['name' => 'OPEX', 'slug' => 'opex', 'parent_id' => $accounting->id, 'order_number' => 3, 'is_active' => true]);
        $create(['name' => 'Definisi', 'slug' => 'opex-definisi', 'parent_id' => $opex->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Kategori Biaya', 'slug' => 'opex-kategori-biaya', 'parent_id' => $opex->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Approval Level', 'slug' => 'opex-approval-level', 'parent_id' => $opex->id, 'order_number' => 3, 'is_active' => true]);

        // 5.3 Procurement
        $procurement = $create([
            'name' => '5.3 Procurement',
            'slug' => '5-3-procurement',
            'parent_id' => $operationHandbook->id,
            'order_number' => 3,
            'is_active' => true,
        ]);

        $purchasing = $create(['name' => 'Prosedur Purchasing', 'slug' => 'prosedur-purchasing', 'parent_id' => $procurement->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Proses Pengajuan Barang dan Jasa', 'slug' => 'proses-pengajuan-barang-jasa', 'parent_id' => $purchasing->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Proses Pengajuan Barang Baru', 'slug' => 'proses-pengajuan-barang-baru', 'parent_id' => $purchasing->id, 'order_number' => 2, 'is_active' => true]);

        // 5.4 Produksi Gelato
        $produksi = $create([
            'name' => '5.4 Produksi Gelato',
            'slug' => '5-4-produksi-gelato',
            'parent_id' => $operationHandbook->id,
            'order_number' => 4,
            'is_active' => true,
        ]);

        $produksiDept = $create(['name' => 'Produksi Dept', 'slug' => 'produksi-dept', 'parent_id' => $produksi->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Perkenalan Team Produksi', 'slug' => 'perkenalan-team-produksi', 'parent_id' => $produksiDept->id, 'order_number' => 1, 'is_active' => true]);

        $inventory = $create(['name' => 'Inventory Produksi', 'slug' => 'inventory-produksi', 'parent_id' => $produksiDept->id, 'order_number' => 2, 'is_active' => true]);

        $gelato = $create(['name' => 'Gelato', 'slug' => 'gelato-inventory', 'parent_id' => $inventory->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Alur Kerja', 'slug' => 'gelato-alur-kerja', 'parent_id' => $gelato->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Aturan', 'slug' => 'gelato-aturan', 'parent_id' => $gelato->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Deadline', 'slug' => 'gelato-deadline', 'parent_id' => $gelato->id, 'order_number' => 3, 'is_active' => true]);
        $create(['name' => 'QC', 'slug' => 'gelato-qc', 'parent_id' => $gelato->id, 'order_number' => 4, 'is_active' => true]);

        $drink = $create(['name' => 'Drink', 'slug' => 'drink-inventory', 'parent_id' => $inventory->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Alur Kerja', 'slug' => 'drink-alur-kerja', 'parent_id' => $drink->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Aturan', 'slug' => 'drink-aturan', 'parent_id' => $drink->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Deadline', 'slug' => 'drink-deadline', 'parent_id' => $drink->id, 'order_number' => 3, 'is_active' => true]);
        $create(['name' => 'QC', 'slug' => 'drink-qc', 'parent_id' => $drink->id, 'order_number' => 4, 'is_active' => true]);

        $create(['name' => 'Do & Don\'ts Produksi', 'slug' => 'do-donts-produksi', 'parent_id' => $produksiDept->id, 'order_number' => 3, 'is_active' => true]);

        // Packing Dept
        $packingDept = $create(['name' => 'Packing Dept', 'slug' => 'packing-dept', 'parent_id' => $produksi->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Perkenalan Team', 'slug' => 'packing-perkenalan-team', 'parent_id' => $packingDept->id, 'order_number' => 1, 'is_active' => true]);

        $packingProses = $create(['name' => 'Alur Proses Packing', 'slug' => 'alur-proses-packing', 'parent_id' => $packingDept->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Alur Kerja', 'slug' => 'packing-alur-kerja', 'parent_id' => $packingProses->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Aturan', 'slug' => 'packing-aturan', 'parent_id' => $packingProses->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Deadline', 'slug' => 'packing-deadline', 'parent_id' => $packingProses->id, 'order_number' => 3, 'is_active' => true]);
        $create(['name' => 'QC', 'slug' => 'packing-qc', 'parent_id' => $packingProses->id, 'order_number' => 4, 'is_active' => true]);

        $create(['name' => 'Do & Don\'ts Packaging', 'slug' => 'do-donts-packaging', 'parent_id' => $packingDept->id, 'order_number' => 3, 'is_active' => true]);

        // Warehouse Dept
        $warehouse = $create(['name' => 'Warehouse Dept', 'slug' => 'warehouse-dept', 'parent_id' => $produksi->id, 'order_number' => 3, 'is_active' => true]);
        $create(['name' => 'Perkenalan Team', 'slug' => 'warehouse-perkenalan-team', 'parent_id' => $warehouse->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Prosedur Pemesanan Barang', 'slug' => 'prosedur-pemesanan-barang', 'parent_id' => $warehouse->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Do & Don\'ts Warehouse', 'slug' => 'do-donts-warehouse', 'parent_id' => $warehouse->id, 'order_number' => 3, 'is_active' => true]);

        // Food & Pastry Dept
        $foodPastry = $create(['name' => 'Food & Pastry Dept', 'slug' => 'food-pastry-dept', 'parent_id' => $produksi->id, 'order_number' => 4, 'is_active' => true]);
        $create(['name' => 'Perkenalan Team', 'slug' => 'food-pastry-perkenalan-team', 'parent_id' => $foodPastry->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Prosedur Kerja', 'slug' => 'food-pastry-prosedur-kerja', 'parent_id' => $foodPastry->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Prosedur Pemesanan', 'slug' => 'food-pastry-prosedur-pemesanan', 'parent_id' => $foodPastry->id, 'order_number' => 3, 'is_active' => true]);

        // Logistik Dept
        $logistik = $create(['name' => 'Logistik Dept', 'slug' => 'logistik-dept', 'parent_id' => $produksi->id, 'order_number' => 5, 'is_active' => true]);
        $create(['name' => 'Perkenalan Team', 'slug' => 'logistik-perkenalan-team', 'parent_id' => $logistik->id, 'order_number' => 1, 'is_active' => true]);

        $prosedurLogistik = $create(['name' => 'Prosedur Logistik', 'slug' => 'prosedur-logistik', 'parent_id' => $logistik->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Peraturan Dasar', 'slug' => 'logistik-peraturan-dasar', 'parent_id' => $prosedurLogistik->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Do & Don\'ts', 'slug' => 'logistik-do-donts', 'parent_id' => $prosedurLogistik->id, 'order_number' => 2, 'is_active' => true]);

        // 5.5 Store Operation
        $storeOp = $create([
            'name' => '5.5 Store Operation',
            'slug' => '5-5-store-operation',
            'parent_id' => $operationHandbook->id,
            'order_number' => 5,
            'is_active' => true,
        ]);

        $prosedurDasar = $create(['name' => 'Prosedur Dasar', 'slug' => 'prosedur-dasar-store', 'parent_id' => $storeOp->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Partimer / Freelance', 'slug' => 'partimer-freelance-store', 'parent_id' => $prosedurDasar->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Store Supervisor', 'slug' => 'store-supervisor', 'parent_id' => $prosedurDasar->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'Store Manager', 'slug' => 'store-manager', 'parent_id' => $prosedurDasar->id, 'order_number' => 3, 'is_active' => true]);
        $create(['name' => 'Manager Operation', 'slug' => 'manager-operation', 'parent_id' => $prosedurDasar->id, 'order_number' => 4, 'is_active' => true]);

        $create(['name' => 'SOP Pelayanan', 'slug' => 'sop-pelayanan', 'parent_id' => $storeOp->id, 'order_number' => 2, 'is_active' => true]);
        $create(['name' => 'SOP Opening & Closing Store', 'slug' => 'sop-opening-closing-store', 'parent_id' => $storeOp->id, 'order_number' => 3, 'is_active' => true]);

        $komplain = $create(['name' => 'Prosedur Penanganan Komplain', 'slug' => 'prosedur-penanganan-komplain', 'parent_id' => $storeOp->id, 'order_number' => 4, 'is_active' => true]);
        $create(['name' => 'Eskalasi', 'slug' => 'komplain-eskalasi', 'parent_id' => $komplain->id, 'order_number' => 1, 'is_active' => true]);
        $create(['name' => 'Penyelesaian Masalah', 'slug' => 'komplain-penyelesaian-masalah', 'parent_id' => $komplain->id, 'order_number' => 2, 'is_active' => true]);

        $create(['name' => 'Prosedur New Store Opening', 'slug' => 'prosedur-new-store-opening', 'parent_id' => $storeOp->id, 'order_number' => 5, 'is_active' => true]);
    }
}
