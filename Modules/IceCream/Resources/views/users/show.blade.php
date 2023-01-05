@extends('icecream::layouts.master')
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
                        <a href="{{ route('users.index') }}" style="text-decoration: none;font-size:15px">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                            Back
                        </a>
                    </div>
                </div>
                <div class="col text-right">
                    <a href="#" class="btn btn-sm btn-outline-primary collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                        aria-controls="collapseTwo">

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
                        <form method="POST" action="{{ route('users.edit', $icecream) }}">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-sm-4 text-start mb-1">
                                    <label for="role_id" class=" col-form-label text-sm-start">{{ __('Role') }}</label>
                                    <select id="role_id" type="text"
                                        class="form-control form-select @error('role_id') is-invalid @enderror"
                                        name="role_id" value="{{ old('role_id', $icecream->role_id) }}" required
                                        autocomplete="role_id" autofocus>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $role->id == $icecream->role_id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-4 mb-1">
                                    <label for="name" class=" col-form-label text-sm-start">{{ __('Name') }}</label>
                                    <div class="">
                                        <input id="name" type="text" placeholder=""
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name', $icecream->name) }}" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-1">
                                    <label for="email"
                                        class=" col-form-label text-sm-start">{{ __('Description') }}</label>
                                    <div class="">
                                        <input id="email" type="email" placeholder="Description"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email', $icecream->email) }}" required autocomplete="email"
                                            autofocus>
                                        @error('email')
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
                        <div class="col-8">{{ $icecream->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><b> Email:</b> </div>
                        <div class="col-8">{{ $icecream->email }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><b> Role:</b> </div>
                        <div class="col-8">{{ $icecream->role->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><b> Created:</b> </div>
                        <div class="col-8">{{ $icecream->created_at->format('D, d M Y \a\t H:i') }}</div>
                    </div>
                </div>
                <div class="col-7">

                </div>
            </div><br>
            <div class="card">
                <div class="card-header">Activities</div>
                <div class="card-body">
                    <table id="data-tebo1" class=" dt-responsive nowrap table shadow rounded-3 table-responsive table-striped">
                        <thead class="shadow rounded-3">
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
