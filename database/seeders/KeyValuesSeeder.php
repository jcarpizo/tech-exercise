<?php

namespace Database\Seeders;

use App\Services\KeyValue\KeyValueInterface;
use Illuminate\Database\Seeder;

class KeyValuesSeeder extends Seeder
{
    /**
     * @var KeyValueInterface
     */
    private KeyValueInterface $keyValueService;

    /**
     * @param KeyValueInterface $keyValueService
     */
    public  function __construct(KeyValueInterface $keyValueService)
    {
        $this->keyValueService = $keyValueService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i <= 9; $i++) {
            sleep(5);
            $keyValue = substr(md5((string)mt_rand()), 0, 7);
            $this->keyValueService->storeKeyValue($keyValue, $keyValue);
        }
    }
}
