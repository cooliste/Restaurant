<?php

namespace Modules\Port\Http\Controllers;

use Illuminate\Http\Request;
use Modules\MPS\Models\Category;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function export()
    {
        return (new FastExcel($this->categoryGenerator()))->download('categories.xlsx');
    }

    public function index()
    {
        return view('port::categories');
    }

    public function save(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:xls,xlsx']);
        $path = $request->file('file')->store('imports');
        try {
            $categories = (new FastExcel())->import(Storage::path($path), function ($line) {
                if (!$line['name'] || !$line['code']) {
                    throw new \Exception(__('name & code are required.'));
                }
                return Category::updateOrCreate(['code' => $line['code']], [
                    'name'  => $line['name'],
                    'photo' => $line['photo'] ?: url('images/dummy.jpg'),
                    'photo' => $line['parent'] ? Category::where('code', $line['parent'])->sole()->id : null,
                ]);
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return bacK()->with('message', __choice('imported_text', ['records' => 'Category', 'count' => $categories->count()]));
    }

    private function categoryGenerator()
    {
        foreach (Category::cursor() as $category) {
            yield [
                'name'   => $category->name,
                'code'   => $category->code,
                'parent' => $category->parent_id ? $category->parent->code : '',
                'photo'  => $category->photo ?? '',
            ];
        }
    }
}
