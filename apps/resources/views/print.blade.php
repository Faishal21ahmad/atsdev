<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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


{{-- <div id="canvas" class="flex flex-wrap justify-center gap-1 mx-auto">
    @foreach ($dataPrint as $item)
    <div id="card" class="flex w-[90mm] h-[40mm] p-2 border-2 bg-white rounded-lg">
        <div id="content-code" class="flex flex-col items-center justify-center w-1/3 p-1">
            <img id="img-qr" src="{{ asset('storage/fileQR/' . $item->code_assets . '.svg') }}" 
                style="height: 35mm; width: auto;">
            <p id="code" class="text-sm font-semibold mt-1">{{ $item->code_assets }}</p>
        </div>
        <div id="content-information" class="w-2/3 p-2 flex flex-col">
            <h1 id="name-asset" class="text-xl font-semibold whitespace-nowrap overflow-hidden text-ellipsis">
                {{ $item->masterAsset->asset_name }}
            </h1>
            <p id="date" class="text-sm font-semibold mt-1">
                Date in : {{ \Carbon\Carbon::parse($item->created_at)->format('d / m / Y') }}
            </p>
        </div>
    </div>
    @endforeach
</div> --}}
