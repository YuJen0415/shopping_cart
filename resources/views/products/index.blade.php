<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>產品列表</title>
    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        .product-item {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: contain;
        }
        .product-info {
            margin: 10px 0;
        }
        .product-brand-name {
            font-weight: bold;
        }
        .product-prices {
            margin-top: 5px;
        }
        .product-sale-price {
            color: red;
            font-size: 1.2em;
            font-weight: bold;
        }
        .product-official-price {
            text-decoration: line-through;
            color: #888;
            margin-left: 5px;
        }
        .add-to-cart {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            margin-top: 10px;
            cursor: pointer;
        }
        .tracking {
            background-color: white;
            border: 1px solid #ddd;
            padding: 5px 10px;
            margin-top: 5px;
            cursor: pointer;
        }
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }
        .pagination li {
            margin: 0 5px;
        }
        .pagination li a, .pagination li span {
            padding: 5px 10px;
            border: 1px solid #ddd;
            color: #333;
            text-decoration: none;
        }
        .pagination li.active span {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        .pagination li.disabled span {
            color: #6c757d;
            pointer-events: none;
            cursor: default;
        }
    </style>
</head>
<body>
    <h1>產品列表</h1>
    <div style="text-align: left; margin: 10px;">
        <a href="{{ url('/register.php') }}" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">會員註冊</a>
    </div>

    <form action="{{ route('products.index') }}" method="GET">
        <input type="text" name="name" placeholder="商品名稱" value="{{ request('name') }}">
        <select name="brand">
            <option value="">不限品牌</option>
            @foreach($brands as $brand)
                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
            @endforeach
        </select>
        <input type="number" name="min_price" placeholder="最低價格" value="{{ request('min_price') }}">
        <input type="number" name="max_price" placeholder="最高價格" value="{{ request('max_price') }}">
        <button type="submit">搜索</button>
    </form>

    <div class="product-grid">
        @foreach($products as $product)
            <div class="product-item">
                <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                <div class="product-info">
                    <div class="product-brand-name">{{ $product->brand }} {{ $product->name }}</div>
                    <div class="product-prices">
                        <span class="product-sale-price">${{ number_format($product->sale_price, 0) }}</span>
                        <span class="product-official-price">${{ number_format($product->official_price, 0) }}</span>
                    </div>
                </div>
                <button class="add-to-cart">加入購物車</button>
                <button class="tracking">&#10004;</button>
            </div>
        @endforeach
    </div>

    <div class="pagination">
        {{ $products->links('vendor.pagination.custom') }}
    </div>
</body>
</html>