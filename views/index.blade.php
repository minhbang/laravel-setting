@extends('kit::backend.layouts.master')
@section('content')
    <div class="ibox ibox-table">
        <div class="ibox-title">
            <h5>{{ trans('setting::common.group') }}</h5>
        </div>
        <div class="ibox-content">
            <table class="table table-striped table-hover table-list">
                <tbody>
                @foreach ($zone->sections() as $section)
                    <tr>
                        <td class="min-width">
                            <a href="{{ route('backend.setting.edit', ['zone' => $zone->name, 'section' => $section->name]) }}"
                               class="btn btn-info">{{$section->title}}</a>
                        </td>
                        <td>{{$section->description}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="min-width">
                        <a id="btn-restore-default"
                           href="{{ route('backend.setting.restore', ['zone' => $zone->name]) }}" class="btn btn-danger"
                           data-title="{{trans('setting::common.restore_default')}}"
                           data-label="{{ trans('common.ok') }}"
                           data-icon="wrench">{{trans('setting::common.default')}}</a>
                    </td>
                    <td>
                        {{ trans('setting::common.restore_default_description') }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop

@push('scripts')
    <script type="text/javascript">
        $('#btn-restore-default').click(function (e) {
            var url = $(this).attr('href');
            e.preventDefault();
            bootbox.confirm({
                title: '<i class="fa fa-reply-all"></i> {{trans("setting::common.restore_default")}}',
                message: '<h3 class="text-danger text-center">{{trans("setting::common.restore_default_confirm")}}</h3>',
                buttons: {
                    cancel: {
                        label: '{{trans('common.cancel')}}'
                    },
                    confirm: {
                        label: '{{trans('common.ok')}}'
                    }
                },
                'callback': function (ok) {
                    if (ok) {
                        $.post(url, {_token: window.Laravel.csrfToken}, function (message) {
                            $.fn.mbHelpers.showMessage(
                                    message.type,
                                    message.content,
                                    {
                                        delay: 1500,
                                        before_close: function () {
                                            document.location.reload(true);
                                        }
                                    }
                            );
                        }, "json");
                    }
                }
            });
            return false;
        });
    </script>
@endpush