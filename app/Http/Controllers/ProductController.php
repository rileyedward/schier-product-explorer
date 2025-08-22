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
        $filter = $request->input('filter');
        $productTypes = ProductType::query()->get();

        $productsQuery = Product::query();

        if ($search) {
            $productsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('short_name', 'like', "%{$search}%")
                    ->orWhere('part_number', 'like', "%{$search}%");
            });

            if ($request->user()) {
                RecentSearch::query()->updateOrCreate(
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

        if ($filter) {
            logger()->info($filter);

            $productsQuery->whereJsonContains('types', $filter);
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
            'filter' => $filter,
        ]);
    }

    public function favorites(Request $request): Response
    {
        $search = $request->input('search');
        $filter = $request->input('filter');
        $productTypes = ProductType::query()->get();

        $favoriteProductIds = Favorite::query()
            ->where('user_id', $request->user()->id)
            ->pluck('product_id');

        $productsQuery = Product::query()->whereIn('id', $favoriteProductIds);

        if ($search) {
            $productsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('short_name', 'like', "%{$search}%")
                    ->orWhere('part_number', 'like', "%{$search}%");
            });

            if ($request->user()) {
                RecentSearch::query()->updateOrCreate(
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

        if ($filter) {
            logger()->info($filter);

            $productsQuery->whereJsonContains('types', $filter);
        }

        $products = $productsQuery->get();
        $favorites = Favorite::query()->where('user_id', $request->user()->id)->get();
        $recentSearches = RecentSearch::query()
            ->where('user_id', $request->user()->id)
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        return inertia('products/products-favorites', [
            'productTypes' => $productTypes,
            'products' => $products,
            'favorites' => $favorites,
            'recentSearches' => $recentSearches,
            'search' => $search,
            'filter' => $filter,
        ]);
    }

    public function toggleFavorite(Request $request, Product $product): RedirectResponse
    {
        $user = $request->user();
        $favorite = Favorite::query()->where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::query()->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        return back();
    }

    public function sync(): RedirectResponse
    {
        SyncSchierProductsJob::dispatch();

        return redirect()->back()->with('success', 'Product sync has been initiated.');
    }
}
