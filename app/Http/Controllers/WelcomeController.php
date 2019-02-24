<?php
/**
 * Created by PhpStorm.
 * User: run
 * Date: 2019/2/24
 * Time: 13:30
 */

namespace App\Http\Controllers;


use App\Models\Student;
use Illuminate\Container\Container;

class WelcomeController
{
    public function index()
    {
        // 找到students表中的第一条数据
        $student = Student::first();
        $data = $student->getAttributes();

        // 获取服务容器的实例
        $app =Container::getInstance();
        $factory = $app->make('view');
        return $factory->make('welcome')->with('data',$data);
    }
}