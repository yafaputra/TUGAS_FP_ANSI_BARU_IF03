@extends('layout.headfoot')

@section('title', 'Cari Lawan Sparring')

@section('content')
<section class="bg-gray-100 font-sans">
    <div class="hero-section bg-gradient-to-br from-green-500 to-green-600 py-16 px-5 text-center relative overflow-hidden">
        <div class="hero-content relative z-10 max-w-6xl mx-auto">
            <h1 class="hero-title text-white text-4xl font-bold mb-8 drop-shadow-md">CARI LAWAN SPARRING</h1>
        </div>
    </div>
    <div class="container mx-auto px-5 max-w-6xl">
        <div class="bg-white p-8 -mt-8 mx-5 mb-8 rounded-xl shadow-xl relative z-20">
            <form action="{{ route('sparring.search') }}" method="GET">
                <div class="flex flex-wrap gap-4 items-center">
                    <input type="text" name="search" class="flex-1 min-w-[200px] p-3 border-2 border-gray-200 rounded-lg text-sm focus:outline-none focus:border-green-500 transition-colors" placeholder="Find Sparring Opponents">
                    <input type="text" name="city" class="flex-1 min-w-[200px] p-3 border-2 border-gray-200 rounded-lg text-sm focus:outline-none focus:border-green-500 transition-colors" placeholder="Pilih kota">
                    <input type="text" name="sport" class="flex-1 min-w-[200px] p-3 border-2 border-gray-200 rounded-lg text-sm focus:outline-none focus:border-green-500 transition-colors" placeholder="Pilih Cabang Olahraga">
                    <button type="button" class="bg-gray-50 border-2 border-gray-200 p-2 rounded-lg hover:bg-gray-100 transition-colors" onclick="openFilters()">⚙️</button>
                    <button type="submit" class="bg-gradient-to-r from-green-500 to-teal-400 text-white px-8 py-3 rounded-lg font-bold cursor-pointer shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">Cari Lawan</button>
                </div>
            </form>
        </div>

        <div class="text-gray-600 text-sm my-5">
            Menampilkan <strong class="font-semibold">{{ $sparrings->count() }} sparring terbuka</strong>
        </div>

        <div class="text-gray-600 text-sm text-right mb-5">
            Urutkan berdasarkan : <strong class="font-semibold">Waktu dan Tanggal</strong>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
            @foreach($sparrings as $sparring)
            <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all border border-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r {{ $sparring->color_gradient[0] }} {{ $sparring->color_gradient[1] }} flex items-center justify-center text-white font-bold text-lg">{{ $sparring->team_initials }}</div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $sparring->team_name }}</h3>
                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs inline-block mt-1">{{ $sparring->sport_type }}</span>
                        <div class="flex items-center gap-2 mt-1 text-sm text-gray-600">
                            @if($sparring->level)
                            <span class="bg-yellow-300 text-gray-800 px-2 py-0.5 rounded text-xs font-bold">Level {{ $sparring->level }}</span>
                            @endif
                            @if($sparring->rating)
                            <span class="text-yellow-400">⭐ {{ number_format($sparring->rating, 2) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="my-4 space-y-2">
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span>📅</span>
                        <span>{{ $sparring->datetime->format('d M Y • H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span>📍</span>
                        <span>{{ $sparring->location }}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-4 mt-4 border-t border-gray-100">
                    <div class="font-semibold text-gray-800">
                        Biaya • {{ $sparring->total_cost ? 'Rp' . number_format($sparring->total_cost, 0, ',', '.') : 'TBD' }} 
                        | Dp • {{ $sparring->down_payment ? 'Rp' . number_format($sparring->down_payment, 0, ',', '.') : '0' }}
                    </div>
                    <button class="bg-gradient-to-r from-green-500 to-teal-400 text-white px-5 py-2 rounded font-bold text-sm hover:shadow-md transition-all" onclick="joinSparring({{ $sparring->id }})">Gabung</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    function joinSparring(sparringId) {
        alert('Bergabung dengan sparring ID: ' + sparringId);
        // Here you would typically make an AJAX call or redirect to a join page
    }

    function openFilters() {
        alert('Membuka filter pencarian...');
        // Implement advanced filter modal
    }
</script>
@endsection