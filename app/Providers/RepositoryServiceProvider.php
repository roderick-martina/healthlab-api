<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Eloquent \{
    EloquentBodpodRepository,
    EloquentMbcaRepository,
    EloquentUserRepository,
    EloquentCustomFieldRepository,
    EloquentPatientRepository,
    EloquentPatientCustomFieldRepository
};

use App\Repositories\Contracts \{
    BodpodRepository,
    MbcaRepository,
    UserRepository,
    CustomFieldRepository,
    PatientRepository,
    PatientCustomFieldRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(BodpodRepository::class, EloquentBodpodRepository::class);
        $this->app->bind(MbcaRepository::class, EloquentMbcaRepository::class);
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(CustomFieldRepository::class, EloquentCustomFieldRepository::class);
        $this->app->bind(PatientRepository::class, EloquentPatientRepository::class);
        $this->app->bind(PatientCustomFieldRepository::class, EloquentPatientCustomFieldRepository::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
