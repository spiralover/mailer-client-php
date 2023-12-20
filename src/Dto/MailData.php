<?php

namespace SpiralOver\Mailer\Client\Dto;

readonly class MailData extends BaseDto
{
    public function __construct(
        public string   $subject,
        public string   $message,
        public ?Mailbox $from,
        public array    $receiver,
        public array    $cc,
        public array    $bcc,
        public array    $reply_to,
    )
    {
    }

    /**
     * @param Mailbox|null $from
     * @param Mailbox[] $receiver
     * @param Mailbox[] $cc
     * @param Mailbox[] $bcc
     * @param Mailbox[] $reply_to
     * @param string $subject
     * @param string $message
     * @return static
     */
    public static function create(
        string   $subject,
        string   $message,
        ?Mailbox $from,
        array    $receiver = [],
        array    $cc = [],
        array    $bcc = [],
        array    $reply_to = [],
    ): static
    {
        return new static(
            subject: $subject,
            message: $message,
            from: $from,
            receiver: $receiver,
            cc: $cc,
            bcc: $bcc,
            reply_to: $reply_to
        );
    }
}