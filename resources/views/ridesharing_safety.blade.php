@extends('layouts.app')

@section('title', 'Popular routes')

@section($menu, 'active')

@section('content')

@include('parts.small_header_extend')
<div class="main ">
    <div class="container">
        <div class="row">

            @include('parts.options_sidebar')

            <div class="col-sm-10">

                <h1>Your saftey</h1>

                <hr class="hidden-xs">

            </div>
        </div>
    </div>
</div>
@endsection