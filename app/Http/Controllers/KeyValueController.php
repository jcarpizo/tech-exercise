<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreKeyValueRequest;
use App\Services\KeyValue\KeyValueInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Throwable;

class KeyValueController extends Controller
{
    private const int CACHE_TTL = 10;

    public function __construct(
        private readonly KeyValueInterface $keyValueService
    )
    {
    }

    public function storeKeyValue(StoreKeyValueRequest $request): JsonResponse
    {
        $data = $request->json()->all();

        if (count($data) !== 1) {
            return response()->json([
                'error_message' => 'Exactly one key-value pair is required.',
            ], 422);
        }

        $keyName = (string)array_key_first($data);
        $keyValue = $data[$keyName];

        $record = $this->keyValueService->storeKeyValue($keyName, $keyValue);

        Cache::forget("keyvalues:{$keyName}");
        Cache::forget('keyvalues:all');

        return response()->json([
            'message' => 'Value stored successfully.',
            'timestamp' => $record->timestamp_reference,
        ], 201);
    }

    public function getKeyValue(string $keyName, Request $request): JsonResponse
    {
        try {
            $timestamp = $request->query('timestamp');

            $data = $keyName === 'get_all_records'
                ? Cache::remember(
                    'keyvalues:all',
                    now()->addSeconds(self::CACHE_TTL),
                    fn(): array => $this->getAllCurrentValues()
                )
                : $this->retrieveKeyValue($keyName, $timestamp);

            return empty($data) ? response()->json(['error_message' => 'Key not found.'], 404) : response()->json($data);

        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'error_message' => 'Unable to retrieve key-value data.',
            ], 500);
        }
    }

    private function retrieveKeyValue(string $keyName, mixed $timestamp): ?array
    {
        $retrieve = function () use ($keyName, $timestamp) {
            $record = $this->keyValueService->getKeyValue($keyName, $timestamp !== null ? (string)$timestamp : '');

            return $record !== null ? ['value' => $record->key_value] : null;
        };

        if ($timestamp !== null) {
            return $retrieve();
        }

        return Cache::remember("keyvalues:{$keyName}", now()->addSeconds(self::CACHE_TTL), $retrieve);
    }

    private function getAllCurrentValues(): array
    {
        return collect($this->keyValueService->getAllKeyValues())
            ->mapWithKeys(fn($record) => [
                $record->key_name => $record->key_value,
            ])
            ->all();
    }
}
