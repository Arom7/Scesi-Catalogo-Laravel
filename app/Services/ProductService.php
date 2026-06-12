<?php

namespace App\Services;

use App\Models\Product;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;

class ProductService
{
    /**
     * Lista de recursos.
     */
    public function index(array $filters = [], int $perPage = 15)
    {
        return new ProductCollection(Product::all());
    }

    /**
     * Crea un nuevo recurso.
     */
    public function store(array $data)
    {
        return new ProductResource(Product::create($data));
    }

    /**
     * Muestra un recurso por ID.
     */
    public function show(string $id)
    {
        return new ProductResource(Product::findOrFail($id));
    }

    /**
     * Actualiza un recurso por ID.
     */
    public function update(string $id, array $data)
    {
        return new ProductResource(tap(Product::findOrFail($id))->update($data));
    }

    /**
     * Elimina un recurso por ID.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }
}
