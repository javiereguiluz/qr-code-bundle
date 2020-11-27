<?php

declare(strict_types=1);

namespace Endroid\QrCodeBundle\Controller;

use Endroid\QrCode\Builder\BuilderRegistryInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Symfony\Component\HttpFoundation\Response;

class GenerateController
{
    private BuilderRegistryInterface $builderRegistry;

    public function __construct(BuilderRegistryInterface $builderRegistry)
    {
        $this->builderRegistry = $builderRegistry;
    }

    public function __invoke(string $name, string $data): Response
    {
        $builder = $this->builderRegistry->getBuilder($name);

        return new QrCodeResponse($builder->build());
    }
}
