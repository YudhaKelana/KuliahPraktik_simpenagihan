<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Pajak Kendaraan</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f6f9; padding: 20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    {{-- Header --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e40af, #3b82f6); padding: 28px 32px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 20px; font-weight: 700; letter-spacing: 0.5px;">
                                UPTD PPD SAMSAT
                            </h1>
                            <p style="color: #bfdbfe; margin: 4px 0 0; font-size: 12px; text-transform: uppercase; letter-spacing: 2px;">
                                Kota Tanjungpinang — Seksi Penagihan
                            </p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 32px;">
                            <p style="color: #374151; font-size: 15px; line-height: 1.6; margin: 0 0 16px;">
                                Yth. <strong>{{ $taxpayerName }}</strong>,
                            </p>

                            <p style="color: #374151; font-size: 15px; line-height: 1.6; margin: 0 0 20px;">
                                Dengan hormat, kami sampaikan bahwa kendaraan bermotor Anda memiliki kewajiban pajak yang perlu segera diselesaikan. Berikut informasi kendaraan Anda:
                            </p>

                            {{-- Vehicle Info Card --}}
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f0f9ff; border: 1px solid #bfdbfe; border-radius: 8px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="padding: 6px 0; color: #6b7280; font-size: 13px; width: 140px;">Nomor Polisi</td>
                                                <td style="padding: 6px 0; color: #111827; font-size: 15px; font-weight: 700;">{{ $plateNumber }}</td>
                                            </tr>
                                            @if($vehicleType)
                                            <tr>
                                                <td style="padding: 6px 0; color: #6b7280; font-size: 13px;">Jenis Kendaraan</td>
                                                <td style="padding: 6px 0; color: #111827; font-size: 14px;">{{ $vehicleType }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td style="padding: 6px 0; color: #6b7280; font-size: 13px;">Jatuh Tempo</td>
                                                <td style="padding: 6px 0; color: #dc2626; font-size: 14px; font-weight: 600;">{{ $dueDate }}</td>
                                            </tr>
                                            @if($arrearAmount > 0)
                                            <tr>
                                                <td style="padding: 6px 0; color: #6b7280; font-size: 13px;">Estimasi Tunggakan</td>
                                                <td style="padding: 6px 0; color: #111827; font-size: 15px; font-weight: 700;">Rp {{ number_format($arrearAmount, 0, ',', '.') }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="color: #374151; font-size: 15px; line-height: 1.6; margin: 0 0 20px;">
                                Kami mengimbau Anda untuk segera melakukan pembayaran pajak kendaraan bermotor di <strong>kantor Samsat terdekat</strong> atau melalui layanan pembayaran online yang tersedia.
                            </p>

                            {{-- CTA Button --}}
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 24px;">
                                <tr>
                                    <td align="center">
                                        <table role="presentation" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="background: linear-gradient(135deg, #1e40af, #2563eb); border-radius: 8px; text-align: center;">
                                                    <a href="https://samsat.id" target="_blank" style="display: inline-block; padding: 14px 32px; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 600; letter-spacing: 0.3px;">
                                                        Informasi Pembayaran →
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="color: #6b7280; font-size: 13px; line-height: 1.6; margin: 0; padding: 16px 0 0; border-top: 1px solid #e5e7eb;">
                                <strong>Catatan:</strong> Apabila Anda sudah melakukan pembayaran, harap mengabaikan email ini. Terima kasih atas kesadaran dan kepatuhan Anda dalam memenuhi kewajiban pajak.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color: #1e293b; padding: 20px 32px; text-align: center;">
                            <p style="color: #94a3b8; font-size: 11px; margin: 0 0 4px; line-height: 1.5;">
                                UPTD PPD Samsat Kota Tanjungpinang — Seksi Penagihan
                            </p>
                            <p style="color: #64748b; font-size: 10px; margin: 0; line-height: 1.5;">
                                Email ini dikirim secara otomatis oleh sistem. Jika tidak ingin menerima email ini,
                                silakan hubungi kantor Samsat setempat.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
