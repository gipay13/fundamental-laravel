@extends('layouts.app')

@section('title', 'Laracamp by BuildWith Angga')

@section('content')
<section class="dashboard my-5">
    <div class="container">
        <div class="row text-left">
            <div class=" col-lg-12 col-12 header-wrap mt-4">
                <p class="story">
                    DASHBOARD
                </p>
                <h2 class="primary-header ">
                    My Bootcamps
                </h2>
            </div>
        </div>
        <div class="row my-5">
            <table class="table">
                <tbody>
                    @forelse ($checkout as $c)
                    <tr class="align-middle">
                        <td width="18%">
                            <img src="/assets/images/item_bootcamp.png" height="120" alt="">
                        </td>
                        <td>
                            <p class="mb-2"><strong>{{ $c->camps->bootcamps_name }}</strong></p>
                            <p>{{ $c->created_at->format('M-d, Y') }}</p>
                        </td>
                        <td>
                            <strong>{{ $c->camps->price }}</strong>
                        </td>
                        <td>
                            @if ($c->is_paid)
                            <strong class="text-success">Payment Success</strong>
                            @else
                            <strong class="text-warning">Waiting for Payment</strong>
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn-primary">Get Invoice</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td>No Data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
