<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\QrCodeBundle\Controller;

use Endroid\QrCode\Builder\BuilderFactoryInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Symfony\Component\HttpFoundation\Response;

class GenerateController
{
    private $builderFactory;

    public function __construct(BuilderFactoryInterface $builderFactory)
    {
        $this->builderFactory = $builderFactory;
    }

    public function __invoke(string $data): Response
    {
        $builder = $this->builderFactory->create('default')
            ->withData($data)
        ;

        return new QrCodeResponse($builder->getWriter());
    }
}
