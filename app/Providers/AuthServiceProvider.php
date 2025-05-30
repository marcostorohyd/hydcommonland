<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\User::class => \App\Policies\AccountPolicy::class,
        \App\DemoCaseStudy::class => \App\Policies\DemoCaseStudyPolicy::class,
        \App\Directory::class => \App\Policies\DirectoryPolicy::class,
        \App\Event::class => \App\Policies\EventPolicy::class,
        \App\MediaLibrary::class => \App\Policies\MediaLibraryPolicy::class,
        \App\News::class => \App\Policies\NewsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
