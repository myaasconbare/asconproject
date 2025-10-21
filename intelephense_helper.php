<?php

namespace Illuminate\Contracts\View;

use Illuminate\Contracts\Support\Renderable;

interface View extends Renderable
{
  /** @return static */
  // fix for Vscode "Undefined method 'title'" on livewire component
  public function title();
}