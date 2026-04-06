<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\Module;
use App\Models\User;
use App\Services\ContentFormatter;
use Illuminate\Database\Seeder;

class StructuredContentSeeder extends Seeder
{
    private ContentFormatter $formatter;

    public function run(): void
    {
        $this->formatter = new ContentFormatter();
        
        $admin = User::where('role', 'super_admin')->first();
        if (!$admin) {
            $this->command->error('No super admin found');
            return;
        }

        $this->command->info('📚 Seeding Structured Content...');

        // === HRD Content ===
        $this->seedHRDContent($admin);

        // === GA Content ===
        $this->seedGAContent($admin);

        // === Marketing Content ===
        $this->seedMarketingContent($admin);

        // === Finance & Accounting Content ===
        $this->seedFinanceContent($admin);

        // === Procurement Content ===
        $this->seedProcurementContent($admin);

        // === Produksi Content ===
        $this->seedProduksiContent($admin);

        // === Store Operation Content ===
        $this->seedStoreOperationContent($admin);

        $this->command->info('✅ Content seeding completed!');
    }

    // =====================================================================
    //  HRD CONTENT
    // =====================================================================

    private function seedHRDContent(User $admin): void
    {
        $this->command->info('  🏢 Seeding HRD Content...');

        // Tugas & Tanggung Jawab HRD
        $this->createContent(
            'Tugas & Tanggung Jawab HRD',
            'Tugas & Tanggung Jawab HRD',
            [
                'General Responsibility',
                'Merekrut dan menyeleksi talenta terbaik untuk organisasi',
                'Mengembangkan program pelatihan dan pengembangan karyawan',
                'Mengelola peraturan dan kebijakan kepegawaian',
                'Menangani kompensasi, benefit, dan payroll',
                'Menciptakan budaya kerja yang positif dan produktif',
                'Menangani employee relations dan conflict resolution',
                'Memastikan kepatuhan terhadap hukum ketenagakerjaan',
            ],
            $admin
        );

        // Struktur Organisasi
        $this->createContent(
            'Struktur Organisasi',
            'Human Resource Development',
            [
                'Organisasi dipimpin oleh General Manager',
                'HRD Department bertugas mengelola:',
                '• Rekrutmen dan Seleksi',
                '• Training & Development',
                '• Employee Relations',
                '• Payroll & Compensation',
                'Hierarchy:',
                'General Manager',
                '└─ HRD Manager',
                '   └─ HRD Staff',
                '   └─ Training Officer',
            ],
            $admin
        );

        // Prosedur Absen
        $this->createContent(
            'Prosedur Absen',
            'Prosedur Absen',
            [
                'Tiga tipe absen berlaku:',
                '',
                '1. Partimer / Freelance',
                'Absen dilakukan setiap hari dengan form manual',
                'Verifikasi oleh supervisor terkait',
                'Proses pembayaran based on hours worked',
                '',
                '2. Staff Level',
                'Absen digital via aplikasi internal',
                'Jam kerja: 08:00 - 17:00 WIB',
                'Toleransi keterlambatan: 10 menit',
                'Lembur harus pre-approval dari manager',
                '',
                '3. Supervisor Level',
                'Absen digital dengan responsibilities khusus',
                'Harus hadir 15 menit sebelum jam kerja',
                'Bertanggung jawab verifikasi absen staff',
                '',
                '4. Manager Level',
                'Absen digital dengan tracking khusus',
                'Flexible working hours dengan approval',
                'Bertanggung jawab oversight seluruh unit',
            ],
            $admin
        );

        // Prosedur Cuti & Izin
        $this->createContent(
            'Prosedur Cuti & Izin',
            'Prosedur Cuti & Izin',
            [
                'Aturan Pengajuan Cuti:',
                '1. Cuti tahunan berjumlah 12 hari kerja',
                '2. Pengajuan minimal 7 hari sebelumnya',
                '3. Persetujuan dari manager langsung',
                '4. Backup harus tersedia sebelum cuti',
                '',
                'Jenis Izin:',
                '• Izin Sakit: surat dokter untuk >2 hari',
                '• Izin Pribadi: max 3 hari per tahun',
                '• Izin Haji/Umroh: per kebijakan perusahaan',
                '• Izin Menikah: 3 hari kerja',
                '',
                'Form:',
                'Download form di portal internal',
                'Lengkapi dan submit ke HRD',
                'Proses: 1x24 jam',
            ],
            $admin
        );

        // Sanksi
        $this->createContent(
            'Sanksi',
            'Sanksi',
            [
                'Sistem Demerit untuk Pelanggaran:',
                '',
                'Kategori Ringan (1-5 demerit):',
                '• Keterlambatan 15-30 menit',
                '• Berpakaian tidak sesuai SOP',
                '• Tidak melengkapi dokumentasi',
                '',
                'Kategori Sedang (6-15 demerit):',
                '• Keterlambatan >30 menit',
                '• Tidak masuk tanpa pemberitahuan',
                '• Performa kerja di bawah standar',
                '',
                'Kategori Berat (>15 demerit):',
                '• Pencurian / hal kriminal',
                '• Tidak mengikuti SOP kritis',
                '• Konflikt dengan tim / harassment',
                '• Pelanggaran berulang',
                '',
                'Konsekuensi:',
                '< 5 demerit: Warning',
                '5-10 demerit: Suspension 1-3 hari',
                '> 10 demerit: Possible termination',
            ],
            $admin
        );

        // Prosedur Pengunduran Diri & Off Boarding
        $this->createContent(
            'Prosedur Pengunduran Diri & Off Boarding',
            'Prosedur Pengunduran Diri & Off Boarding',
            [
                'Proses Pengunduran Diri:',
                '1. Submit resignation letter minimal 2 minggu sebelumnya',
                '2. Pindahkan tanggung jawab kepada replacement',
                '3. Knowledge transfer session',
                '4. Collect semua company assets',
                '5. Final meeting dengan HRD',
                '',
                'Off Boarding Checklist:',
                '• Collect ID card, access key, laptop',
                '• Update sistem untuk access removal',
                '• Final salary settlement',
                '• Release reference letter',
                '• Dokumentasi final evaluation',
                '',
                'Exit Interview:',
                'Conducted oleh HRD Manager',
                'Gather feedback untuk improvement',
                'Maintain relationship untuk future opportunities',
            ],
            $admin
        );

        // Manajemen Kandidat Karyawan
        $this->createContent(
            'Manajemen Kandidat Karyawan',
            'Manajemen Kandidat Karyawan',
            [
                'Prosedur Rekrutmen:',
                '',
                'SLA HRD: 30 hari dari job open hingga hire',
                '',
                'Tahapan:',
                '1. HR screening - 3 hari',
                '2. Technical test - 2 hari',
                '3. Manager interview - 3 hari',
                '4. General Manager approval - 2 hari',
                '5. Offer & negotiation - 5 hari',
                '6. Onboarding - 7 hari',
                '',
                'Terminasi Kandidat:',
                'Jika tidak lulus tahapan tertentu, komunikasi immediate',
                'Keep databank untuk future opportunities',
                '',
                'Poin & KPI:',
                'Target hire: 90% of open positions dalam 30 hari',
                'Employee retention rate: 85%',
                'Time-to-productivity: 30 hari',
            ],
            $admin
        );

        // Prosedur Seragam & Berbusana
        $this->createContent(
            'Prosedur Seragam & Berbusana',
            'Prosedur Seragam & Berbusana',
            [
                'Dress Code - Office:',
                '• Business casual untuk hari kerja normal',
                '• Formal atau branded polo untuk meeting',
                '• Closed shoes (tidak sandal)',
                '• Rapi dan profesional',
                '',
                'Dress Code - Central Kitchen:',
                '• Chef uniform (white)',
                '• non-slip shoes',
                '• Hair net dan apron',
                '• Name badge di dada',
                '',
                'Dress Code - Store:',
                '• Branded polo / uniform terkait brand',
                '• Black pants rapi',
                '• Closed shoes (clean & polished)',
                '• Name badge positioned',
                '',
                'Alokasi Seragam:',
                'Baru hire: 3 set seragam',
                'Replacement: Submit ke GA dengan bukti rusak',
                'Penggantian tahunan: sesuai kondisi',
            ],
            $admin
        );
    }

