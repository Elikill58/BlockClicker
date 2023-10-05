<?php

namespace Azuriom\Plugin\BlockClicker\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;

class BlockClickerServiceProvider extends BasePluginServiceProvider
{
    /**
     * Register any plugin services.
     *
     * @return void
     */
    public function register()
    {

        $this->registerMiddlewares();
    }

    /**
     * Bootstrap any plugin services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViews();

        $this->loadTranslations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        Permission::registerPermissions([
            'blockclicker.admin' => 'blockclicler::permissions.admin'
        ]);
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array
     */
    protected function routeDescriptions()
    {
        return [
            'positivity.index' => trans('positivity::messages.title'),
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array
     */
    protected function adminNavigation()
    {
        return [
            'blockclicker' => [
                'name'       => trans('blockclicker::admin.title'), // Traduction du nom de l'onglet
                'permission' => 'blockclicker.admin',
                'icon'       => 'bi bi-box', // Icône FontAwesome
                'route'      => 'blockclicker.admin.index', // Route de la page
            ],
        ];
    }
}
