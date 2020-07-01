<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\QrCodeBundle\Response;

use Endroid\QrCode\Writer\WriterInterface;
use Symfony\Component\HttpFoundation\Response;

class QrCodeResponse extends Response
{
    public function __construct(WriterInterface $writer)
    {
        parent::__construct($writer->writeString(), Response::HTTP_OK, ['Content-Type' => $writer->getMimeType()]);
    }
}
