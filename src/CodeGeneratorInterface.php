<?php

declare(strict_types=1);

namespace Mobicms\Captcha;

interface CodeGeneratorInterface
{
    public function getCode(): string;
}
