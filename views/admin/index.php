<!DOCTYPE html>
<html lang="id">

<head>
    <title>Sukabumi Muda - Admin Panel (Front-end Demo)</title>
    <?php include __DIR__ . '/../../config/config.php'; ?>
    <?php include __DIR__ . '/components/header.php'; ?>
    <?php include __DIR__ . '/../../vendor/autoload.php'; ?>
    <?php // Ambil data dari tabel artikels;
    use Carbon\Carbon;

    Carbon::setLocale('id');
    $result = $conn->query("SELECT * FROM artikels ORDER BY tanggal_publish DESC"); ?>
</head>

<body>
    <section id="adminMainWrapper" class="admin-main-wrapper">
        <?php include('components/navbar.php') ?>
        <main class="admin-main-content">
            <div class="container">
                <br>
                <?php if (isset($_SESSION['flash_success'])): ?>
                    <div class="alert alert-success">
                        <?= $_SESSION['flash_success'];
                        unset($_SESSION['flash_success']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['flash_error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['flash_error'];
                        unset($_SESSION['flash_error']); ?>
                    </div>
                <?php endif; ?>
                <br>
                <div id="dashboardPage" class="admin-sub-page active">
                    <h2 class="page-section-title">Ringkasan Statistik</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="icon"><i class="fas fa-newspaper"></i></div>
                            <div class="number">125</div>
                            <div class="label">Total Artikel</div>
                        </div>
                        <div class="stat-card">
                            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="number">18</div>
                            <div class="label">Event Mendatang</div>
                        </div>
                        <div class="stat-card">
                            <div class="icon"><i class="fas fa-briefcase"></i></div>
                            <div class="number">32</div>
                            <div class="label">Lowongan Aktif</div>
                        </div>
                        <div class="stat-card">
                            <div class="icon"><i class="fas fa-users"></i></div>
                            <div class="number">850</div>
                            <div class="label">Total Pengunjung Bulan Ini</div>
                        </div>
                    </div>

                    <h2 class="page-section-title">Tindakan Cepat</h2>
                    <div class="quick-links-grid">
                        <a href="#" class="quick-link-button" data-page-target="articles">
                            <div class="icon"><i class="fas fa-plus-circle"></i></div>
                            <div class="text">Buat Artikel Baru</div>
                        </a>
                        <a href="#" class="quick-link-button" data-page-target="events">
                            <div class="icon"><i class="fas fa-calendar-plus"></i></div>
                            <div class="text">Tambah Event Baru</div>
                        </a>
                        <a href="#" class="quick-link-button" data-page-target="jobs">
                            <div class="icon"><i class="fas fa-briefcase-medical"></i></div>
                            <div class="text">Posting Lowongan Baru</div>
                        </a>
                        <a href="#" class="quick-link-button">
                            <div class="icon"><i class="fas fa-edit"></i></div>
                            <div class="text">Kelola Rekomendasi</div>
                        </a>
                        <a href="#" class="quick-link-button">
                            <div class="icon"><i class="fas fa-cogs"></i></div>
                            <div class="text">Pengaturan Website</div>
                        </a>
                        <a href="#" class="quick-link-button">
                            <div class="icon"><i class="fas fa-chart-bar"></i></div>
                            <div class="text">Lihat Laporan</div>
                        </a>
                    </div>

                    <h2 class="page-section-title">Pemberitahuan</h2>
                    <div class="notifications-area">
                        <p><i class="fas fa-bell"></i> Belum ada pemberitahuan baru.</p>
                        <p><i class="fas fa-check-circle"></i> Sistem berjalan normal.</p>
                    </div>
                </div>

                <div id="articlesPage" class="admin-sub-page">
                    <h2 class="page-section-title">Manajemen Artikel</h2>
                    <div class="info-card">
                        <p>Di sini Anda bisa mengelola semua artikel yang dipublikasikan di Sukabumi Muda.</p>
                        <div class="form-group" style="text-align: right;">
                            <button onclick="window.location.href='/SukaInfo_app/createArtikel'" class="submit-button" style="width: auto;">
                                <i class="fas fa-plus"></i> Tambah Artikel Baru
                            </button>
                        </div>

                        <div class="table-responsive-wrapper">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul Artikel</th>
                                        <th>Penulis</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result && $result->num_rows > 0): ?>
                                        <?php $no = 1;
                                        while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= htmlspecialchars($row['judul']) ?></td>
                                                <td><?= htmlspecialchars($row['penulis'] ?: 'Admin') ?></td>
                                                <td>
                                                    <?php
                                                    $tanggal = $row['tanggal_publish'];
                                                    echo $tanggal ? Carbon::parse($tanggal)->translatedFormat('d F Y') : '-';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $status = strtolower($row['status']);
                                                    $statusLabel = $status === 'draft' ? 'orange' : 'green';
                                                    echo "<span style='color: {$statusLabel}; font-weight: 500;'>" . ucfirst($status) . "</span>";
                                                    ?>
                                                </td>

                                                <td class="action-buttons">
                                                    <a href="/SukaInfo_app/viewArtikel?id=<?= $row['id'] ?>" title="Lihat"><i class="fas fa-eye"></i></a>
                                                    <a href="/SukaInfo_app/editArtikel?id=<?= $row['id'] ?>" title="Edit"><i class="fas fa-edit"></i></a>
                                                    <a href="/SukaInfo_app/deleteArtikel?id=<?= $row['id'] ?>" title="Hapus" class="delete" onclick="return confirm('Yakin ingin hapus?')"><i class="fas fa-trash-alt"></i></a>
                                                </td>

                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6">Tidak ada artikel.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div id="eventsPage" class="admin-sub-page">
                    <h2 class="page-section-title">Manajemen Event</h2>
                    <div class="info-card">
                        <p>Atur dan publikasikan event yang diselenggarakan oleh Sukabumi Muda atau mitra.</p>
                        <div class="form-group" style="text-align: right;">
                            <button class="submit-button" style="width: auto;"><i class="fas fa-plus"></i> Tambah Event Baru</button>
                        </div>
                        <div class="table-responsive-wrapper">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Event</th>
                                        <th>Tanggal</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Seminar Kewirausahaan Muda</td>
                                        <td>2025-07-20</td>
                                        <td>Gedung Pemuda</td>
                                        <td><span style="color: blue; font-weight: 500;">Mendatang</span></td>
                                        <td class="action-buttons">
                                            <button title="Edit"><i class="fas fa-edit"></i></button>
                                            <button title="Hapus" class="delete"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Workshop Desain Grafis</td>
                                        <td>2025-08-05</td>
                                        <td>Pusat Komunitas</td>
                                        <td><span style="color: blue; font-weight: 500;">Mendatang</span></td>
                                        <td class="action-buttons">
                                            <button title="Edit"><i class="fas fa-edit"></i></button>
                                            <button title="Hapus" class="delete"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Bakti Sosial Lingkungan</td>
                                        <td>2025-06-25</td>
                                        <td>Pantai Pelabuhan Ratu</td>
                                        <td><span style="color: green; font-weight: 500;">Selesai</span></td>
                                        <td class="action-buttons">
                                            <button title="Edit"><i class="fas fa-edit"></i></button>
                                            <button title="Hapus" class="delete"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="jobsPage" class="admin-sub-page">
                    <h2 class="page-section-title">Manajemen Lowongan Kerja</h2>
                    <div class="info-card">
                        <p>Kelola daftar lowongan kerja yang tersedia untuk pemuda Sukabumi.</p>
                        <div class="form-group" style="text-align: right;">
                            <button class="submit-button" style="width: auto;"><i class="fas fa-plus"></i> Tambah Lowongan Baru</button>
                        </div>
                        <div class="table-responsive-wrapper">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Posisi</th>
                                        <th>Perusahaan</th>
                                        <th>Batas Lamaran</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Web Developer Junior</td>
                                        <td>PT Maju Digital</td>
                                        <td>2025-07-31</td>
                                        <td><span style="color: green; font-weight: 500;">Aktif</span></td>
                                        <td class="action-buttons">
                                            <button title="Edit"><i class="fas fa-edit"></i></button>
                                            <button title="Hapus" class="delete"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Social Media Specialist</td>
                                        <td>Sukabumi Kreatif</td>
                                        <td>2025-07-15</td>
                                        <td><span style="color: green; font-weight: 500;">Aktif</span></td>
                                        <td class="action-buttons">
                                            <button title="Edit"><i class="fas fa-edit"></i></button>
                                            <button title="Hapus" class="delete"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Marketing Staff</td>
                                        <td>CV Harapan Baru</td>
                                        <td>2025-06-30</td>
                                        <td><span style="color: orange; font-weight: 500;">Ditutup</span></td>
                                        <td class="action-buttons">
                                            <button title="Edit"><i class="fas fa-edit"></i></button>
                                            <button title="Hapus" class="delete"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="usersPage" class="admin-sub-page">
                    <h2 class="page-section-title">Manajemen Pengguna</h2>
                    <div class="info-card">
                        <p>Lihat dan kelola akun pengguna yang terdaftar di platform Sukabumi Muda.</p>
                        <div class="form-group" style="text-align: right;">
                            <button class="submit-button" style="width: auto;"><i class="fas fa-user-plus"></i> Tambah Pengguna Baru</button>
                        </div>
                        <div class="table-responsive-wrapper">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pengguna</th>
                                        <th>Email</th>
                                        <th>Peran</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Sihab</td>
                                        <td>sihabudin@gamil.com</td>
                                        <td>Admin</td>
                                        <td><span style="color: green; font-weight: 500;">Aktif</span></td>
                                        <td class="action-buttons">
                                            <button title="Edit"><i class="fas fa-edit"></i></button>
                                            <button title="Hapus" class="delete"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Aripin</td>
                                        <td>aripinn@gmail.com</td>
                                        <td>Admin</td>
                                        <td><span style="color: green; font-weight: 500;">Aktif</span></td>
                                        <td class="action-buttons">
                                            <button title="Edit"><i class="fas fa-edit"></i></button>
                                            <button title="Hapus" class="delete"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Budi Santoso</td>
                                        <td>budi.s@gmail.com</td>
                                        <td>Admin</td>
                                        <td><span style="color: orange; font-weight: 500;">Nonaktif</span></td>
                                        <td class="action-buttons">
                                            <button title="Edit"><i class="fas fa-edit"></i></button>
                                            <button title="Hapus" class="delete"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="footer">
            <p>&copy; 2025 Sukabumi Muda. All rights reserved.</p>
        </footer>
    </section>
    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/dashboard.js"></script>
</body>

</html>