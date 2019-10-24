<?php 

namespace Royalcms\Component\WeChat;

use Illuminate\Contracts\Support\DeferrableProvider;
use Royalcms\Component\Support\ServiceProvider;
use Royalcms\Component\WeChat\Foundation\WeChat as WeChatContainer;

class WeChatServiceProvider extends ServiceProvider implements DeferrableProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;
	
	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{ 
	    //
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
	    $this->package('royalcms/wechat');
	    
		$this->registerWeChat();
		

		// Load the alias
		$this->loadAlias();
	}
	
	/**
	 * Bind Memcahce classes
	 * @return void
	 */
	protected function registerWeChat()
	{
	    $this->royalcms->singleton('wechat', function($royalcms)
	    {
            return new WeChatContainer();
	    });

        $this->registerBase();
	}
	
	/**
	 * Register basic providers.
	 */
	protected function registerBase()
	{
        $royalcms = $this->royalcms;

	    $wechat = $this->royalcms['wechat'];

        $wechat->singleton('request', function ($wechat) use ($royalcms) {
            return $royalcms['request'];
        });

        $wechat->singleton('cache', function ($wechat) use ($royalcms) {
            return $royalcms['cache'];
        });
	}
	
	/**
	 * Load the alias = One less install step for the user
	 */
	protected function loadAlias()
	{
	    $this->royalcms->booting(function()
	    {
	        $loader = \Royalcms\Component\Foundation\AliasLoader::getInstance();
	        $loader->alias('RC_WeChat', 'Royalcms\Component\WeChat\Facades\WeChat');
	    });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('wechat');
	}

}
