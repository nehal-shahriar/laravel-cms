<?php

namespace App\Http\Livewire;
use App\Models\Page;
use Livewire\Component;

class Pages extends Component
{
    public $modalFormVisible=false;
    public $slug;
    public $title;
    public $content;
    
    /**
     * show the form modal
     * of the create function
     *
     * @return void
     */
    public function createShowModal(){
        $this->modalFormVisible=true;
    }
    public function render()
    {
        return view('livewire.pages');
    }
}