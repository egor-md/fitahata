<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BlockController extends Controller
{
    public function index(): Response
    {
        $blocks = Block::orderBy('name')->get();

        return Inertia::render('admin/blocks/index', [
            'blocks' => $blocks,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/blocks/create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:gallery,carousel'],
            'settings' => ['nullable', 'array'],
            'settings.images' => ['nullable', 'array'],
            'settings.images.*.url' => ['nullable', 'string'],
            'settings.images.*.alt' => ['nullable', 'string'],
            'settings.images.*.caption' => ['nullable', 'string'],
        ]);

        $validated['settings'] = $validated['settings'] ?? ['images' => []];
        if (isset($validated['settings']['images'])) {
            $validated['settings']['images'] = array_values(
                array_filter($validated['settings']['images'], fn ($img) => ! empty($img['url'] ?? null))
            );
        }

        Block::create($validated);

        return redirect()->route('admin.blocks.index');
    }

    public function edit(Block $block): Response
    {
        return Inertia::render('admin/blocks/edit', [
            'block' => $block,
        ]);
    }

    public function update(Request $request, Block $block): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:gallery,carousel'],
            'settings' => ['nullable', 'array'],
            'settings.images' => ['nullable', 'array'],
            'settings.images.*.url' => ['nullable', 'string'],
            'settings.images.*.alt' => ['nullable', 'string'],
            'settings.images.*.caption' => ['nullable', 'string'],
        ]);

        $validated['settings'] = $validated['settings'] ?? ['images' => []];
        if (isset($validated['settings']['images'])) {
            $validated['settings']['images'] = array_values(
                array_filter($validated['settings']['images'], fn ($img) => ! empty($img['url'] ?? null))
            );
        }

        $block->update($validated);

        return redirect()->route('admin.blocks.index');
    }

    public function destroy(Block $block): RedirectResponse
    {
        $block->delete();

        return redirect()->route('admin.blocks.index');
    }
}
