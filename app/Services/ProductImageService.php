<?php

namespace App\Services;

use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class ProductImageService
{
    private string $disk = 'public';

    private string $directory = 'products/images';

    /**
     * Crea un nuevo recurso.
     */
    public function storeImageProduct(string $product_id, array $images = [])
    {
        if (empty($images)) {
            return;
        }

        foreach ($images as $image) {
            // Verificar si ya existe una imagen principal para el producto
            $alreadyHasMain = ProductImage::query()
                ->where('product_id', $product_id)
                ->where('is_main', true)
                ->exists();

            $path = $image->store($this->directory, $this->disk);

            if ($path === false) {
                throw new RuntimeException('No se pudo almacenar la imagen.');
            }

            ProductImage::create([
                'image_url' => asset('storage/' . $path),
                'is_main' => !$alreadyHasMain, // Si no hay imagen principal, esta será la principal
                'product_id' => $product_id,
            ]);
        }
    }

    /**
     * Elimina un recurso por ID.
     */
    public function destroyImageProduct(string $id)
    {
        $productImage = ProductImage::query()->findOrFail($id);

        $storedPath = $this->extractStoragePath($productImage->image_url);

        $productImage->delete();

        if ($storedPath && Storage::disk($this->disk)->exists($storedPath)) {
            Storage::disk($this->disk)->delete($storedPath);
        }
    }

    /**
     * Extrae la ruta relativa del disco público desde una URL almacenada.
     */
    private function extractStoragePath(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        if (str_contains($url, '/storage/')) {
            return ltrim(Str::after($url, '/storage/'), '/');
        }

        if (str_starts_with($url, $this->directory . '/')) {
            return ltrim($url, '/');
        }

        return null;
    }
}
