<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Console\Command;
use SchierProducts\SchierProductApi\ApiClients\ProductApi\ProductApiClient;
use SchierProducts\SchierProductApi\Exception\ApiErrorException;

class SyncSchierProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-schier-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calls the Schier API with the PHP SDK to sync the API products with the local database products';

    protected ProductApiClient $productApiClient;

    public function __construct()
    {
        parent::__construct();

        $this->productApiClient = new ProductApiClient([
            'api_key' => config('services.schier.key')
        ]);
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->syncProductTypes();
        $this->syncProducts();
    }

    protected function syncProductTypes(): void
    {
        try {
            $productTypes = $this->productApiClient->productTypes();

            logger()->info(collect($productTypes)->count() . ' product types found');

            foreach (collect($productTypes) as $productType) {
                $productTypeData = $productType->toArray();
                ProductType::query()->updateOrCreate(
                    ['key' => $productTypeData['key']],
                    $productTypeData
                );
            }
        } catch (ApiErrorException $e) {
            logger()->info('An error with the Schier Product API has occurred...');
            logger()->info($e->getMessage());
        }
    }

    protected function syncProducts(): void
    {
        try {
            $products = $this->productApiClient->products();

            logger()->info(collect($products)->count() . ' products found');

            foreach (collect($products) as $product) {
                $productData = $product->toArray();
                Product::query()->updateOrCreate(
                    ['part_number' => $productData['part_number']],
                    $productData
                );
            }
        } catch (ApiErrorException $e) {
            logger()->info('An error with the Schier Product API has occurred...');
            logger()->info($e->getMessage());
        }
    }
}
