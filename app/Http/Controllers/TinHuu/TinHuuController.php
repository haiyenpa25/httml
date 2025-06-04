<?php

namespace App\Http\Controllers\TinHuu;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use App\Models\TinHuu;

class TinHuuController extends Controller
{
    use ApiResponseTrait;

    protected $thanhVienController;

    public function __construct(TinHuuThanhVienController $thanhVienController)
    {
        $this->thanhVienController = $thanhVienController;
    }

    public function index(): View
    {
        return $this->thanhVienController->index();
    }

    public function store(Request $request): JsonResponse
    {
        return $this->thanhVienController->store($request);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        return $this->thanhVienController->update($request, $id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->thanhVienController->destroy($id);
    }

    public function list(Request $request): JsonResponse
    {
        $cacheKey = 'tin_huu_list_' . md5(json_encode($request->all()));
        $cacheDuration = now()->addMinutes(30);

        return Cache::remember($cacheKey, $cacheDuration, function () use ($request) {
            return $this->thanhVienController->list($request);
        });
    }

    public function show(int $id): JsonResponse
    {
        return $this->thanhVienController->show($id);
    }

    public function edit(int $id): JsonResponse
    {
        return $this->thanhVienController->edit($id);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $tinHuus = TinHuu::where('ho_ten', 'like', '%' . $query . '%')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'items' => $tinHuus->items(),
            'hasMore' => $tinHuus->hasMorePages(),
        ]);
    }
}
