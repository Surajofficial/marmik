<?php
// app/Services/ProductService.php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function searchProducts($searchTerm)
    {
        return Product::with('maxPriceVariant:id,product_id,discount,price,stock')
        ->where(function ($query) use ($searchTerm) {
            $query->orWhere('title', 'like', '%' . $searchTerm . '%')
                ->orWhere('slug', 'like', '%' . $searchTerm . '%')
                ->orWhere('description', 'like', '%' . $searchTerm . '%')
                ->orWhere('summary', 'like', '%' . $searchTerm . '%');
        })
        ->orWhereHas('variants', function ($query) use ($searchTerm) {
            $query->where('price', 'like', '%' . $searchTerm . '%');
        })
        ->orderBy('id', 'DESC')
        ->get(['id', 'photo', 'title', 'slug']);
    }
}
