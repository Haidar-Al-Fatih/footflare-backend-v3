<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FootFlare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table img { border-radius: 8px; object-fit: cover; background-color: #f1f1f1; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">FOOTFLARE <span class="text-warning">ADMIN</span></a>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm p-4" style="border-radius: 12px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="m-0 fw-bold text-dark">Daftar Inventaris Produk Sepatu</h4>
                <a href="{{ route('admin.products.create') }}" class="btn btn-dark px-4" style="border-radius: 8px;">+ Tambah Produk Baru</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Brand ID</th>
                            <th>Category ID</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <!-- Menampilkan asset gambar dinamis dari kolom thumbnail_url database -->
                                    <img src="{{ asset($product->thumbnail_url) }}" alt="sepatu" width="55" height="55">
                                </td>
                                <td class="fw-semibold text-dark">{{ $product->name }}</td>
                                <td><span class="badge bg-secondary">ID: {{ $product->brand_id }}</span></td>
                                <td><span class="badge bg-light text-dark border">ID: {{ $product->category_id }}</span></td>
                                <td class="fw-bold text-dark">${{ $product->price }}</td>
                                <td>
                                    <!-- Logika penampil tag diskon -->
                                    @if($product->discount_percentage > 0)
                                        <span class="badge bg-danger">{{ $product->discount_percentage }}% OFF</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-muted" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $product->description }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada produk terdaftar dalam database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>