    // =====================================================================
    //  GA CONTENT
    // =====================================================================

    private function seedGAContent(User $admin): void
    {
        $this->command->info('  🏭 Seeding GA Content...');

        // Tugas & Tanggung Jawab GA
        $this->createContent(
            'Tugas & Tanggung Jawab GA',
            'General Affair',
            [
                'General Affair (GA) Department bertanggung jawab:',
                '',
                '1. Facility Management',
                'Pemeliharaan building dan equipment',
                'Koordinasi vendor & contractor',
                '',
                '2. Asset Management',
                'Tracking semua company assets',
                'Maintenance schedule',
                'Depreciation calculation',
                '',
                '3. Logistik & Supplies',
                'Office supplies procurement',
                'Distribution ke departemen',
                'Inventory management',
                '',
                '4. Administrative Support',
                'Dokumen & filing',
                'Permit & licensing',
                'External coordination',
            ],
            $admin
        );

        // Prosedur Pemeliharaan Aset
        $this->createContent(
            'Prosedur Pemeliharaan Aset',
            'Prosedur Pemeliharaan Aset',
            [
                'Store Maintenance:',
                '',
                'Aset:',
                '• Monthly inspection',
                '• Quarterly maintenance',
                '• Replace jika rusak > 30%',
                '',
                'Bangunan:',
                '• Weekly cleaning',
                '• Monthly pest control',
                '• Roof inspection setiap 6 bulan',
                '',
                'Taman / Outdoor:',
                '• Weekly trimming & cleaning',
                '• Monthly landscape maintenance',
                '',
                'Office & Central Kitchen Aset:',
                '• AC maintenance: setiap 3 bulan',
                '• Freezer maintenance: setiap bulan',
                '• Equipment servicing: per manual',
                '',
                'Kendaraan:',
                '• Oil change: setiap 5000 km',
                '• Maintenance: setiap 10000 km',
                '• Insurance & registration update',
                '',
                'Staff Level:',
                '• Laptop: anti-virus update, disk cleanup',
                '• Mouse/peripherals: replace if broken',
                '• Phone: screen protector, case provided',
            ],
            $admin
        );

        // Pengajuan Perbaikan Aset & Bangunan
        $this->createContent(
            'Pengajuan Perbaikan Aset & Bangunan',
            'Pengajuan Perbaikan Aset & Bangunan',
            [
                'Proses Pengajuan:',
                '',
                'Step 1: Identifikasi masalah',
                'Step 2: Fill form (download dari portal)',
                'Step 3: Submit ke GA Manager',
                'Step 4: GA assess & quotation',
                'Step 5: Approval dari General Manager',
                'Step 6: Eksekusi maintenance',
                '',
                'Timeline:',
                'Emergency (critical): ASAP',
                'High priority: 3 hari',
                'Normal: 1 minggu',
                'Low priority: 2 minggu',
            ],
            $admin
        );

        // Prosedur Perjalanan Dinas
        $this->createContent(
            'Prosedur Perjalanan Dinas',
            'Prosedur Perjalanan Dinas',
            [
                'Proses Perjalanan Dinas:',
                '',
                '1. Buat travel request dengan detail',
                '2. Submit untuk approval (min 7 hari sebelumnya)',
                '3. Booking oleh GA atau finance',
                '4. Dapatkan konirmasi booking',
                '5. Travel dan collect receipt',
                '6. Submit reimbursement dalam 3 hari',
                '',
                'Budget Allowance:',
                '• Domestik: Rp500k - Rp1.5jt (tergantung kota)',
                '• ASEAN: USD 100 - 200',
                '• Internasional: USD 200+',
                '',
                'Reimbursement:',
                'Proses: 1-2 minggu',
                'Dokumen: receipt asli + form',
            ],
            $admin
        );
    }

