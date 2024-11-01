@extends('frontend.layouts.master')
@section('title', 'التصنيفات')
@section('content')
        <div class="category" style="direction: rtl;">
            <div class="container" style="background-color: white;">
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-md-4" s style="width: 100%;max-width: 100%;padding: 20px 5px;">
                            <ul class="tree" style="text-align: right;">
                                <li class="parent">
                                    <details open class="details">
                                        <summary>{{ $category->name }}</summary>

                                        <ul class="nested-list">
                                            @foreach ($category->subCategories as $subCategory)
                                                <li class="nested-item">
                                                     <a href="{{ route('projects.listSubCategory', $subCategory->id) }}">
                                                         {{ $subCategory->name }}
                                                    </a>
                                                    <span class="label">
                                                        {{ $subCategory->subCategoryProjects->count() }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </details>
                                </li>
                            </ul>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection
