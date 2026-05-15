<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengumuman RT') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('pengumuman.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                        + Buat Pengumuman
                    </a>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @forelse($pengumumen as $pengumuman)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">{{ $pengumuman->judul }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Diposting oleh: {{ $pengumuman->user->name }} | 
                                        Tanggal: {{ \Carbon\Carbon::parse($pengumuman->tanggal_terbit)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('pengumuman.edit', $pengumuman) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                    <form action="{{ route('pengumuman.destroy', $pengumuman) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-3 text-gray-700">
                                {{ nl2br(e($pengumuman->isi)) }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            Belum ada pengumuman. Klik "Buat Pengumuman" untuk menambahkan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>