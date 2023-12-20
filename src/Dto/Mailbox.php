<?php

namespace SpiralOver\Mailer\Client\Dto;

readonly class Mailbox extends BaseDto
{
    public function __construct(
        public string  $name,
        public string  $email,
    ){}

    public static function create(string $name, string $email): static
    {
        return new static($name, $email);
    }
}