    // =====================================================================
    //  MARKETING CONTENT
    // =====================================================================

    private function seedMarketingContent(User $admin): void
    {
        $this->command->info('  📢 Seeding Marketing Content...');

        $this->createContent(
            'Marketing Department',
            '5.1 Marketing',
            [
                'Team Marketing Overview',
                '',
                'Marketing Department fokus pada:',
                '',
                '1. Brand Awareness',
                'Social media campaigns',
                'Event & sponsorship',
                'PR & media relations',
                '',
                '2. Product Promotion',
                'Launch campaigns',
                'Promotional strategy',
                'Marketing materials',
                '',
                '3. Customer Engagement',
                'CRM management',
                'Newsletter & communication',
                'Loyalty programs',
                '',
                'Key Functions:',
                '• Strategy & planning',
                '• Creative team (design, content)',
                '• Digital marketing',
                '• Analytics & reporting',
            ],
            $admin
        );

        $this->createContent(
            'SOP Marketing',
            'SOP Marketing',
            [
                'Prosedur Sosialisasi Program Marketing:',
                '',
                '1. Campaign Planning',
                'Brief dari management',
                'Strategy meeting',
                'Approve final concept',
                '',
                '2. Creative Development',
                'Design stage',
                '• Mockup & iteration',
                '• Stakeholder review',
                '• Final approval',
                '',
                '3. Campaign Execution',
                'Launch on schedule',
                'Monitor performance',
                'Daily engagement tracking',
                '',
                'Ruang Lingkup Marketing untuk Store:',
                '• Local activation & events',
                '• In-store promotional materials',
                '• Community engagement',
                '• Sales coordination',
            ],
            $admin
        );

        $this->createContent(
            'Prosedur Permintaan Design',
            'Prosedur Permintaan Design kepada Marketing',
            [
                'Cara Meminta Design ke Marketing:',
                '',
                '1. Submit Request',
                'Fill form dengan detail:',
                '• What (jenis design)',
                '• Why (purpose)',
                '• When (deadline)',
                '• Details (specification)',
                '',
                '2. Marketing Brief',
                'Meeting untuk clarify requirement',
                'Define dimension, format, style',
                '',
                '3. Design Process',
                'Initial concept: 2-3 hari',
                'Revision: sesuai feedback',
                'Final delivery: after approval',
                '',
                'Timeline:',
                'Simple design: 3-5 hari',
                'Complex design: 7-10 hari',
                '',
                'Note:',
                'Rush order (+50% timeline)',
                'Submit 1-2 minggu sebelumnya ideal',
            ],
            $admin
        );
    }

