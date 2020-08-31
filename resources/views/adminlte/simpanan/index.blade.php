@extends('adminlte.layouts.app')

@section('title', 'Simpanan')

{{-- Custom CSS --}}
@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endpush

@section('content')
@if (auth()->user()->is_admin === FALSE)
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Info Simpanan Anggota</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                    <div class="info-box-content">
                        <span class="info-box-text text-center text-muted">Bunga Simpanan</span>
                        <span class="info-box-number text-center text-muted mb-0">{{ $bunga }}%</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                    <div class="info-box-content">
                        <span class="info-box-text text-center text-muted">Total Simpanan</span>
                        <span class="info-box-number text-center text-muted mb-0">{{ 'Rp. ' . number_format($total_simpanan ?? 0) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                    <div class="info-box-content">
                        <span class="info-box-text text-center text-muted">Total Simpanan Sukarela</span>
                        <span class="info-box-number text-center text-muted mb-0">{{ 'Rp. ' . number_format($total_simpanan_sukarela ?? 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">History Simpanan Sukarela</h3>
        @if (auth()->user()->is_admin === FALSE)
        <a class="btn btn-info float-right" href="{{ route('simpanan.create') }}">Tambah Simpanan</a>
        @endif
    </div>
    <div class="card-body">
        <table id="simpanan-table" class="table table-bordered table-hover projects">
            <thead>
                <tr>
                    <th> Tanggal </th>
                    <th> Nama </th>
                    <th> NIK </th>
                    <th> Simpanan Sukarela </th>
                    <th> Bunga </th>
                    <th> Total Simpanan Sukarela </th>
                    @if (auth()->user()->is_admin === FALSE)
                    <th class="text-center"> Actions </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($simpanan as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('LL') }}</td>
                    <td>{{ $item->anggota->user->name }}</td>
                    <td>{{ $item->anggota->nik }}</td>
                    <td>{{ 'Rp. ' . number_format($item->simpanan_sukarela) }}</td>
                    <td>{{ 'Rp. ' . number_format($item->bunga) }}</td>
                    <td>{{ 'Rp. ' . number_format($item->total_simpanan_sukarela) }}</td>
                    @if (auth()->user()->is_admin === FALSE)
                    <td td class="text-center">
                        <a class="btn btn-success btn-sm" href="{{ route('simpanan.edit', $item->id) }}" data-toggle="tooltip" title="Edit">
                            <i class="fas fa-pencil-alt"> </i>
                        </a>
                        <button class="btn btn-danger btn-sm hapus-simpanan" data-simpanan="{{ $item->id }}" data-toggle="tooltip" title="Delete">
                            <i class="fas fa-trash"> </i>
                        </button>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('js')
<!-- DataTables -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script>
    $( document ).ready(function() {
      $('[data-toggle="tooltip"]').tooltip()

      $("#simpanan-table").DataTable({
        @if (auth()->user()->is_admin)
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        @endif
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            { "width": "10%", "targets": -1 }
        ]
      });

      $('.hapus-simpanan').click(function () {
        const simpanan_id = $(this).data('simpanan');
        Swal.fire({
            title: 'Menghapus Simpanan ?',
            text: "Apakah Anda yakin akan menghapusnya ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus',
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
                return fetch(`{{ route('simpanan.index') }}/${simpanan_id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                    `Request failed: ${error}`
                    )
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                  'Terhapus!',
                  'Data simpanan berhasil dihapus',
                  'success'
                )

                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        })
      });

      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
    
      @if (session('status'))
      Toast.fire({
        icon: 'success',
        title: '{{ session('status') }}'
      })
      @endif
    });
</script>
@endpush