<!DOCTYPE html>
<html>

<head>
    <title>LK Input {{ $nomenklaturs->nama_nomenklatur }} </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<style>
    hr.s1 {
        height: 1px;
        border-top: 1px solid black;
        border-bottom: 1px solid black;
        margin-top: 7px
    }

    .new {
        padding: 50px;
    }

    .form-group {
        display: block;
        margin-bottom: 15px;
    }

    .form-group input {
        padding: 0;
        height: initial;
        width: initial;
        margin-bottom: 0;
        display: none;
        cursor: pointer;
    }

    .form-group label {
        position: relative;
        cursor: pointer;
    }

    .form-group label:before {
        content: '';
        -webkit-appearance: none;
        background-color: transparent;
        border: 1px solid #000000;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
        padding: 5px;
        display: inline-block;
        position: relative;
        vertical-align: middle;
        cursor: pointer;
        margin-right: 5px;
    }

    .form-group input:checked+label:after {
        content: '';
        display: block;
        position: absolute;
        top: -5px;
        left: 5px;
        width: 6px;
        height: 12px;
        border: solid #000000;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
</style>


<body>
    <table style="line-height: 8px; font-size:13px">
        <tr>
            <td style="width: 40%">
                <img src="../public/asset/logo.png" style="width: 100%">
            </td>
            <td>
                <h6>
                    <center>
                        <b>
                            LEMBAR KERJA PENGUJIAN/ KALIBRASI
                            {{ $nomenklaturs->nama_nomenklatur }}
                        </b>
                    </center>
                </h6>
                <center>
                    <span>{{ $nomenklaturs->no_dokumen }}</span>
                </center>
            </td>
        </tr>
    </table>
    <hr class="s1">
    <p style="font-size: 14px"><b>A. PENDATAAN ADMINISTRASI</b></p>
    <table class="table table-borderless  table-sm"
        style="margin-left: 18px;font-size:11px;width:100%;margin-top:-10px;float:left ">
        <tbody>
            @php($count = 1)
            @foreach ($laporan_pendataan_administrasi as $row)
                <?php if ($row->field_pendataan_administrasi == 'Faskes Pemilik') {
                    $value = get_data_rs($row->value);
                } else {
                    $value = $row->value;
                }
                ?>
                @if ($count <= $dataAwal)
                    <tr>
                        <td style="width: 1px">{{ $loop->iteration }}.</td>
                        <td style="width: 17%;text-align: justify">{{ $row->field_pendataan_administrasi }}</td>
                        <td style="width: 1px;text-align: justify">:</td>
                        <td style="text-align: justify"><b>{{ $value }} <span>{{ $row->satuan }}</span></b>
                        </td>
                    </tr>
                    @php($count++)
                @endif
            @endforeach
        </tbody>
    </table>
    <table class="table table-borderless table-sm"
        style="margin-left: 50%;font-size:11px;width:100%;margin-top:-10px;margin-bottom:0px">
        <tbody>
            @php($count2 = 1)
            @foreach ($laporan_pendataan_administrasi as $row)
                <?php if ($row->field_pendataan_administrasi == 'Faskes Pemilik') {
                    $value = get_data_rs($row->value);
                } else {
                    $value = $row->value;
                }
                ?>
                @if ($count2 > $dataAwal)
                    <tr>
                        <td style="width: 1px">{{ $loop->iteration }}.</td>
                        <td style="width: 17%;text-align: justify">{{ $row->field_pendataan_administrasi }}</td>
                        <td style="width: 1px;text-align: justify">:</td>
                        <td style="text-align: justify"> <b>{{ $value }} <span>{{ $row->satuan }}</span></b>
                        </td>
                    </tr>
                @endif
                @php($count2++)
            @endforeach
        </tbody>
    </table>

    <p style="font-size: 14px;"><b>B. DAFTAR ALAT</b></p>
    <table class="table table-bordered table-sm"
        style="margin-left: 18px;font-size:11px;width:100%;margin-top:-10px; padding-right:18px">
        <thead>
            <tr>
                <th style="width: 4%;text-align: center;">No</th>
                <th style="width: 24%;text-align: center;">Nama Alat</th>
                <th style="width: 24%;text-align: center;">Merk</th>
                <th style="width: 24%;text-align: center;">Tipe</th>
                <th style="width: 24%;text-align: center;">No Seri</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporan_daftar_alat_ukur as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="text-align: justify">{{ $row->jenis_alat }}</td>
                    <td style="text-align: justify">{{ $row->nama_merek }}</td>
                    <td style="text-align: justify">{{ $row->tipe }}</td>
                    <td style="text-align: justify">{{ $row->serial_number }}</td>
                </tr>
            @empty
                <tr>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p style="font-size: 14px"><b>C. PENGUKURAN KONDISI LINGKUNGAN </b></p>
    <table class="table table-bordered table-sm" style="margin-left: 18px;font-size:11px;width:75%;margin-top:-10px;">
        <thead>
            <tr>
                <th style="width: 4%;text-align: center;">No</th>
                <th style="width: 35%;text-align: center;">Parameter</th>
                <th style="width: 35%;text-align: center;" colspan="2">Terukur</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Thermohygrometer</td>
                <td>Awal : <b>{{ $laporan_kondisi_lingkungan->suhu_awal }}</b> <span style="float: right">&deg;C</span>
                </td>
                <td>Akhir : <b>{{ $laporan_kondisi_lingkungan->suhu_akhir }}</b> <span
                        style="float: right">&deg;C</span></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Kelembaban Ruangan </td>
                <td>Awal : <b>{{ $laporan_kondisi_lingkungan->kelembapan_ruangan_awal }}</b> <span
                        style="float: right">%RH</span>
                </td>
                <td>Akhir : <b>{{ $laporan_kondisi_lingkungan->kelembapan_ruangan_akhir }}</b> <span
                        style="float: right">%RH</span>
                </td>
            </tr>

        </tbody>
    </table>

    <p style="font-size: 14px"><b>D. PEMERIKSAAAN KONDISI FISIK DAN FUNGSI</b></p>
    <table class="table table-bordered table-sm"
        style="margin-left: 18px;font-size:11px;width:100%;margin-top:-10px; padding-right:18px">
        <thead>
            <tr>
                <th style="width: 4%;text-align: center;">No</th>
                <th style="width: 24%;text-align: center;">Bagian Alat</th>
                <th style="width: 52%;text-align: center;">Hasil Pemeriksaan</th>
                <th style="width: 20%;text-align: center;">Hasil Pengamatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kondisi_fisik_fungsi as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="text-align: justify">{{ $row->field_parameter_fisik_fungsi }}</td>
                    <td style="text-align: justify">{{ $row->field_batas_pemeriksaan }}</td>
                    <td style="text-align: justify"> <b>{{ $row->value == 'baik' ? 'Baik' : 'Tidak Baik' }}</b> </td>
                </tr>
            @empty
                <tr>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p style="font-size: 14px"><b>E. PENGUKURAN KESELAMATAN LISTRIK</b></p>
    <table class="table table-bordered table-sm"
        style="margin-left: 18px;font-size:11px;width:100%;margin-top:-10px; padding-right:18px">
        <thead>
            <tr>
                <th style="width: 4%;text-align: center;">No</th>
                <th colspan="2" style="width: 24%;text-align: center;">Parameter</th>
                <th style="width: 20%;text-align: center;">Terukur</th>
                <th style="width: 20%;text-align: center;">Ambang Batas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="3">1</td>
                <td rowspan="3" style="text-align: justify">Tegangan Input (Main Voltage)</td>
                <td style="text-align: justify">Phase - Netral</td>
                <td style="text-align: justify">Vac</td>
                <td style="text-align: justify">220 ± 10% Vac
                </td>
            </tr>
            <tr>
                <td style="text-align: justify">Phase - Ground</td>
                <td style="text-align: justify">Vac</td>
                <td style="text-align: justify">220 ± 10% Vac
                </td>
            </tr>
            <tr>
                <td style="text-align: justify">Ground - Netral</td>
                <td style="text-align: justify">Vac</td>
                <td style="text-align: justify">≤ 5 Vac
                </td>
            </tr>
            <tr>
                <td rowspan="3">2</td>
                <td colspan="2" style="text-align: justify">Resistansi pembumian protektif</td>
                <td colspan="2" style="text-align: justify;background-color: gray"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify">Kabel dapat dilepas (DPS)</td>
                <td style="text-align: justify;">Ω
                </td>
                <td style="text-align: justify;">≤ 200 mΩ
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify">Kabel tidak dapat dilepas (NPS)</td>
                <td style="text-align: justify;">Ω
                </td>
                <td style="text-align: justify;">≤ 300 mΩ
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td colspan="2" style="text-align: justify">Resistansi isolasi</td>
                <td style="text-align: justify">MΩ</td>
                <td style="text-align: justify">> 2Ω

                </td>
            </tr>
            <tr>
                <td rowspan="2">4</td>
                <td colspan="2" style="text-align: justify">Arus bocor peralatan metode langsung/diferensial</td>
                <td colspan="2" style="text-align: justify;background-color: gray"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify">Kelas I tipe B/BF/CF</td>
                <td style="text-align: justify;">µA
                </td>
                <td style="text-align: justify;">≤ 200 mΩ
                </td>
            </tr>
        </tbody>
    </table>

    <p style="font-size: 14px"><b>F. PENGUKURAN KINERJA</b></p>


    <p style="font-size: 14px"><b>G. TELAAH TEKNIS</b></p>
    <table class="table table-bordered table-sm"
        style="margin-left: 18px;font-size:11px;width:100%;margin-top:-10px; padding-right:18px">
        <tbody>
            @forelse ($laporan_telaah_teknis as $row)
                <tr>
                    <td style="width: 4%;text-align: center;">{{ $loop->iteration }}</td>
                    <td style="text-align: justify;vertical-align: middle;">{{ $row->field_telaah_teknis }}</td>
                    <td>
                        <div class="form-group" style="margin: 0px">
                            <input type="checkbox" {{ $row->value == 'baik' ? 'checked' : '' }}>
                            <label>Baik</label>
                        </div>
                        <div class="form-group" style="margin: 0px">
                            <input type="checkbox" {{ $row->value == 'tidak-baik' ? 'checked' : '' }}>
                            <label>Tidak Baik</label>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;">-</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p style="font-size: 14px"><b>H. KESIMPULAN TELAAH TEKNIS KALIBRASI</b></p>

    <table class="table table-bordered table-sm"
        style="margin-left: 18px;font-size:11px;width:100%;margin-top:-10px; padding-right:18px">
        <tbody>
            <tr>
                <td style="height:60px"><b>Catatan :</b> {{ $laporan_kesimpulan_telaah_teknis->catatan }} </td>
            </tr>
        </tbody>
    </table>


    <table class="table table-bordered table-sm"
        style="margin-left: 18px;font-size:11px;width:100%;margin-top:-10px; padding-right:18px">
        <tbody>
            <tr>
                <td style="width: 40%;text-align: center;vertical-align: middle;">Berdasarkan hasil pengujian dan/ atau
                    hasil kalibrasi, alat ini dinyatakan </td>
                <td style="width: 20%;text-align: center;vertical-align: middle;">
                    <div class="form-group" style="margin: 0px">
                        <input type="checkbox" checked>
                        <label><b style="font-size: 12px">LAIK PAKAI</b></label>
                    </div>
                </td>
                <td style="width: 20%;text-align: center;vertical-align: middle;">
                    <div class="form-group" style="margin: 0px">
                        <input type="checkbox">
                        <label><b style="font-size: 12px">TIDAK LAIK PAKAI</b></label>
                    </div>
                </td>
                <td style="width: 20%;text-align: center;vertical-align: middle;"><b
                        style="font-size: 12px">PENYELIA</b> </td>
            </tr>
            <tr>
                <td style="text-align: center;height:75px;vertical-align: middle;">Pelaksana Pengujian dan Kalibrasi
                </td>
                <td colspan="2" style="text-align: center">
                    {!! QrCode::size(100)->generate('ramdan') !!}
                    <span>Muhammad Saeful Ramdan</span>
                </td>
                <td style="text-align: center">
                    {!! QrCode::size(100)->generate('ramdan') !!}
                    <span>Muhammad Saeful Ramdan</span>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
