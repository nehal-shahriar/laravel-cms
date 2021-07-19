<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;

class Frontpage extends Component
{
    public $title;
    public $content;
    public $urlslug;

    public function mount($urlslug = null)
    {
        $this->retrieveContent($urlslug);
    }

    public function retrieveContent($urlslug)
    {
        // Get home page if slug is empty
        if (empty($urlslug)) {
            $data = Page::where('is_default_home', true)->first();
        } else {
            //Get the page according to the slug value
            $data = Page::where('slug', $urlslug)->first();

            // If we can't retireve anything from slug value(slug is not present in db)
            if(!$data){
                $data = Page::where('is_default_not_found',true)->first();
            }
        }

        $this->title = $data->title;
        $this->content = $data->content;
    }
    public function render()
    {
        return view('livewire.frontpage')->layout('layouts.frontpage');
    }
}
