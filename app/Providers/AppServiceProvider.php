<?php

namespace App\Providers;

use App\Contracts\Interfaces\CategoryInterface;
use App\Contracts\Interfaces\CourseInterface;
use App\Contracts\Interfaces\ModuleMaterialInterface;
use App\Contracts\Interfaces\QuizInterface;
use App\Contracts\Interfaces\QuizOptionInterface;
use App\Contracts\Repository\CategoryRepository;
use App\Contracts\Repository\CourseRepository;
use App\Contracts\Repository\ModuleMaterialRepository;
use App\Contracts\Repository\QuizOptionRepository;
use App\Contracts\Repository\QuizRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    private array $register = [
        CategoryInterface::class => CategoryRepository::class,
        CourseInterface::class => CourseRepository::class,
        ModuleMaterialInterface::class => ModuleMaterialRepository::class,
        QuizInterface::class => QuizRepository::class,
        QuizOptionInterface::class => QuizOptionRepository::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->register as $interface => $repository) $this->app->bind($interface, $repository);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}