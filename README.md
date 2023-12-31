# Mail PHP Client

Mail Router PHP Client

## Getting started

> composer require spiralover/mailer-client

## Usage

### Application Management

```php
<?php

use SpiralOver\Mailer\Client\Application;

require __DIR__ . '/vendor/autoload.php';

$client  = Application::client(authToken: '<authentication-token>');

// List
$applications = $client->list();

// Create
$created = $client->create(
    name: 'My Application 1',
    url: 'localhost:7788',
    webhook: 'localhost:7788/webhook',
    desc: 'Hello World',
);

// Update
$updated = $client->update(
    id: $created->application_id,
    name: 'My Application 1',
    url: 'localhost:7788',
    webhook: 'localhost:7788/webhook',
    desc: 'Hello World',
);

// Fetch Info
$viewed = $application->read('2eb91dc3-b8ad-4d41-a207-963cec055fac');

// Delete
$message = $application->delete($created->neuron_id);

```

### Sending Emails

Sending mails to receivers

```php
<?php

use GuzzleHttp\Exception\GuzzleException;
use SpiralOver\Mailer\Client\Dto\Mailbox;
use SpiralOver\Mailer\Client\Dto\MailData;
use SpiralOver\Mailer\Client\Exceptions\RequestFailureException;
use SpiralOver\Mailer\Client\Mailer;

require __DIR__ . '/vendor/autoload.php';

$client  = Mailer::client(authToken: '<authentication-token>');
$response = $client->send(
    appId: '2eb91dc3-b8ad-4d41-a207-963cec055fab',
    mails: [
        MailData::create(
            subject: 'Test 001',
            message: 'Hello World',
            from: Mailbox::create(
                name: 'SpiralOver',
                email: 'noreply@spiralover.com'
            ),
            receiver: [
                Mailbox::create(
                    name: 'Jane Doe',
                    email: 'jane.doe@spiralover.com'
                )
            ]
        )
    ]
);
```

You can also specify **cc**, **bcc** & **reply to**
```php
MailData::create(
    [...],
    cc: [
        Mailbox::create(
            name: 'Jane',
            email: 'jane@spiralover.com'
        )
    ],
    bcc: [
        Mailbox::create(
            name: 'Shaheed',
            email: 'shaheed@spiralover.com'
        )
    ],
    reply_to: [
        Mailbox::create(
            name: 'Tom Tucker',
            email: 'tom.tucker@spiralover.com'
        )
    ]
);
```


## Client Options

```php
<?php

use SpiralOver\Mailer\Client\Application;

require __DIR__ . '/vendor/autoload.php';

$client  = Application::client(
    authToken: '<authentication-token>',
    server: Application::SERVER_SPIRALOVER,
    apiVersion: 'v1'
);
```


Enjoy 😎