<?php
/**
 *   框架入口文件
 */

use Illuminate\Database\Capsule\Manager;
use  Illuminate\Support\Fluent;


// 引入composer的自动加载
require __DIR__ . '/../vendor/autoload.php';

// 实例化服务容器
$app = new \Illuminate\Container\Container();

// 将服务容器添加为静态属性
\Illuminate\Container\Container::setInstance($app);

// 注册 事件容器和路由
with(new \Illuminate\Events\EventServiceProvider($app))->register();
with(new \Illuminate\Routing\RoutingServiceProvider($app))->register();
// 启动Eloquent ORM 模块并进行相关配置
$manager = new Manager();
$manager->addConnection(require '../config/database.php');
$manager->bootEloquent();

// 将config与Fluent类的实例进行绑定
$app->instance('config',new Fluent());
$app['config']['view.compiled'] = __DIR__.'/../storage/framework/views';
$app['config']['view.paths'] = [__DIR__.'/../resource/views'];
with(new \Illuminate\View\ViewServiceProvider($app))->register();
with(new \Illuminate\Filesystem\FilesystemServiceProvider($app))->register();

// 加载路由
require __DIR__.'/../app/Http/routes.php';

$request = \Illuminate\Http\Request::createFromGlobals();

// 路由分发
$response = $app['router']->dispatch($request);

//返回响应
$response->send();

