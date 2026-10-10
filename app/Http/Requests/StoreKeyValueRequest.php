<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\KeyValues;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreKeyValueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $data = $this->all();

            if (count($data) !== 1) {
                $validator->errors()->add('payload', 'Exactly one key-value pair is required.');
                return;
            }

            $keyName = (string)array_key_first($data);

            if (KeyValues::where('key_name', $keyName)->exists()) {
                $validator->errors()->add($keyName, 'This key already exists.');
            }
        });
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $data = $this->all();

                if (count($data) !== 1 || in_array(reset($data), [null, ''], true)) {
                    $validator->errors()->add(
                        'payload',
                        'Exactly one key-value pair is required.'
                    );
                }
            },
        ];
    }
}
