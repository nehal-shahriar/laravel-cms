<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;

class Bloglist extends Component
{
    public function render()
    {
        $bloglist = Page::orderBy('created_at','DESC')->get()->take(3);
        return view('livewire.bloglist',['bloglist'=>$bloglist]);
    }
}
