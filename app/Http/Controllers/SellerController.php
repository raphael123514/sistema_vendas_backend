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

class SellerController extends Controller
{
    public function __construct(
        private ListSellersAction $listSellersAction,
        private CreateSellerAction $createSellerAction,
        private ShowSellerAction $showSellerAction,
        private ListSellerSalesAction $listSellerSalesAction
    ) {}

    /**
     * Listar todos vendedores
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('per_page', 15);
        $name = $request->input('name');
        $sellers = $this->listSellersAction->execute($page, $perPage, $name);

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
     * Listar vendas do vendedor
     */
    public function sales($id): AnonymousResourceCollection
    {
        $sales = $this->listSellerSalesAction->execute($id);

        return SaleResource::collection($sales);
    }
}
