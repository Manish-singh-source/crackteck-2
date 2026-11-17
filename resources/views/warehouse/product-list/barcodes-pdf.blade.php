<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Product barcodes</title>
    <style>
        @page {
            margin: 18px;
        }

        body {
            color: #222;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        h2 {
            margin: 0 0 4px;
        }

        .product-details {
            margin-bottom: 14px;
        }

        table {
            border-collapse: collapse;
            table-layout: fixed;
            width: 100%;
        }

        td {
            padding: 5px;
            vertical-align: top;
            width: 33.33%;
        }

        .barcode-label {
            border: 1px dashed #999;
            height: 100px;
            padding: 8px;
            text-align: center;
        }

        .barcode-label img {
            height: 58px;
            max-width: 100%;
        }

        .serial {
            font-size: 9px;
            overflow-wrap: anywhere;
        }
    </style>
</head>
<body>
    <div class="product-details">
        <h2>{{ $product->product_name }}</h2>
        <div>SKU: {{ $product->sku }}</div>
    </div>

    <table>
        <tbody>
            @foreach ($barcodes->chunk(3) as $row)
                <tr>
                    @foreach ($row as $barcode)
                        <td>
                            <div class="barcode-label">
                                <img src="{{ $barcode['image'] }}" alt="Barcode">
                                <div class="serial">{{ $barcode['serial'] }}</div>
                            </div>
                        </td>
                    @endforeach
                    @for ($column = $row->count(); $column < 3; $column++)
                        <td></td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
