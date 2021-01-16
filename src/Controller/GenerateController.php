<?php

declare(strict_types=1);

namespace Endroid\QrCodeBundle\Controller;

use Endroid\QrCode\Builder\BuilderRegistryInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Symfony\Component\HttpFoundation\Response;

class GenerateController
{
    /** @var BuilderRegistryInterface */
    private $builderRegistry;

    public function __construct(BuilderRegistryInterface $builderRegistry)
    {
        $this->builderRegistry = $builderRegistry;
    }

    public function __invoke(string $name, string $data): Response
    {
        $result = $this->builderRegistry->getBuilder($name)
            ->data($data)
            ->build()
        ;

        return new QrCodeResponse($result);
    }
}
