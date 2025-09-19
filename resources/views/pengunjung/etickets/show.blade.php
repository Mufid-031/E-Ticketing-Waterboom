<x-app-layout>
    <!-- E-Ticket Content -->
    <section class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- E-Ticket Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                <!-- Ticket Header -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <h1 class="text-2xl font-bold">Grand Waterboom Maros</h1>
                            <p class="text-blue-100">E-Tiket Digital</p>
                        </div>
                    </div>
                </div>

                <!-- Ticket Body -->
                <div class="p-8">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- QR Code Section -->
                        <div class="text-center">
                            <div class="bg-white border-4 border-gray-200 rounded-2xl p-6 inline-block shadow-lg">
                                {!! $qrCode !!}
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mt-4 mb-2">Scan QR Code</h3>
                            <p class="text-gray-600 text-sm">
                                Tunjukkan QR code ini ke petugas untuk masuk
                            </p>

                            <!-- Status Badge -->

                            <div class="mt-4">
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                                    {{ $eTicket->status === 'active' ? 'bg-green-100 text-green-800' : ($eTicket->status === 'used' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                                    @if ($eTicket->status === 'active')
                                        <i class="fas fa-check-circle mr-1"></i>Aktif
                                    @elseif($eTicket->status === 'used')
                                        <i class="fas fa-times-circle mr-1"></i>Sudah Digunakan
                                    @else
                                        <i class="fas fa-ban mr-1"></i>Tidak Aktif
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Ticket Details -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Detail Tiket</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Nomor Transaksi</span>
                                        <span
                                            class="font-semibold text-gray-900">#{{ str_pad($eTicket->transaction->id, 6, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    @if (isset($ticketDetails['verification_code']))
                                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                            <span class="text-gray-600">Kode Verifikasi</span>
                                            <span
                                                class="font-semibold text-purple-600 font-mono">{{ $ticketDetails['verification_code'] ?? 'N/A' }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Pemegang Tiket</span>
                                        <span
                                            class="font-semibold text-gray-900">{{ $eTicket->transaction->user->name }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Tanggal Pembelian</span>
                                        <span
                                            class="font-semibold text-gray-900">{{ $eTicket->transaction->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    @if (isset($ticketDetails['ticket_name']))
                                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                            <span class="text-gray-600">Jenis Tiket</span>
                                            <span
                                                class="font-semibold text-blue-600">{{ $ticketDetails['ticket_name'] }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Total Pembayaran</span>
                                        <span class="font-semibold text-green-600">Rp
                                            {{ number_format($eTicket->transaction->total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Metode Pembayaran</span>
                                        <span class="font-semibold">
                                            @if ($eTicket->transaction->payment_method === 'cash')
                                                <i class="fas fa-money-bill text-green-600 mr-1"></i>
                                                <span class="text-green-600">Tunai</span>
                                            @else
                                                <i class="fas fa-credit-card text-purple-600 mr-1"></i>
                                                <span class="text-purple-600">Midtrans</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Status Pembayaran</span>
                                        <span class="font-semibold">
                                            @if ($eTicket->transaction->status === 'pending')
                                                <span class="text-orange-600">
                                                    <i class="fas fa-hourglass-half mr-1"></i>Menunggu Pembayaran
                                                </span>
                                            @elseif($eTicket->transaction->status === 'paid')
                                                <span class="text-green-600">
                                                    <i class="fas fa-check-circle mr-1"></i>Lunas
                                                </span>
                                            @elseif($eTicket->transaction->status === 'confirmed')
                                                <span class="text-blue-600">
                                                    <i class="fas fa-check-double mr-1"></i>Terkonfirmasi
                                                </span>
                                            @else
                                                <span class="text-gray-600">
                                                    <i
                                                        class="fas fa-times-circle mr-1"></i>{{ ucfirst($eTicket->transaction->status) }}
                                                </span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Ticket Items -->
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-3">Paket Tiket:</h4>
                                <div class="space-y-2">
                                    @foreach ($eTicket->transaction->transactionDetails as $detail)
                                        <div class="bg-gray-50 rounded-xl p-4">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $detail->ticket->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-600">{{ $detail->quantity }}x tiket
                                                    </div>
                                                </div>
                                                <div class="text-sm">
                                                    <span
                                                        class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                                        {{ ucfirst($detail->ticket->type) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Instructions for Cash -->
                @if ($eTicket->transaction->payment_method === 'cash' && $eTicket->transaction->status === 'pending')
                    <div class="bg-orange-50 border-t border-orange-200 px-8 py-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-money-bill text-orange-600 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-orange-900 mb-2">Instruksi Pembayaran Tunai</h4>
                                <ul class="text-sm text-orange-800 space-y-1">
                                    <li>• Tunjukkan e-tiket ini ke petugas loket waterboom</li>
                                    <li>• Lakukan pembayaran tunai sebesar <strong>Rp
                                            {{ number_format($eTicket->transaction->total, 0, ',', '.') }}</strong>
                                    </li>
                                    <li>• Petugas akan melakukan scan QR code untuk konfirmasi pembayaran</li>
                                    <li>• Setelah scan, status pembayaran otomatis berubah menjadi "Lunas"</li>
                                    <li>• Anda bisa langsung masuk waterboom setelah pembayaran dikonfirmasi</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Ticket Footer -->
                <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                        <div class="text-center sm:text-left">
                            <div class="text-sm text-gray-600">Customer Service</div>
                            <div class="font-semibold text-gray-900">
                                <i class="fas fa-phone mr-1"></i>
                                0411-123456
                            </div>
                        </div>
                        <div class="text-center sm:text-right">
                            <div class="text-sm text-gray-600">Website</div>
                            <div class="font-semibold text-gray-900">
                                <i class="fas fa-globe mr-1"></i>
                                www.grandwaterboommaros.com
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
