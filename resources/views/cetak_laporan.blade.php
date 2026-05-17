<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan SITAMPAN #{{ $laporan->id }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.4; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px double #1e40af; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 22px; color: #1e40af; text-transform: uppercase; font-weight: bold; }
        .header p { margin: 2px 0; font-size: 10px; font-style: italic; color: #555; }
        
        .info-box { margin-bottom: 20px; width: 100%; border-collapse: collapse; }
        .info-box td { padding: 8px; border: 1px solid #ddd; }
        .label { background-color: #f3f4f6; font-weight: bold; width: 25%; color: #1e40af; }
        
        .section-title { background: #1e40af; color: white; padding: 5px 10px; margin-top: 20px; margin-bottom: 10px; font-weight: bold; text-transform: uppercase; border-radius: 4px; font-size: 11px; }
        
        .deskripsi-box { padding: 10px; border: 1px solid #eee; background: #fafafa; border-radius: 5px; margin-bottom: 15px; }
        
        /* Area Lampiran Foto */
        .lampiran-box { text-align: center; padding: 10px; border: 1px dashed #ccc; background: #fff; margin-bottom: 20px; border-radius: 5px; }
        .lampiran-img { max-width: 100%; max-height: 350px; border-radius: 5px; object-fit: contain; }
        
        .chat-row { margin-bottom: 15px; border-bottom: 1px dashed #eee; padding-bottom: 10px; }
        .chat-meta { font-weight: bold; margin-bottom: 5px; color: #1e40af; }
        .chat-meta span { color: #666; font-weight: normal; font-size: 10px; margin-left: 10px; }
        .chat-body { padding: 5px 0 5px 10px; border-left: 3px solid #ddd; }
        
        .footer { margin-top: 40px; width: 100%; }
        .footer-table { width: 100%; border: none; }
        .footer-table td { border: none; padding: 0; vertical-align: top; }
        .ttd-box { text-align: center; width: 300px; float: right; }
        
        .stamp { margin-top: 15px; margin-bottom: 15px; font-weight: bold; color: #1e40af; border: 2px solid #1e40af; display: inline-block; padding: 5px 15px; transform: rotate(-5deg); opacity: 0.5; text-transform: uppercase; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SITAMPAN UNTAD</h1>
        <p>Sistem Informasi Layanan Pengaduan Terpadu Mahasiswa</p>
        <p>Universitas Tadulako, Palu, Sulawesi Tengah</p>
    </div>

    <div class="section-title">Informasi Laporan</div>
    <table class="info-box">
        <tr>
            <td class="label">ID Tiket</td>
            <td><strong>#TP-{{ $laporan->id }}</strong></td>
            <td class="label">Status</td>
            <td><strong>{{ strtoupper($laporan->status) }}</strong></td>
        </tr>
        <tr>
            <td class="label">Pelapor</td>
            <td>{{ $laporan->user->name ?? 'Mahasiswa' }}</td>
            <td class="label">Tanggal</td>
            <td>{{ $laporan->created_at->format('d F Y, H:i') }} WITA</td>
        </tr>
        <tr>
            <td class="label">Kategori</td>
            <td colspan="3">{{ strtoupper($laporan->kategori) }}</td>
        </tr>
        <tr>
            <td class="label">Subjek</td>
            <td colspan="3">"{{ $laporan->subjek }}"</td>
        </tr>
    </table>

    <div class="section-title">Isi Laporan & Deskripsi</div>
    <div class="deskripsi-box">
        {{ $laporan->deskripsi }}
    </div>

    <div class="section-title">Lampiran Bukti (Foto)</div>
    <div class="lampiran-box">
        @if($laporan->lampiran)
            @php
                $imagePath = storage_path('app/public/' . $laporan->lampiran);
                if(file_exists($imagePath)) {
                    $imageData = base64_encode(file_get_contents($imagePath));
                    $imageSrc = 'data:image/' . mime_content_type($imagePath) . ';base64,' . $imageData;
                    echo '<img src="' . $imageSrc . '" class="lampiran-img" alt="Bukti Lampiran">';
                } else {
                    echo '<p style="color: red; font-style: italic;">-- File foto hilang dari server --</p>';
                }
            @endphp
        @else
            <p style="color: #999; font-style: italic;">-- Tidak ada lampiran foto yang disertakan --</p>
        @endif
    </div>

    <div class="section-title">Riwayat Penanganan Laporan</div>
    @forelse($laporan->messages as $msg)
        <div class="chat-row">
            <div class="chat-meta">
                {{ strtoupper($msg->sender) }} 
                {{ $msg->source == 'ai' ? '(AI ASSISTANT)' : '' }}
                <span>{{ $msg->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="chat-body">
                {!! nl2br(e($msg->message)) !!}
            </div>
        </div>
    @empty
        <p style="color: #999; font-style: italic;">-- Belum ada tanggapan/chat pada laporan ini --</p>
    @endforelse

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td>
                    <p style="font-size: 10px; color: #888;">*Dokumen ini sah dan dicetak otomatis oleh Sistem SITAMPAN.</p>
                </td>
                <td class="ttd-box">
                    <p>Palu, {{ date('d F Y') }}</p>
                    <div class="stamp">Printed via SITAMPAN</div>
                    
                    <p style="font-weight: bold; text-decoration: underline; margin-top: 10px;">{{ auth()->user()->name }}</p>
                    <p style="margin-top: 0; color: #555; font-weight: bold;">
                        {{ auth()->user()->role == 'admin' ? 'Administrator Utama' : 'Mahasiswa' }}
                    </p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>