    // =====================================================================
    //  FINANCE & ACCOUNTING CONTENT
    // =====================================================================

    private function seedFinanceContent(User $admin): void
    {
        $this->command->info('  💰 Seeding Finance & Accounting Content...');

        $this->createContent(
            'Prosedur Finance',
            'Prosedur Finance',
            [
                'Pengajuan Pembayaran:',
                '',
                '1. Vendor creates invoice',
                '2. Department head reviews & approves',
                '3. Finance verifies amount & attachment',
                '4. General Manager signs off',
                '5. Payment processing',
                '',
                'Timeline:',
                '• Invoice received → processed 3-5 hari',
                '• Payment transfer: 1-2 hari kerja',
                '',
                'Proses Pelaporan Sales:',
                '',
                '1. Store submits daily sales report',
                '2. Finance consolidate all sales',
                '3. Generate management report',
                '4. Monthly financial statement',
                '5. Board reporting',
                '',
                'Requirements:',
                '• Accuracy of data entry',
                '• Supporting documents attached',
                '• Timely submission',
            ],
            $admin
        );

        $this->createContent(
            'Prosedur Accounting',
            'Prosedur Accounting',
            [
                'Proses Pengurusan Pajak:',
                '',
                '1. PPh (Income Tax)',
                '• Calculation monthly',
                '• Payment: sebelum tgl 10 bulan berikutnya',
                '• Annual settlement: March',
                '',
                '2. PPN (VAT)',
                '• Input tracking',
                '• Output tracking',
                '• Monthly filing',
                '',
                '3. Withholding Tax',
                '• Contractor & freelancer',
                '• Foreign transactions',
                '',
                'CAPEX:',
                '',
                'Definisi:',
                'Capital expenditure for assets > Rp5jt atau useful life > 1 tahun',
                '',
                'Kriteria:',
                '• Long-term asset',
                '• Generate future benefit',
                '• Not immediately expensed',
                '',
                'Approval Level:',
                '• < Rp50jt: Manager approval',
                '• Rp50-200jt: Director approval',
                '• > Rp200jt: Board approval',
                '',
                'OPEX:',
                '',
                'Definisi:',
                'Operating expense untuk day-to-day business',
                '',
                'Kategori Biaya:',
                '• Supplies',
                '• Utilities',
                '• Maintenance',
                '• Advertising',
                '• Personnel',
                '',
                'Approval Level:',
                '• < Rp25jt: Manager',
                '• Rp25-100jt: Director',
                '• > Rp100jt: Board',
            ],
            $admin
        );
    }

    // =====================================================================
    //  PROCUREMENT CONTENT
    // =====================================================================

    private function seedProcurementContent(User $admin): void
    {
        $this->command->info('  🛒 Seeding Procurement Content...');

        $this->createContent(
            'Prosedur Purchasing',
            '5.3 Procurement',
            [
                'Proses Pengajuan Barang dan Jasa:',
                '',
                '1. Department submits PO (Purchase Order)',
                '2. Procurement verify quantity & specification',
                '3. Send RFQ to 3 vendors minimum',
                '4. Compare quotation & select best',
                '5. Create PO & send to vendor',
                '6. Follow up delivery',
                '7. Receive goods & verify with PO',
                '8. AP process invoice',
                '',
                'Timeline:',
                '• Standart barang: 1-2 minggu',
                '• Custom barang: 2-4 minggu',
                '• Emergency order: negotiate with vendor',
                '',
                'Proses Pengajuan Barang Baru:',
                '',
                '• Submit product sample + spec',
                '• Quality & price evaluation',
                '• Approval meeting',
                '• Once approved: add to approved vendor list',
                '• Ongoing replenishment via standart PO',
            ],
            $admin
        );
    }

    // =====================================================================
    //  PRODUCTION CONTENT
    // =====================================================================

