@extends('adminlte.layouts.app')

@section('title', 'Pinjaman')

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
        <h3 class="card-title">History Pinjaman Anggota</h3>
        @if (auth()->user()->is_admin === FALSE)
        <a class="btn btn-info float-right" href="{{ route('pinjaman.create') }}">Ajukan Peminjaman</a>
        @endif
    </div>
    <div class="card-body">
        <table id="pinjaman-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th> Tanggal Pinjaman </th>
                    <th> Nama </th>
                    <th> Jenis Pinjaman </th>
                    <th> Keperluan </th>
                    <th> Jumlah Pengajuan </th>
                    <th> Angsuran per bulan </th>
                    <th class="text-center"> Status </th>
                    <th class="text-center"> Actions </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pinjaman as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('LL') }}</td>
                    <td>{{ $item->anggota->user->name }}</td>
                    <td>{{ $item->jenis_pinjaman->nama }}</td>
                    <td>{{ $item->keperluan }}</td>
                    <td>{{ 'Rp. ' . number_format($item->jumlah_pengajuan) }}</td>
                    <td>{{ 'Rp. ' . number_format($item->angsuran_yang_disanggupi) }}</td>
                    <td class="text-center">
                        @switch($item->status)
                        @case('diterima')
                        <span class="badge badge-success">Approve</span>
                        @break
                        @case('ditolak')
                        <span class="badge badge-danger">Reject</span>
                        @break
                        @default
                        <p class="badge badge-warning">Waiting</p><br>
                        @if (auth()->user()->is_admin)
                        <button class="btn btn-success btn-sm status-pinjaman" data-pinjaman="{{ $item->id }}"
                            data-status="1" data-toggle="tooltip" title="Approve">
                            <i class="fas fa-check"> </i>
                        </button>
                        <button class="btn btn-danger btn-sm status-pinjaman" data-pinjaman="{{ $item->id }}"
                            data-status="0" data-toggle="tooltip" title="Reject">
                            <i class="fas fa-times"> </i>
                        </button>
                        @endif
                        @endswitch
                    </td>
                    <td class="text-center">
                        <a class="btn btn-warning btn-sm {{ $item->status != 'diterima' ? 'disabled' : '' }}"
                            href="{{ route('pinjaman.angsuran.index', $item->id) }}" data-toggle="tooltip"
                            title="Angsuran">
                            <i class="fas fa-money-bill-wave-alt"> </i>
                        </a>
                        <a class="btn btn-info btn-sm" href="{{ route('pinjaman.show', $item->id) }}"
                            data-toggle="tooltip" title="Detail">
                            <i class="fas fa-eye"> </i>
                        </a>
                        @if (auth()->user()->is_admin === FALSE)
                        <a class="btn btn-success btn-sm" href="{{ route('pinjaman.edit', $item->id) }}"
                            data-toggle="tooltip" title="Edit">
                            <i class="fas fa-pencil-alt"> </i>
                        </a>
                        @endif
                    </td>
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
      $("#pinjaman-table").DataTable({
        @if (auth()->user()->is_admin)
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        @endif
        "columnDefs": [
            { "width": "10%", "targets": -1 }
        ]
      });

      $('[data-toggle="tooltip"]').tooltip()

      $('.status-pinjaman').click(function () {
        const pinjaman_id = $(this).data('pinjaman');
        const status = $(this).data('status');
        Swal.fire({
            title: 'Status',
            text: "Apakah Anda yakin ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
                return fetch(`api/pinjaman/status/${pinjaman_id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({status})
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
                  'Sukses!',
                  'Status berhasil diganti',
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