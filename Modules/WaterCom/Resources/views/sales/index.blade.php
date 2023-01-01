@extends('watercom::layouts.master')
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
                @if ($item->products->count() != 0 && $item->status == 1)
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
                                            @if ($product->status == 1)
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
                                                                <b> {{ number_format($product->price, 0, '.', ',') }}</b>
                                                                Tsh
                                                            </span>
                                                        </div>
                                                        <div style="display:none">{{ $totalAmount = 0 }}</div>
                                                        @for ($i = 1; $i <= 3; $i++)
                                                            <div style="display:none">
                                                                {{ $totalAmount += $product->quantity }}
                                                            </div>
                                                            @if ($totalAmount > $product->item->quantity)
                                                                <span class="d-inline-block" tabindex="0"
                                                                    data-toggle="tooltip"
                                                                    title="{{ $product->item->name . ' sold out. Only ' . $item->quantity . ' ' . $item->unit . ' remained.' }}">
                                                                    <button href="#"
                                                                        class="btn btn-sm btn-primary my-1"
                                                                        style="opacity: var(--bs-btn-disabled-opacity);cursor:auto;pointer-events: none;">
                                                                        {{ $i . ' ' . $product->container }}

                                                                    </button>
                                                                </span>
                                                            @else
                                                                <button href="#" class="btn btn-sm btn-primary my-1"
                                                                    onclick="document.getElementById('sell-{{ $product->id }}-{{ $i }}').submit()">
                                                                    {{ $i . ' ' . $product->container }}
                                                                    <form
                                                                        id="sell-{{ $product->id }}-{{ $i }}"
                                                                        method="post"
                                                                        action="{{ route('products.sell', $product) }}">
                                                                        @csrf
                                                                        @method('post')
                                                                        <input hidden type="number" name="iteration"
                                                                            value="{{ $i }}">
                                                                    </form>
                                                                </button>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                            @endif
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
            <div class="row">
                <div class="col-sm-5">
                    <h5 class="my-0">
                        <b>{{ __('RECENT SALES') }}
                        </b>
                    </h5>
                </div>
                <div class="col-sm-7">
                    <form action="{{ route('sales.index') }}" method="GET" id="filter-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 text-center py-1">
                                <div class="input-group">
                                    <label for="filteredItemName" class=" col-form-label">Filter By Product:
                                    </label>
                                    <select name="filteredItemName" id="filteredItemName"
                                        class="form-select  mx-1 form-control" style="border-radius:0.375rem;"
                                        onchange="this.form.submit()">
                                        <option value='All Products'
                                            {{ $selectedItemName == 'All Products' ? 'selected' : '' }}>
                                            All Products
                                        </option>
                                        @foreach ($allItems as $item)
                                            <option value="{{ $item->name }}"
                                                {{ $selectedItemName == $item->name ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="input-group">

                                    <label for="filteredDate" class=" col-form-label">Filter By Date: </label>
                                    <input id="filteredDate" type="date" style="border-radius:0.375rem;"
                                        class="form-control mx-1 @error('filteredDate') is-invalid @enderror"
                                        name="filteredDate" value="{{ $filteredDate }}" required
                                        onchange="this.form.submit()">
                                    @error('filteredDate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="data-tebo1"
                class="dt-responsive nowrap table shadow rounded-3 table-responsive-sm  table-striped table-hover"
                style="width: 100%">
                <thead class="rounded-3 shadow ">
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
                            <td>{{ $sale->name }}</td>
                            <td>{{ $sale->container . ' of ' . $sale->quantity . ' ' . $sale->unit }}</td>
                            <td class="text-right">{{ number_format($sale->price, 0, '.', ',') }} </td>
                            <td class="">{{ $sale->created_at->format('D, d M Y \a\t H:i:s') }} </td>
                            <td>{{ $sale->user_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $("#filter-form").on("submit", function(e) {
            e.preventDefault();
            var url = $("#filter-form").attr("action");
            var newUrl = `${url}?filteredItemName=${$(e.target).val()}?filteredDate=${$(e.target).val()}`;
            window.location.assign(newUrl);
        });
    </script>
@endsection
