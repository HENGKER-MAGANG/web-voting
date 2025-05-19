<?php
include '../includes/db.php';
include '../includes/auth.php';
cekLogin('admin');

// Ambil data suara
$sql = "SELECT calon.nama, COUNT(suara.id) as total FROM calon LEFT JOIN suara ON calon.id = suara.id_calon GROUP BY calon.id";
$result = mysqli_query($conn, $sql);
$data = [];
$labels = [];

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['nama'];
    $data[] = $row['total'];
}

// Ambil data anggota
$anggota = mysqli_query($conn, "SELECT * FROM anggota ORDER BY nama");

// Ambil data calon
$calon = mysqli_query($conn, "SELECT * FROM calon ORDER BY nama");
?>
<?php include '../includes/header.php'; ?>

<div class="p-6 max-w-7xl mx-auto">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-8">Dashboard Admin</h1>

    <!-- Diagram Voting -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4 text-blue-700">Statistik Voting</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <?php foreach ($labels as $i => $nama): ?>
            <div class="bg-white border-l-4 border-blue-500 p-4 shadow-md rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700"><?= htmlspecialchars($nama) ?></h3>
                <p class="text-gray-600"><?= $data[$i] ?> Suara</p>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="bg-white p-4 rounded shadow-md">
            <canvas id="chart" height="100"></canvas>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('chart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($labels) ?>,
                    datasets: [{
                        label: 'Jumlah Suara',
                        data: <?= json_encode($data) ?>,
                        backgroundColor: 'rgba(37, 99, 235, 0.7)',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }
                }
            });
        </script>
    </section>

    <!-- Form Tambah Anggota -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4 text-green-700">Tambah Anggota</h2>
        <form method="POST" action="tambah_anggota.php" class="bg-white p-6 rounded shadow-md space-y-4 max-w-lg">
            <input name="nama" placeholder="Nama Lengkap" required class="p-2 border rounded w-full">
            <input name="nisn" placeholder="NISN" required class="p-2 border rounded w-full">
            <input type="password" name="password" placeholder="Password" required class="p-2 border rounded w-full">
            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full">Tambah Anggota</button>
        </form>

        <!-- Daftar Anggota -->
        <h3 class="text-xl font-semibold mt-8 mb-2 text-gray-700">Data Anggota</h3>
        <div class="bg-white shadow-md rounded overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="p-3 border">Nama</th>
                        <th class="p-3 border">NISN</th>
                        <th class="p-3 border">Sudah Memilih</th>
                        <th class="p-3 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php mysqli_data_seek($anggota, 0); while ($a = mysqli_fetch_assoc($anggota)): ?>
                    <tr class="text-center text-gray-700">
                        <td class="p-3 border"><?= htmlspecialchars($a['nama']) ?></td>
                        <td class="p-3 border"><?= htmlspecialchars($a['nisn']) ?></td>
                        <td class="p-3 border"><?= $a['sudah_memilih'] ? '✅' : '❌' ?></td>
                        <td class="p-3 border">
                            <a href="hapus_anggota.php?id=<?= $a['id'] ?>" onclick="return confirm('Yakin ingin menghapus anggota ini?')" class="text-red-500 hover:underline">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Form Tambah Calon Ketua -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4 text-blue-700">Tambah Calon Ketua</h2>
        <form method="POST" action="proses_calon.php" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md space-y-4 max-w-lg">
            <input name="nama" placeholder="Nama Calon" required class="p-2 border rounded w-full">
            <textarea name="visi" placeholder="Visi" required class="p-2 border rounded w-full"></textarea>
            <textarea name="misi" placeholder="Misi" required class="p-2 border rounded w-full"></textarea>
            <input type="file" name="foto" accept="image/*" required class="p-2 border rounded w-full">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">Simpan Calon</button>
        </form>

        <!-- Daftar Calon Ketua -->
        <h3 class="text-xl font-semibold mt-8 mb-2 text-gray-700">Data Calon Ketua</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php mysqli_data_seek($calon, 0); while ($c = mysqli_fetch_assoc($calon)): ?>
            <div class="bg-white shadow p-4 rounded relative">
                <img src="../calon_foto/<?= htmlspecialchars($c['foto']) ?>" class="w-full h-48 object-cover rounded mb-2">
                <h4 class="font-bold text-lg text-gray-800 mb-1"><?= htmlspecialchars($c['nama']) ?></h4>
                <p class="text-sm text-gray-700"><strong>Visi:</strong> <?= htmlspecialchars($c['visi']) ?></p>
                <p class="text-sm text-gray-700"><strong>Misi:</strong> <?= htmlspecialchars($c['misi']) ?></p>
                <a href="hapus_calon.php?id=<?= $c['id'] ?>" onclick="return confirm('Yakin ingin menghapus calon ini?')" class="text-red-500 hover:underline text-sm absolute top-2 right-2 bg-white px-2 py-1 rounded">Hapus</a>
            </div>
            <?php endwhile; ?>
        </div>
    </section>

    <a href="../logout.php" class="inline-block mt-8 text-sm text-red-500 hover:underline">← Logout</a>
</div>
</body>
</html>