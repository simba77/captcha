<?php

declare(strict_types=1);

namespace Mobicms\Captcha;

interface FontProviderInterface
{
    /** @return array<Font> */
    public function getFontsList(): array;
}
