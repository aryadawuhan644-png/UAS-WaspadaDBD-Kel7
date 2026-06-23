<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Modern Header -->
            <div class="mb-10 px-4 sm:px-0">
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Halo, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h1>
                <p class="text-gray-400 mt-2 text-sm">Berikut adalah ringkasan WaspadaDBD hari ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 px-4 sm:px-0">
                
                @if(auth()->user()->role === 'admin')
                    <!-- Card 1 -->
                    <a href="{{ route('titik-risiko.index') }}" class="group block bg-[#171717] p-6 rounded-2xl border border-[#262626] hover:border-blue-500 hover:shadow-[0_0_20px_rgba(59,130,246,0.15)] transition-all duration-300 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-24 h-24 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        </div>
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-2">Total Titik</p>
                        <p class="text-4xl font-black text-white">{{ $total_titik }}</p>
                        <p class="text-xs text-blue-500 mt-4 flex items-center font-medium">Lihat semua data <svg class="w-3 h-3 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></p>
                    </a>

                    <!-- Card 2 -->
                    <a href="{{ route('risiko-tinggi') }}" class="group block bg-[#171717] p-6 rounded-2xl border border-[#262626] hover:border-red-500 hover:shadow-[0_0_20px_rgba(244,63,94,0.15)] transition-all duration-300 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-24 h-24 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        </div>
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-2">Risiko Tinggi</p>
                        <p class="text-4xl font-black text-red-500">{{ $risiko_tinggi }}</p>
                        <p class="text-xs text-red-500 mt-4 flex items-center font-medium">Tindak lanjuti segera <svg class="w-3 h-3 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></p>
                    </a>
                @endif

                <!-- Card 3 -->
                <a href="{{ route('pemeriksaan.index') }}" class="group block bg-[#171717] p-6 rounded-2xl border border-[#262626] hover:border-green-500 hover:shadow-[0_0_20px_rgba(16,185,129,0.15)] transition-all duration-300 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <svg class="w-24 h-24 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-2">Pemeriksaan</p>
                    <p class="text-4xl font-black text-green-500">{{ $pemeriksaan_bulan_ini }}</p>
                    <p class="text-xs text-green-500 mt-4 flex items-center font-medium">Kelola riwayat <svg class="w-3 h-3 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></p>
                </a>

                @if(auth()->user()->role === 'admin')
                    <!-- Card 4 -->
                    <a href="{{ route('petugas.index') }}" class="group block bg-[#171717] p-6 rounded-2xl border border-[#262626] hover:border-purple-500 hover:shadow-[0_0_20px_rgba(139,92,246,0.15)] transition-all duration-300 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-24 h-24 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        </div>
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-2">Admin Panel</p>
                        <p class="text-lg font-black text-white mt-1">Manajemen Petugas</p>
                        <p class="text-xs text-purple-500 mt-6 flex items-center font-medium">Kelola akun & wilayah <svg class="w-3 h-3 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></p>
                    </a>
                @endif
            </div>

            @if(auth()->user()->role === 'petugas')
                <div class="mb-12 px-4 sm:px-0">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-white tracking-tight">Tugas Pemeriksaan Anda</h3>
                        <span class="bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                            {{ count($titik_risikos) }} Tersisa
                        </span>
                    </div>

                    <div class="space-y-4">
                        @forelse($titik_risikos as $titik)
                            <div class="bg-[#171717] p-5 rounded-2xl border border-[#262626] flex justify-between items-center hover:border-gray-500 transition-colors group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-[#262626] flex items-center justify-center text-gray-400 group-hover:text-blue-500 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-3">
                                            <p class="font-bold text-white text-lg">{{ $titik->nama_titik }}</p>
                                            <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 text-xs px-2.5 py-0.5 rounded font-semibold uppercase tracking-wide">
                                                {{ $titik->jenis_risiko }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-400 mt-1">
                                            {{ $titik->alamat }} <span class="text-gray-600 mx-1">&bull;</span> <span class="font-medium">{{ $titik->rt_rw }}</span>
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('pemeriksaan.create', ['titik_id' => $titik->id]) }}" 
                                   class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-500/20">
                                    Periksa
                                </a>
                            </div>
                        @empty
                            <div class="p-8 bg-[#171717] border border-green-500/20 rounded-2xl text-center">
                                <div class="w-16 h-16 bg-green-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-white">Semua Selesai!</h3>
                                <p class="text-gray-400 mt-1">Semua titik risiko sudah diperiksa bulan ini. Kerja bagus!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Grafik Khusus Petugas -->
                <div class="px-4 sm:px-0">
                    <div class="bg-[#171717] p-8 rounded-3xl border border-[#262626]">
                        <h3 class="font-bold text-white text-xl mb-8 tracking-tight">Statistik Pemeriksaan</h3>
                        <div class="h-64">
                            <canvas id="pemeriksaanChart"></canvas>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'petugas')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endif

    @if(auth()->user()->role === 'admin')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4 mb-16 px-4 sm:px-0">
            <div class="bg-[#171717] p-8 rounded-3xl border border-[#262626]">
                <h3 class="font-bold text-white text-xl mb-8 tracking-tight">Tren Penambahan Titik Risiko</h3>
                <div class="h-64">
                    <canvas id="risikoChart"></canvas>
                </div>
            </div>
        </div>

        <script>
            const ctx = document.getElementById('risikoChart').getContext('2d');
            
            let gradientBar = ctx.createLinearGradient(0, 0, 0, 300);
            gradientBar.addColorStop(0, 'rgba(96, 165, 250, 1)'); // retina light blue
            gradientBar.addColorStop(1, 'rgba(59, 130, 246, 0.1)'); 

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labels) !!}, 
                    datasets: [{
                        label: 'Titik Risiko Baru',
                        data: {!! json_encode($dataGrafik) !!}, 
                        backgroundColor: gradientBar,
                        borderRadius: 6,
                        borderSkipped: false,
                        barThickness: 32,
                        hoverBackgroundColor: '#93c5fd'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { 
                            ticks: { color: '#a3a3a3' }, 
                            grid: { display: false } 
                        },
                        y: { 
                            beginAtZero: true, 
                            ticks: { stepSize: 1, color: '#a3a3a3' }, 
                            grid: { color: '#262626', borderDash: [4, 4] },
                            border: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#171717',
                            titleColor: '#ffffff',
                            bodyColor: '#a3a3a3',
                            borderColor: '#404040',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false,
                            cornerRadius: 8
                        }
                    }
                }
            });
        </script>
    @endif

    @if(auth()->user()->role === 'petugas')
        <script>
            const ctxPemeriksaan = document.getElementById('pemeriksaanChart').getContext('2d');
            
            let gradientLine = ctxPemeriksaan.createLinearGradient(0, 0, 0, 300);
            gradientLine.addColorStop(0, 'rgba(52, 211, 153, 0.6)'); // retina green
            gradientLine.addColorStop(1, 'rgba(16, 185, 129, 0)');

            new Chart(ctxPemeriksaan, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labelsPemeriksaan) !!}, 
                    datasets: [{
                        label: 'Pemeriksaan Selesai',
                        data: {!! json_encode($dataPemeriksaan) !!}, 
                        borderColor: '#34d399',
                        borderWidth: 3,
                        backgroundColor: gradientLine,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#171717',
                        pointBorderColor: '#34d399',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#34d399',
                        pointHoverBorderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        x: { 
                            ticks: { color: '#a3a3a3' }, 
                            grid: { display: false } 
                        },
                        y: { 
                            beginAtZero: true, 
                            ticks: { stepSize: 1, color: '#a3a3a3' }, 
                            grid: { color: '#262626', borderDash: [4, 4] },
                            border: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#171717',
                            titleColor: '#ffffff',
                            bodyColor: '#a3a3a3',
                            borderColor: '#404040',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false,
                            cornerRadius: 8
                        }
                    }
                }
            });
        </script>
    @endif
</x-app-layout>