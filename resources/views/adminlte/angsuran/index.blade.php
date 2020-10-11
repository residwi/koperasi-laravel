@extends('adminlte.layouts.app')

@section('title', 'Angsuran')

{{-- Custom CSS --}}
@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Info Angsuran Anggota</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                    <div class="info-box-content">
                        <span class="info-box-text text-center text-muted">Total Pinjaman x 35%</span>
                        <span
                            class="info-box-number text-center text-muted mb-0">{{ 'Rp. ' . number_format($pinjaman->jumlah_pengajuan ?? 0) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                    <div class="info-box-content">
                        <span class="info-box-text text-center text-muted">Angsuran per bulan</span>
                        <span
                            class="info-box-number text-center text-muted mb-0">{{ 'Rp. ' . number_format($pinjaman->angsuran_yang_disanggupi ?? 0) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                    <div class="info-box-content">
                        <span class="info-box-text text-center text-muted">Sisa Pinjaman</span>
                        <span
                            class="info-box-number text-center text-muted mb-0">{{ 'Rp. ' . number_format($sisa_pinjaman ?? $pinjaman->angsuran_yang_disanggupi) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">History Angsuran Anggota</h3>
        @if (auth()->user()->is_admin)
        <a class="btn btn-info float-right" href="{{ route('pinjaman.angsuran.create', $pinjaman->id) }}">Bayar Angsuran</a>
        @endif
    </div>
    <div class="card-body">
        <table id="angsuran-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th> Tanggal </th>
                    <th> Nama </th>
                    <th> Total Pinjaman </th>
                    <th> Angsuran per bulan </th>
                    <th> Sisa Pinjaman </th>
                    {{-- <th class="text-center"> Actions </th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($pinjaman->angsuran as $item)
                <tr>
                    <td>{{ Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('LL') }}</td>
                    <td>{{ $item->pinjaman->anggota->user->name }}</td>
                    <td>{{ 'Rp. ' . number_format($item->pinjaman->jumlah_pengajuan += $item->pinjaman->jumlah_pengajuan * 0.35 ) }}</td>
                    <td>{{ 'Rp. ' . number_format($item->pinjaman->angsuran_yang_disanggupi) }}</td>
                    <td>{{ 'Rp. ' . number_format($item->sisa_pinjaman) }}</td>
                    {{-- <td class="text-center">
                        <a class="btn btn-success btn-sm" href="{{ route('pinjaman.edit', $item->id) }}"
                            data-toggle="tooltip" title="Edit">
                            <i class="fas fa-pencil-alt"> </i>
                        </a>
                    </td> --}}
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
      $("#angsuran-table").DataTable({
        @if (auth()->user()->is_admin)
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
        ],
        @endif
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            { "width": "10%", "targets": -1 }
        ]
      });

      $('[data-toggle="tooltip"]').tooltip()

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