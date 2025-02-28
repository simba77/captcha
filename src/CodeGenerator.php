<?php

declare(strict_types=1);

namespace Mobicms\Captcha;

final class CodeGenerator implements CodeGeneratorInterface
{
    public function __construct(
        private readonly Config $config,
        private string $code = '',
    ) {
    }

    #[\Override]
    public function getCode(): string
    {
        if ($this->code === '') {
            $this->code = $this->generateCode();
        }
        return $this->code;
    }

    private function generateCode(): string
    {
        $length = random_int($this->config->lengthMin, $this->config->lengthMax);
        do {
            $code = substr(str_shuffle(str_repeat($this->config->characterSet, 3)), 0, $length);
        } while (preg_match('/' . $this->config->excludedCombinationsPattern . '/', $code));

        return $code;
    }
}
