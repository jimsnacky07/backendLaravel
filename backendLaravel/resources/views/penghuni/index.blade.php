@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Penghuni</h2>
    <a href="{{ route('penghuni.create') }}" class="btn btn-primary mb-3">Tambah Penghuni</a>
    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle" style="font-size: 0.95rem; min-width: 900px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Registrasi</th>
                    <th>Kamar</th>
                    <th>Status Kamar</th>
                    <th>Roommate</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penghunis as $penghuni)
                <tr>
                    <td>{{ $penghuni->id }}</td>
                    <td>{{ $penghuni->nama }}</td>
                    <td style="max-width:120px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $penghuni->alamat }}</td>
                    <td>{{ $penghuni->nohp }}</td>
                    <td>{{ $penghuni->getFormattedRegistrasi() }}</td>
                    <td>
                        @if(is_object($penghuni->kamar))
                        {{ $penghuni->kamar->id }}
                        @elseif($penghuni->kamar)
                        {{ $penghuni->kamar }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(is_object($penghuni->kamar))
                        {{ $penghuni->kamar->getOccupancyStatus() }}
                        @else
                        -
                        @endif
                    </td>
                    <td style="max-width:120px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        @if($penghuni->hasRoommates())
                        @foreach($penghuni->getRoommates() as $roommate)
                        {{ $roommate->nama }}<br>
                        @endforeach
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('penghuni.edit', $penghuni->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('penghuni.destroy', $penghuni->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus penghuni?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $penghunis->links() }}
</div>
@endsection