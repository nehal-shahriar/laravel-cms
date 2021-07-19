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
    public $isSetToDefaultHomePage;
    public $isSetToDefaultNotFoundPage;

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
        $this->unassignDefaultHomepage();
        $this->unassignDefaultNotFoundpage();
        Page::create($this->modelData());
        $this->modalFormVisible=false;
        $this->reset();
    }

    

    public function generateSlug(){
        $this->slug=Str::slug($this->title,'-');
    }
    
    public function update(){
        $this->validate();
        $this->unassignDefaultHomepage();
        $this->unassignDefaultNotFoundpage();
        Page::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible=false;
        $this->reset();
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
        $this->reset();
        $this->modalFormVisible=true;
    }

    public function updateShowModal($id){
        $this->resetValidation();
        $this->reset();
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
        $this->isSetToDefaultHomePage=!$data->is_default_home ? null:true;
        $this->isSetToDefaultNotFoundPage=!$data->is_default_not_found ? null:true;
    }

    public function updatedIsSetToDefaultHomePage(){
        $this->isSetToDefaultNotFoundPage=null;
    }

    public function updatedIsSetToDefaultNotFoundPage(){
        $this->isSetToDefaultHomePage=null;
    }

    private function unassignDefaultHomepage(){
        if($this->isSetToDefaultHomePage !=null){
            Page::where('is_default_home', true)->update(['is_default_home'=>false]);
        }
    }

    private function unassignDefaultNotFoundpage(){
        if($this->isSetToDefaultNotFoundPage !=null){
            Page::where('is_default_not_found', true)->update(['is_default_not_found'=>false]);
        }
    }

    public function modelData(){
        return [
            'title'=>$this->title,
            'slug'=>$this->slug,
            'content'=>$this->content,
            'is_default_home'=>$this->isSetToDefaultHomePage,
            'is_default_not_found'=>$this->isSetToDefaultNotFoundPage,
        ];
    }

    
    public function render()
    {
        $data=Page::paginate(5);
        return view('livewire.pages', ['data'=>$data]);
    }
}