    private function seedProduksiContent(User $admin): void
    {
        $this->command->info('  🍨 Seeding Produksi Content...');

        $this->createContent(
            'Produksi Department',
            'Produksi Dept',
            [
                'Produksi Department Overview',
                '',
                'Team:',
                '• Produksi Manager',
                '• Assistant Manager',
                '• Production Staff',
                '• Quality Control',
                '',
                'Responsibility:',
                '1. Gelato production',
                '2. Drink production',
                '3. Quality assurance',
                '4. Inventory management',
                '5. Compliance dengan food safety',
                '',
                'Key Success Factor:',
                '• Tepat waktu production',
                '• Konsisten kualitas',
                '• Mengikuti food safety standards',
                '• Inventory accuracy',
            ],
            $admin
        );

        $this->createContent(
            'Inventory Produksi - Gelato',
            'Produksi Dept',
            [
                'Alur Kerja Produksi Gelato:',
                '',
                '1. Receive formula & ingredient list',
                '2. Pre-production check (ekspirasi, quality)',
                '3. Mixing & processing',
                '4. Cooling phase',
                '5. Churning & freezing',
                '6. Packaging',
                '7. QC check',
                '8. Freeze storage',
                '9. Distribution',
                '',
                'Aturan:',
                '• Hygiene: hand wash, glove, hair net mandatory',
                '• Temperature control: -18C terjaga',
                '• Traceability: batch number semua produk',
                '• Cross-contamination: prevent allergen mix',
                '',
                'Deadline:',
                '• Daily production: 06:00 - 14:00',
                '• Packing: 14:00 - 16:00',
                '',
                'Quality Control:',
                '• Taste & texture check setiap batch',
                '• Expire date labeling',
                '• Storage temperature verify',
                '• Weekly shelf-life test',
            ],
            $admin
        );

        $this->createContent(
            'Inventory Produksi - Drink',
            'Produksi Dept',
            [
                'Alur Kerja Produksi Drink:',
                '',
                '1. Receive formula & concentrate',
                '2. Mixing dengan water (ratio per formula)',
                '3. Blending process',
                '4. Temperature check',
                '5. Syrup preparation',
                '6. Bottling & sealing',
                '7. Label placement',
                '8. QC check',
                '9. Cooling & storage',
                '',
                'Aturan:',
                '• Use calibrated mixing tools',
                '• Temperature berdasarkan formula',
                '• Shelf-life per concentrate data',
                '• Cleanliness: equipment sanitized daily',
                '',
                'Deadline:',
                '• Production: 07:00 - 15:00',
                '• QC: before 16:00',
                '',
                'QC Checklist:',
                '• Taste & fragrance verification',
                '• Color consistency',
                '• Seal integrity',
                '• Proper labeling & exp date',
            ],
            $admin
        );

        $this->createContent(
            'Do & Dont\'s Produksi',
            'Produksi Dept',
            [
                'DO:',
                '✓ Wear complete safety gear (glove, apron, net)',
                '✓ Wash hands before & after each task',
                '✓ Follow recipe & measurement exactly',
                '✓ Check expiry date sebelum use',
                '✓ Report equipment issue immediately',
                '✓ Maintain cleanliness work area',
                '✓ Communicate dengan team',
                '',
                'DON\'T:',
                '✗ Work when sick',
                '✗ Eat/drink near production area',
                '✗ Skip quality check step',
                '✗ Use expired ingredients',
                '✗ Leave equipment running unattended',
                '✗ Mix batches dari different dates',
                '✗ Take shortcut pada process',
                '✗ Overload freezer beyond capacity',
            ],
            $admin
        );

        $this->createContent(
            'Packing Department',
            'Packing Dept',
            [
                'Packing Team Overview',
                '',
                'Team Structure:',
                '• Packing Manager',
                '• Packing Supervisor',
                '• Packing Staff (3-5 orang)',
                '',
                'Responsibility:',
                '• Receive finish product dari produksi',
                '• Packaging sesuai standard',
                '• Quality inspection',
                '• Labeling dengan correct info',
                '• Organize for shipment',
                '',
                'Working Hours:',
                '• Shift: 14:00 - 22:00 atau 10:00 - 18:00',
                '• Daily target: 500-800 unit',
                '',
                'Equipment:',
                '• Packing machine (semi-auto)',
                '• Scale for weight check',
                '• Labeling equipment',
                '• Storage racks',
            ],
            $admin
        );

        $this->createContent(
            'Alur Proses Packing',
            'Packing Dept',
            [
                'Alur Kerja Packing:',
                '',
                '1. Receive product list & specification',
                '2. Pick product dari cooling room',
                '3. Arrange dalam packaging material',
                '4. Seal packaging (machine/manual)',
                '5. Weigh & verify correct quantity',
                '6. Apply label dengan info:',
                '   - Product name',
                '   - Expiry date',
                '   - Batch number',
                '   - Content weight/volume',
                '7. QC final check',
                '8. Organize box untuk shipment',
                '9. Record & documentation',
                '',
                'Aturan:',
                '• Follow packaging hierarchy',
                '• Use correct material',
                '• Maintain temperature during packing',
                '• Prevent contamination',
                '• Accurate documentation',
                '',
                'Deadline:',
                '• Packing complete by 21:00',
                '',
                'QC Packing:',
                '• Random check 5% dari batch',
                '• Verify seal integrity',
                '• Check label accuracy',
                '• Weight compliance',
            ],
            $admin
        );

        $this->createContent(
            'Do & Dont\'s Packaging',
            'Packing Dept',
            [
                'DO:',
                '✓ Use designated packaging material',
                '✓ Maintain cold chain (keep <-18C)',
                '✓ Check label sebelum apply',
                '✓ Verify weight accuracy',
                '✓ Organize traceability',
                '✓ Report defective packing',
                '✓ Sanitize hands & equipment regularly',
                '',
                'DON\'T:',
                '✗ Use damaged packaging',
                '✗ Leave packed product at room temperature',
                '✗ Mix products dari different batches',
                '✗ Skip QC step',
                '✗ Reuse packaging',
                '✗ Eat/drink dalam packing area',
                '✗ Overload boxes beyond weight limit',
            ],
            $admin
        );

        $this->createContent(
            'Warehouse Department',
            'Warehouse Dept',
            [
                'Warehouse Team Overview',
                '',
                'Responsibility:',
                '• Receive finished goods',
                '• Organize & store efficiently',
                '• Manage inventory accuracy',
                '• Fulfill store orders',
                '• Maintain cold storage',
                '• Track expiry date',
                '',
                'Key Focus:',
                '• FIFO (First In First Out)',
                '• Proper temperature (< -18C)',
                '• Accurate inventory records',
                '• Timely fulfillment',
                '• Prevent spoilage',
            ],
            $admin
        );

        $this->createContent(
            'Prosedur Pemesanan Barang - Warehouse',
            'Warehouse Dept',
            [
                'Prosedur Pemesanan Barang:',
                '',
                '1. Store Manager submit order form',
                '   - Product & quantity',
                '   - Delivery date needed',
                '',
                '2. Warehouse Manager verify stock',
                '   - Check availability',
                '   - Verify expiry date',
                '',
                '3. Process order',
                '   - Pick dari rak',
                '   - QC & verify',
                '   - Pack untuk delivery',
                '',
                '4. Prepare delivery',
                '   - Use maintain cold transport',
                '   - Generate delivery note',
                '   - Coordinate transport',
                '',
                '5. Delivery & receipt',
                '   - Store manager sign off',
                '   - Record dalam system',
                '',
                'Timeline:',
                'Same-day order: fulfill within 24 hours',
                'Advance order: fulfill sesuai tanggal request',
            ],
            $admin
        );

        $this->createContent(
            'Do & Dont\'s Warehouse',
            'Warehouse Dept',
            [
                'DO:',
                '✓ Check expiry date setiap receive',
                '✓ Maintain temperature strict',
                '✓ Organize FIFO sistem',
                '✓ Keep inventory record updated',
                '✓ Sanitize storage area regularly',
                '✓ Use proper handling equipment',
                '✓ Report damaged product immediately',
                '',
                'DON\'T:',
                '✗ Stack product above capacity',
                '✗ Leave freezer door open lama',
                '✗ Mix different batches',
                '✗ Skip expiry date check',
                '✗ Use expired product (even slightly)',
                '✗ Store non-food items dengan product',
                '✗ Process order tanpa verification',
            ],
            $admin
        );

        $this->createContent(
            'Food & Pastry Department',
            'Food & Pastry Dept',
            [
                'Food & Pastry Team Overview',
                '',
                'Department Focus:',
                '• Pastry & baked goods production',
                '• Topping & filling creation',
                '• Special recipe development',
                '• Quality consistency',
                '',
                'Key Product:',
                '• Pastry shells',
                '• Toppings & sauces',
                '• Cone & biscuit',
                '• Seasonal specials',
                '',
                'Standard:',
                '• Food safety compliance',
                '• Recipe standardization',
                '• Quality control rigorous',
                '• Inventory tracking',
            ],
            $admin
        );

        $this->createContent(
            'Prosedur Kerja - Food & Pastry',
            'Food & Pastry Dept',
            [
                'Alur Kerja Produksi:',
                '',
                '1. Receive formula & ingredient list',
                '2. Pre-production setup',
                '3. Mixing & preparation',
                '4. Baking / cooking process',
                '5. Cooling & conditioning',
                '6. Packaging untuk packing dept',
                '7. QC check hasil',
                '',
                'Working hours:',
                '• Early shift: 04:00 - 12:00',
                '• Afternoon: 11:00 - 19:00',
                '',
                'Quality standard:',
                '• Taste consistency',
                '• Texture uniformity',
                '• Visual appearance',
                '• Proper packaging',
            ],
            $admin
        );

        $this->createContent(
            'Prosedur Pemesanan - Food & Pastry',
            'Food & Pastry Dept',
            [
                'Prosedur Pemesanan:',
                '',
                '1. Produksi / Warehouse submit order',
                '2. Food & Pastry Manager review',
                '3. Schedule production line',
                '4. Communicate delivery date',
                '5. Produce sesuai schedule',
                '6. Deliver & document',
                '',
                'Lead Time:',
                'Standart item: 2-3 hari',
                'Custom recipe: 5-7 hari development',
                'Seasonal: advance order min 2 minggu',
            ],
            $admin
        );

        $this->createContent(
            'Logistik Department',
            'Logistik Dept',
            [
                'Logistik Team Overview',
                '',
                'Responsibility:',
                '• Coordinate product distribution',
                '• Transport management',
                '• Delivery schedule optimization',
                '• Partner dengan courier/driver',
                '• Track shipment status',
                '',
                'Working Area:',
                '• Intra-warehouse logistics',
                '• Store distribution',
                '• Customer delivery',
                '• Return goods handling',
                '',
                'Fleet:',
                '• Refrigerated truck (maintain <-18C)',
                '• Regular delivery van',
                '• Courier partnerships',
            ],
            $admin
        );

        $this->createContent(
            'Prosedur Logistik',
            'Logistik Dept',
            [
                'Peraturan Dasar:',
                '',
                'Pre-Delivery:',
                '• Verify temperature alat transportasi',
                '• Check vehicle condition',
                '• Confirm delivery route',
                '• Brief driver tentang timeline',
                '',
                'During Delivery:',
                '• Maintain cold chain',
                '• Avoid unnecessary stops',
                '• Protect product damage',
                '• Document delivery',
                '',
                'Post-Delivery:',
                '• Collect signed proof',
                '• Record temperature log',
                '• Report any issue immediately',
                '• Vehicle cleanup & maintenance',
                '',
                'Do & Dont\'s:',
                '',
                'DO:',
                '✓ Inspect product sebelum load',
                '✓ Organize pallet efficiently',
                '✓ Monitor temperature in real-time',
                '✓ Follow traffic rules ketat',
                '',
                'DON\'T:',
                '✗ Overload vehicle',
                '✗ Leave product in warm area',
                '✗ Deviate dari planned route tanpa approval',
                '✗ Use expired tracking',
            ],
            $admin
        );
    }

