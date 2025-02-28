<?php

declare(strict_types=1);

namespace Mobicms\Captcha;

final readonly class Font
{
    public function __construct(
        private string $path,
        private int $size,
        private FontCaseEnum $case = FontCaseEnum::DEFAULT
    ) {
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getCase(): FontCaseEnum
    {
        return $this->case;
    }
}
