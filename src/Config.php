<?php

declare(strict_types=1);

namespace Mobicms\Captcha;

final readonly class Config
{
    public function __construct(
        public int $imageWidth = 190,
        public int $imageHeight = 90,
        public int $defaultFontSize = 30,
        public bool $fontMix = true,
        public int $lengthMin = 4,
        public int $lengthMax = 5,
        public string $characterSet = '23456789ABCDEGHJKMNPQRSTUVXYZabcdeghjkmnpqrstuvxyz',
        public string $excludedCombinationsPattern = 'rn|rm|mm|ww',
    ) {
    }
}
