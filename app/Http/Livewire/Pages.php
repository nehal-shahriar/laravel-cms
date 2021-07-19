<?php

namespace App\Http\Livewire;
use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Pages extends Component
{
    use WithPagination;
    public $modalFormVisible=false;
    public $modalConfirmDeleteVisible=false;
    public $modelId;
    public $slug;
    public $title;
    public $content;

    public function rules(){
        return [
            'title'=>'required',
            'slug'=>['required', Rule::unique('pages','slug')->ignore($this->modelId)],
            'content'=>'required',
        ];
    }

    public function mount(){
        $this->resetPage();
    }

    public function create(){
        $this->validate();
        Page::create($this->modelData());
        $this->modalFormVisible=false;
        $this->resetVars();
    }

    

    public function generateSlug(){
        $this->slug=Str::slug($this->title,'-');
    }
    
    public function update(){
        $this->validate();
        Page::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible=false;
        $this->resetVars();
    }

    public function delete(){
        Page::destroy($this->modelId);
        $this->modalConfirmDeleteVisible=false;
        $this->resetPage();
    }
    /**
     * show the form modal
     * of the create function
     *
     * @return void
     */
    public function createShowModal(){
        $this->resetValidation();
        $this->resetVars();
        $this->modalFormVisible=true;
    }

    public function updateShowModal($id){
        $this->resetValidation();
        $this->resetVars();
        $this->modelId=$id;
        $this->modalFormVisible=true;
        $this->loadModel();
    }

    public function deleteShowModal($id){
        $this->modelId=$id;
        $this->modalConfirmDeleteVisible=true;
    }
     
    public function loadModel(){
        $data=Page::find($this->modelId);
        $this->title=$data->title;
        $this->slug=$data->slug;
        $this->content=$data->content;
    }

    public function modelData(){
        return [
            'title'=>$this->title,
            'slug'=>$this->slug,
            'content'=>$this->content,
        ];
    }

    public function resetVars(){
        $this->modelId=null;
        $this->title=null;
        $this->slug=null;
        $this->content=null;
    }
    public function render()
    {
        $data=Page::paginate(2);
        return view('livewire.pages', ['data'=>$data]);
    }
}
