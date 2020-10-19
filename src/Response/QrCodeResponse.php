<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\QrCodeBundle\Response;

use Endroid\QrCode\Writer\ResultInterface;
use Symfony\Component\HttpFoundation\Response;

class QrCodeResponse extends Response
{
    public function __construct(ResultInterface $result)
    {
        parent::__construct($result->getString(), Response::HTTP_OK, ['Content-Type' => $result->getMimeType()]);
    }
}
