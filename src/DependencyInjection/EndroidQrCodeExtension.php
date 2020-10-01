<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\QrCodeBundle\DependencyInjection;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Builder\BuilderFactoryInterface;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\ErrorCorrectionLevelInterface;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\LabelAlignmentInterface;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class EndroidQrCodeExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = $this->getConfiguration($configs, $container);

        if (!$configuration instanceof ConfigurationInterface) {
            throw new \Exception('Configuration not found');
        }

        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        foreach ($config as $builderName => $builderConfig) {
            $this->createBuilderDefinition($builderName, $builderConfig, $container);
        }
    }

    private function createBuilderDefinition(string $builderName, array $builderConfig, ContainerBuilder $container): void
    {
        $id = sprintf('endroid_qr_code.%s_builder', $builderName);

        $builderDefinition = new ChildDefinition(BuilderInterface::class);

        foreach ($builderConfig as $option => $value) {
            switch ($option) {
                case 'writer':
                    $value = new Reference($value);
                    break;
                case 'encoding':
                    $value = new Definition(Encoding::class, [$value]);
                    break;
                case 'errorCorrectionLevel':
                    $value = new Definition('Endroid\\QrCode\\ErrorCorrectionLevel\\'.ucfirst($value));
                    break;
                case 'labelAlignment':
                    $value = new Definition('Endroid\\QrCode\\LabelAlignment\\'.ucfirst($value));
                    break;
                default:
                    break;
            }

            $builderDefinition->addMethodCall($option, [$value]);
            $builderDefinition->setPublic(true);
        }

        $container->setDefinition($id, $builderDefinition);

        if (method_exists($container, 'registerAliasForArgument')) {
            $container->registerAliasForArgument($id, BuilderInterface::class, $builderName.'QrCodeBuilder')->setPublic(false);
        }
    }
}
