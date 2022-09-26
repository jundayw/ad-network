@extends('advertisement.layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    {{ $share->get('action') }}
                </div>
                <div class="panel-wrapper">
                    <form action="{{ route('advertisement.advertiser.updatePassword') }}" class="form-horizontal" method="post" rel-action="submit">
                        <div class="panel-body p-b-0">
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">昵称</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->usernick }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">用户名</label>
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $data->username }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">密码</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="password" name="userpass" value="" placeholder="请输入密码" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 control-label col-form-label">确认密码</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="password" name="password" value="" placeholder="请输入确认密码" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{ $data->id }}"/>
                        <div class="panel-footer">
                            <div class="offset-md-2">
                                <button type="submit" class="btn btn-default btn-outline">保存</button>
                                <button type="reset" class="btn btn-default btn-outline">重置</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
