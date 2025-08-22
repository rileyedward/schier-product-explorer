<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(): Response
    {
        // TODO: Pull down products from SDK...

        return inertia('products/products-index');
    }

    public function favorites(): Response
    {
        // TODO: Pull down favorites...

        return inertia('products/products-favorites');
    }
}
