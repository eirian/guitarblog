<?php 
namespace Eirian\GuitarBlog;

use Symfony\Component\Yaml\Yaml;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;

class Application extends \Silex\Application
{
    private
        $configuration;
    
    public function __construct($configurationFile)
    {
        parent::__construct();

        $this->loadConfiguration($configurationFile);
        $this->initializeDatabase();
        $this->initializeTemplateEngine();
        $this->mountControllerProviders();
    }

    private function loadConfiguration($configurationFile)
    {
        if(! is_file($configurationFile))
        {
            throw new \Exception("Configuration not found at location [$configurationFile]");
        }   
        
        $this->configuration = Yaml::parse($configurationFile);
    }

    private function initializeDatabase()
    {
        if(! isset($this->configuration['db']['user'])
        || ! isset($this->configuration['db']['password']))
        {
            throw new \Exception('Missing database configuration (expecting db/user and db/password');
        }

        $this->register(new DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver'   => 'pdo_mysql',
                'host'     => 'localhost',
                'dbname'   => $this->configuration['db']['name'],
                'user'     => $this->configuration['db']['user'],
                'password' => $this->configuration['db']['password'],
                'charset'  => 'utf8'
            ),
        ));
    }
    
    private function initializeTemplateEngine()
    {
        $this->register(new TwigServiceProvider(), array(
            'twig.path'    => array(__DIR__ . '/../www/views'),
            'twig.options' => array('cache' => false), //$this['cache.path']),
        ));
    }
  
    private function mountControllerProviders()
    {
        $this->register(new ServiceControllerServiceProvider());

        $this->mount('/', new Controllers\DefaultControllerProvider());
    }    
}
	
		