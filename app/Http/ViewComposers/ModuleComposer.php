<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\General;
use Auth;

class ModuleComposer
{
    /**
     * The general model.
     *
     * @var General
     */
    protected $general;

    /**
     * Create a new profile composer.
     *
     * @param  General  $general
     * @return void
     */
    public function __construct(General $general)
    {
        // Dependencies automatically resolved by service container...
        $this->general = $general;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $view->with('module', $this->general->module(Auth::user()->group_id));
        }
    }
}