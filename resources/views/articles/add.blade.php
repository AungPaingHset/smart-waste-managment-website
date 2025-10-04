{{-- @extends("layouts.app")
@section("content")
<div class="container" style="max-width:800px">
  
  @if ($errors->any())
  <div class="alert alert-warning">
    @foreach($errors->all() as $err)
    {{$err}}
    @endforeach
  </div>
  @endif
  
<form method="post">
  @csrf
  <div class="mb-2">
    <label>Title</label>
    <input type="text" class="form-control" name="title">
  </div>

  <div class="mb-2">
    <label>Body</label>
    <textarea name="body" class="form-control"></textarea>
  </div>

  <div class="mb-2">
    <label>Category</label>
    <select name="category_id" id="" class="form-select">
      @foreach($categories as $category)
      <option value="{{ $category->id }}">{{ $category->name }}</option>
     @endforeach
    </select>
  </div>
  <button class="btn btn-primary"> Add Article</button>
  </form></div>
@endsection --}}

@extends("layouts.app")


@section("content")

<div class="container-fluid ">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8 col-xl-6">
<div class="article-form-wrapper my-5 py-5">

  
  @if ($errors->any())
  <div class="alert alert-warning">
    @foreach($errors->all() as $err)
      {{ $err }}<br>
    @endforeach
  </div>
  @endif

  <form method="post">
    @csrf
    
    <div class="mb-2">
      <textarea name="body" class="form-control" rows="5" placeholder="Write your comment here..."></textarea>
    </div>
    
    <button class="btn btn-primary">+ Add Article</button>

    <a href="{{ url('/articles') }}" class="btn btm-primary" style=" display: inline-block;">
    ← Back to Articles
    </a>
    
  </form>
</div>
    </div>
    <div>
</div>
@endsection

