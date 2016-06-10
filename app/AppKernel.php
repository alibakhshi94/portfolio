<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),

            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),

            new Liip\FunctionalTestBundle\LiipFunctionalTestBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Sensio\Bundle\BuzzBundle\SensioBuzzBundle(),

            new Sonata\CacheBundle\SonataCacheBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\SeoBundle\SonataSeoBundle(),

            new Vich\UploaderBundle\VichUploaderBundle(),

            new Stfalcon\Bundle\BlogBundle\StfalconBlogBundle(),
            new Stfalcon\Bundle\PortfolioBundle\StfalconPortfolioBundle(),
            new Stfalcon\ReCaptchaBundle\StfalconReCaptchaBundle(),

            new Application\Bundle\DefaultBundle\ApplicationDefaultBundle(),

            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
            new FOS\UserBundle\FOSUserBundle(),
            new Application\Bundle\UserBundle\ApplicationUserBundle(),
            new Avalanche\Bundle\ImagineBundle\AvalancheImagineBundle(),
            new Sonata\MediaBundle\SonataMediaBundle(),
            new Application\Bundle\MediaBundle\ApplicationMediaBundle(),

            new JMS\TranslationBundle\JMSTranslationBundle(),
            new JMS\I18nRoutingBundle\JMSI18nRoutingBundle(),
            new A2lix\TranslationFormBundle\A2lixTranslationFormBundle(),
            new Stfalcon\RedirectBundle\StfalconRedirectBundle(),
            new Fresh\Bundle\DoctrineEnumBundle\FreshDoctrineEnumBundle(),
            new Hype\MailchimpBundle\HypeMailchimpBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),

            new IAkumaI\SphinxsearchBundle\SphinxsearchBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

//        if ($this->getEnvironment() == 'test') {
//            $bundles[] = new Behat\BehatBundle\BehatBundle();
//            $bundles[] = new Behat\MinkBundle\MinkBundle();
//        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
