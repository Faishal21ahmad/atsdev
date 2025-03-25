<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('storage/asset/ATS_light.png') }}" type="image/png" media="(prefers-color-scheme: light)">
    <link rel="icon" href="{{ asset('storage/asset/ATS_dark.png') }}" type="image/png" media="(prefers-color-scheme: dark)">
    <title>Print PDF</title>
    <link href="{{ public_path('storage/asset/print.css') }}" rel="stylesheet">
</head>
<body>
    <div id="canvas">
        <p id="wm">{{ $sizePaper }}</p>
        @foreach ($dataPrint as $item)
        <div id="card">
            <div id="content-code">
                <img id="img-qr" src="{{ public_path('storage/fileQR/' . $item->code_assets .'.svg') }}">
                <p id="code">{{ $item->code_assets }}</p>
            </div>
            <div id="content-information">
                <h1 id="name-asset">{{ $item->masterAsset->asset_name }}</h1>
                <p id="date">Date in : {{ \Carbon\Carbon::parse($item->created_at)->format('d / m / Y') }}</p>
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>
