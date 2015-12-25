<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Group;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        $abilities = config('ability');

        foreach ($abilities as $ability => $key)
        {
            foreach ($key as $row => $level)
            {
                $gate->define($row .'-'. $ability, function($user, $rules = 'greater') use ($level) {
                    $group = auth()->user()->level;
                    //dd($group);
                    $result = false;

                    switch ($rules)
                    {
                        case 'greater':
                            if (is_array($level))
                            {
                                foreach ($level as $lv)
                                {
                                    if ($group >= $lv)
                                    {
                                        $result = true;
                                    }
                                }
                            }
                            else
                            {
                                $result = $group >= $level;
                            }
                            break;
                        case 'lesser':
                            if (is_array($level))
                            {
                                foreach ($level as $lv)
                                {
                                    if ($group <= $lv)
                                    {
                                        $result = true;
                                    }
                                }
                            }
                            else
                            {
                                $result = $group <= $level;
                            }
                            break;
                        case 'strict':
                            if (is_array($level))
                            {
                                foreach ($level as $lv)
                                {
                                    if ($group == $lv)
                                    {
                                        $result = true;
                                    }
                                }
                            }
                            else
                            {
                                $result = $group == $level;
                            }
                            break;                    
                    }

                    return $result;
                });
            }
        }
    }
}
