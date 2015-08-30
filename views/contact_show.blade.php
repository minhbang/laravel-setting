@extends('backend.layouts.main')
@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ trans('setting::'.$section.'.show') }}</h5>
            <div class="ibox-tools">
                {!! Html::linkButton(
                    $edit_url,
                    trans('common.edit'),
                    ['size' => 'xs', 'icon' => 'pencil', 'type' => 'primary']
                ) !!}
            </div>
        </div>
        <div class="ibox-content">
            <table class="table table-hover table-striped table-bordered table-detail">
                <tr>
                    <td>{{ trans('setting::'.$section.'.fields.name') }}</td>
                    <td><strong>{{ $settings['name'] }}</strong></td>
                </tr>
                <tr>
                    <td>{{ trans('setting::'.$section.'.fields.success') }}</td>
                    <td><strong>{{ $settings['success'] }}</strong></td>
                </tr>
                <tr>
                    <td>{{ trans('setting::'.$section.'.fields.form') }}</td>
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
                    <td>{!! Html::yesNoLabel($settings['enable']) !!}</td>
                </tr>
                <tr>
                    <td>{{ trans('setting::'.$section.'.fields.email') }}</td>
                    <td>{{ $settings['email'] }}</td>
                </tr>
            </table>
        </div>
    </div>
@stop
@section('script')
    @include('backend._form_show_script', ['form' => ['#form-editor-preview' => $settings["form"]]])
@stop