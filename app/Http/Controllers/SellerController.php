<?php

namespace App\Http\Controllers;

use App\Actions\Sellers\CreateSellerAction;
use App\Actions\Sellers\ListSellersAction;
use App\Actions\Sellers\ListSellerSalesAction;
use App\Actions\Sellers\ShowSellerAction;
use App\Http\Requests\SellerRequest;
use App\Http\Resources\SaleResource;
use App\Http\Resources\SellerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class SellerController extends Controller
{
    public function __construct(
        private ListSellersAction $listSellersAction,
        private CreateSellerAction $createSellerAction,
        private ShowSellerAction $showSellerAction,
        private ListSellerSalesAction $listSellerSalesAction
    ) {}

    /**
     * Listar todos vendedores (com cache)
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('per_page', 15);
        $name = $request->input('name');

        $cacheKey = 'sellers:index:' . md5("page={$page}|perPage={$perPage}|name={$name}");

        $sellers = Cache::remember($cacheKey, now()->addMinutes(value: 60), function () use ($page, $perPage, $name) {
            return $this->listSellersAction->execute($page, $perPage, $name);
        });

        return SellerResource::collection($sellers);
    }

    /**
     * Cadastrar novo vendedor
     */
    public function store(SellerRequest $request): SellerResource
    {
        $seller = $this->createSellerAction->execute($request->validated());

        return new SellerResource($seller);
    }

    /**
     * Mostrar vendedor específico (opcional)
     */
    public function show($id): SellerResource
    {
        $seller = $this->showSellerAction->execute($id);

        return new SellerResource($seller);
    }

    /**
     * Listar vendas do vendedor (com cache)
     */
    public function sales($id): AnonymousResourceCollection
    {
        $cacheKey = "sellers:{$id}:sales";

        $sales = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($id) {
            return $this->listSellerSalesAction->execute($id);
        });

        return SaleResource::collection($sales);
    }
}
