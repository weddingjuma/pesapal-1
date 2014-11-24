<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 18/11/14
 * Time: 10:35
 */
namespace Pesapal;
use Pesapal\Config;
use Pesapal\Entities\Order;
use Pesapal\Requests\GenerateIframe;
use Pesapal\Container;

class Pesapal
{
    /**
     * @var Config
     */
    protected $config;
    protected $bootstrap;
    protected static $instance;
    protected $container;

    private function __construct(Config $config)
    {
        $this->config = $config;

        Container::make()->run();
        Container::make()->setConfig($config);
        Container::make()->setBootstrap($config);
        Container::make()->setOauthCredentials($config);
    }


    static function make(Config $config)
    {
        if (!self::$instance) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }


    function generateIframe(Order $order)
    {
        $commandBus=Container::make()->getContainer()->get('commandBus');
        $commandBus->handle(new GenerateIframe($order));
    }
    /**
     * @return \DI\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    function ipn($data)
    {

    }


} 