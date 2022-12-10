@extends('layouts.app')
@section('title')
    Item
@endsection
@section('style')
@endsection
@section('content')
    <div class="card">
        <div class=" card-header">
            <div class="row">
                <div class="col">
                    <div class=" text-left">
                        <a href="{{ route('items.index') }}" style="text-decoration: none;font-size:15px">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                            Back
                        </a>
                    </div>
                </div>
                <div class="col text-right">
                    <a href="#" class="btn btn-sm btn-outline-primary collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                        aria-controls="collapseTwo">

                        <i class="feather icon-plus"></i> Edit Item

                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="collapseTwo" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="card mb-1 p-2" style="background: var(--form-bg-color)">
                        <form method="POST" action="{{ route('items.edit', $item) }}">
                            @method('PUT')
                            @csrf
                            <div class="row">

                                <div class="col-sm-4 text-start mb-1">
                                    <label for="name" class=" col-form-label text-sm-start">{{ __('Name') }}</label>
                                    <input id="name" type="text" placeholder=""
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $item->name) }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-4 text-start mb-1">
                                    <label for="quantity" class=" col-form-label text-sm-start">{{ __('Quantity') }}</label>
                                    <div class="input-group">
                                        <input id="quantity" type="number" step="any" placeholder="00"
                                            class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                                            value="{{ old('quantity', $item->quantity) }}" required autocomplete="quantity"
                                            autofocus style="float: left;">
                                        <select class="form-control form-select" name="unit" required
                                            style="float: left;max-width:115px; width: inaitial; background-color:rgb(238, 238, 242)">
                                            <option value="Kilograms" {{ $item->unit == 'Kilograms' ? 'selected' : '' }}>
                                                Kilograms</option>
                                            <option value="Litres" {{ $item->unit == 'Litres' ? 'selected' : '' }}>
                                                Litres</option>
                                            <option value="Counts" {{ $item->unit == 'Counts' ? 'selected' : '' }}>
                                                Counts</option>
                                        </select>
                                        @error('quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4 text-start mb-1">
                                    <label for="cost"
                                        class="col-form-label text-sm-start">{{ __('Cost (Tsh)') }}</label>
                                    <input id="cost" type="number" placeholder="Tsh"
                                        class="form-control @error('cost', $item->cost) is-invalid @enderror" name="cost"
                                        value="{{ old('cost', $item->cost) }}" required autocomplete="cost" autofocus>
                                    @error('cost')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-1 mt-2">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-4"><b> Name:</b> </div>
                        <div class="col-8">{{ $item->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><b> Quantity:</b> </div>
                        <div class="col-8">{{ $item->quantity . ' ' . $item->unit }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><b> Cost:</b> </div>
                        <div class="col-8">{{ number_format($item->cost, 0, '.', ',') }} Tsh</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><b> Created:</b> </div>
                        <div class="col-8">{{ $item->created_at->format('D, d M Y \a\t H:i') }}</div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-4"><b> Ingredients:</b> </div>
                        <div class="col-8" style="background: rgb(234, 232, 244); border-radius:5px">
                            @forelse ($ingredients as $ingredient)
                                <span style="">
                                    {{ $ingredient->quantity . ' ' . $ingredient->unit . ' of ' . $ingredient->material->name }}
                                </span><br>

                            @empty
                                No Ingredient
                            @endforelse
                            <div class="text-end">
                                @if ($ingredients->count() == 0)
                                    <a id="edit-btn" href="#" style="text-decoration: none;"
                                        onclick="showForm1()">
                                        Add Ingredients
                                    </a>
                                @else
                                    <a id="edit-btn" href="#" style="text-decoration: none;"
                                        onclick="showForm2()">
                                        Change Ingredients
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    @if (Session::has('error'))
                        <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}
                        </p>
                    @endif
                    <div class="card"id="edit-form" style="display: none">
                        <div class="card-body">
                            @if ($ingredients->count() == 0)
                                <form method="POST" action="{{ route('items.add-ingredients', $item) }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col mb-1">
                                            <div
                                                class="input-group input-group control-group after-add-more"style="margin-bottom:10px">
                                                <select id="ingredient_name" class="form-control form-select"
                                                    name="ids[]" required style="float: left; width: inaitial; ">
                                                    <option value="">{{ 'Name' }}</option>
                                                    @foreach ($materials as $material)
                                                        <option value="{{ $material->id }}">{{ $material->name }}
                                                        </option>
                                                    @endforeach
                                                    @error('ingredient_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </select>
                                                <input id="ingredient_quantity" type="number" step="any"
                                                    placeholder="Quantity"
                                                    class="form-control @error('ingredient_quantity') is-invalid @enderror"
                                                    name="quantities[]" value="{{ old('ingredient_quantity') }}" required
                                                    autocomplete="ingredient_quantity" autofocus style="float: left;">
                                                @error('ingredient_quantity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <select id="ingredient_unit" class="form-control form-select"
                                                    name="units[]" required
                                                    style="float: left; width: inaitial; background-color:rgb(238, 238, 242)">
                                                    <option value="">Unit</option>
                                                    <option value="Kilograms">Kilograms</option>
                                                    <option value="Litres">Litres</option>
                                                    <option value="Counts">Counts</option>
                                                </select>
                                                @error('ingredient_unit')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <span class="input-group-btn">
                                                    <button class="btn btn-outline-success add-more"
                                                        type="button"style="border-top-left-radius: 0%;border-bottom-left-radius: 0%"><i
                                                            class="bx bx-plus"></i></button>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Copy Fields -->
                                        <div class="copy hide">
                                            <div class="input-group control-group" style="margin-bottom:10px">
                                                <select id="ingredient_name" class="form-control form-select"
                                                    name="ids[]" required style="float: left; width: inaitial; ">
                                                    <option value="">{{ 'Name' }}</option>
                                                    @foreach ($materials as $material)
                                                        <option value="{{ $material->id }}">{{ $material->name }}
                                                        </option>
                                                    @endforeach
                                                    @error('ingredient_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </select>
                                                <input id="ingredient_quantity" type="number" step="any"
                                                    placeholder="Quantity"
                                                    class="form-control @error('ingredient_quantity') is-invalid @enderror"
                                                    name="quantities[]" value="{{ old('ingredient_quantity') }}" required
                                                    autocomplete="ingredient_quantity" autofocus style="float: left;">
                                                @error('ingredient_quantity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <select id="ingredient_unit" class="form-control form-select"
                                                    name="units[]" required
                                                    style="float: left; width: inaitial; background-color:rgb(238, 238, 242)">
                                                    <option value="">Unit</option>
                                                    <option value="Kilograms">Kilograms</option>
                                                    <option value="Litres">Litres</option>
                                                    <option value="Counts">Counts</option>
                                                </select>
                                                @error('ingredient_unit')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <span class="input-group-btn">
                                                    <button class="btn btn-outline-danger remove"
                                                        type="button"style="border-top-left-radius: 0%;border-bottom-left-radius: 0%"><i
                                                            class="bx bx-minus"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 mt-2">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                {{ __('Submit') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <form id="update-ingredients" method="POST"
                                    action="{{ route('items.edit-ingredients', $item) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        @foreach ($ingredients as $ingredient)
                                            <div class="input-group control-group" style="margin-bottom:10px">
                                                <input hidden name="ingredient_id[]" value="{{ $ingredient->id }}"
                                                    type="text">
                                                <select disabled id="ingredient_name" class="form-control forsm-select"
                                                    name="ids[]" required style="float: left; width: inaitial; ">
                                                    @foreach ($materials as $material)
                                                        <option
                                                            value="{{ $material->id }}"{{ $ingredient->material_id == $material->id ? 'selected' : '' }}>
                                                            {{ $material->name }}</option>
                                                    @endforeach
                                                    @error('ingredient_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </select>
                                                <input id="ingredient_quantity" type="number" step="any"
                                                    placeholder="Quantity"
                                                    class="form-control @error('ingredient_quantity') is-invalid @enderror"
                                                    name="quantities[]"
                                                    value="{{ old('ingredient_quantity', $ingredient->quantity) }}"
                                                    required autocomplete="ingredient_quantity" autofocus
                                                    style="float: left;">
                                                @error('ingredient_quantity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <select id="ingredient_unit" class="form-control form-select"
                                                    name="units[]" required
                                                    style="float: left; width: inaitial; background-color:rgb(238, 238, 242)">
                                                    <option
                                                        value="Kilograms"{{ $ingredient->unit == 'Kilograms' ? 'selected' : '' }}>
                                                        Kilograms</option>
                                                    <option
                                                        value="Litres"{{ $ingredient->unit == 'Litres' ? 'selected' : '' }}>
                                                        Litres
                                                    </option>
                                                    <option
                                                        value="Counts"{{ $ingredient->unit == 'Counts' ? 'selected' : '' }}>
                                                        Counts
                                                    </option>
                                                </select>
                                                @error('ingredient_unit')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <span class="input-group-btn">
                                                    <button class="btn btn-outline-danger"
                                                        type="button"style="border-top-left-radius: 0%;border-bottom-left-radius: 0%"
                                                        onclick="if(confirm('{{ $ingredient->material->name }} will be deleted from this item\'s ingredients.')) document.getElementById('delete-ingredient-{{ $ingredient->id }}').submit()">
                                                        <i class="bx bx-trash"></i></button>

                                                </span>
                                            </div>
                                        @endforeach
                                        <div class=" mb-1">
                                            <div class="text-center">
                                                <button type="" class="btn btn-sm btn-outline-primary"
                                                    onclick="document.getElementById('update-ingredients').submit()">
                                                    {{ __('Update') }}
                                                </button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </form>
                                <form id="delete-ingredient-{{ $ingredient->id }}" method="post"
                                    action="{{ route('items.delete-ingredient', $ingredient) }}">@csrf
                                    @method('delete')
                                </form>
                                <form method="POST" action="{{ route('items.add-ingredients', $item) }}">
                                    @csrf
                                    <div class="text-right after-add-more"style="margin-bottom:10px;">
                                        <a class="add-more" type="button"style="text-decoration:none">Add
                                            Another Ingredient</a>
                                    </div>
                                    <!-- Copy Fields -->
                                    <div class="copy hide">
                                        <div class="input-group control-group" style="margin-bottom:10px">
                                            <select id="ingredient_name" class="form-control form-select" name="ids[]"
                                                required style="float: left; width: inaitial; ">
                                                <option value="">{{ 'Name' }}</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}">{{ $material->name }}</option>
                                                @endforeach
                                                @error('ingredient_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </select>
                                            <input id="ingredient_quantity" type="number" step="any"
                                                placeholder="Quantity"
                                                class="form-control @error('ingredient_quantity') is-invalid @enderror"
                                                name="quantities[]" value="{{ old('ingredient_quantity') }}" required
                                                autocomplete="ingredient_quantity" autofocus style="float: left;">
                                            @error('ingredient_quantity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <select id="ingredient_unit" class="form-control form-select" name="units[]"
                                                required
                                                style="float: left; width: inaitial; background-color:rgb(238, 238, 242)">
                                                <option value="">Unit</option>
                                                <option value="Kilograms">Kilograms</option>
                                                <option value="Litres">Litres</option>
                                                <option value="Counts">Counts</option>
                                            </select>
                                            @error('ingredient_unit')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <span class="input-group-btn">
                                                <button class="btn btn-outline-danger remove"
                                                    type="button"style="border-top-left-radius: 0%;border-bottom-left-radius: 0%"><i
                                                        class="bx bx-minus"></i></button>
                                            </span>
                                        </div>
                                    </div>
                        </div>
                        <div class="row mb-1 mt-2">
                            <div class="text-center">
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                        </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header">Utilization Records</div>
            <div class="card-body">
                <table id="data-tebo" class=" dt-responsive nowrap table table-bordered table-responsive table-striped">
                    <thead>
                        <th>#</th>
                        <th>Date</th>
                        <th>Action</th>
                        <th>Issued By</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        function showForm1() {
            x = document.getElementById('edit-form')
            y = document.getElementById('edit-btn')
            if (x.style.display == 'block') {
                x.style.display = 'none'
                y.innerHTML = 'Add Ingredients'
                y.style.color = 'blue'
            } else {
                x.style.display = 'block'

                y.innerHTML = 'Deny'
                y.style.color = 'red'
            }
        }

        function showForm2() {
            x = document.getElementById('edit-form')
            y = document.getElementById('edit-btn')
            if (x.style.display == 'block') {
                x.style.display = 'none'

                y.innerHTML = 'Change Ingredients'
                y.style.color = 'blue'
            } else {
                x.style.display = 'block'
                y.innerHTML = 'Deny'
                y.style.color = 'red'
            }
        }
    </script>
@endsection
