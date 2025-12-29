@extends('e-commerce/layouts/master')

@section('content')

<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Add Collection</h4>
            </div>
            <div>
                <a href="{{ route('collection.index') }}" class="btn btn-secondary">Back to Collections</a>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Collection Information</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form action="{{ route('collection.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    @include('components.form.input', [
                                        'label' => 'Collection Title',
                                        'name' => 'title',
                                        'type' => 'text',
                                        'placeholder' => 'Enter Collection Title',
                                        'required' => true,
                                    ])
                                </div>
                                <div class="col-lg-6">
                                    <label for="image" class="form-label">Collection Image <span class="text-danger">*</span></label>
                                    <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/jpg,image/png">
                                    <small class="text-muted">Allowed formats: JPG, JPEG, PNG. Max size: 2MB</small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Enter Collection Description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    @include('components.form.select', [
                                        'label' => 'Status',
                                        'name' => 'status',
                                        'options' => ['1' => 'Active', '0' => 'Inactive'],
                                    ])
                                </div>
                            </div>

                            <!-- Collection Categories Section -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Collection Categories <span class="text-danger">*</span></h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3 mb-3">
                                                <div class="col-lg-8">
                                                    <label for="category_search" class="form-label">Search Categories</label>
                                                    <input type="text" id="category_search" class="form-control" placeholder="Type to search categories...">
                                                </div>
                                                <div class="col-lg-4 d-flex align-items-end">
                                                    <button type="button" id="add_category_btn" class="btn btn-success" disabled>
                                                        <i class="fas fa-plus me-1"></i> Add Category
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Search Results -->
                                            <div id="search_results" class="mb-3" style="display: none;">
                                                <div class="list-group" id="category_list"></div>
                                            </div>

                                            <!-- Selected Categories Table -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Category Name</th>
                                                            <th>Products Count</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="selected_categories">
                                                        <!-- Selected categories will be added here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            @error('categories')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Create Collection
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div> <!-- content -->

<script>
let selectedCategories = [];
let selectedCategoryData = null;

$(document).ready(function() {
    // Category search functionality
    $('#category_search').on('input', function() {
        const query = $(this).val();
        if (query.length >= 2) {
            searchCategories(query);
        } else {
            $('#search_results').hide();
            $('#add_category_btn').prop('disabled', true);
        }
    });

    // Add category button click
    $('#add_category_btn').click(function() {
        if (selectedCategoryData && !selectedCategories.includes(selectedCategoryData.id)) {
            addCategoryToTable(selectedCategoryData);
            selectedCategories.push(selectedCategoryData.id);
            $('#category_search').val('');
            $('#search_results').hide();
            $(this).prop('disabled', true);
        }
    });
});

function searchCategories(query) {
    $.ajax({
        url: '{{ route("collection.search-categories") }}',
        method: 'GET',
        data: { q: query },
        success: function(response) {
            displaySearchResults(response);
        },
        error: function() {
            console.error('Error searching categories');
        }
    });
}

function displaySearchResults(categories) {
    const categoryList = $('#category_list');
    categoryList.empty();
    
    if (categories.length > 0) {
        categories.forEach(function(category) {
            if (!selectedCategories.includes(category.id)) {
                const item = $(`
                    <a href="#" class="list-group-item list-group-item-action category-item" data-category='${JSON.stringify(category)}'>
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">${category.name}</h6>
                            <small>${category.products_count} products</small>
                        </div>
                    </a>
                `);
                categoryList.append(item);
            }
        });
        
        $('#search_results').show();
        
        // Handle category selection
        $('.category-item').click(function(e) {
            e.preventDefault();
            selectedCategoryData = JSON.parse($(this).attr('data-category'));
            $('.category-item').removeClass('active');
            $(this).addClass('active');
            $('#add_category_btn').prop('disabled', false);
        });
    } else {
        $('#search_results').hide();
        $('#add_category_btn').prop('disabled', true);
    }
}

function addCategoryToTable(category) {
    const row = $(`
        <tr>
            <td>${category.name}</td>
            <td><span class="badge bg-info-subtle text-info">${category.products_count} products</span></td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeCategory(${category.id}, this)">
                    <i class="fas fa-trash"></i> Remove
                </button>
                <input type="hidden" name="categories[]" value="${category.id}">
            </td>
        </tr>
    `);
    $('#selected_categories').append(row);
}

function removeCategory(categoryId, button) {
    selectedCategories = selectedCategories.filter(id => id !== categoryId);
    $(button).closest('tr').remove();
}
</script>

@endsection
