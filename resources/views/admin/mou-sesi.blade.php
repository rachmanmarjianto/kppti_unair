@extends('layout.layout')

@section('title', 'Sesi MoU')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Sesi MoU</li>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4>Sesi MoU</h4>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Jam Mulai</th>
                                <th>Jam Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sesiList as $sesi)
                                <tr>
                                    <td>{{ substr($sesi->jam_mulai, 0, 5) }}</td>
                                    <td>{{ substr($sesi->jam_akhir, 0, 5) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Belum ada data sesi MoU.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
