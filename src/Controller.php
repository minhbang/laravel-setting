<?php
namespace Minhbang\Setting;

use Minhbang\Kit\Extensions\BackendController;
use Illuminate\Http\Request;
use Session;

/**
 * Class Controller
 *
 * @package Minhbang\Setting
 */
class Controller extends BackendController
{
    /**
     * @param string $zone
     *
     * @return \Illuminate\View\View
     */
    public function index($zone)
    {
        $zone = $this->getZone($zone);
        $this->buildHeading(
            [trans('setting::common.setting'), $zone->title],
            'wrench',
            trans('setting::common.setting')
        );

        return view('setting::index', compact('zone'));
    }

    /**
     * @param string $zone
     * @param string $section
     *
     * @return \Illuminate\View\View
     */
    public function show($zone, $section)
    {
        $zone = $this->getZone($zone, $section);
        $section = $zone->section($section);
        abort_unless($section->is_special, 404, trans('setting::common.unable_show'));
        $this->buildHeading(
            [trans('setting::common.setting'), $section->special_title],
            'wrench',
            [
                route('backend.setting.index', ['zone' => $zone->name]) => trans('setting::common.setting'),
                '#'                                                     => $section->special_title,
            ],
            [
                [
                    route('backend.setting.edit', ['zone' => $zone->name, 'section' => $section->name]),
                    trans('common.update'),
                    ['type' => 'primary', 'size' => 'sm', 'icon' => 'pencil'],
                ],
            ]
        );
        $titles = $section->titles;
        $values = $section->values();

        return $zone->view("{$section->name}_show", compact('section', 'titles', 'values'));
    }

    /**
     * @param string $zone
     * @param string $section
     *
     * @return \Illuminate\View\View
     */
    public function edit($zone, $section)
    {
        $zone = $this->getZone($zone, $section);
        $section = $zone->section($section);
        $html = $this->newClassInstance(config('setting.html'), $section);
        $return_url = $section->return_url;
        $update_url = route('backend.setting.update', ['zone' => $zone->name, 'section' => $section->name]);

        $this->buildHeading(
            [trans('setting::common.setting') . " {$zone->title}:", $section->special_title],
            'wrench',
            [$return_url => trans('setting::common.setting'), '#' => $section->special_title]
        );

        return $zone->view($section->name, compact('section', 'html', 'return_url', 'update_url'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $zone
     * @param string $section
     *
     * @return \Illuminate\View\View
     */
    public function update(Request $request, $zone, $section)
    {
        $zone = $this->getZone($zone, $section);
        $section = $zone->section($section);
        $this->validate($request, $section->rules, [], $section->titles);
        $section->update($request->all());
        Session::flash(
            'message',
            [
                'type'    => 'success',
                'content' => trans('common.save_object_success', ['name' => trans('setting::common.setting')]),
            ]
        );
        $return_url = $request->has('_return');
        $return_url = $return_url ?: $section->return_url;

        return redirect($return_url);
    }

    /**
     * Phục hồi setting về mặc định
     *
     * @param string $zone
     *
     * @return \Illuminate\View\View
     */
    public function restore($zone)
    {
        $this->getZone($zone)->restore();

        return response()->json(
            [
                'type'    => 'success',
                'content' => trans('setting::common.restore_default_success'),
            ]
        );
    }

    /**
     * @param string $name
     * @param string $section
     *
     * @return \Minhbang\Setting\Zone
     */
    protected function getZone($name, $section = null)
    {
        $ok = !is_null($zone = \Setting::zone($name));
        if ($ok && $section) {
            $ok = $zone->has($section);
        }
        abort_unless($ok, 404, trans('setting::common.not_found'));

        return $zone;
    }
}
