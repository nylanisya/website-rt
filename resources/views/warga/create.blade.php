<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Warga Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('warga.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Pilih KK -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Kartu Keluarga (KK) *</label>
                                <select name="keluarga_id" class="w-full border rounded px-3 py-2 @error('keluarga_id') border-red-500 @enderror" required>
                                    <option value="">-- Pilih KK --</option>
                                    @foreach($keluargas as $keluarga)
                                        <option value="{{ $keluarga->id }}" {{ old('keluarga_id') == $keluarga->id ? 'selected' : '' }}>
                                            {{ $keluarga->no_kk }} - {{ $keluarga->kepala_keluarga }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('keluarga_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIK -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">NIK *</label>
                                <input type="text" name="nik" value="{{ old('nik') }}" class="w-full border rounded px-3 py-2 @error('nik') border-red-500 @enderror" required>
                                @error('nik')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap *</label>
                                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border rounded px-3 py-2 @error('nama') border-red-500 @enderror" required>
                                @error('nama')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin *</label>
                                <select name="jenis_kelamin" class="w-full border rounded px-3 py-2 @error('jenis_kelamin') border-red-500 @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tempat Lahir -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tempat Lahir *</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full border rounded px-3 py-2 @error('tempat_lahir') border-red-500 @enderror" required>
                                @error('tempat_lahir')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Lahir *</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border rounded px-3 py-2 @error('tanggal_lahir') border-red-500 @enderror" required>
                                @error('tanggal_lahir')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status dalam Keluarga -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Status dalam Keluarga *</label>
                                <select name="status_dalam_keluarga" class="w-full border rounded px-3 py-2 @error('status_dalam_keluarga') border-red-500 @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Kepala Keluarga" {{ old('status_dalam_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                                    <option value="Istri" {{ old('status_dalam_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                                    <option value="Anak" {{ old('status_dalam_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                                    <option value="Lainnya" {{ old('status_dalam_keluarga') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('status_dalam_keluarga')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pendidikan -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Pendidikan *</label>
                                <select name="pendidikan" class="w-full border rounded px-3 py-2 @error('pendidikan') border-red-500 @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Tidak Sekolah" {{ old('pendidikan') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                    <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    <option value="D3" {{ old('pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                                @error('pendidikan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pekerjaan -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Pekerjaan</label>
                                <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" class="w-full border rounded px-3 py-2">
                                @error('pekerjaan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex gap-2 mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                            <a href="{{ route('warga.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>