<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - FootFlare Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.products.index') }}">FOOTFLARE <span class="text-warning">ADMIN</span></a>
        </div>
    </nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Daftar Produk FootFlare</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-dark fw-semibold">+ Tambah Produk Baru</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Gambar</th>
                            <th>Nama Produk</th>
                            <th>Brand</th>
                            <th>Kategori</th>
                            <th>Harga Asli</th>
                            <th>Diskon</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="ps-4">
                                    @if($product->thumbnail_url_full)
                                        <img src="{{ $product->thumbnail_url_full }}" 
                                             alt="{{ $product->name }}" 
                                             class="rounded border"
                                             style="width: 60px; height: 60px; object-fit: contain; background-color: #f8f9fa;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td class="fw-semibold text-dark">{{ $product->name }}</td>
                                
                                <td><span class="badge bg-secondary px-2.5 py-1.5">{{ $product->brand->name ?? 'No Brand' }}</span></td>
                                
                                <td><span class="badge bg-info text-dark px-2.5 py-1.5">{{ $product->category->name ?? 'No Category' }}</span></td>
                                
                                <td class="fw-medium">${{ number_format($product->price, 2) }}</td>
                                <td>
                                    @if($product->discount_percentage > 0)
                                        <span class="text-danger fw-bold">{{ $product->discount_percentage }}% OFF</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-muted" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $product->description ?? 'Tidak ada deskripsi.' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <p class="mb-0 fw-medium">Belum ada produk terdaftar di database.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>