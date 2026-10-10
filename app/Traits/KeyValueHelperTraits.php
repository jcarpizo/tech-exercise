<?php declare(strict_types = 1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait KeyValueHelperTraits
{
    /**
     * @param $keyValues
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function getRequestResponse($keyValues, int $statusCode = 200): JsonResponse
    {
        if (empty($keyValues)) {
            return response()->json(['message' => 'no available value'], $statusCode);
        }

        return response()->json($keyValues, $statusCode);
    }

    /**
     * @param array $requestKeyValues
     * @return bool
     */
    protected function validateRequest(array $requestKeyValues): bool
    {
        if (empty($requestKeyValues) || count($requestKeyValues) > 1) {
            return true;
        }
        return false;
    }
}
