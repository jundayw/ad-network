@extends('publishment.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('publishment.site.store') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">名称</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="title" value="" placeholder="请输入名称" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">输入网站</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="protocol" rel-action="select">
                                        @foreach($filter['protocol'] as $key => $state)
                                            <option value="{{ $key }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" name="domain" value="" placeholder="请输入网站，如：www.baidu.com" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">站点领域</label>
                                <div class="col-md-10">
                                    <select class="form-control" name="industry" rel-action="select">
                                        @foreach($filter['industry'] as $key => $industry)
                                            <option value="{{ $industry->id }}">{{ $industry->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">描述</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="description" rows="5" placeholder="请输入描述"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">状态</label>
                                <div class="col-md-10">
                                    <div class="radio-list">
                                        @foreach($filter['state'] as $key => $item)
                                            <label class="radio-inline">
                                                <input type="radio" name="state" value="{{ $key }}" @checked($loop->first)>
                                                {{ $item }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="offset-md-2">
                                <button type="submit" class="btn btn-default btn-outline">下一步</button>
                                <button type="reset" class="btn btn-default btn-outline">重置</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
