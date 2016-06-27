@extends('backend.layouts.master')
@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ $section->special_title }}</h5>
        </div>
        <div class="ibox-content">
            <table class="table table-hover table-striped table-bordered table-detail">
                <tr>
                    <td>{{ $titles['name'] }}</td>
                    <td><strong>{{ $values['name'] }}</strong></td>
                </tr>
                <tr>
                    <td>{{ $titles['success'] }}</td>
                    <td>{!!$values['success']!!}</td>
                </tr>
                <tr>
                    <td>{{ $titles['form'] }}</td>
                    <td>
                        <div class="form-horizontal">
                            <div class="form-editor">
                                <div id="form-editor-preview" class="form-editor-preview form-control"></div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>{{ trans('common.status') }}</td>
                    <td>{!! Html::yesNoLabel($values['enable']) !!}</td>
                </tr>
                <tr>
                    <td>{{ $titles['email'] }}</td>
                    <td>{{ $values['email'] }}</td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('script')
    @include('_form_show_script', ['form' => $values["form"]])
@stop