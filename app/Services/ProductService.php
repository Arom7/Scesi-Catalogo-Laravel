<?php

namespace App\Services;

use App\Models\Product;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(
        private ProductImageService $productImageService
    ) {}

    /**
     * Lista de recursos.
     */
    public function index(array $filters = [], int $perPage = 15)
    {
        return new ProductCollection(Product::with('productImages')->get());
    }

    /**
     * Crea un nuevo recurso.
     */
    public function store(array $data, array $images = [])
    {
        return DB::transaction(function () use ($data, $images) {
            $newProduct = Product::create($data);

            // Almacenar imágenes asociadas al producto
            $this->productImageService->storeImageProduct($newProduct->id, $images);

            // Convertir producto a recurso para incluir las imágenes
            return new ProductResource($newProduct);
        });
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
    public function update(string $id, array $data, array $images = [])
    {
        return DB::transaction(function () use ($id, $data, $images) {
            $product = tap(Product::findOrFail($id))->update($data);
             // Actualizar imágenes asociadas al producto, para ello primero las eliminamos y luego las volvemos a crear
            $this->deleteImageProduct($product);
            // Sea que se tenga imagenes o no igual se hace el registro de las nuevas imagenes
            $this->productImageService->storeImageProduct($product->id, $images);

            return new ProductResource($product);
        });
    }

    /**
     * Elimina un recurso por ID.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        // Eliminar imágenes asociadas al producto antes de eliminar el producto, para evitar que queden imágenes huérfanas en la base de datos
        $this->deleteImageProduct($product);
        $product->delete();
    }

    // Otros métodos relacionados con la lógica de negocio del producto pueden ser añadidos aquí
    public function deleteImageProduct(Product $product)
    {
        if ($product->productImages()->exists()) {
            $existingImages = $product->productImages()->pluck('id')->toArray();
            foreach ($existingImages as $imageId) {
                $this->productImageService->destroyImageProduct($imageId);
            }
        }
    }
}
