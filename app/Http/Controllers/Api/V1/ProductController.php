<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    // Inyección de dependencias del servicio de productos
    public function __construct(
        private ProductService $productService
    )
    {}


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            return response()->json([
                'message' => 'Productos obtenidos exitosamente',
                'data' => $this->productService->index()
                ], 200);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error al obtener los productos',
                'message' => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try{
            $dataProductValidated = $request->safe()->only(['name', 'description', 'base_price']);

            return response()->json([
                'message' => 'Producto registrado correctamente',
                'data' => $this->productService->store($dataProductValidated)
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error durante el registro de productos',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            return response()->json([
                'message' => 'Producto obtenido exitosamente',
                'data' => $this->productService->show($id)
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error al obtener el producto',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        try{
            $dataProductValidated = $request->safe()->only(['name', 'description', 'base_price']);
            return response()->json([
                'message' => 'Producto actualizado correctamente',
                'data' => $this->productService->update($id, $dataProductValidated)
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error al actualizar el producto',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $this->productService->destroy($id);
            return response()->json([
                'message' => 'Producto eliminado exitosamente'
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Error al eliminar el producto',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
