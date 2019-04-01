<?php

class MessageData
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $purseNumber;

    /**
     * @var string
     */
    private $sum;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getPurseNumber(): string
    {
        return $this->purseNumber;
    }

    public function setPurseNumber(string $purseNumber): self
    {
        $this->purseNumber = $purseNumber;

        return $this;
    }

    public function getSum(): string
    {
        return $this->sum;
    }

    public function setSum(string $sum): self
    {
        $this->sum = $sum;

        return $this;
    }
}

class MessageParser
{
    /**
     * @throws Exception
     */
    public function parse(string $message): MessageData
    {
        return
            (new MessageData())
                ->setCode($this->parseCode($message))
                ->setPurseNumber($this->parsePurseNumber($message))
                ->setSum($this->parseSum($message))
            ;
    }

    /**
     * @throws Exception
     */
    private function parseCode(string $message): string
    {
        preg_match('/(пароль|код)[:\- ]*(\d{4,})/ui', $message, $matches);

        if (empty($matches)) {
            throw new Exception($message);
        }

        return $matches[2] ?? '';
    }

    /**
     * @throws Exception
     */
    private function parsePurseNumber(string $message): string
    {
        preg_match('/(сч(е|ё)т|кошел(е|ё)к)\s*(41001\d{7,11})/ui', $message, $matches);

        if (empty($matches)) {
            throw new Exception($message);
        }

        return $matches[4] ?? '';
    }

    /**
     * @throws Exception
     */
    private function parseSum(string $message): string
    {
        preg_match('/(\d+([.,]\d{1,2})?)\s*(р(уб)?|rub)/ui', $message, $matches);

        if (empty($matches)) {
            throw new Exception($message);
        }

        return $matches[1] ?? '';
    }
}
