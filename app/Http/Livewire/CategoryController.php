<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use Livewire\WithPagination;

class CategoryController extends Component
{
    use WithPagination;

    public $category, $identificador;

    public $name;

    public $user_id = '';

    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';

    public $readyToLoad = false;

    public $cant = '10';

    public $open = false;
    public $open_delete = false;

    protected $listeners = ['renderizar' => 'render'];
    protected $rules = [
        'category.name' => 'required|string|max:50',
        'category.description' => 'nullable|string|max:255',
    ];
    protected $messages = [
        'category.name.required' => 'Este campo es requerido',
        'category.name.string' => 'El valor no es correcto',
        'category.name.max' => 'Solo se permite 50 caracteres',
        'category.description.string' => 'El valor no es correcto',
        'category.description.max' => 'Solo se permite 255 caracteres',
    ];

    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'id'],
        'search' => ['except' => ''],
        'direction' => ['except' => 'desc'],
    ];

    public function mount(Category $category)
    {
        $this->identificador = rand();

        $this->category = $category;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->readyToLoad) {
            $categories = Category::where('name', 'like', '%' . $this->search . '%')
                ->orwhere('description', 'like', '%' . $this->search . '%')
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
        } else {
            $categories = [];
        }
        return view('livewire.category', compact('categories'));
    }

    public function loadCategories()
    {
        $this->readyToLoad = true;
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function edit(Category $category)
    {
        $this->category = $category;
        $this->open = true;
    }

    public function confirmDelete($id)
    {
        //$article->delete();
        $this->open_delete = $id;
    }

    public function delete(Category $category)
    {
        $category->delete();
        $this->open_delete = false;
        session()->flash('message', 'Categoria eliminado exitosamente');
    }

    public function update()
    {
        if (isset($this->category->id)) {
            $this->validate();
            $this->user_id = auth()->user()->id;
            $this->category->save();
            session()->flash('message', 'Categoria actualizado exitosamente');
        } else {
            $this->validate();
            $this->user_id = auth()->user()->id;
            Category::create([
                'user_id' => $this->user_id,
                'name' => $this->category['name'],
                'description' => $this->category['description'],
            ]);
            session()->flash('message', 'Categoria creado exitosamente');
        }
        //resetar modal y formulario
        $this->reset(['open']);
        $this->reset(['category']);
    }
    public function updatingOpen()
    {
        if ($this->open == false) {
            $this->reset(['category']);
        }
    }
}
