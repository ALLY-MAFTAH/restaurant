@extends('layouts.app')
@section('title')
    Sales
@endsection
@section('style')
@endsection
@section('content')
    <div class="card">
        <div class="text-center card-header">
            <h5 class="my-0">
                <b>{{ __("TODAY'S PRODUCTS") }}</b>
            </h5>
        </div>
        <div class="card-body px-2">


            @foreach ($items as $index => $item)
                <div class="card my-3 shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3" style="font-size: 22px;font-weight:bolder">{{ $item->name }}</div>
                            <div class="col-md-8 ">
                                <div class="row ">
                                    @foreach ($item->products as $product)
                                        <div class=" col text-center">
                                            <div class="py-2 px-1"
                                                style="position:absolut; background:orange; border-radius:10px;">
                                                <div class=" ">
                                                    <div class="text-white">
                                                        <h4> {{ number_format($product->price, 0, '.', ',') }} Tsh</h4>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="">
                                                        <h3> {{ $product->quantity . ' ' . $product->unit }} </h3>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="">
                                                        <button href="#" class="btn btn-primary mx-1 my-1">
                                                         1 {{ $product->container }}
                                                        </button>
                                                        <button href="#" class="btn  btn-primary mx-1">
                                                        2 {{ $product->container }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <br>
    <div class="card">
        <div class=" card-header">
            <h5 class="my-0">
                <span class="">
                    <b>{{ __('RECENT PRODUCT SALES') }}
                    </b>

                </span>
            </h5>
        </div>
        <div class="card-body">
            <div id="collapseTwo" style="width: 100%;border-width:0px" class="accordion-collapse collapse "
                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="card mb-1 p-2" style="background: var(--form-bg-color)">
                        <form method="POST" action="{{ route('products.add') }}">
                            @csrf

                            <div class="mb-1 mt-2">
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
                    <th>Container</th>
                    <th>Quantity</th>
                    <th class="text-right">Price (Tsh)</th>
                    <th>Last Updated</th>
                    <th style="max-width: 50px">Status</th>
                    <th></th>
                    <th></th>
                    <th></th>

                </thead>
                <tbody>
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->container }}</td>
                            <td>{{ $product->quantity . ' ' . $product->unit }}</td>
                            <td class="text-right">{{ number_format($product->price, 0, '.', ',') }} </td>
                            <td class="">{{ $product->updated_at->format('D, d M Y \a\t H:i:s') }} </td>
                            <td class="text-center">
                                <form id="toggle-status-form-{{ $product->id }}" method="POST"
                                    action="{{ route('products.toggle-status', $product) }}">
                                    <div class="form-check form-switch ">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" name="status" id="status-switch-{{ $product->id }}"
                                            class="form-check-input " @if ($product->status) checked @endif
                                            @if ($product->trashed()) disabled @endif value="1"
                                            onclick="this.form.submit()" />
                                    </div>
                                    @csrf
                                    @method('PUT')
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('products.show', $product) }}"
                                    class="btn btn-sm btn-outline-info collapsed" type="button">
                                    <i class="feather icon-edit"></i> View
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-outline-primary collapsed" type="button"
                                    data-bs-toggle="modal" data-bs-target="#editModal-{{ $product->id }}"
                                    aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="feather icon-edit"></i> Edit
                                </a>
                                <div class="modal modal-sm fade" id="editModal-{{ $product->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('products.edit', $product) }}">
                                                    @method('PUT')
                                                    @csrf



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
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-outline-danger"
                                    onclick="if(confirm('Are you sure want to delete {{ $product->name }}?')) document.getElementById('delete-product-{{ $product->id }}').submit()">
                                    <i class="f"></i>Delete
                                </a>
                                <form id="delete-product-{{ $product->id }}" method="post"
                                    action="{{ route('products.delete', $product) }}">@csrf @method('delete')
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
