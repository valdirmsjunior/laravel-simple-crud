@extends('layouts.layout')
@section('title', 'Product List')

@section('content')
    <div class="container mb-5 mt-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h2>Products</h2>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-md-6">
                                <form class="d-flex" role="search" action="{{ route('products.index') }}" method="GET">
                                    @csrf
                                    <input class="form-control me-2" type="search" name="search" placeholder="Search"
                                        aria-label="Search" />
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('products.trashed') }}" class="btn btn-warning float-end">
                                            Deleted </a>
                                    </div>
                                    <div class="col">
                                        <a href="{{ route('products.create') }}" class="btn btn-primary float-end">Add
                                            New</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table-striped table-hover table">
                    <thead class="text-center">
                        <tr>
                            <th scope="col" class="text-nowrap align-middle">#
                                <a class="d-inline"
                                    href="{{ route('products.index', ['sort' => 'id', 'direction' => $sort === 'id' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                    @if ($sort === 'id')
                                        <span class="ms-2">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ms-2">↕</span>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="text-nowrap align-middle">Name
                                <a class="d-inline"
                                    href="{{ route('products.index', ['sort' => 'name', 'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc']) }}">

                                    @if ($sort === 'name')
                                        <span class="ms-2">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ms-2">↕</span>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="text-nowrap align-middle">Category
                                <a class="d-inline"
                                    href="{{ route('products.index', ['sort' => 'category', 'direction' => $sort === 'category' && $direction === 'asc' ? 'desc' : 'asc']) }}">

                                    @if ($sort === 'category')
                                        <span class="ms-2">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ms-2">↕</span>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="text-nowrap align-middle">Quantity
                                <a class="d-inline"
                                    href="{{ route('products.index', ['sort' => 'quantity', 'direction' => $sort === 'quantity' && $direction === 'asc' ? 'desc' : 'asc']) }}">

                                    @if ($sort === 'quantity')
                                        <span class="ms-2">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ms-2">↕</span>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="text-nowrap align-middle">Price
                                <a class="d-inline"
                                    href="{{ route('products.index', ['sort' => 'price', 'direction' => $sort === 'price' && $direction === 'asc' ? 'desc' : 'asc']) }}">

                                    @if ($sort === 'price')
                                        <span class="ms-2">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ms-2">↕</span>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="text-nowrap align-middle">Status
                                <a class="d-inline"
                                    href="{{ route('products.index', ['sort' => 'status', 'direction' => $sort === 'status' && $direction === 'asc' ? 'desc' : 'asc']) }}">

                                    @if ($sort === 'status')
                                        <span class="ms-2">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ms-2">↕</span>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="text-nowrap align-middle">Description
                                <a class="d-inline"
                                    href="{{ route('products.index', ['sort' => 'description', 'direction' => $sort === 'description' && $direction === 'asc' ? 'desc' : 'asc']) }}">

                                    @if ($sort === 'description')
                                        <span class="ms-2">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ms-2">↕</span>
                                    @endif
                                </a>
                            </th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($products->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">No products found.</td>
                            </tr>
                        @else
                            @foreach ($products as $product)
                                <tr class="text-justify">
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td><span
                                            class="badge bg-{{ $product->status->value === 'active' ? 'success' : 'warning' }}">{{ $product->status }}</span>
                                    </td>
                                    <td>{{ Str::limit($product->description, 30) }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('products.show', $product->id) }}"
                                                class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                class="m-0 p-0" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
