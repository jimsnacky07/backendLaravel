@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Kamar</h2>
    <a href="{{ route('kamar.create') }}" class="btn btn-primary mb-3">Tambah Kamar</a>
    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle" style="font-size: 0.95rem; min-width: 900px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Lantai</th>
                    <th>Kapasitas</th>
                    <th>Fasilitas</th>
                    <th>Tarif</th>
                    <th>Maks. Penghuni</th>
                    <th>Status</th>
                    <th>Jumlah Penghuni</th>
                    <th>Slot Tersedia</th>
                    <th>Daftar Penghuni</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kamars as $kamar)
                <tr>
                    <td>{{ $kamar->id }}</td>
                    <td>{{ $kamar->lantai }}</td>
                    <td>{{ $kamar->kapasitas }}</td>
                    <td style="max-width:120px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $kamar->fasilitas }}</td>
                    <td>
                        {{ $kamar->getFormattedTarif() }}
                        <br>
                        <small>Per Penghuni: Rp {{ number_format($kamar->tarif_per_penghuni, 0, ',', '.') }}</small>
                    </td>
                    <td>{{ $kamar->max_penghuni }}</td>
                    <td>{{ $kamar->getOccupancyStatus() }}</td>
                    <td>{{ $kamar->getCurrentOccupantsCount() }}</td>
                    <td>{{ $kamar->getAvailableSlots() }}</td>
                    <td style="max-width:120px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        @foreach($kamar->penghuni as $p)
                        {{ $p->nama }}<br>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('kamar.edit', $kamar->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('kamar.destroy', $kamar->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus kamar?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $kamars->links() }}
</div>
@endsection