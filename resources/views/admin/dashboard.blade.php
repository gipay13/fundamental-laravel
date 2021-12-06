@extends('layouts.app')

@section('title', 'Laracamp by BuildWith Angga')

@section('content')
<section class="dashboard my-5">
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        @include('components.alert')
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Camp</th>
                                    <th>Price</th>
                                    <th>Register Data</th>
                                    <th>Paid Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($checkout as $c)
                                    <tr>
                                        <td>{{ $c->user->name }}</td>
                                        <td>{{ $c->camp->bootcamp_name }}</td>
                                        <td>{{ $c->camp->price }}</td>
                                        <td>{{ $c->created_at->format('M d y') }}</td>
                                        <td>
                                            @if ($c->is_paid)
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-warning">Waiting</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$c->is_paid)
                                            <form action="{{ route('admin.checkout.update', $c->id) }}" method="post">
                                                @csrf
                                                <button class="btn btn-primary btn-sm">Set Paid</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No Camp Registered</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
