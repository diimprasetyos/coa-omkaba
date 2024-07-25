<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Hasil Cek Parameter Logam dan Mikrobiologi</title>
</head>
<body>
    <div class="container mt-5">
    <p>Tanggal Pengujian: {{ $currentDate }}</p>
        @if($is_passed)
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                Lolos hasil uji.
            </div>
        @else
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-x-circle-fill me-2"></i>
                Tidak lolos hasil uji.
            </div>
        @endif

        <ul class="list-group mb-3">
            @foreach($messages as $message)
                <li class="list-group-item">{{ $message }}</li>
            @endforeach
        </ul>

        <h3>Data Ambang Batas Acuan untuk produk : {{ $request->nama_produk }}</h3>

        <div class="mb-4">
            <h4>Ambang Batas Maksimal Logam</h4>
            <ul class="list-group">
                @foreach($data_acuan['Logam'] as $logam => $value)
                    <li class="list-group-item">
                        {{ $logam }}: {{ $value }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mb-4">
            <h4>Ambang Batas Maksimal Mikrobiologi</h4>
            <ul class="list-group">
                @foreach($data_acuan['Mikrobiologi'] as $mikrobiologi => $value)
                    <li class="list-group-item">
                        {{ $mikrobiologi }}: {{ $value }}
                    </li>
                @endforeach
            </ul>
        </div>

        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
