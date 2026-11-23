<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print Barcodes - {{ $product->product_name }}</title>
    <style>
        @page { margin: 8mm; }
        body { font-family: Arial, sans-serif; margin: 0; color: #111; }
        .toolbar { margin: 12px; text-align: center; }
        .toolbar button { padding: 8px 14px; cursor: pointer; }
        .labels { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8mm; }
        .label { min-height: 42mm; border: 1px dashed #aaa; text-align: center; padding: 4mm; box-sizing: border-box; page-break-inside: avoid; }
        .product { font-size: 11px; font-weight: 700; margin: 0 0 2mm; }
        .sku, .serial { font-size: 10px; margin: 1mm 0; }
        img { max-width: 100%; height: 18mm; object-fit: contain; }
        @media print { .toolbar { display: none; } .label { border-color: transparent; } }
    </style>
</head>
<body>
    <div class="toolbar"><button type="button" onclick="window.print()">Print {{ $serials->count() }} Barcode Label(s)</button></div>
    <main class="labels">
        @foreach ($serials as $serial)
            <section class="label">
                <p class="product">{{ $product->product_name }}</p>
                <p class="sku">SKU: {{ $product->sku }}</p>
                <img src="{{ asset($serial->barcode_url) }}" alt="Barcode for {{ $serial->final_serial }}">
                <p class="serial">{{ $serial->final_serial }}</p>
            </section>
        @endforeach
    </main>
</body>
</html>
