@extends('layouts.app')
@section('title')
    Materials
@endsection
@section('style')
@endsection
@section('content')
    <div class="card">
        <div class=" card-header">
            <div class="row">
                <div class="col">
                    <div class=" text-left">
                        <h5><b>{{ __('MATERIALS') . ' - ' . $materials->count() }}
                            </b>
                        </h5>
                    </div>
                </div>
                <div class="col text-right">
                    <a href="#" class="btn btn-sm btn-outline-primary collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">

                        <i class="feather icon-plus"></i> Add Material

                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="collapseTwo" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="card mb-1 p-2" style="background: var(--form-bg-color)">
                        <form method="POST" action="{{ route('materials.add') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4 mb-1">
                                    <label for="name" class=" col-form-label text-sm-start">{{ __('Name') }}</label>
                                    <div class="">
                                        <input id="name" type="text" placeholder=""
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-1">
                                    <label for="quantity" class=" col-form-label text-sm-start">{{ __('Quantity') }}</label>
                                    <div class="input-group">
                                        <input id="quantity" type="number" step="any" placeholder="00"
                                            class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                                            value="{{ old('quantity') }}" required autocomplete="quantity" autofocus
                                            style="float: left;">
                                        <select class="form-control form-select" name="unit" required
                                            style="float: left;max-width:115px; width: inaitial; background-color:rgb(238, 238, 242)">
                                            <option value="Kilograms">Kilograms</option>
                                            <option value="Litres">Litres</option>
                                            <option value="Counts">Counts</option>
                                        </select>
                                        @error('quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-1">
                                    <label for="cost"
                                        class=" col-form-label text-sm-start">{{ __('Cost (Tsh)') }}</label>
                                    <div class="">
                                        <input id="cost" type="number" placeholder="Tsh"
                                            class="form-control @error('cost') is-invalid @enderror" name="cost"
                                            value="{{ old('cost') }}" required autocomplete="cost" autofocus>
                                        @error('cost')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
                    </div>
                </div>
            </div>
            <table id="data-tebo"
                class="dt-responsive nowrap table table-bordered table-responsive-sm  table-striped table-hover"
                style="width: 100%">
                <thead>
                    <th style="max-width: 20px">#</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th class="text-right">Cost (Tsh)</th>
                    <th>Last Updated</th>
                    <th style="max-width: 50px">Status</th>
                    <th></th>
                    <th></th>
                    <th></th>

                </thead>
                <tbody>
                    @foreach ($materials as $index => $material)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $material->name }}</td>
                            <td>{{ $material->quantity . ' ' . $material->unit }}</td>
                            <td class="text-right">{{ number_format($material->cost, 0, '.', ',') }} </td>
                            <td class="">{{ $material->updated_at->format('D, d M Y \a\t H:i:s') }} </td>
                            <td class="text-center">
                                <form id="toggle-status-form-{{ $material->id }}" method="POST"
                                    action="{{ route('materials.toggle-status', $material) }}">
                                    <div class="form-check form-switch ">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" name="status" id="status-switch-{{ $material->id }}"
                                            class="form-check-input " @if ($material->status) checked @endif
                                            @if ($material->trashed()) disabled @endif value="1"
                                            onclick="this.form.submit()" />
                                    </div>
                                    @csrf
                                    @method('PUT')
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('materials.show', $material) }}"
                                    class="btn btn-sm btn-outline-info collapsed" type="button">
                                    <i class="feather icon-edit"></i> View
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-outline-primary collapsed" type="button"
                                    data-bs-toggle="modal" data-bs-target="#editModal-{{ $material->id }}"
                                    aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="feather icon-edit"></i> Edit
                                </a>
                                <div class="modal modal-sm fade" id="editModal-{{ $material->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Material</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('materials.edit', $material) }}">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="text-start mb-1">
                                                        <label for="name"
                                                            class=" col-form-label text-sm-start">{{ __('Name') }}</label>
                                                        <input id="name" type="text" placeholder=""
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            name="name" value="{{ old('name', $material->name) }}"
                                                            required autocomplete="name" autofocus>
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="text-start mb-1">
                                                        <label for="quantity"
                                                            class=" col-form-label text-sm-start">{{ __('Quantity') }}</label>
                                                        <div class="input-group">
                                                            <input id="quantity" type="number" step="any"
                                                                placeholder="00"
                                                                class="form-control @error('quantity') is-invalid @enderror"
                                                                name="quantity"
                                                                value="{{ old('quantity', $material->quantity) }}"
                                                                required autocomplete="quantity" autofocus
                                                                style="float: left;">
                                                            <select class="form-control form-select" name="unit"
                                                                required
                                                                style="float: left;max-width:115px; width: inaitial; background-color:rgb(238, 238, 242)">
                                                                <option value="Kilograms"
                                                                    {{ $material->unit == 'Kilograms' ? 'selected' : '' }}>
                                                                    Kilograms</option>
                                                                <option value="Litres"
                                                                    {{ $material->unit == 'Litres' ? 'selected' : '' }}>
                                                                    Litres</option>
                                                                <option value="Counts"
                                                                    {{ $material->unit == 'Counts' ? 'selected' : '' }}>
                                                                    Counts</option>
                                                            </select>
                                                            @error('quantity')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="text-start mb-1">
                                                        <label for="cost"
                                                            class="col-form-label text-sm-start">{{ __('Cost') }}</label>
                                                        <input id="cost" type="number" placeholder="Tsh"
                                                            class="form-control @error('cost', $material->cost) is-invalid @enderror"
                                                            name="cost" value="{{ old('cost', $material->cost) }}"
                                                            required autocomplete="cost" autofocus>
                                                        @error('cost')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                    <div class="row mb-1 mt-2">
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-sm btn-primary">
                                                                {{ __('Submit') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-outline-danger"
                                    onclick="if(confirm('Are you sure want to delete {{ $material->name }}?')) document.getElementById('delete-material-{{ $material->id }}').submit()">
                                    <i class="f"></i>Delete
                                </a>
                                <form id="delete-material-{{ $material->id }}" method="post"
                                    action="{{ route('materials.delete', $material) }}">@csrf @method('delete')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
