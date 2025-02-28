<?php

declare(strict_types=1);

namespace Mobicms\Captcha;

/**
 * @psalm-api
 */
final readonly class CaptchaFactory
{
    public static function create(Config $config = new Config()): Image
    {
        $codeGenerator = new CodeGenerator($config);
        $fontCollection = new FontCollection($config);

        if ($config->useBuiltinFonts) {
            $fontsOptions = [
                '3dlet.ttf'          => [
                    'size' => 46,
                    'case' => FontCaseEnum::LOWER,
                ],
                'baby_blocks.ttf'    => [
                    'size' => 22,
                    'case' => FontCaseEnum::DEFAULT,
                ],
                'karmaticarcade.ttf' => [
                    'size' => 26,
                    'case' => FontCaseEnum::DEFAULT,
                ],
                'betsy_flanagan.ttf' => [
                    'size' => 34,
                    'case' => FontCaseEnum::DEFAULT,
                ],
            ];

            $defaultFolder = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'fonts';
            $fontCollection->addFolder($defaultFolder, $fontsOptions);
        }

        foreach ($config->fontFolders as $fontFolder) {
            $fontCollection->addFolder($fontFolder['path'], $fontFolder['options']);
        }

        return new Image($config, $codeGenerator, $fontCollection);
    }
}
