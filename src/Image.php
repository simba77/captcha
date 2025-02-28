<?php

declare(strict_types=1);

namespace Mobicms\Captcha;

use GdImage;

use function base64_encode;
use function count;
use function imagecolorallocate;
use function imagecolorallocatealpha;
use function imagecreatetruecolor;
use function imagedestroy;
use function imagefill;
use function imagepng;
use function imagesavealpha;
use function imagettftext;
use function ob_get_clean;
use function ob_start;
use function random_int;
use function strtolower;
use function strtoupper;

final readonly class Image
{
    public function __construct(
        private Config $config,
        private CodeGeneratorInterface $codeGenerator,
        private FontProviderInterface $fontProvider,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function getImage(): string
    {
        ob_start();
        $image = imagecreatetruecolor($this->config->imageWidth, $this->config->imageHeight);

        if ($image !== false) {
            $color = imagecolorallocatealpha($image, 0, 0, 0, 127);

            if ($color !== false) {
                imagesavealpha($image, true);
                imagefill($image, 0, 0, $color);
                $image = $this->drawText($image);
                imagepng($image);
                imagedestroy($image);
            }
        }

        return 'data:image/png;base64,' . base64_encode((string) ob_get_clean());
    }

    /**
     * @throws \Exception
     */
    private function drawText(GdImage $image): GdImage
    {
        $fontsList = $this->fontProvider->getFontsList();
        $font = $fontsList[random_int(0, count($fontsList) - 1)];
        $symbols = str_split($this->codeGenerator->getCode());
        $len = count($symbols);

        foreach ($symbols as $key => $symbol) {
            if ($this->config->fontMix) {
                $font = $fontsList[random_int(0, count($fontsList) - 1)];
            }

            $letter = $this->setLetterCase($symbol, $font);
            $xPos = intval(($this->config->imageWidth - $font->getSize()) / $len) * $key + intval($font->getSize() / 2);
            $xPos = random_int($xPos, $xPos + 5);
            $yPos = $this->config->imageHeight - intval(($this->config->imageHeight - $font->getSize()) / 2);
            $angle = random_int(-25, 25);
            $color = imagecolorallocate($image, random_int(0, 150), random_int(0, 150), random_int(0, 150));

            if ($color !== false) {
                imagettftext($image, $font->getSize(), $angle, $xPos, $yPos, $color, $font->getPath(), $letter);
            }
        }

        return $image;
    }

    private function setLetterCase(string $string, Font $font): string
    {
        return match ($font->getCase()) {
            FontCaseEnum::UPPER => strtoupper($string),
            FontCaseEnum::LOWER => strtolower($string),
            default => $string,
        };
    }

    public function getCode(): string
    {
        return $this->codeGenerator->getCode();
    }
}