    // =====================================================================
    //  STORE OPERATION CONTENT
    // =====================================================================

    private function seedStoreOperationContent(User $admin): void
    {
        $this->command->info('  🏪 Seeding Store Operation Content...');

        $this->createContent(
            'Prosedur Dasar - Store',
            'Prosedur Dasar',
            [
                'Store Operation Framework',
                '',
                'Tiga tipe staff dengan responsibility berbeda:',
                '',
                'Partimer / Freelance Level:',
                '• Basic counter service',
                '• Product serving',
                '• Cleaning duty',
                '• Follow SOP strictly',
                '• Report to supervisor',
                '',
                'Store Supervisor Level:',
                '• Oversee daily operation',
                '• Staff management & scheduling',
                '• Quality assurance',
                '• Inventory management',
                '• Report to Store Manager',
                '',
                'Store Manager Level:',
                '• Full store accountability',
                '• P&L responsibility',
                '• Marketing & promotion',
                '• Staff development',
                '• Report to Area Manager',
                '',
                'Manager Operation Level:',
                '• Multi-store oversight',
                '• Strategy execution',
                '• Performance monitoring',
                '• Regional coordination',
                '• Report to General Manager',
            ],
            $admin
        );

        $this->createContent(
            'SOP Pelayanan',
            'SOP Pelayanan',
            [
                'Standard Pelayanan Pelanggan:',
                '',
                'Greeting (0-30 detik saat customer masuk):',
                '• Sapa dengan ramah & senyum',
                '• "Selamat datang di [brand]"',
                '• Tanyakan apa yang dicari',
                '',
                'Product Knowledge:',
                '• Pahami semua menu items',
                '• Tahu ingredientnya',
                '• Bisa rekomendasi',
                '• Handle dietary question',
                '',
                'Ordering Process:',
                '1. Listen carefully',
                '2. Confirm order',
                '3. Ulangi untuk avoid mistake',
                '4. Process order dg cepat',
                '',
                'Payment:',
                '• Clear harga komunikasi',
                '• Bandingkan alternatif pembayaran',
                '• Terima payment dengan senyum',
                '• Give receipt & change tepat',
                '',
                'While Serving:',
                '• Serve dengan presentation baik',
                '• Eye contact & senyum',
                '• "Terima kasih sudah datang"',
                '• Tanya apakah ada yang perlu tambahan',
                '',
                'Finishing:',
                '• "Kami tunggu Anda kembali"',
                '• Bersihkan meja setelah pelanggan pergi',
                '',
                'Complaint Handling:',
                '• Dengarkan dengan tenang',
                '• Jangan defensive',
                '• Tawarkan solusi',
                '• Eskalasi jika perlu',
            ],
            $admin
        );

        $this->createContent(
            'SOP Opening & Closing Store',
            'SOP Opening & Closing Store',
            [
                'Prosedur Opening Store:',
                '',
                'Pre-Opening (30 menit sebelum operasional):',
                '1. Unlock & masuk semua area',
                '2. Check suhu freezer (harus -18C)',
                '3. Verifikasi product quality',
                '4. Bersihkan semua counter & peralatan',
                '5. Setup register & payment system',
                '6. Check persediaan supplies (cup, serbet, dll)',
                '7. Briefing to staff tentang hari ini',
                '8. Test POS system',
                '',
                'Operational Opening:',
                '9. Unlock pintu untuk customer',
                '10. Welcome first customer dengan enthusiasm',
                '11. Maintain cleanliness during service',
                '',
                'Prosedur Closing Store:',
                '',
                'During Last Hour:',
                '• Inform customer "closing soon"',
                '• Finish pending orders',
                '• Stop accepting new order 15 min before close',
                '',
                'Closing Process:',
                '1. Lock pintu (stop entry)',
                '2. Close cash register',
                '3. Count & reconcile cash',
                '4. Prepare deposit untuk bank (next day)',
                '5. Deep clean equipment',
                '6. Mop floors & disinfect',
                '7. Organize untuk besok',
                '8. Check freezer temperature',
                '9. Turn off semua equipment',
                '10. Lock windows & back door',
                '11. Final security check',
                '12. Lock pintu depan & pergi',
                '',
                'Documentation:',
                '• Record cash count',
                '• Daily report sign off',
                '• Any issue noted untuk manager',
            ],
            $admin
        );

        $this->createContent(
            'Prosedur Penanganan Komplain',
            'Prosedur Penanganan Komplain',
            [
                'Handling Complaint - Step by Step:',
                '',
                'Level 1 - Front Line (Partimer/Staff):',
                '1. Dengarkan customer dengan penuh perhatian',
                '2. Tunjukkan empati ("Kami pahami kekhawatiran Anda")',
                '3. Jangan argue atau defensive',
                '4. Catat apa keluhan utama',
                '5. Tawarkan solusi langsung jika bisa:',
                '   - Replace product',
                '   - Refund',
                '   - Discount next purchase',
                '6. Jika tidak bisa resolve → escalate',
                '',
                'Level 2 - Supervisor (Escalation):',
                '7. Supervisor meet dengan customer',
                '8. Review apa sudah dicoba',
                '9. Offer additional remedy',
                '10. Get customer contact info',
                '11. Promise follow-up',
                '',
                'Eskalasi:',
                'Jika komplain serious (food poisoning, major damage):',
                '• Immediately report ke manager',
                '• Document incident detail',
                '• Mungkin perlu involve medical (food poisoning)',
                '• Keep sample product (jika ada)',
                '',
                'Penyelesaian:',
                '• Resolve dalam 24 jam',
                '• Give appropriate compensation',
                '• Document resolution',
                '• Follow-up call customer',
                '',
                'Prevention:',
                '• Analyze root cause',
                '• Implement corrective action',
                '• Share learning dengan team',
            ],
            $admin
        );

        $this->createContent(
            'Prosedur New Store Opening',
            'Prosedur New Store Opening',
            [
                'Pre-Opening Planning (4-6 minggu):',
                '',
                'Fase 1: Preparation',
                '• Verify lokasi & facility',
                '• Ensure semua equipment arrived & installed',
                '• Set up POS & payment system',
                '• Training received (staff & manager)',
                '• Supply chain ready',
                '• Marketing campaign prepared',
                '',
                'Fase 2: Soft Opening (1 minggu sebelum official)',
                '• Limited hours operation',
                '• Trained staff only',
                '• Test all process & system',
                '• Iron out operation issues',
                '• Get feedback dari trial customer',
                '',
                'Fase 3: Grand Opening (Day 1)',
                '• Full hours operation',
                '• Official announcement',
                '• Special promotion/discount',
                '• VIP customer invited',
                '• Media & influencer present',
                '',
                'Post-Opening (First 2 weeks):',
                '• Monitor closely daily',
                '• Staff supervision intensif',
                '• Quick problem resolution',
                '• Customer feedback collection',
                '• Quality assurance strict',
                '',
                'Success Criteria:',
                '• 80% customer satisfaction',
                '• Zero operational issue',
                '• Staff confidence in SOP',
                '• Sales projection 80%+',
            ],
            $admin
        );
    }

    // =====================================================================
    //  HELPER METHOD
    // =====================================================================

    /**
     * Create formatted content helper
     */
    private function createContent(
        string $title,
        string $moduleName,
        array $contentLines,
        User $admin
    ): void {
        $module = Module::where('name', $moduleName)->first();
        if (!$module) {
            $this->command->warn("    ⚠ Module not found: {$moduleName}");
            return;
        }

        $formatted = $this->formatter->format($contentLines);
        $wrappedHtml = $this->formatter->wrapContent($formatted, $title);

        $existing = Content::where('module_id', $module->id)->where('title', $title)->first();

        if ($existing) {
            $existing->update([
                'content' => $wrappedHtml,
                'updated_by' => $admin->id,
            ]);
        } else {
            Content::create([
                'module_id' => $module->id,
                'title' => $title,
                'content' => $wrappedHtml,
                'status' => 'publish',
                'created_by' => $admin->id,
            ]);
        }

        $this->command->line("    ✅ {$title}");
    }
}
