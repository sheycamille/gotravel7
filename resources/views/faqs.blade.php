@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('active')

@section('content')

@include('parts.small_header_extend')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <h1> @lang('page.faq.title')</h1>
                <p> @lang('page.faq.questions_1')</p>
                <p> @lang('page.faq.questions_2')</p>
                <p> @lang('page.faq.questions_3')</p>
                <p> @lang('page.faq.questions_4')</p>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
