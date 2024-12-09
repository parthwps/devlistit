<?php

namespace App\Http\Controllers\BackEnd\Car;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UploadFile;
use App\Models\Car\FuelType;
use App\Models\Car\BodyType;
use App\Models\Car\Category;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FuelTypeController extends Controller
{
   
    public function index_body_type(Request $request)
    {
        // first, get the language info from db
        $language = Language::where('code', $request->language)->firstOrFail();
        $information['language'] = $language;

        // then, get the equipment categories of that language from db
        $information['carFuelTypes'] = BodyType::with('category')->orderByDesc('id')->get();
        $information['categories'] = Category::where('parent_id' , 24)->orderByDesc('id')->get();
      
        // also, get all the languages from db
        $information['langs'] = Language::all();

        return view('backend.car.body-type.index', $information);
    }

    public function store_body_type(Request $request)
    {
        $rules = [
            'language_id' => 'required',
            'name' => 'required|unique:fuel_types|max:255',
            'status' => 'required|numeric',
            'serial_number' => 'required|numeric',
            'image' => ['nullable', new ImageMimeTypeRule()]
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

        if($request->hasFile('image')){
            $image = UploadFile::store(public_path('assets/img/body_types'), $request->file('image'));
        }

        BodyType::create($request->except(['slug','image']) + [
            'slug' => createSlug($request->name),
            'image' => $image ?? null,
        ]);

        Session::flash('success', 'New Car Body Type added successfully!');

        return Response::json(['status' => 'success'], 200);
    }

    public function update_body_type(Request $request)
    {
        $rules = [
            'name' => [
                'required',
                'max:255'
            ],
            'status' => 'required|numeric',
            'serial_number' => 'required|numeric',
            'image' => ['nullable', new ImageMimeTypeRule()]
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()
            ], 400);
        }

        $fuel_types = BodyType::find($request->id);

        $oldImage = $fuel_types->image;
        if($request->hasFile('image')){
            $oldImage = UploadFile::update(public_path('assets/img/body_types'), $request->file('image'),$oldImage);
        }

        $fuel_types->update($request->except(['slug','image']) + [
            'slug' => createSlug($request->name),
            'image' => $oldImage,
        ]);

        Session::flash('success', 'Car body Type updated successfully!');

        return Response::json(['status' => 'success'], 200);
    }

    public function destroy_body_type($id)
    {
        $fuel_types = BodyType::find($id);
        $fuel_types->delete();
        return redirect()->back()->with('success', 'Car body Type deleted successfully!');
    }

    public function bulkDestroy_body_type(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $fuel_types = BodyType::find($id);
            $fuel_types->delete();
        }
        Session::flash('success', 'Car Body Types deleted successfully!');

        return Response::json(['status' => 'success'], 200);
    }
    
    
    
   
    public function index(Request $request)
    {
        // first, get the language info from db
        $language = Language::where('code', $request->language)->firstOrFail();
        $information['language'] = $language;

        // then, get the equipment categories of that language from db
        $information['carFuelTypes'] = $language->fuelType()->orderByDesc('id')->get();

        // also, get all the languages from db
        $information['langs'] = Language::all();

        return view('backend.car.fuel-type.index', $information);
    }

    public function store(Request $request)
    {
        $rules = [
            'language_id' => 'required',
            'name' => 'required|unique:fuel_types|max:255',
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

        FuelType::create($request->except('slug') + [
            'slug' => createSlug($request->name)
        ]);

        Session::flash('success', 'New Car Fuel Type added successfully!');

        return Response::json(['status' => 'success'], 200);
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => [
                'required',
                'max:255',
                Rule::unique('fuel_types', 'name')->ignore($request->id, 'id')
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

        $fuel_types = FuelType::find($request->id);

        $fuel_types->update($request->except('slug') + [
            'slug' => createSlug($request->name)
        ]);

        Session::flash('success', 'Car Fuel Type updated successfully!');

        return Response::json(['status' => 'success'], 200);
    }

    public function destroy($id)
    {
        $fuel_types = FuelType::find($id);
        $fuel_types->delete();
        return redirect()->back()->with('success', 'Car Fuel Type deleted successfully!');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $fuel_types = FuelType::find($id);
            $fuel_types->delete();
        }
        Session::flash('success', 'Car Fuel Types deleted successfully!');

        return Response::json(['status' => 'success'], 200);
    }
}
