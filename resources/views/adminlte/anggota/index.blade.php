@extends('adminlte.layouts.app')

@section('title', 'Anggota')

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
        <h3 class="card-title">Anggota</h3>
        @if (auth()->user()->is_admin)
        <a href="{{ route('daftar-anggota') }}" class="btn btn-primary float-right">Tambah Anggota</a>
        @endif
    </div>
    <div class="card-body">
        <table id="anggota-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th> Tanggal Daftar </th>
                    <th> Nama </th>
                    <th> Tanggal Lahir </th>
                    <th> Nama Perusahaan </th>
                    <th> NIK </th>
                    <th> Tanggal NIK </th>
                    <th> Divisi </th>
                    <th> Bagian </th>
                    <th> Golongan </th>
                    <th> Upah Pokok </th>
                    <th> Tunjangan Jabatan </th>
                    <th> Gaji </th>
                    <th> Simpanan Sukarela </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($anggota as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('LL') }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->tgl_lahir }}</td>
                    <td>{{ $item->perusahaan }}</td>
                    <td>{{ $item->nik }}</td>
                    <td>{{ $item->tgl_nik }}</td>
                    <td>{{ $item->divisi }}</td>
                    <td>{{ $item->bagian }}</td>
                    <td>{{ $item->golongan }}</td>
                    <td>{{ 'Rp. ' . number_format($item->upah_pokok) }}</td>
                    <td>{{ 'Rp. ' . number_format($item->tunjangan_jabatan) }}</td>
                    <td>{{ 'Rp. ' . number_format($item->gaji) }}</td>
                    <td>{{ 'Rp. ' . number_format($item->simpanan_sukarela) }}</td>
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
      $("#anggota-table").DataTable({
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
                orientation: 'landscape',
                exportOptions: {
                    columns: ':visible'
                }
            },
        ],
        @endif
        "columnDefs": [
            { "width": "10%", "targets": -1 }
        ]
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