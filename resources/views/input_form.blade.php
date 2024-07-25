<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cek Parameter Logam dan Mikrobiologi</title>
</head>
<body>
    <div class="container mt-5">
        <form action="{{ route('validateData') }}" method="post" class="border p-4 rounded">
            @csrf
            <div class="mb-3">
                <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                <select id="nama_perusahaan" name="nama_perusahaan" class="form-select">
                    <option value="">Pilih Perusahaan</option>
                    @foreach($companies as $company)
                        <option value="{{ $company }}">{{ $company }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <select id="nama_produk" name="nama_produk" class="form-select">
                    <option value="">Pilih Produk</option>
                    <!-- Produk akan diisi berdasarkan perusahaan yang dipilih -->
                </select>
            </div>

            <!-- <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control">
            </div> -->

            <div id="logam_input" class="mb-3">
                <label class="form-label">Kandungan Logam</label>
                <div class="row g-2">
                    <div class="col">
                        <input type="text" name="logam_as" class="form-control" placeholder="As" required>
                    </div>
                    <div class="col">
                        <input type="text" name="logam_pb" class="form-control" placeholder="Pb" required>
                    </div>
                    <div class="col">
                        <input type="text" name="logam_hg" class="form-control" placeholder="Hg" required>
                    </div>
                    <div class="col">
                        <input type="text" name="logam_cd" class="form-control" placeholder="Cd" required>
                    </div>
                    <div class="col">
                        <input type="text" name="logam_sn" class="form-control" placeholder="Sn" required>
                    </div>
                </div>
            </div>

            <div id="mikrobiologi_input" class="mb-3">
                <!-- Input untuk mikrobiologi akan di-generate di sini -->
            </div>

            <button type="submit" class="btn btn-primary">Cek</button>
        </form>
    </div>

    <script>
        document.getElementById('nama_perusahaan').addEventListener('change', function() {
            var company = this.value;

            // Panggil API untuk mendapatkan produk berdasarkan perusahaan
            fetch(`/getProductData?nama_perusahaan=${company}`)
                .then(response => response.json())
                .then(data => {
                    var produkSelect = document.getElementById('nama_produk');
                    produkSelect.innerHTML = '<option value="">Pilih Produk</option>'; // Hapus opsi sebelumnya

                    data.forEach(item => {
                        produkSelect.innerHTML += `<option value="${item['Nama Produk']}">${item['Nama Produk']}</option>`;
                    });
                });
        });

        document.getElementById('nama_produk').addEventListener('change', function() {
            var product = this.value;
            var company = document.getElementById('nama_perusahaan').value;

            // Panggil API untuk mendapatkan data produk
            fetch(`/getProductData?nama_perusahaan=${company}&nama_produk=${product}`)
                .then(response => response.json())
                .then(data => {
                    var mikrobiologiInput = document.getElementById('mikrobiologi_input');
                    mikrobiologiInput.innerHTML = ''; // Hapus input sebelumnya

                    if (data.Mikrobiologi) {
                        Object.keys(data.Mikrobiologi).forEach(function(key) {
                            mikrobiologiInput.innerHTML += `
                                <div class="mb-3">
                                    <label for="mikrobiologi_${key.toLowerCase()}" class="form-label">${key}</label>
                                    <input type="text" name="mikrobiologi_${key.toLowerCase()}" id="mikrobiologi_${key.toLowerCase()}" class="form-control" placeholder="${key}">
                                </div>`;
                        });
                    }
                });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
