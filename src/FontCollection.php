<?php

declare(strict_types=1);

namespace Mobicms\Captcha;

final class FontCollection implements FontProviderInterface
{
    /** @var array<Font> */
    private array $fonts = [];

    public function __construct(
        private readonly Config $config
    ) {
    }

    public function addFont(Font $font): void
    {
        if (! file_exists($font->getPath())) {
            throw new \InvalidArgumentException(sprintf('Font "%s" not found', $font->getPath()));
        }
        $this->fonts[] = $font;
    }

    /**
     * @param string $path
     * @param array<string, array{size: int, case: FontCaseEnum}> $fontsOptions
     * @return void
     */
    public function addFolder(string $path, array $fontsOptions = []): void
    {
        $path = rtrim($path, '/\\');
        if (! is_dir($path)) {
            throw new \InvalidArgumentException(sprintf('Folder "%s" not found', $path));
        }

        $fonts = glob($path . DIRECTORY_SEPARATOR . '*.ttf');
        if (! is_array($fonts) || $fonts === []) {
            throw new \InvalidArgumentException(sprintf('The specified folder "%s" does not contain any fonts', $path));
        }

        foreach ($fonts as $font) {
            $fontName = basename($font);

            // Change font parameters if specified
            $fontSize = $fontsOptions[$fontName]['size'] ?? $this->config->defaultFontSize;
            $fontCase = $fontsOptions[$fontName]['case'] ?? FontCaseEnum::DEFAULT;

            $this->addFont(new Font($font, $fontSize, $fontCase));
        }
    }

    /** @return array<Font> */
    #[\Override]
    public function getFontsList(): array
    {
        return $this->fonts;
    }
}
