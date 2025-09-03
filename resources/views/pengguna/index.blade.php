@extends('layouts.app')
@section('title', 'Pengguna')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Pengguna</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class='bx bx-plus'></i> Tambah Pengguna
        </button>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    @if(session('error'))
    <div id="errorMessage" data-message="{{ session('error') }}" style="display: none;"></div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-primary me-2" 
                                            onclick='editUser({{ $user->id }}, @json($user))' 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal">
                                        <i class='bx bx-edit'></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" 
                                            onclick="deleteUser({{ $user->id }})">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pengguna.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="name" id="editName" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap" id="editNamaLengkap" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="editEmail" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" name="no_telp" id="editNoTelp">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" id="editAlamat" rows="3"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Hak Akses</label>
                        <select class="form-select" name="id_priv" id="editPriv" required>
                            <option value="">Pilih Hak Akses</option>
                            @foreach($priv as $p)
                                <option value="{{ $p->id_priv }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Foto</label>
                        <input type="file" class="form-control" name="foto" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus user ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function showSuccessNotification(message) {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: message,
        timer: 3000,
        showConfirmButton: false
    });
}

function showErrorNotification(message) {
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: message,
        timer: 3000,
        showConfirmButton: false
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');

    if (successMessage) {
        showSuccessNotification(successMessage.dataset.message);
    }

    if (errorMessage) {
        showErrorNotification(errorMessage.dataset.message);
    }
});

function editUser(id, data) {
    // console.log('Data from server:', data); // Debug data yang diterima
    
    const editForm = document.getElementById('editForm');
    editForm.action = `/gmp/pengguna/${id}`;
    
    // Isi form dengan data user
    document.getElementById('editName').value = data.name;
    document.getElementById('editNamaLengkap').value = data.nama_lengkap;
    document.getElementById('editEmail').value = data.email;
    document.getElementById('editNoTelp').value = data.no_telp;
    document.getElementById('editAlamat').value = data.alamat;
    
    // Set selected option untuk priv
    const privSelect = document.getElementById('editPriv');
    // console.log('Current priv value:', data.id_priv); // Debug nilai id_priv
    
    // Cara 1: Set selected menggunakan selectedIndex
    Array.from(privSelect.options).forEach((option, index) => {
        if (option.value == data.id_priv) {
            privSelect.selectedIndex = index;
            // console.log('Selected index:', index); // Debug index yang dipilih
        }
    });
    
    // Cara 2: Set selected attribute
    privSelect.querySelector(`option[value="${data.id_priv}"]`).selected = true;
    
    // Cara 3: Trigger change event
    privSelect.value = data.id_priv;
    privSelect.dispatchEvent(new Event('change'));
}

function deleteUser(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/gmp/user/${id}`;
            deleteForm.submit();
        }
    });
}
</script>

<style>
    /* Table styles */
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: var(--text-color) !important;
        vertical-align: top;
        border-color: var(--border-color) !important;
    }

    .table > :not(caption) > * > * {
        background-color: var(--card-bg) !important;
        color: var(--text-color) !important;
        padding: 0.75rem;
    }

    .table-bordered > :not(caption) > * {
        border-width: 1px 0;
    }

    .table-bordered > :not(caption) > * > * {
        border-width: 0 1px;
        border-color: var(--border-color) !important;
    }

    .table > thead th {
        color: var(--primary-color) !important;
        font-weight: 600 !important;
        background-color: var(--card-bg) !important;
        border-bottom: 2px solid var(--border-color) !important;
        white-space: nowrap;
    }

    .table tbody tr:nth-of-type(odd) > * {
        background-color: var(--card-bg) !important;
    }

    .table tbody tr:nth-of-type(even) > * {
        background-color: var(--background-color) !important;
    }

    .table tbody tr:hover > * {
        background-color: var(--background-color) !important;
        color: var(--text-color) !important;
    }

    /* Action buttons */
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.2rem;
    }

    .btn-sm i {
        font-size: 1rem;
    }
</style>
@endsection 