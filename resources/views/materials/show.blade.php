@extends('layouts.app')
@section('title')
    Material
@endsection
@section('style')
@endsection
@section('content')
    <div class="card">
        <div class=" card-header">
            <div class="row">
                <div class="col">
                    <div class=" text-left">
                        <a href="{{ route('materials.index') }}" style="text-decoration: none;font-size:15px">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                            Back
                        </a>
                    </div>
                </div>
                <div class="col text-right">
                    <a href="#" class="btn btn-sm btn-outline-primary collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">

                        <i class="feather icon-plus"></i> Edit Material

                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="collapseTwo" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="card mb-1 p-2" style="background: var(--form-bg-color)">
                        <form method="POST" action="{{ route('materials.edit', $material) }}">
                            @method('PUT')
                            @csrf
                            <div class="row">

                                <div class="col-sm-4 text-start mb-1">
                                    <label for="name" class=" col-form-label text-sm-start">{{ __('Name') }}</label>
                                    <input id="name" type="text" placeholder=""
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $material->name) }}" required autocomplete="name" autofocus>
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
                                            value="{{ old('quantity', $material->quantity) }}" required
                                            autocomplete="quantity" autofocus style="float: left;">
                                        <select class="form-control form-select" name="unit" required
                                            style="float: left;max-width:115px; width: inaitial; background-color:rgb(238, 238, 242)">
                                            <option value="Kilograms"
                                                {{ $material->unit == 'Kilograms' ? 'selected' : '' }}>
                                                Kilograms</option>
                                            <option value="Litres" {{ $material->unit == 'Litres' ? 'selected' : '' }}>
                                                Litres</option>
                                            <option value="Counts" {{ $material->unit == 'Counts' ? 'selected' : '' }}>
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
                                        class="form-control @error('cost', $material->cost) is-invalid @enderror"
                                        name="cost" value="{{ old('cost', $material->cost) }}" required
                                        autocomplete="cost" autofocus>
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
                                        {{ __('Submit') }}
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
                        <div class="col-8">{{ $material->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><b> Quantity:</b> </div>
                        <div class="col-8">{{ $material->quantity . ' ' . $material->unit }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><b> Cost:</b> </div>
                        <div class="col-8">{{ number_format($material->cost, 0, '.', ',') }} Tsh</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><b> Created:</b> </div>
                        <div class="col-8">{{ $material->created_at->format('D, d M Y \a\t H:i') }}</div>
                    </div>
                </div>
            </div><br>
            <div class="card">
                <div class="card-header">Utilization Records</div>
                <div class="card-body">
                    <table id="data-tebo1" class=" dt-responsive nowrap table table-bordered table-responsive table-striped">
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
@endsection
