PENGINGAT PAJAK KENDARAAN BERMOTOR
====================================

Yth. {{ $taxpayerName }},

Dengan hormat, kami sampaikan bahwa kendaraan bermotor Anda memiliki kewajiban pajak yang perlu segera diselesaikan.

Informasi Kendaraan:
- Nomor Polisi   : {{ $plateNumber }}
@if($vehicleType)
- Jenis Kendaraan: {{ $vehicleType }}
@endif
- Jatuh Tempo    : {{ $dueDate }}
@if($arrearAmount > 0)
- Est. Tunggakan : Rp {{ number_format($arrearAmount, 0, ',', '.') }}
@endif

Kami mengimbau Anda untuk segera melakukan pembayaran pajak kendaraan bermotor di kantor Samsat terdekat atau melalui layanan pembayaran online yang tersedia.

Catatan: Apabila Anda sudah melakukan pembayaran, harap mengabaikan email ini.

Terima kasih atas kesadaran dan kepatuhan Anda dalam memenuhi kewajiban pajak.

---
UPTD PPD Samsat Kota Tanjungpinang — Seksi Penagihan
Email ini dikirim secara otomatis oleh sistem.
