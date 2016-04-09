@extends('core::admin.master')

@section('title', trans('categories::global.name'))

@section('main')

<div ng-app="typicms" ng-cloak ng-controller="ListController">

    @include('core::admin._button-create', ['module' => 'categories'])

    <h1>
        <span>@{{ models.length }} @choice('categories::global.categories', 2)</span>
    </h1>

    <div class="btn-toolbar">
        @include('core::admin._lang-switcher')
    </div>

    <div class="table-responsive">

        <table st-persist="categoriesTable" st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="status" class="status st-sort">Status</th>
                    <th st-sort="image" class="image st-sort">Image</th>
                    <th st-sort="position" st-sort-default="true" class="position st-sort">Position</th>
                    <th st-sort="title" class="title st-sort">Title</th>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td typi-btn-delete action="delete(model)"></td>
                    <td>
                        @include('core::admin._button-edit', ['module' => 'categories'])
                    </td>
                    <td typi-btn-status action="toggleStatus(model)" model="model"></td>
                    <td>
                        <img ng-src="@{{ model.thumb }}" alt="">
                    </td>
                    <td>
                        <input class="form-control input-sm" min="0" type="number" name="position" ng-model="model.position" ng-change="update(model)">
                    </td>
                    <td>@{{ model.title }}</td>
                </tr>
            </tbody>
        </table>

    </div>

</div>

@endsection
