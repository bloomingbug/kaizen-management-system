<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Print Ide Kaizen - Aplikasi Kaizen</title>

  <style>
    @page {
      size: A4;
    }

    .logo {
      font-family: "Nunito", sans-serif;
      font-size: 2rem;
      font-weight: 700;
      color: #435ebe;
    }

    body {
      font-family: "Arial", sans-serif;
      font-size: 12px;
      width: 100%;
      height: auto margin: 0 auto;
      background-color: #ffffff;
      color: #000000;
      box-sizing: border-box;
      margin: 0;
    }

    header {
      text-align: center;
      margin-bottom: 16px;
    }

    main table table {
      display: inline-table;
    }

    table {
      width: 100%;
      text-align: center;
    }

    .table-footer {
      width: fit-content;
      text-align: left;
      margin-top: 32px;
    }

    .table-footer th {
      width: 15%;
      font-style: italic;
      font-weight: 600;
      text-align: left;
    }

    .table-footer td {
      text-align: left;
      width: fit-content;
    }

    .table-footer td a {
      text-align: left;
    }
  </style>
</head>

<body>
  <header>
    <table border="1" cellpadding="10" cellspacing="0">
      <tr>
        <td rowspan="2">
          <span class="logo"> LOGO </span>
        </td>
        <td rowspan="2">
          <h1>FORMULIR IDE KAIZEN</h1>
        </td>
        <th>No. Kaizen</th>
      </tr>
      <tr>
        <td>{{ $kaizen->no }}</td>
      </tr>
    </table>
  </header>

  <main>
    <table border="1" cellpadding="10" cellspacing="0">
      <tr>
        <td>Target Improvement</td>
        <td>
          @forelse ($categories as $category)
            <table border="1" cellpadding="4" cellspacing="0" style="width: 30%; margin: 2px 4px">
              <tr>
                <td>
                  <label>{{ $category->name }}</label>
                </td>

                <td style="width: 20%">
                  @if ($kaizen->category->id == $category->id)
                    <input type="checkbox" checked disabled readonly />
                  @else
                    <input type="checkbox" disabled readonly />
                  @endif
                </td>
              </tr>
            </table>

          @empty
          @endforelse
        </td>
      </tr>
    </table>

    <table border="1" cellspacing="0" cellpadding="3" style="margin: 16px auto">
      <tr>
        <th>Name</th>
        <td>{{ $kaizen->name }}</td>
        <th>Departement</th>
        <td>{{ $kaizen->departement->name }}</td>
        <th>Tanggal</th>
        <td>{{ date_format($kaizen->created_at, 'j M Y') }}</td>
      </tr>
    </table>

    <table border="1" cellspacing="0" style="margin: 16px auto">
      <tr>
        <td colspan="2">
          <h3>Keadaan Saat Ini</h3>
        </td>
      </tr>
      <tr>
        <th style="width: 50%">Deskripsi</th>
        <th>Gambar / Ilustrasi</th>
      </tr>
      <tr>
        <td style="text-align: left">
          {{ $kaizen->description_old }}
        </td>
        <td>
          @if (substr($kaizen->image_old, -7) != 'kaizens')
            <img src="{{ $kaizen->image_old }}" alt="Gambar Illustrasi Saat Ini" style="width: 100%" />
          @endif
        </td>
      </tr>
    </table>

    <table border="1" cellspacing="0" style="margin: 16px auto">
      <tr>
        <td colspan="2">
          <h3>Usulan Perbaikan</h3>
        </td>
      </tr>
      <tr>
        <th style="width: 50%">Deskripsi</th>
        <th>Gambar / Ilustrasi</th>
      </tr>
      <tr>
        <td style="text-align: left">
          {{ $kaizen->description_new }}
        </td>
        <td>
          @if (substr($kaizen->image_new, -7) != 'kaizens')
            <img src="{{ $kaizen->image_new }}" alt="Gambar Illustrasi Usulan" style="width: 100%" />
          @endif
        </td>
      </tr>
    </table>

    <table border="1" cellspacing="0" style="margin: 16px auto;">
      <tr>
        <th>Manfaat / Keuntungan</th>
      </tr>
      <tr>
        <td style="text-align: left">
          {{ $kaizen->benefit }}
        </td>
      </tr>
    </table>

    <table border="1" cellspacing="0" style="margin: 16px auto;">
      <tr>
        <th colspan="3">Keputusan Final</th>
        <th rowspan="2">Nilai Akhir</th>
      </tr>
      <tr>
        <th style="width: 10%">Jabatan</th>
        <th style="width: 10%">Status</th>
        <th>Keterangan</th>
      </tr>
      <tr>
        <th style="text-align: left">Secretary</th>
        <td>{{ $kaizen->statusSecretary->name }}</td>
        <td style="text-align: left">{{ $kaizen->statusSecretary->description }}</td>

        <td rowspan="2" style="text-align: center">
          @if ($kaizen->point_pic && $kaizen->point_secretary)
            <h3 style="font-weight: 700; font-size: 32px">
              {{ ($kaizen->point_pic + $kaizen->point_secretary) / 2 }}
            </h3>
          @else
            <h3 style="font-weight: 700; font-size: 32px">
              -
            </h3>
          @endif
        </td>
      </tr>
      <tr>
        <th style="text-align: left">PIC</th>
        <td>{{ $kaizen->statusPic->name }}</td>
        <td style="text-align: left">{{ $kaizen->statusPic->description }}</td>
      </tr>
    </table>

    <table border="1" cellspacing="0" style="margin: 16px auto;">
      <tr>
        <th colspan="2">Review / Ulasan / Komentar</th>
      </tr>
      <tr>
        <th style="width: 15%">Jabatan</th>
        <th>Ulasan</th>

      </tr>
      <tr>
        <th style="text-align: left">Secretary</th>
        <td style="text-align: left">{{ $kaizen->review_secretary }}</td>
      </tr>
      <tr>
        <th style="text-align: left">PIC</th>
        <td style="text-align: left">{{ $kaizen->review_pic }}</td>
      </tr>
    </table>

    <table style="margin: 24px auto;">
      <tr>
        <th>Ditandatangani secara elektronik oleh <br> PIC,</th>
        <th>Ditandatangani secara elektronik oleh <br> Secretary,</th>
      </tr>
      <tr style="height: 130px">
        <td style="text-align: center;">
          @if ($kaizen->pic_id)
            <img
              src="{{ 'https://chart.googleapis.com/chart?chs=120x120&cht=qr&chma=0,0,0,0&chl=' . env('APP_URL') . '/sign/' . $kaizen->pic_id }}">
          @endif
        </td>
        <td style="text-align: center;">
          @if ($kaizen->secretary_id)
            <img
              src="{{ 'https://chart.googleapis.com/chart?chs=120x120&cht=qr&chma=0,0,0,0&chl=' . env('APP_URL') . '/sign/' . $kaizen->secretary_id }}">
          @endif
        </td>
      </tr>
      <tr>
        <td style="text-align: center">
          @if ($kaizen->pic_id)
            {{ $kaizen->pic->user->name }}
          @else
            (............................)
          @endif
        </td>
        <td style="text-align: center">
          @if ($kaizen->secretary_id)
            {{ $kaizen->sekretaris->user->name }}
          @else
            (............................)
          @endif
        </td>
      </tr>
    </table>

    <table class="table-footer">
      <tr>
        <th>
          <span>Lihat Update
          </span>
        </th>
        <td>
          <a href="{{ env('APP_URL') . '/details/' . $kaizen->id }}"
            target="_blank">{{ env('APP_URL') . '/details/' . $kaizen->id }}</a>
        </td>
      </tr>
      <tr>
        <th>
          <span>Tanggal Download
          </span>
        </th>
        <td>{{ date_create()->format('Y-m-d H:i:s') }}</td>
      </tr>
    </table>
  </main>
</body>

</html>
