<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class WithoutOwnId implements Rule
{
    private ?int $modelId, $requestId;

    public function __construct(?int $modelId = null, ?int $requestId = null)
    {
        $this->modelId = $modelId;
        $this->requestId = $requestId;
    }

    public function passes($attribute, $value)
    {
        if (empty($this->modelId) || empty($this->requestId))
            return true;

        return $this->modelId != $this->requestId;
    }

    public function message()
    {
        return 'Invalid option selected.';
    }
}
