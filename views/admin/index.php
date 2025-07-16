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
                            <div class="number"><?= $totalArtikel ?></div>
                            <div class="label">Total Artikel</div>
                        </div>
                        <div class="stat-card">
                            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="number"><?= $totalEvents ?></div>
                            <div class="label">Event Mendatang</div>
                        </div>
                        <?php
                        // Hitung lowongan yang masih aktif
                        $lowonganAktif = array_filter($lowongans, function ($job) {
                            return strtotime($job['tanggal_berakhir']) >= time();
                        });
                        ?>
                        <div class="stat-card">
                            <div class="icon"><i class="fas fa-briefcase"></i></div>
                            <div class="number"><?= count($lowonganAktif) ?></div>
                            <div class="label">Lowongan Aktif</div>
                        </div>
                        <div class="stat-card">
                            <div class="icon"><i class="fas fa-users"></i></div>
                            <div class="number"><?= $totalPengguna ?></div>
                            <div class="label">Total Data Pengguna</div>
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
                                                    <a href="/SukaInfo_app/detailArtikel?id=<?= $row['id'] ?>" title="Lihat"><i class="fas fa-eye"></i></a>
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

                <div id="rekomendasiPage" class="admin-sub-page">
                    <h2 class="page-section-title">Manajemen Rekomendasi Tempat</h2>

                    <div class="info-card">
                        <p>Di sini Anda bisa mengelola semua tempat wisata, kuliner, atau lokasi menarik di Sukabumi.</p>

                        <div class="form-group text-end">
                            <button onclick="window.location.href='/SukaInfo_app/rekomendasi/create'" class="submit-button" style="width: auto;">
                                <i class="fas fa-plus"></i> Tambah Rekomendasi Baru
                            </button>
                        </div>

                        <div class="table-responsive-wrapper">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Tempat</th>
                                        <th>Kategori</th>
                                        <th>Lokasi</th>
                                        <th>Tanggal Ditambahkan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($rekomendasis)): ?>
                                        <?php $no = 1;
                                        foreach ($rekomendasis as $row): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= htmlspecialchars($row['nama_tempat']) ?></td>
                                                <td><?= htmlspecialchars($row['kategori'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($row['lokasi']) ?></td>
                                                <td>
                                                    <?php
                                                    $tanggal = $row['tanggal'] ?? null;
                                                    echo $tanggal ? \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') : '-';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $status = strtolower($row['status']);
                                                    $warna = $status === 'draft' ? 'orange' : 'green';
                                                    echo "<span style='color: {$warna}; font-weight: 500;'>" . ucfirst($status) . "</span>";
                                                    ?>
                                                </td>
                                                <td class="action-buttons">
                                                    <a href="/SukaInfo_app/detailRekomendasi?id=<?= $row['id'] ?>" title="Lihat"><i class="fas fa-eye"></i></a>
                                                    <a href="/SukaInfo_app/rekomendasi/edit?id=<?= $row['id'] ?>" title="Edit"><i class="fas fa-edit"></i></a>
                                                    <a href="/SukaInfo_app/rekomendasi/delete?id=<?= $row['id'] ?>" title="Hapus" class="delete" onclick="return confirm('Yakin ingin menghapus tempat ini?')"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Belum ada data tempat yang direkomendasikan.</td>
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
                            <button onclick="window.location.href='/SukaInfo_app/createEvent'" class="submit-button" style="width: auto;"><i class="fas fa-plus"></i> Tambah Event Baru</button>
                        </div>
                        <div class="table-responsive-wrapper">
                            <table class="data-table table table-bordered table-striped">
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
                                    <?php foreach ($events as $index => $event): ?>
                                        <?php
                                        $tanggalEvent = strtotime($event['tanggal']);
                                        $status = $tanggalEvent >= time() ? 'Mendatang' : 'Selesai';
                                        $warnaStatus = $status === 'Mendatang' ? 'blue' : 'green';
                                        ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= htmlspecialchars($event['judul']) ?></td>
                                            <td><?= htmlspecialchars($event['tanggal']) ?></td>
                                            <td><?= htmlspecialchars($event['lokasi']) ?></td>
                                            <td><span style="color: <?= $warnaStatus ?>; font-weight: 500;"><?= $status ?></span></td>
                                            <td class="action-buttons">
                                                <!-- Tombol Detail -->
                                                <a href="/SukaInfo_app/event/detail?id=<?= $event['id'] ?>" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <!-- Tombol Edit -->
                                                <a href="/SukaInfo_app/event/edit?id=<?= $event['id'] ?>" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <!-- Tombol Hapus -->
                                                <a href="/SukaInfo_app/event/delete?id=<?= $event['id'] ?>" title="Hapus" class="delete" onclick="return confirm('Yakin ingin menghapus event ini?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
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
                            <button onclick="window.location.href='/SukaInfo_app/createJobs'" class="submit-button" style="width: auto;"><i class="fas fa-plus"></i> Tambah Lowongan Baru</button>
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
                                    <?php foreach ($lowongans as $index => $job): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= htmlspecialchars($job['judul']) ?></td>
                                            <td><?= htmlspecialchars($job['perusahaan']) ?></td>
                                            <td><?= htmlspecialchars($job['tanggal_berakhir']) ?></td>
                                            <td>
                                                <?php
                                                $status = strtotime($job['tanggal_berakhir']) >= time() ? 'Aktif' : 'Ditutup';
                                                $warna = $status === 'Aktif' ? 'green' : 'orange';
                                                ?>
                                                <span style="color: <?= $warna ?>; font-weight: 500;"><?= $status ?></span>
                                            </td>
                                            <td class="action-buttons">
                                                <a href="/SukaInfo_app/jobs/detail?id=<?= $job['id'] ?>" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                                <a href="/SukaInfo_app/lowongan/edit?id=<?= $job['id'] ?>" title="Edit"><i class="fas fa-edit"></i></a>
                                                <a href="/SukaInfo_app/jobs/delete?id=<?= $job['id'] ?>" title="Hapus" class="delete" onclick="return confirm('Yakin ingin hapus?')"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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
                            <button class="submit-button" onclick="window.location.href='/SukaInfo_app/pengguna/create'" style="width: auto;"><i class="fas fa-user-plus"></i> Tambah Pengguna Baru</button>
                        </div>
                        <div class="table-responsive-wrapper">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pengguna</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $index => $user): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= htmlspecialchars($user['username']) ?></td>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td class="action-buttons">
                                                <a href="/SukaInfo_app/pengguna?id=<?= $user['id'] ?>" title="Edit"><i class="fas fa-edit"></i></a>
                                                <a href="/SukaInfo_app/deletePengguna?id=<?= $user['id'] ?>" title="Hapus" class="delete" onclick="return confirm('Yakin ingin hapus?')"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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