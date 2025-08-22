<?php

namespace App\Http\Controllers;

use App\Jobs\SyncSchierProductsJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductApiClient;

class ProductController extends Controller
{
    protected ProductApiClient $productApiClient;

    public function __construct()
    {
        $this->productApiClient = new ProductApiClient([
            'api_key' => config('services.schier.key')
        ]);
    }

    public function index(): Response
    {
//        $productTypes = $this->productApiClient->productTypes();
//        $products = $this->productApiClient->products();
//
//        logger()->info($products->count());

//        logger()->info($productTypes);
//        logger()->info($products);

        return inertia('products/products-index');
    }

    public function favorites(): Response
    {
        // TODO: Pull down favorites...

        return inertia('products/products-favorites');
    }

    public function sync(): RedirectResponse
    {
        SyncSchierProductsJob::dispatch();

        return redirect()->back()->with('success', 'Product sync has been initiated.');
    }
}
