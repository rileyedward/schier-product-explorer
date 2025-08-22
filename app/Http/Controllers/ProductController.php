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
        $search = $request->input('search');
        $productTypes = ProductType::query()->get();

        $productsQuery = Product::query();

        if ($search) {
            $productsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('short_name', 'like', "%{$search}%")
                    ->orWhere('part_number', 'like', "%{$search}%");
            });

            // Store the search query in recent searches
            if ($request->user()) {
                RecentSearch::updateOrCreate(
                    [
                        'user_id' => $request->user()->id,
                        'query' => $search
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );
            }
        }

        $products = $productsQuery->get();
        $favorites = Favorite::query()->where('user_id', $request->user()->id)->get();
        $recentSearches = RecentSearch::query()
            ->where('user_id', $request->user()->id)
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        return inertia('products/products-index', [
            'productTypes' => $productTypes,
            'products' => $products,
            'favorites' => $favorites,
            'recentSearches' => $recentSearches,
            'search' => $search,
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
