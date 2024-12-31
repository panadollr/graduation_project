<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Lk2CmsCrud extends Command
{
    protected $signature = 'lk2_cms:crud {name}';
    protected $description = 'Generate CRUD components for the specified entity.';

    public function handle()
    {
        $name = $this->argument('name');
        $this->createLivewireComponent($name);
        $this->createViewFiles($name);
        $this->info("CRUD components for {$name} created successfully.");
    }

    protected function createLivewireComponent($name)
    {
        $modelName = ucfirst($name);
        $componentName = "{$modelName}List"; // Livewire Component name
        $directory = app_path("Http/Livewire/Admin/{$modelName}");
        $this->ensureDirectoryExists($directory);
        
        $filePath = "{$directory}/{$componentName}.php";
        $content = <<<PHP
<?php

namespace App\Livewire\Admin\\$modelName;

use App\Models\\$modelName;
use Livewire\Component;
use Livewire\WithPagination;

class {$componentName} extends Component
{
    use WithPagination;

    public \$search = ''; // Variable for filtering
    protected \$paginationTheme = 'bootstrap'; // Use Bootstrap for pagination

    // Delete model
    public function delete{$modelName}(\$id) 
    {
        \$category = $modelName::find(\$id);
        if (\$category) {
            \$category->delete();
            session()->flash('success', '{$modelName} đã được xóa thành công.');
        }
    }

    public function searchBy()
    {
        \$this->resetPage();
    }

    public function render()
    {
        \$entities = $modelName::where('name', 'like', '%' . \$this->search . '%')
            ->paginate(10); // 10 items per page

        return view('admin.$name.list.livewire.list', [
            'entities' => \$entities
        ]);
    }
}
PHP;

        File::put($filePath, $content);
        $this->info("Livewire component {$componentName} created at {$filePath}");
    }

    protected function createViewFiles($name)
    {
        $modelName = ucfirst($name);
        $componentName = strtolower($name) . '-list'; // Define the component name here
        $viewPath = resource_path("views/admin/{$name}");

        // Ensure the main directory exists
        $this->ensureDirectoryExists($viewPath);

        // Create create/index.blade.php
        $createContent = <<<BLADE
@extends('admin.app')

@section('title', isset(\$entity) ? 'Edit {$modelName}' : 'Add {$modelName}')

@section('content')
    <div class="container-scroller">
    @include('admin.partials.navbar')
    <div class="container-fluid page-body-wrapper">
        @include('admin.partials.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ isset(\$entity) ? 'Edit {$modelName}' : 'Add {$modelName}' }}</h4>

                        @if (\$errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach (\$errors->all() as \$error)
                                    <li>{{ \$error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form class="forms-sample" action="{{ isset(\$entity) ? route('admin.{$name}.update', \$entity->id) : route('admin.{$name}.store') }}" method="POST">
                        @csrf
                        @if(isset(\$entity))
                            @method('PUT') <!-- Method spoofing for update -->
                        @endif
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{ old('name', \$entity->name ?? '') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ \$message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug" placeholder="Slug" value="{{ old('slug', \$entity->slug ?? '') }}">
                            @error('slug')
                                <div class="invalid-feedback">
                                    {{ \$message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Save</button>
                        <a href="{{ route("admin.{$name}.list") }}" class="btn btn-light">Cancel</a>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        @include('admin.partials.footer')
        </div>
    </div>
    </div>
@endsection
BLADE;

        // Create the directory for 'create' first
        $this->ensureDirectoryExists("{$viewPath}/create");

        File::put("{$viewPath}/create/index.blade.php", $createContent);
        $this->info("Create index view created at {$viewPath}/create/index.blade.php");

        // Create list/livewire/list.blade.php
        $listContent = <<<BLADE
<div>
    @include('layouts.alert.success')
    @include('admin.{$name}.list.filter')

    @php
        \$rowHeight = 19; // Row height (pixels)
        \$totalHeight = max(count(\$entities), 5) * \$rowHeight; // Set minimum rows to 5
    @endphp

    <div wire:loading class="text-center my-4 justify-content-center align-items-center" style="min-height: {{ \$totalHeight }}px; width: 100%">
        <div class="spinner-grow text-primary" style="width: 5rem; height: 5rem;" role="status">
            <span class="sr-only">Please wait...</span>
        </div>
    </div>

    <div class="table-responsive" wire:loading.remove>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\$entities as \$entity)
                <tr>
                    <td>{{ \$entity->name }}</td>
                    <td>{{ \$entity->slug }}</td>
                    <td>
                        <a href="{{ route('admin.{$name}.edit', \$entity->id) }}" class="btn btn-dark btn-icon-text btn-sm"> 
                            Edit 
                        <i class="ti-file btn-icon-append"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-icon-text btn-sm" wire:click="delete{$modelName}({{\$entity->id}})"> 
                            Delete 
                        <i class="ti-trash btn-icon-append"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No {$modelName} found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <br>
    {{ \$entities->links() }}
</div>
BLADE;

        // Create directory for 'list'
        $this->ensureDirectoryExists("{$viewPath}/list/livewire");

        File::put("{$viewPath}/list/livewire/list.blade.php", $listContent);
        $this->info("List view created at {$viewPath}/list/livewire/list.blade.php");

        // Create list/index.blade.php
        $listIndexContent = <<<BLADE
@extends('admin.app')

@section('title', 'List of {$modelName}')

@section('content')
    <div class="container-scroller">
    @include('admin.partials.navbar')
    <div class="container-fluid page-body-wrapper">
        @include('admin.partials.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                <a href="{{ route('admin.{$name}.create') }}" class="btn btn-primary btn-icon-text">
                <i class="ti-plus btn-icon-prepend"></i>
                Add {$modelName}
                </a>
                <br><br>
                <div class="row">                 
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <livewire:admin.{$modelName}.{$componentName} />
                        </div>
                    </div>
                </div>
                </div>
            </div>
            @include('admin.partials.footer')
        </div>
    </div>
    </div>
@endsection
BLADE;

        // Create the directory for 'list' first
        $this->ensureDirectoryExists("{$viewPath}/list");

        File::put("{$viewPath}/list/index.blade.php", $listIndexContent);
        $this->info("List index view created at {$viewPath}/list/index.blade.php");
    }

    protected function ensureDirectoryExists($directory)
    {
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
            $this->info("Directory created at {$directory}");
        }
    }
}
