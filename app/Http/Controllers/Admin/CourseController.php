<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class CourseController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|\Illuminate\Contracts\View\View|View
     */
    public function index()
    {
        $courses = Course::all();
        return view('Admin.courses.all' , compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function create()
    {
        return view('Admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseRequest $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(CourseRequest $request)
    {
        $imagesUrl = $this->uploadImages($request->file('images'));
        auth()->user()->course()->create(array_merge($request->all() , [ 'images' => $imagesUrl]));
        return redirect(route('courses.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Course $course
     * @return Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Course $course
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function edit(Course $course)
    {
        return view('Admin.courses.edit' , compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Course $course
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, Course $course)
    {
        $file = $request->file('images');
        $inputs = $request->all();

        if($file) {
            $inputs['images'] = $this->uploadImages($request->file('images'));
        } else {
            $inputs['images'] = $course->images;
            $inputs['images']['thumb'] = $inputs['imagesThumb'];

        }

        unset($inputs['imagesThumb']);
        $course->update($inputs);

        return redirect(route('articles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course $course
     * @return Application|RedirectResponse|Response|Redirector
     * @throws Exception
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect(route('courses.index'));
    }
}
