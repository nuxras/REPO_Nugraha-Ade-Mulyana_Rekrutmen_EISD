<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('reports')->orderBy('name')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255|unique:categories,name',
            'priority_weight' => 'required|integer|min:1|max:100',
        ], [
            'name.required'            => 'Nama kategori wajib diisi.',
            'name.unique'              => 'Nama kategori sudah ada.',
            'priority_weight.required' => 'Bobot prioritas wajib diisi.',
            'priority_weight.min'      => 'Bobot prioritas minimal 1.',
            'priority_weight.max'      => 'Bobot prioritas maksimal 100.',
        ]);

        Category::create($request->only('name', 'priority_weight'));

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'            => 'required|string|max:255|unique:categories,name,' . $category->id,
            'priority_weight' => 'required|integer|min:1|max:100',
        ], [
            'name.required'            => 'Nama kategori wajib diisi.',
            'name.unique'              => 'Nama kategori sudah ada.',
            'priority_weight.required' => 'Bobot prioritas wajib diisi.',
            'priority_weight.min'      => 'Bobot prioritas minimal 1.',
            'priority_weight.max'      => 'Bobot prioritas maksimal 100.',
        ]);

        $category->update($request->only('name', 'priority_weight'));

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        // Check if category is used by any reports
        if ($category->reports()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh laporan.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
