@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.buses.index') }}" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold">Tambah Armada Baru</h1>
            <p class="text-slate-400">Daftarkan bus/minibus baru ke sistem</p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.buses.store') }}" method="POST" enctype="multipart/form-data" class="max-w-3xl">
        @csrf

        <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden">
            
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-sky-500/10 to-indigo-500/10 border-b border-white/10 px-6 py-4">
                <h3 class="font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    Informasi Armada
                </h3>
            </div>

            <!-- Form Body -->
            <div class="p-6 space-y-6">

                <!-- Nama Armada -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-2">
                        Nama Armada <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required
                           placeholder="Contoh: Bus Eksekutif A1"
                           class="w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50 focus:ring-2 focus:ring-sky-500/20 transition-all">
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Plat Nomor -->
                <div>
                    <label for="plate_number" class="block text-sm font-medium text-slate-300 mb-2">
                        Plat Nomor <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           id="plate_number" 
                           name="plate_number" 
                           value="{{ old('plate_number') }}" 
                           required
                           placeholder="Contoh: B 1234 ABC"
                           class="w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50 focus:ring-2 focus:ring-sky-500/20 transition-all font-mono uppercase">
                    @error('plate_number')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kapasitas -->
                <div>
                    <label for="capacity" class="block text-sm font-medium text-slate-300 mb-2">
                        Kapasitas Kursi <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                               id="capacity" 
                               name="capacity" 
                               value="{{ old('capacity', 12) }}" 
                               required
                               min="1"
                               max="50"
                               placeholder="12"
                               class="w-full px-4 py-3 pr-16 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50 focus:ring-2 focus:ring-sky-500/20 transition-all">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">kursi</span>
                    </div>
                    @error('capacity')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fasilitas -->
                <div>
                    <label for="facilities" class="block text-sm font-medium text-slate-300 mb-2">
                        Fasilitas
                    </label>
                    <input type="text" 
                           id="facilities" 
                           name="facilities" 
                           value="{{ old('facilities') }}" 
                           placeholder="AC, WiFi, USB Charger, Reclining Seat (pisahkan dengan koma)"
                           class="w-full px-4 py-3 rounded-xl bg-navy-900/50 border border-white/10 text-white placeholder-slate-500 focus:outline-none focus:border-sky-500/50 focus:ring-2 focus:ring-sky-500/20 transition-all">
                    <p class="text-xs text-slate-500 mt-1">Pisahkan setiap fasilitas dengan tanda koma</p>
                    @error('facilities')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar -->
                <div>
                    <label for="image" class="block text-sm font-medium text-slate-300 mb-2">
                        Gambar Armada
                    </label>
                    <div id="imageDropZone" class="relative border-2 border-dashed border-white/20 hover:border-sky-500/50 rounded-xl p-6 text-center transition-all cursor-pointer">
                        <input type="file" 
                               id="image" 
                               name="image" 
                               accept="image/jpeg,image/png,image/jpg"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        
                        <div id="imagePlaceholder">
                            <div class="w-14 h-14 rounded-xl bg-sky-500/20 border border-sky-500/30 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium mb-1">Klik untuk upload gambar</p>
                            <p class="text-xs text-slate-500">JPG, JPEG, PNG (Max. 2MB)</p>
                        </div>

                        <div id="imagePreviewContainer" class="hidden">
                            <img id="imagePreview" src="" alt="Preview" class="max-h-40 rounded-xl mx-auto">
                            <p id="imageFileName" class="text-sm text-slate-400 mt-2"></p>
                        </div>
                    </div>
                    @error('image')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-3">
                        Status <span class="text-red-400">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="active" class="peer sr-only" {{ old('status', 'active') === 'active' ? 'checked' : '' }} required>
                            <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-emerald-500 peer-checked:bg-emerald-500/10 hover:border-white/20 transition-all text-center">
                                <div class="w-10 h-10 rounded-lg bg-emerald-500/20 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-sm">Aktif</p>
                                <p class="text-xs text-slate-500">Siap beroperasi</p>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="maintenance" class="peer sr-only" {{ old('status') === 'maintenance' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-amber-500 peer-checked:bg-amber-500/10 hover:border-white/20 transition-all text-center">
                                <div class="w-10 h-10 rounded-lg bg-amber-500/20 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-sm">Maintenance</p>
                                <p class="text-xs text-slate-500">Sedang perbaikan</p>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="status" value="inactive" class="peer sr-only" {{ old('status') === 'inactive' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl bg-navy-900/50 border-2 border-white/10 peer-checked:border-slate-500 peer-checked:bg-slate-500/10 hover:border-white/20 transition-all text-center">
                                <div class="w-10 h-10 rounded-lg bg-slate-500/20 flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-sm">Nonaktif</p>
                                <p class="text-xs text-slate-500">Tidak beroperasi</p>
                            </div>
                        </label>
                    </div>
                    @error('status')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Form Footer -->
            <div class="bg-white/5 border-t border-white/10 px-6 py-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.buses.index') }}" class="px-6 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 font-medium transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-indigo-500 hover:from-sky-400 hover:to-indigo-400 text-white font-semibold shadow-lg shadow-sky-500/25 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Armada
                </button>
            </div>
        </div>
    </form>

</div>

@push('scripts')
<script>
    // Image Preview
    const imageInput = document.getElementById('image');
    const imagePlaceholder = document.getElementById('imagePlaceholder');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const imageFileName = document.getElementById('imageFileName');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imageFileName.textContent = file.name;
                imagePlaceholder.classList.add('hidden');
                imagePreviewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    // Uppercase plate number
    document.getElementById('plate_number').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase();
    });
</script>
@endpush
@endsection