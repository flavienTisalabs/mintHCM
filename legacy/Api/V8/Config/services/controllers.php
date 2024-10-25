<?php

use Api\Core\Loader\CustomLoader;
use Api\V8\Controller;
use Api\V8\Service\FileService;
use Api\V8\Service\ListViewSearchService;
use Api\V8\Service\ListViewService;
use Api\V8\Service\LogoutService;
use Api\V8\Service\MetaService;
use Api\V8\Service\ModuleService;
use Api\V8\Service\RelationshipService;
use Api\V8\Service\UserPreferencesService;
use Api\V8\Service\UserService;
use Api\V8\Service\MonthInfoService;
use League\OAuth2\Server\ResourceServer;
use Psr\Container\ContainerInterface as Container;

return CustomLoader::mergeCustomArray([
    Controller\ListViewSearchController::class => function (Container $container) {
        return new Controller\ListViewSearchController(
            $container->get(ListViewSearchService::class)
        );
    },
    Controller\UserPreferencesController::class => function (Container $container) {
        return new Controller\UserPreferencesController(
            $container->get(UserPreferencesService::class)
        );
    },
    Controller\UserController::class => function (Container $container) {
        return new Controller\UserController(
            $container->get(UserService::class)
        );
    },
    Controller\MetaController::class => function (Container $container) {
        return new Controller\MetaController(
            $container->get(MetaService::class)
        );
    },
    Controller\ListViewController::class => function (Container $container) {
        return new Controller\ListViewController(
            $container->get(ListViewService::class)
        );
    },
    Controller\ModuleController::class => function (Container $container) {
        return new Controller\ModuleController(
            $container->get(ModuleService::class)
        );
    },
    Controller\LogoutController::class => function (Container $container) {
        return new Controller\LogoutController(
            $container->get(LogoutService::class),
            $container->get(ResourceServer::class)
        );
    },
    Controller\RelationshipController::class => function (Container $container) {
        return new Controller\RelationshipController(
            $container->get(RelationshipService::class)
        );
    },
    Controller\FileController::class => function (Container $container) {
        return new Controller\FileController(
            $container->get(FileService::class)
        );
    },
    Controller\MonthInfoController::class => function (Container $container) {
        return new Controller\MonthInfoController(
            $container->get(MonthInfoService::class)
        );
    },
], basename(__FILE__));
