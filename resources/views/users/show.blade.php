@extends('layouts.app')
@section('title')
    User
@endsection
@section('style')
@endsection
@section('content')
    <div class="card">
        <div class=" card-header">
            <div class="row">
                <div class="col">
                    <div class=" text-left">
                        <h5><b>{{ $user->name }}
                            </b>
                        </h5>
                    </div>
                </div>
                <div class="col text-right">
                    <a href="#" class="btn btn-sm btn-outline-primary collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">

                        <i class="feather icon-plus"></i> Edit User

                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="collapseTwo" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="card mb-1 p-2" style="background: var(--form-bg-color)">
                        <form method="POST" action="{{ route('users.edit', $user) }}">
                            @method('PUT')
                            @csrf
                            <div class="row">

                                <div class="col-sm-4 text-start mb-1">
                                    <label for="name" class=" col-form-label text-sm-start">{{ __('Name') }}</label>
                                    <input id="name" type="text" placeholder=""
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
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
                                            value="{{ old('quantity', $user->quantity) }}" required
                                            autocomplete="quantity" autofocus style="float: left;">
                                        <select class="form-control form-select" name="unit" required
                                            style="float: left;max-width:115px; width: inaitial; background-color:rgb(238, 238, 242)">
                                            <option value="Kilograms"
                                                {{ $user->unit == 'Kilograms' ? 'selected' : '' }}>
                                                Kilograms</option>
                                            <option value="Litres" {{ $user->unit == 'Litres' ? 'selected' : '' }}>
                                                Litres</option>
                                            <option value="Counts" {{ $user->unit == 'Counts' ? 'selected' : '' }}>
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
                                        class="form-control @error('cost', $user->cost) is-invalid @enderror"
                                        name="cost" value="{{ old('cost', $user->cost) }}" required
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
                <div><b> Name:</b> {{ $user->name }}</div>
                <div><b> Quantity:</b> {{ $user->quantity . ' ' . $user->unit }}</div>
                <div><b> Cost:</b> {{ number_format($user->cost, 0, '.', ',') }} Tsh</div>
                <div><b> Recorded:</b> {{ $user->created_at->format('D, d M Y \a\t H:i') }}</div>
            </div><br>
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
@endsection