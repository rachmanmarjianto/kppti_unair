@extends('layout.layout')

@section('title', 'Blank Page')

@section('page-css')

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Layouts</a></li>
    <li class="breadcrumb-item active" aria-current="page">Empty Page</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Title</h4>
                    </div>          
                </div>
            </div>
            <div class="widget-content widget-content-area">

            </div>
        </div>
    </div>
@endsection


@section('page-js')

@endsection