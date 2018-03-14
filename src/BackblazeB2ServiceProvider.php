<?php
	/**
	 * Created by PhpStorm.
	 * User: alihamze
	 * Date: 3/13/18
	 * Time: 7:55 PM
	 */
	
	namespace TechYet\B2Provider;
	
	use Illuminate\Support\Facades\Storage;
	use Illuminate\Support\ServiceProvider;
	use League\Flysystem\Filesystem;
	use TechYet\B2\Client;
	use TechYet\B2Flysystem\B2Adapter;
	
	class BackblazeB2ServiceProvider extends ServiceProvider {
		public function boot() {
			Storage::extend('b2', function ($app, $config) {
				if (!(
					isset($config['accountId']) ||
					isset($config['applicationKey']) ||
					isset($config['bucketName']))) {
					throw new BackblazeB2ServiceProviderException('Please set all configuration keys. (accountId, applicationKey, bucketName)');
				}
				$client = new Client($config['accountId'], $config['applicationKey']);
				$adapter = new B2Adapter($client, $config['bucketName']);
				
				return new Filesystem($adapter);
			});
		}
		
		public function register() {
		
		}
	}
