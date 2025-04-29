<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Tạo phản hồi JSON thành công.
     *
     * @param string $message Thông điệp phản hồi
     * @param mixed $data Dữ liệu đi kèm (mặc định là mảng rỗng)
     * @param int $status Mã trạng thái HTTP (mặc định là 200)
     * @return JsonResponse
     */
    protected function successResponse(string $message, $data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Tạo phản hồi JSON lỗi.
     *
     * @param string $message Thông điệp lỗi
     * @param mixed $errors Chi tiết lỗi (nếu có, mặc định là null)
     * @param int $status Mã trạng thái HTTP (mặc định là 400)
     * @return JsonResponse
     */
    protected function errorResponse(string $message, $errors = null, int $status = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    /**
     * Tạo phản hồi lỗi validation.
     *
     * @param array $errors Mảng chứa chi tiết lỗi validation
     * @param string $message Thông điệp lỗi (mặc định: "Dữ liệu không hợp lệ")
     * @return JsonResponse
     */
    protected function validationErrorResponse(array $errors, string $message = 'Dữ liệu không hợp lệ'): JsonResponse
    {
        return $this->errorResponse($message, $errors, 422);
    }

    /**
     * Tạo phản hồi không tìm thấy dữ liệu.
     *
     * @param string $message Thông điệp lỗi (mặc định: "Không tìm thấy dữ liệu")
     * @return JsonResponse
     */
    protected function notFoundResponse(string $message = 'Không tìm thấy dữ liệu'): JsonResponse
    {
        return $this->errorResponse($message, null, 404);
    }

    /**
     * Tạo phản hồi từ chối truy cập.
     *
     * @param string $message Thông điệp lỗi (mặc định: "Không có quyền truy cập")
     * @return JsonResponse
     */
    protected function forbiddenResponse(string $message = 'Không có quyền truy cập'): JsonResponse
    {
        return $this->errorResponse($message, null, 403);
    }

    /**
     * Tạo phản hồi chưa được xác thực.
     *
     * @param string $message Thông điệp lỗi (mặc định: "Chưa đăng nhập")
     * @return JsonResponse
     */
    protected function unauthorizedResponse(string $message = 'Chưa đăng nhập'): JsonResponse
    {
        return $this->errorResponse($message, null, 401);
    }
}
