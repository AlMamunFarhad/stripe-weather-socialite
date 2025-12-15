<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PracticeController extends Controller
{
    public function praceticeMethod()
    {

        $numbers = [1, 2, 3, 4, 5, 0];
        $col = collect($numbers);


        $product = $col->reduce(function ($carry, $item) {
            return ($carry ?? 1) * ($item ?: 1); // 0 থাকলে 1 ধরে নাও
        }, null);

        return $product;
    }
}
