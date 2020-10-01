<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\QrCodeBundle\Controller;

use Cassandra\Cluster\Builder;
use Endroid\QrCode\Builder\BuilderFactoryInterface;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class GenerateController
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(string $profile, string $data): Response
    {
        dump($this->container->get('endroid_qr_code.'.$profile.'_builder'));

        die;

        dump($profile);
        dump($data);
        die('a');

        $builder = $this->builderFactory->create('default')
            ->withData($data)
        ;

        return new QrCodeResponse($builder->getWriter());
    }
}
