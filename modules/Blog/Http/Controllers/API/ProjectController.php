<?php

namespace Modules\Blog\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Models\Template;

class ProjectController extends Controller
{
    public function show(Template $template, Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => json_decode($template->content),
            'message' => 'Success load page content'
        ]);
    }

    public function update(Request $request, $template)
    {
        $page = Template::findOrFail($template);
        $page->update(['content' => json_encode($request->input('data'))]);

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Project stored successfully'
        ]);
    }
}
