<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print PDF</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        @media print {
            @page {
                margin: 0;
                padding: 5mm;
            }
        }
    </style>
</head>
<body class="bg-slate-500 flex justify-center gap-1">
    <p class="text-xs">{{ $sizePaper }}</p>
    <div class="flex flex-wrap justify-center gap-1 mx-auto"> 
        @foreach ($dataPrint as $item)
        <div id="content" class="flex w-[90mm] h-[40mm] p-2 border-2 bg-white rounded-lg">
            <!-- Block Identity -->
            <div id="block-identity" class="flex flex-col items-center justify-center w-1/3 p-1">
                <img src="{{ public_path('storage/fileQR/' . $item->code_assets .'.svg') }}" class="object-contain" alt="">
                <p class="text-sm font-semibold mt-1">{{ $item->code_assets }}</p>
            </div>
            <!-- Block Information -->
            <div id="block-information" class="w-2/3 p-2 flex flex-col">
                <h1 class="text-xl font-semibold whitespace-nowrap overflow-hidden text-ellipsis">{{ $item->masterAsset->asset_name }}</h1>
                <p class="text-sm font-semibold mt-1">Date in : {{ \Carbon\Carbon::parse($item->created_at)->format('d / m / Y') }}</p>
            </div>
        </div>
        @endforeach
    </div>
    <p class="text-xs">{{ $sizePaper }}</p>
</body>
</html>
