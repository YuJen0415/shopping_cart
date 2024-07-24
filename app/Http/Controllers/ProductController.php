<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Product::query();

            if ($request->filled('name')) {     // 用filled確保欄位有值才執行
                $query->where('name', 'like', '%' . $request->input('name') . '%');
            }

            if ($request->filled('brand')) {
                $query->where('brand', $request->input('brand'));
            }

            if ($request->filled('min_price')) {
                $query->where('sale_price', '>=', $request->input('min_price'));
            }

            if ($request->filled('max_price')) {
                $query->where('sale_price', '<=', $request->input('max_price'));
            }

            $products = $query->paginate(8)->withQueryString();

            // 獲取所有唯一的品牌
            $brands = Product::distinct()->pluck('brand')->sort();

            return view('products.index', compact('products', 'brands'));
        } catch (\Exception $e) {
            Log::error('Product search error: ' . $e->getMessage());
            return back()->with('error', '搜尋時發生錯誤，請稍後再試。');
        }
    }
}