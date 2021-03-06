<?php

namespace Modules\Forwarder\Http\Controllers;

use Plugin\Helper;
use Plugin\Response;
use App\Http\Controllers\Controller;
use Modules\Forwarder\Dao\Repositories\ProductRepository;
use App\Http\Services\MasterService;
use Modules\Item\Dao\Repositories\CategoryRepository;
use Modules\Item\Dao\Repositories\CurrencyRepository;
use Modules\Item\Dao\Repositories\TaxRepository;
use Modules\Item\Models\Tax;
use Modules\Production\Dao\Repositories\VendorRepository;

class ProductController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new ProductRepository();
        }
        $this->template  = Helper::getTemplate(__CLASS__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {

        $tax = Helper::createOption((new TaxRepository()));
        $category = Helper::createOption((new CategoryRepository()));
        $currency = Helper::createOption((new CurrencyRepository()));

        $view = [
            'key'       => self::$model->getKeyName(),
            'tax'      => $tax,
            'category'  => $category,
            'currency'  => $currency,
         
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service, GeneralRequest $request)
    {
        if (request()->isMethod('POST')) {

            $service->save(self::$model, $request->all());
        }
        return view(Helper::setViewCreate())->with($this->share());
    }

    public function update(MasterService $service, GeneralRequest $request)
    {
        if (request()->isMethod('POST')) {

            $service->update(self::$model, $request->all());
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {

            $data = $service->show(self::$model);

            return view(Helper::setViewUpdate())->with($this->share([
                'model'        => $data,
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function delete(MasterService $service)
    {
        $service->delete(self::$model);
        return Response::redirectBack();;
    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            return $service->datatable(self::$model)->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields'   => Helper::listData(self::$model->datatable),
            'template' => $this->template,
        ]);
    }

    public function show(MasterService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model);
            return view(Helper::setViewShow())->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'key'   => self::$model->getKeyName()
            ]));
        }
    }
}
