<form action="{{ route('validateData') }}" method="post">
    @csrf
    <select id="nama_perusahaan" name="nama_perusahaan">
        @foreach($companies as $company)
            <option value="{{ $company }}">{{ $company }}</option>
        @endforeach
    </select>
    <select id="nama_produk" name="nama_produk">
        <!-- Produk akan diisi berdasarkan perusahaan yang dipilih -->
    </select>
    <input type="date" name="tanggal">

    <div id="logam_input">
        <input type="text" name="logam_as" placeholder="As">
        <input type="text" name="logam_pb" placeholder="Pb">
        <input type="text" name="logam_hg" placeholder="Hg">
        <input type="text" name="logam_cd" placeholder="Cd">
        <input type="text" name="logam_sn" placeholder="Sn">
    </div>

    <div id="mikrobiologi_input">
        <!-- Input untuk mikrobiologi akan di-generate di sini -->
    </div>

    <button type="submit">Cek</button>
</form>

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
                mikrobiologiInput.innerHTML = '';

                for (var key in data) {
                    if (key.startsWith('Mikrobiologi')) {
                        mikrobiologiInput.innerHTML += `<input type="text" name="${key}" placeholder="${key}">`;
                    }
                }
            });
    });
</script>
