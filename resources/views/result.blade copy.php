<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Test Results</title>
</head>
<body>
    <div class="container mt-5">
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

        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
