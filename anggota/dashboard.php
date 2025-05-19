<?php
include '../includes/db.php';
include '../includes/auth.php';
cekLogin('anggota');

$id = $_SESSION['id'];
$cek = mysqli_query($conn, "SELECT sudah_memilih FROM anggota WHERE id=$id");
$status = mysqli_fetch_assoc($cek)['sudah_memilih'];

include '../includes/header.php';
?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center md:text-left">🗳️ Dashboard Anggota</h1>

    <?php if ($status): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow mb-8 text-center">
            <h2 class="text-lg font-semibold">Anda sudah memilih ✅</h2>
            <p class="text-sm">Terima kasih telah berpartisipasi dalam pemilihan ketua komunitas.</p>
        </div>
    <?php else: ?>
        <?php $calon = mysqli_query($conn, "SELECT * FROM calon"); ?>
        <form method="POST" action="proses_voting.php" class="space-y-6" id="voteForm">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while ($c = mysqli_fetch_assoc($calon)): ?>
                    <label class="relative bg-white border border-gray-200 rounded-xl shadow-lg p-4 hover:border-blue-500 transition group cursor-pointer">
                        <input type="radio" name="id_calon" value="<?= $c['id'] ?>" required class="absolute top-4 right-4 w-5 h-5 accent-blue-600">
                        <div class="flex flex-col items-center text-center">
                            <img src="../calon_foto/<?= htmlspecialchars($c['foto']) ?>"
                                 alt="<?= htmlspecialchars($c['nama']) ?>"
                                 class="w-24 h-24 object-cover rounded-full mb-4 border-4 border-white shadow-md transition group-hover:scale-105">
                            <h3 class="text-lg font-bold text-gray-800"><?= htmlspecialchars($c['nama']) ?></h3>
                            <p class="mt-2 text-sm text-gray-600"><strong>Visi:</strong> <?= htmlspecialchars($c['visi']) ?></p>
                            <p class="mt-1 text-sm text-gray-600"><strong>Misi:</strong> <?= htmlspecialchars($c['misi']) ?></p>
                        </div>
                    </label>
                <?php endwhile; ?>
            </div>

            <div class="text-center mt-8">
                <button type="submit" id="submitBtn" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 transition text-white font-semibold px-6 py-3 rounded-lg shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg id="loadingSpinner" class="hidden w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span id="submitText">Kirim Suara 🗳️</span>
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>

<script>
    document.getElementById('voteForm')?.addEventListener('submit', function () {
        const submitBtn = document.getElementById("submitBtn");
        const loadingSpinner = document.getElementById("loadingSpinner");
        const submitText = document.getElementById("submitText");

        submitBtn.disabled = true;
        loadingSpinner.classList.remove("hidden");
        submitText.textContent = "Mengirim...";
    });
</script>

</body>
</html>
