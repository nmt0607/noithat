@extends('layouts.master')
@section('title')
    <title>Workflow</title>
@endsection
@section(config('workflows.section'))
    <div class="body-content p-2">
        <div class="card">
            <div class="card-body p-2">
                <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
                    <div class="">
                        <h4 class="m-0 ml-2">
                            Workflow
                        </h4>
                    </div>
                    <div class="paginate">
                        <div class="d-flex">
                            <div class="">
                                <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                            </div>
                            <span class="px-2">/</span>
                            <div class="">
                                <div class="disable">Workflow</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter d-flex align-items-center justify-content-between mb-2">
                    <button type="button" class="btn btn-secondary"><i class="fa fa-undo"></i> Làm mới</button>
                    <div>
                        <div style="float: left;text-align: center;">
                            <a href="{{config('workflows.prefix')}}/workflows/create">
                                <div class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Tạo mới
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                               aria-describedby="example2_info">
                            <tr>
                                <th>Tên tác vụ</th>
                                <th>Task</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                            @foreach($workflows as $workflow)
                                <tr>
                                    <td>{{ $workflow->name }}</td>
                                    <td>{{ $workflow->tasks->count() }}</td>
                                    <td>{{ $workflow->created_at->format('d.m.Y') }}</td>
                                    <td>
                                        <a href="{{config('workflows.prefix')}}/workflows/{{$workflow->id}}"><i
                                                class="fas fa-eye"></i></a> -
                                        <a href="{{config('workflows.prefix')}}/workflows/{{$workflow->id}}/edit"><i
                                                class="fas fa-edit"></i></a> -
                                        <a href="{{config('workflows.prefix')}}/workflows/{{$workflow->id}}/delete"><i
                                                class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        @if(!isset($workflows) || !count($workflows))
                            <div class="pb-2 pt-3 text-center">Không tìm thấy dữ liệu</div>
                        @endif
                        {{ $workflows->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
