<?php

namespace App\Http\Controllers;

use App\Jobs\SyncSchierProductsJob;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\RecentSearch;
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

    public function index(Request $request): Response
    {
        $productTypes = ProductType::query()->get();
        $products = Product::query()->get();
        $favorites = Favorite::query()->where('user_id', $request->user()->id)->get();
        $recentSearches = RecentSearch::query()->where('user_id', $request->user()->id)->get();

        return inertia('products/products-index', [
            'productTypes' => $productTypes,
            'products' => $products,
            'favorites' => $favorites,
            'recentSearches' => $recentSearches,
        ]);
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
