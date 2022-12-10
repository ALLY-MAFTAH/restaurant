@extends('layouts.app')
@section('title')
    Sales
@endsection
@section('style')
@endsection
@section('content')
    <div class="card">
        <div class="text-center card-header">
            <h4 class="my-0">
                <b>{{ __('PRODUCTS AVAILABLE FOR SELL') }}</b>
            </h4>
        </div>
        <div class="card-body px-2">
            @foreach ($items as $index => $item)
                @if ($item->products->count() != 0)
                    <div class="card my-2" style="background-image: linear-gradient(to right, white,rgb(212, 208, 238));">
                        <div class="card-body my-1 py-0">
                            <div class="row"style="align-items:center;">
                                <div class="col-md-3">
                                    <div style="background:white;">
                                        <h4 style="font-weight:bolder;font-size: 22px;">{{ $item->name }}</h4>
                                        <div style="color:rgb(118, 7, 7); font-size: 15px;">Remained Amount:
                                            <b>{{ $item->quantity }} </b> {{ $item->unit }}
                                        </div>
                                        <a href="{{ route('items.show', $item) }}" style="text-decoration: none">View</a>
                                    </div>
                                </div>
                                <div class="col-md-9 ">
                                    <div class="row ">
                                        @foreach ($item->products as $product)
                                            <div class=" col text-center ">
                                                <div class="py-2 px-1 my-1 shadow"
                                                    style="max-width:260px; background:white;  border-radius:5px;">
                                                    <div class="row pb-2">
                                                        <span class="col text-start "
                                                            style="color: green; font-weight:bold;">
                                                            {{ $product->quantity . ' ' . $product->unit }}
                                                        </span>
                                                        <span class="col-1"></span>
                                                        <span class="col text-end" style="color: rgb(243, 119, 4);">
                                                            <b> {{ number_format($product->price, 0, '.', ',') }}</b> Tsh
                                                        </span>
                                                    </div>
                                                    <div style="display:none">{{ $totalAmount = 0 }}</div>
                                                    @for ($i = 1; $i <= 3; $i++)
                                                        <div style="display:none">{{ $totalAmount += $product->quantity }}
                                                        </div>
                                                        @if ($totalAmount > $product->item->quantity)
                                                            <span class="d-inline-block" tabindex="0"
                                                                data-toggle="tooltip"
                                                                title="{{ $product->item->name . ' sold out.' }}">
                                                                <button href="#" class="btn btn-sm btn-primary my-1"
                                                                    style="opacity: var(--bs-btn-disabled-opacity);cursor:auto;pointer-events: none;">
                                                                    {{ $i . ' ' . $product->container }}

                                                                </button>
                                                            </span>
                                                        @else
                                                            <button href="#" class="btn btn-sm btn-primary my-1"
                                                                onclick="document.getElementById('sell-{{ $product->id }}-{{ $i }}').submit()">
                                                                {{ $i . ' ' . $product->container }}
                                                                <form id="sell-{{ $product->id }}-{{ $i }}"
                                                                    method="post"
                                                                    action="{{ route('products.sell', $product) }}">@csrf
                                                                    @method('post')
                                                                    <input hidden type="number" name="iteration"
                                                                        value="{{ $i }}">
                                                                </form>
                                                            </button>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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
                    <th>Quantity</th>
                    <th class="text-right">Price (Tsh)</th>
                    <th>Date</th>
                    <th>Issued By</th>

                </thead>
                <tbody>
                    @foreach ($sales as $index => $sale)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $sale->product->item->name }}</td>
                            <td>{{ $sale->product->container . ' of ' .$sale->product->quantity . ' ' . $sale->product->unit }}</td>
                            <td class="text-right">{{ number_format($sale->product->price, 0, '.', ',') }} </td>
                            <td class="">{{ $sale->created_at->format('D, d M Y \a\t H:i:s') }} </td>
                            <td>{{ $sale->user->name . ' (' . $sale->user->role->name . ')' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
