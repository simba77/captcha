<?php

declare(strict_types=1);

namespace Mobicms\Captcha;

/**
 * @psalm-api
 */
final readonly class CaptchaFactory
{
    public static function create(): Image
    {
        $config = new Config();
        $codeGenerator = new CodeGenerator($config);
        $fontCollection = new FontCollection($config);

        $fontsOptions = [
            '3dlet.ttf'          => [
                'size' => 16,
                'case' => FontCaseEnum::LOWER,
            ],
            'baby_blocks.ttf'    => [
                'size' => -8,
                'case' => FontCaseEnum::DEFAULT,
            ],
            'karmaticarcade.ttf' => [
                'size' => -4,
                'case' => FontCaseEnum::DEFAULT,
            ],
            'betsy_flanagan.ttf' => [
                'size' => 4,
                'case' => FontCaseEnum::DEFAULT,
            ],
        ];

        $fontCollection->addFolder(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'fonts', $fontsOptions);

        return new Image($config, $codeGenerator, $fontCollection);
    }
}
