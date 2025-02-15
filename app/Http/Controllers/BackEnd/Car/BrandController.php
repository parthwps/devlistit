<?php

namespace App\Http\Controllers\BackEnd\Car;

use App\Http\Controllers\Controller;
use App\Models\Car\Brand;
use App\Models\Language;
use App\Models\Car\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $language = Language::where('code', $request->language)->firstOrFail();
        
        $information['language'] = $language;

        $information['carBrands'] = $language->carBrand()->orderByDesc('id')->paginate(50);

        $information['langs'] = Language::all();
        
        $information['categories'] = Category::where('status' , 1)->get(['id' , 'name']);

        return view('backend.car.brand.index', $information);
    }

    public function store(Request $request)
    {
        $rules = [
            'language_id' => 'required',
            'name' => 'required|max:255',
            'status' => 'required|numeric',
            'serial_number' => 'required|numeric'
        ];

        $message = [
            'language_id.required' => 'The language field is required.'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()
            ], 400);
        }


        Brand::create($request->except('slug') + [
            'slug' => createSlug($request->name)
        ]);

        Session::flash('success', 'New Car Brand added successfully!');

        return Response::json(['status' => 'success'], 200);
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => [
                'required',
                'max:255'
            ],
            'status' => 'required|numeric',
            'serial_number' => 'required|numeric'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()
            ], 400);
        }

        $brand = Brand::find($request->id);

        $brand->update($request->except('slug') + [
            'slug' => createSlug($request->name)
        ]);

        Session::flash('success', 'Car Brand updated successfully!');

        return Response::json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);

        $models = $brand->models()->get();
        foreach ($models as $model) {
            $model->delete();
        }

        $brand->delete();
        return redirect()->back()->with('success', 'Brand deleted successfully!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $brand = Brand::find($id);
            $models = $brand->models()->get();
            foreach ($models as $model) {
                $model->delete();
            }
            $brand->delete();
        }
        Session::flash('success', 'Car Brand deleted successfully!');

        return Response::json(['status' => 'success'], 200);
    }
}
