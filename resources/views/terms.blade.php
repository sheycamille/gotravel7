@extends('layouts.app')

@section('title', 'Terms and conditions')

@section('active')

@section('content')

@include('parts.small_header_extend')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <center><h1>@lang('page.terms.title')</h1></center><br><br>
                <h2>@lang('page.terms.business')</h>
                <h3> @lang('page.terms.by_using') </h3>

                <h2>@lang('page.terms.intro')</h2>
                <ol>
                <li> @lang('page.terms.handled_by')</li>
                </ol>

                <h2> @lang('page.terms.member')</h2>
                <ol>
                    <li>@lang('page.terms.member_point_one')</li>
                    <li>@lang('page.terms.member_point_two')</li>
                    <li>@lang('page.terms.member_point_three')
                        <ul>
                            <li>@lang('page.terms.member_point_3a')</li>
                            <li>@lang('page.terms.member_point_3b')</li>
                        </ul>
                    </li>
                    <li>@lang('page.terms.member_point_four')</li>
                    <li>@lang('page.terms.member_point_five')</li>
                    <li>@lang('page.terms.member_point_six')</li>
                </ol>

                <h2>@lang('page.terms.service')</h2>
                <ol>
                    <li>@lang('page.terms.service_point_1')</li>
                </ol>

                <h2>@lang('page.terms.pay')</h2>
                <ol>
                    <li>@lang('page.terms.pay_point_1')</li>
                    <li>@lang('page.terms.pay_point_2')</li>
                    <li>@lang('page.terms.pay_point_3')</li>
                </ol>

                <h2>@lang('page.terms.market')</h2>
                <ol>
                    <li>@lang('page.terms.market_point_1')</li>
                    <li>@lang('page.terms.market_point_2')</li>
                </ol>

                <h2>@lang('page.terms.obligation')</h2>
                <ol>
                    <li>@lang('page.terms.obligation_point_1')</li>
                    <li>@lang('page.terms.obligation_point_2')</li>
                    <li>@lang('page.terms.obligation_point_3')</li>
                    <li>@lang('page.terms.obligation_point_4')</li>
                </ol>

                <h2>@lang('page.terms.Disclaimer')</h2>
                <ol>
                    <li>@lang('page.terms.disclaimer_point_1')</li>
                    <li>@lang('page.terms.disclaimer_point_2')</li>
                    <li>@lang('page.terms.disclaimer_point_3')</li>
                    <li>@lang('page.terms.disclaimer_point_4')</li>
                    <li>@lang('page.terms.disclaimer_point_5')</li>
                    <li>@lang('page.terms.disclaimer_point_6')</li>
                </ol>

                <h2>@lang('page.terms.data')</h2>
                <ol>
                    <li>@lang('page.terms.data_point_1')</li>
                    <li>@lang('page.terms.data_point_2')</li>
                    <li>@lang('page.terms.data_point_3')</li>
                    <li>@lang('page.terms.data_point_4')</li>
                </ol>

                <h2>@lang('page.terms.change_bis_terms')</h2>
                <ol>
                    <li>@lang('page.terms.change_bis_terms_1')</li>
                    <li>@lang('page.terms.change_bis_terms_2')</li>
                </ol>

                <h2>@lang('page.terms.provision')</h2>
                <ol>
                    <li>@lang('page.terms.provision_point_1')</li>
                    <li>@lang('page.terms.provision_point_2')</li>
                    <li>@lang('page.terms.provision_point_3')</li>
                </ol>

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
