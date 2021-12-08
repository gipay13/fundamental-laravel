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
            @include('components.alert')
            <table class="table">
                <tbody>
                    @forelse ($checkout as $c)
                    <tr class="align-middle">
                        <td width="18%">
                            <img src="/assets/images/item_bootcamp.png" height="120" alt="">
                        </td>
                        <td>
                            <p class="mb-2"><strong>{{ $c->camp->bootcamp_name }}</strong></p>
                            <p>{{ $c->created_at->format('M-d, Y') }}</p>
                        </td>
                        <td>
                            <strong>{{ $c->camp->price }}</strong>
                        </td>
                        <td>
                            <strong class="text-success">{{ $c->payment_status }}</strong>
                        </td>
                        <td>
                            @if ($c->payment_status == 'waiting')
                                <a href="{{ $c->midtrans_url }}" class="btn btn-primary">Pay Here</a>
                            @endif
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
