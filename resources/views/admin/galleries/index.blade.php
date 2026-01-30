@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Galeri Foto</h1>
            <p class="text-gray-500">Kelola foto portofolio dan background landing page.</p>
        </div>
        <a href="{{ route('admin.galleries.create') }}" class="bg-black text-white hover:bg-gray-800 font-bold py-2 px-4 rounded-lg transition">
            + Tambah Foto
        </a>
    </div>

    <!-- Masonry Layout using CSS Columns -->
    <div class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4" x-data="{ 
        showModal: false, 
        activePhoto: null,
        toggleFeatured(id) {
            fetch(`/admin/galleries/${id}/toggle-featured`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    this.activePhoto.is_featured = data.is_featured;
                    // Update DOM element directly if needed or reload page
                    // For simplicity, we just toggle the state in activePhoto which updates the modal
                    // To update the list view, we might need a page reload or more complex state management
                    // But changing the class on the grid item is tricky without a full list re-render.
                    // Let's just update the modal button state visually.
                    
                    // Optional: Find the grid item and update its badge
                    const gridItem = document.getElementById(`gallery-item-${id}`);
                    const badge = gridItem.querySelector('.featured-badge');
                    if (data.is_featured) {
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }
            });
        }
    }">
        @forelse($galleries as $gallery)
            <div id="gallery-item-{{ $gallery->id }}" class="break-inside-avoid bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group relative mb-4">
                
                <!-- Main Click Trigger -->
                <div class="cursor-pointer" @click="showModal = true; activePhoto = {{ $gallery->toJson() }}">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" class="w-full h-auto object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                </div>
                
                <!-- Overlay Actions (Visible on Hover) -->
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none flex flex-col justify-between p-3">
                    
                    <!-- Top Bar: Badge & Actions -->
                    <div class="flex justify-between items-start pointer-events-auto">
                        <!-- Featured Badge -->
                        @if($gallery->is_featured)
                            <span class="bg-yellow-400 text-black text-[10px] font-bold px-2 py-1 rounded shadow-sm flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                Featured
                            </span>
                        @else
                            <span></span> <!-- Spacer -->
                        @endif

                        <!-- Delete Button -->
                        <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-white/20 hover:bg-red-500 text-white p-1.5 rounded-lg backdrop-blur-sm transition" title="Hapus Foto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>

                    <!-- Bottom Bar: Info (Clickable) -->
                    <div class="pointer-events-auto cursor-pointer" @click="showModal = true; activePhoto = {{ $gallery->toJson() }}">
                        <p class="text-white text-sm font-bold truncate drop-shadow-md">{{ $gallery->title ?? 'Tanpa Judul' }}</p>
                        <p class="text-white/80 text-[10px] uppercase tracking-wider font-medium">{{ $gallery->business_unit }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-xl border border-dashed border-gray-300">
                Belum ada foto di galeri.
            </div>
        @endforelse

        <!-- Modal -->
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-sm" style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="relative max-w-5xl w-full h-full md:h-auto flex flex-col md:flex-row bg-white rounded-2xl overflow-hidden shadow-2xl" @click.away="showModal = false">
                
                <!-- Image Container -->
                <div class="w-full md:w-2/3 bg-black flex items-center justify-center relative group">
                    <img :src="activePhoto ? '{{ asset('storage') }}/' + activePhoto.image_path : ''" class="max-w-full max-h-[80vh] object-contain">
                    <button @click="showModal = false" class="absolute top-4 left-4 text-white hover:text-gray-300 bg-black/50 rounded-full p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Sidebar Details -->
                <div class="w-full md:w-1/3 p-6 flex flex-col justify-between bg-white">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-1" x-text="activePhoto?.title || 'Tanpa Judul'"></h3>
                        <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded uppercase tracking-wide font-bold mb-6" x-text="activePhoto?.business_unit"></span>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 text-sm">Foto Terbaik</p>
                                        <p class="text-xs text-gray-500">Tampil di background landing page</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" :checked="activePhoto?.is_featured" @change="toggleFeatured(activePhoto.id)">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-500"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 border-t pt-6">
                        <form :action="`{{ url('admin/galleries') }}/${activePhoto?.id}`" method="POST" onsubmit="return confirm('Hapus foto ini permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-white text-red-600 border-2 border-red-100 hover:bg-red-50 hover:border-red-200 font-bold py-3 rounded-xl transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus Foto
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        {{ $galleries->links() }}
    </div>
@endsection