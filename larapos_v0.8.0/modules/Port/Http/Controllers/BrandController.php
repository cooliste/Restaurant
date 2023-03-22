<?php

namespace Modules\Port\Http\Controllers;

use Illuminate\Http\Request;
use Modules\MPS\Models\Brand;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function export()
    {
        return (new FastExcel($this->categoryGenerator()))->download('brands.xlsx');
    }

    public function index()
    {
        return view('port::brands');
    }

    public function save(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:xls,xlsx']);

        $path = $request->file('file')->store('imports');
        try {
            $brands = (new FastExcel())->import(Storage::path($path), function ($line) {
                if (!$line['name'] || !$line['code']) {
                    throw new \Exception(__('name & code are required.'));
                }
                return Brand::updateOrCreate(['code' => $line['code']], [
                    'name'    => $line['name'],
                    'order'   => $line['order'],
                    'details' => $line['details'],
                    'photo'   => $line['photo'] ?: url('images/dummy.jpg'),
                ]);
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('message', __choice('imported_text', ['records' => 'Brand', 'count' => $brands->count()]));
    }

    private function categoryGenerator()
    {
        foreach (Brand::cursor() as $category) {
            yield [
                'name'    => $category->name,
                'code'    => $category->code,
                'order'   => $category->order ?: '',
                'details' => $category->details ?: '',
                'photo'   => $category->photo ?: '',
            ];
        }
    }
}
