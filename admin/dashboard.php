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

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-10">Dashboard Admin</h1>

    <!-- Statistik Voting -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4 text-blue-700">Statistik Voting</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
            <?php foreach ($labels as $i => $nama): ?>
            <div class="bg-white border-l-4 border-blue-500 p-4 shadow rounded">
                <h3 class="text-lg font-semibold text-gray-700"><?= htmlspecialchars($nama) ?></h3>
                <p class="text-gray-600"><?= $data[$i] ?> Suara</p>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <canvas id="chart" height="100"></canvas>
        </div>
    </section>

    <!-- Tambah Anggota -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4 text-green-700">Tambah Anggota</h2>
        <form method="POST" action="tambah_anggota.php" class="bg-white p-6 rounded shadow space-y-4 max-w-lg mx-auto">
            <input name="nama" placeholder="Nama Lengkap" required class="form-control">
            <input name="nisn" placeholder="NISN" required class="form-control">
            <input type="password" name="password" placeholder="Password" required class="form-control">
            <button class="btn btn-success w-full">Tambah Anggota</button>
        </form>

        <h3 class="text-xl font-semibold mt-10 mb-4 text-gray-700">Data Anggota</h3>
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="table table-striped">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3">Nama</th>
                        <th class="p-3">NISN</th>
                        <th class="p-3">Sudah Memilih</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php mysqli_data_seek($anggota, 0); while ($a = mysqli_fetch_assoc($anggota)): ?>
                    <tr>
                        <td class="p-3"><?= htmlspecialchars($a['nama']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($a['nisn']) ?></td>
                        <td class="p-3 text-center"><?= $a['sudah_memilih'] ? '✅' : '❌' ?></td>
                        <td class="p-3">
                            <a href="hapus_anggota.php?id=<?= $a['id'] ?>" onclick="return confirm('Yakin ingin menghapus anggota ini?')" class="text-red-500 hover:underline">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Tambah Calon Ketua -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4 text-blue-700">Tambah Calon Ketua</h2>
        <form method="POST" action="proses_calon.php" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4 max-w-lg mx-auto">
            <input name="nama" placeholder="Nama Calon" required class="form-control">
            <textarea name="visi" placeholder="Visi" required class="form-control"></textarea>
            <textarea name="misi" placeholder="Misi" required class="form-control"></textarea>
            <input type="file" name="foto" accept="image/*" required class="form-control">
            <button class="btn btn-primary w-full">Simpan Calon</button>
        </form>

        <h3 class="text-xl font-semibold mt-10 mb-4 text-gray-700">Data Calon Ketua</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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

    <!-- Logout -->
    <div class="text-center mt-8">
        <a href="../logout.php" class="text-sm text-red-500 hover:underline">&larr; Logout</a>
    </div>
</div>

<!-- Chart.js -->
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

<!-- Tailwind Form Styling -->
<style>
    .form-control {
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 0.375rem;
        width: 100%;
    }
    .btn {
        display: inline-block;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        text-align: center;
    }
    .btn-success {
        background-color: #16a34a;
        color: white;
    }
    .btn-success:hover {
        background-color: #15803d;
    }
    .btn-primary {
        background-color: #2563eb;
        color: white;
    }
    .btn-primary:hover {
        background-color: #1d4ed8;
    }
</style>

</body>
</html>