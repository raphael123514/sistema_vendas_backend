<?php

namespace App\Http\Controllers;

use App\Actions\Sales\CreateSaleAction;
use App\Actions\Sales\ListSalesAction;
use App\Http\Requests\SaleRequest;
use App\Http\Resources\SaleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class SaleController extends Controller
{
    public function __construct(
        private ListSalesAction $listSalesAction,
        private CreateSaleAction $createSaleAction
    ) {}

    /**
     * Lista todas as vendas com paginação (com cache)
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('per_page', 15);

        $cacheKey = 'sales:index:' . md5("page={$page}|perPage={$perPage}");

        $sales = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($page, $perPage) {
            return $this->listSalesAction->execute(
                page: $page,
                perPage: $perPage
            );
        });

        return SaleResource::collection($sales);
    }

    /**
     * Cadastra uma nova venda
     */
    public function store(SaleRequest $request): SaleResource
    {
        $sale = $this->createSaleAction->execute($request->validated());
        $sale->load('seller');

        return new SaleResource($sale);
    }
}
