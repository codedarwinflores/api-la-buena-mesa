<?php

namespace App\Http\Controllers\Api;

use App\Enums\MenuCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Http\Resources\MenuItemResource;
use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * Controlador RESTful para la gestión del menú de "La Buena Mesa".
 *
 * Sigue el principio de responsabilidad única: cada método atiende
 * exclusivamente a una acción del recurso "menu-items". La lógica de
 * validación vive en los FormRequest y la lógica de consulta reutilizable
 * vive en scopes del modelo Eloquent.
 */
class MenuItemController extends Controller
{
    /**
     * GET /api/menu-items
     * Lista el menú con filtros opcionales por query string y paginación.
     *
     * Query params soportados:
     *  - category=postre
     *  - available=1|0
     *  - search=texto (busca en name)
     *  - per_page=15
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'category' => ['sometimes', Rule::in(MenuCategory::values())],
            'available' => ['sometimes', 'boolean'],
            'search' => ['sometimes', 'string', 'max:150'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        $query = MenuItem::query();

        if ($request->filled('category')) {
            $query->category($request->string('category'));
        }

        if ($request->has('available')) {
            $query->where('available', $request->boolean('available'));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->string('search') . '%');
        }

        $perPage = (int) $request->input('per_page', 15);
        $menuItems = $query->orderBy('category')->orderBy('name')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => MenuItemResource::collection($menuItems),
            'meta' => [
                'current_page' => $menuItems->currentPage(),
                'last_page' => $menuItems->lastPage(),
                'per_page' => $menuItems->perPage(),
                'total' => $menuItems->total(),
            ],
        ]);
    }

    /**
     * GET /api/menu-items/{id}
     */
    public function show(MenuItem $menuItem): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new MenuItemResource($menuItem),
        ]);
    }

    /**
     * POST /api/menu-items
     */
    public function store(StoreMenuItemRequest $request): JsonResponse
    {
        $menuItem = MenuItem::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Elemento del menú creado correctamente.',
            'data' => new MenuItemResource($menuItem),
        ], 201);
    }

    /**
     * PUT/PATCH /api/menu-items/{id}
     */
    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem): JsonResponse
    {
        $menuItem->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Elemento del menú actualizado correctamente.',
            'data' => new MenuItemResource($menuItem->fresh()),
        ]);
    }

    /**
     * DELETE /api/menu-items/{id}
     */
    public function destroy(MenuItem $menuItem): JsonResponse
    {
        $menuItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Elemento del menú eliminado correctamente.',
        ], 200);
    }

    /**
     * GET /api/menu-items/category/{category}
     */
    public function byCategory(string $category): JsonResponse
    {
        if (! in_array($category, MenuCategory::values(), true)) {
            throw ValidationException::withMessages([
                'category' => 'Categoría inválida. Valores permitidos: ' . implode(', ', MenuCategory::values()),
            ]);
        }

        $menuItems = MenuItem::category($category)->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => MenuItemResource::collection($menuItems),
        ]);
    }

    public function docs(){
        return view("docs.index");
    }
}
