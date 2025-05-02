<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    protected bool $success;
    protected ?string $message;
    protected int $code;

    public function __construct($resource, bool $success = true, ?string $message = null, int $code = 200)
    {
        parent::__construct($resource);

        $this->success = $success;
        $this->message = $message;
        $this->code = $code;
    }

    public static function success($data, ?string $message = null, int $code = 200): self
    {
        return new self($data, true, $message, $code);
    }

    public static function error(?string $message = 'An error occurred.', int $code = 400): self
    {
        return new self(null, false, $message, $code);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'success' => $this->success,
            'code' => $this->code,
            'data' => $this->success ? parent::toArray($request) : null,
            'message' => $this->message,
        ];
    }
}
