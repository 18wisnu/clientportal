<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Parameter Radius</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .gradient-card {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen pb-20 lg:pb-0">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 glass px-6 py-4 flex justify-between items-center shadow-sm">
        <div class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-200">
                P
            </div>
            <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">
                Parameter
            </span>
        </div>
        <div class="flex items-center space-x-4">
            <button class="p-2 rounded-full hover:bg-gray-100 relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-blue-400 to-indigo-500 border-2 border-white shadow-sm flex items-center justify-center text-white font-medium">
                JD
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-8">
        <!-- Welcome Hero -->
        <div class="gradient-card rounded-3xl p-8 mb-8 text-white relative overflow-hidden shadow-2xl shadow-blue-200 animate-fade-in">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold mb-2">Halo, John Doe! 👋</h2>
                    <p class="text-blue-100 text-lg">Paket internet Anda aktif hingga 30 Maret 2026.</p>
                </div>
                <div class="mt-6 md:mt-0 bg-white/20 backdrop-blur-md rounded-2xl p-4 px-6 border border-white/30">
                    <span class="text-sm block text-blue-100 opacity-80 uppercase tracking-wider font-semibold">Sisa Masa Aktif</span>
                    <span class="text-3xl font-bold">21 <span class="text-xl font-normal">Hari</span></span>
                </div>
            </div>
            <!-- Decorative Circles -->
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full"></div>
            <div class="absolute -left-10 -top-10 w-48 h-48 bg-white/5 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Connection Status -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow animate-fade-in" style="animation-delay: 0.1s">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-800 text-lg">Status Koneksi</h3>
                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-bold uppercase tracking-wide">Connected</span>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">SSID 2.4G</span>
                        <span class="font-semibold text-gray-700">Param_Guest</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">SSID 5G</span>
                        <span class="font-semibold text-gray-700">Param_HighSpeed</span>
                    </div>
                    <button class="w-full mt-4 py-3 bg-blue-50 text-blue-600 rounded-2xl font-semibold hover:bg-blue-100 transition-colors">
                        Pengaturan Wi-Fi
                    </button>
                </div>
            </div>

            <!-- Devices Connected -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow animate-fade-in" style="animation-delay: 0.2s">
                <h3 class="font-bold text-gray-800 text-lg mb-6">Perangkat Terhubung</h3>
                <div class="flex items-end justify-between">
                    <div>
                        <span class="text-4xl font-bold text-gray-800">08</span>
                        <span class="text-gray-400 ml-1">Devices</span>
                    </div>
                    <div class="flex -space-x-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 border-2 border-white flex items-center justify-center text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-indigo-100 border-2 border-white flex items-center justify-center text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 002-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <p class="text-sm text-gray-400 mt-4 italic">Kapasitas maksimal: 15 Perangkat</p>
            </div>

            <!-- Billing -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow animate-fade-in" style="animation-delay: 0.3s">
                <h3 class="font-bold text-gray-800 text-lg mb-6">Tagihan & Paket</h3>
                <div class="mb-4">
                    <span class="text-sm text-gray-500 block">Paket Terdaftar</span>
                    <span class="font-bold text-gray-800">Ultimate Home 50Mbps</span>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-gray-500">Biaya Bulanan</span>
                    <span class="font-bold text-blue-600">Rp 250.000</span>
                </div>
                <button class="w-full py-3 bg-blue-600 text-white rounded-2xl font-semibold shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all">
                    Bayar Sekarang
                </button>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="mt-8 bg-white rounded-3xl p-8 shadow-sm border border-gray-100 animate-fade-in" style="animation-delay: 0.4s">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-gray-800 text-xl">Riwayat Transaksi</h3>
                <a href="#" class="text-blue-600 font-semibold hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-gray-400 text-sm border-b border-gray-50">
                            <th class="pb-4 font-semibold uppercase tracking-wider">ID Transaksi</th>
                            <th class="pb-4 font-semibold uppercase tracking-wider">Tanggal</th>
                            <th class="pb-4 font-semibold uppercase tracking-wider">Tipe</th>
                            <th class="pb-4 font-semibold uppercase tracking-wider">Nominal</th>
                            <th class="pb-4 font-semibold uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 divide-y divide-gray-50">
                        <tr>
                            <td class="py-4 font-medium">#INV/2026/03/001</td>
                            <td class="py-4">01 Mar 2026</td>
                            <td class="py-4">Monthly Subscription</td>
                            <td class="py-4">Rp 250.000</td>
                            <td class="py-4"><span class="px-3 py-1 bg-green-100 text-green-600 rounded-lg text-xs font-bold">LUNAS</span></td>
                        </tr>
                        <tr>
                            <td class="py-4 font-medium">#INV/2026/02/088</td>
                            <td class="py-4">01 Feb 2026</td>
                            <td class="py-4">Monthly Subscription</td>
                            <td class="py-4">Rp 250.000</td>
                            <td class="py-4"><span class="px-3 py-1 bg-green-100 text-green-600 rounded-lg text-xs font-bold">LUNAS</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Bottom Mobile Nav -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 glass border-t border-gray-100 px-6 py-3 flex justify-between items-center z-50 rounded-t-3xl shadow-[0_-10px_20px_-5px_rgba(0,0,0,0.05)]">
        <button class="p-2 text-blue-600 flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-[10px] font-bold mt-1">Beranda</span>
        </button>
        <button class="p-2 text-gray-400 flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <span class="text-[10px] font-medium mt-1">Penggunaan</span>
        </button>
        <button class="p-2 text-gray-400 flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
            <span class="text-[10px] font-medium mt-1">Tagihan</span>
        </button>
        <button class="p-2 text-gray-400 flex flex-col items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-[10px] font-medium mt-1">Profil</span>
        </button>
    </div>
</body>
</html>
